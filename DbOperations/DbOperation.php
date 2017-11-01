<?php
//refactor this class break it up like the 'Api' script
class DbOperation {
    
    private $con;
    
    function __construct() {
        
        require_once dirname(__FILE__).'/DbConnect.php';
        
        $db = new DbConnect();
        
        $this->con = $db->connect();
    }

    function getDefaultExercises() {
        $query = $this->con->prepare('SELECT exercise_name,exercise_description from WorkoutBuddy_defaultexercise');
        $query->execute();
        $query->bind_result($exercise_name, $exercise_description);

        $exercises = array();
        
        while($query->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $exercise_name;
            $exercise['exercise_description'] = $exercise_description;
            $exercise['default'] = true;
    
            array_push($exercises,$exercise);
        }
        return $exercises;
    }
    
    function getCustomExercises($user_id) {
        $query = $this->con->prepare("SELECT WorkoutBuddy_customexercise.id,exercise_name,exercise_description,local_exercise_image FROM WorkoutBuddy_customexercise LEFT JOIN(WorkoutBuddy_customexerciseimage) ON (WorkoutBuddy_customexerciseimage.exercise_id = WorkoutBuddy_customexercise.id)  ");
        $query->execute();
        $query->bind_result($id,$exercise_name,$exercise_description,$exercise_image);
        
        $custom_exercises = array(); 
        
        while($query->fetch()) {
            $exercise = array();
            $exercise['id'] = $id;
            $exercise['exercise_name'] = $exercise_name;
            $exercise['exercise_description'] = $exercise_description;
            $exercise['exercise_image'] = $exercise_image;
            $exercise['default'] = false;

            array_push($custom_exercises,$exercise);
        }
        return $custom_exercises;        
    }
    
    function getAllExercises($user_id) {
        $default_exercises = $this->getDefaultExercises();
        $custom_exercises = $this->getCustomExercises($user_id);

        return array_merge($default_exercises,$custom_exercises);
    }
    
    function getMainWorkoutNames($user_id) {
        $query = $this->con->prepare("SELECT id,main_workout_name FROM WorkoutBuddy_mainworkout where user_profile_id='$user_id' or user_profile_id IS NULL");
        $query->execute();
        $query->bind_result($id,$main_workout_name);
        $main_workouts = array();
        
        while($query->fetch()) {
            $main_workout = array();
            $main_workout['id'] = $id;
            $main_workout['main_workout_name'] = $main_workout_name;
            
            array_push($main_workouts, $main_workout);
        }
        return $main_workouts;
    }
    
    function getSubWorkoutNames($main_workout_id) {
        $query = $this->con->prepare("SELECT id,sub_workout_name from WorkoutBuddy_subworkout where main_workout_id='$main_workout_id'");
        $query->execute();
        $query->bind_result($id,$sub_workout_name);
        $sub_workouts = array();
        
        while($query->fetch()) {
            $sub_workout = array();
            $sub_workout['id'] = $id;
            $sub_workout['sub_workout_name'] = $sub_workout_name;
            
            array_push($sub_workouts, $sub_workout);
        }
        return $sub_workouts;
    }
    
    private function getSubWorkoutDefaultExerciseIds($sub_workout_id) {
        $default_exercise_query = $this->con->prepare("SELECT defaultexercise_id FROM WorkoutBuddy_subworkout_default_exercises WHERE subworkout_id='$sub_workout_id'");
        $default_exercise_query->execute();
        $default_exercise_query->bind_result($default_ex_id);
        
        $default_exercise_ids = array();
        $index = 0;
        while($default_exercise_query->fetch()) {
            $default_exercise_ids[$index] = $default_ex_id;
            $index++;
        }
        return $default_exercise_ids;
    }
    
    private function getSubWorkoutCustomExerciseIds($sub_workout_id) {
        $custom_exercise_query = $this->con->prepare("SELECT customexercise_id FROM WorkoutBuddy_subworkout_custom_exercises WHERE subworkout_id='$sub_workout_id'");
        $custom_exercise_query->execute();
        $custom_exercise_query->bind_result($ex_id);
        
        $custom_exercise_ids = array();
        $index = 0;
         while($custom_exercise_query->fetch()) {
            $custom_exercise_ids[$index] = $ex_id;
            $index++;
        }
        return $custom_exercise_ids;
    }
    
    function getSubWorkoutExercises($sub_workout_id) {//only return ex name
        $de_ids = $this->getSubWorkoutDefaultExerciseIds($sub_workout_id); 
        $de_ids = join("','",$de_ids);
        $query = $this->con->prepare("SELECT id,exercise_name FROM WorkoutBuddy_defaultexercise where id IN('$de_ids')");
        $query->execute();
        $query->bind_result($id,$de_name);
        $exercises = array();
    
        while($query->fetch()) {
            $arr = array();
            $arr['id'] = $id;
            $arr['exercise_name'] = $de_name;
            $arr['default'] = true;
            
            array_push($exercises, $arr);
        }
        
        $ce_ids = $this->getSubWorkoutCustomExerciseIds($sub_workout_id);
        $ce_ids = join("','", $ce_ids);
        $query = $this->con->prepare("SELECT exercise_name,id FROM WorkoutBuddy_customexercise where id IN('$ce_ids')");
        $query->execute();
        $query->bind_result($id,$ce_name);
        
        while($query->fetch()) {
            $arr = array();
            $arr['id'] = $id;
            $arr['exercise_name'] = $ce_name;
            $arr['default'] = false;
            
            array_push($exercises, $arr);
        }
        return $exercises;
    }

    function getGoalExercises($sub_workout_id) {//check this again
        $exercises = $this->getSubWorkoutExercises($sub_workout_id);//change with a query to get names and ids
        $de_ids = array();
        $de = array();
        $ce_ids = array();
        $ce = array();
        $x = 0;
        $z = 0;
        foreach($exercises as $exercise) {//nice does exactly what is wanted
            if($exercise['default']) {
                $de[$x] = $exercise['exercise_name']; 
                $de_ids[$x] = $exercise['id'];
                $x++;
            } else {
                $ce_ids[$z] = $exercise['id'];
                $ce[$z] = $exercise['exercise_name'];
                $z++;
            }
        }
        
        $de_ids = join("','", $de_ids);
        $query = $this->con->prepare("SELECT id,goal_sets, goal_reps FROM WorkoutBuddy_exercisegoals WHERE default_exercise_id IN('$de_ids') AND sub_workout_id='$sub_workout_id'");
        $query->execute();
        $query->bind_result($id,$goal_sets,$goal_reps);
        
        $x = 0;
        $exes = array();
        while($query->fetch()) {
            $ex = array();
            $ex['exercise_name'] = $de[$x];
            $ex['goal_sets'] = $goal_sets;
            $ex['goal_reps'] = $goal_reps;
            $x++;
            array_push($exes, $ex);
        }
        
        $ce_ids = join("','",$ce_ids);
        $query = $this->con->prepare("SELECT goal_sets,goal_reps FROM WorkoutBuddy_exercisegoals where custom_exercise_id IN('$ce_ids') and sub_workout_id='$sub_workout_id'");
        $query->execute();
        $query->bind_result($goal_sets,$goal_reps);
        
        $x = 0;
        while($query->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $ce[$x];
            $exercise['goal_sets'] = $goal_sets;
            $exercise['goal_reps'] = $goal_reps;
            
            $x++;
            array_push($exercises, $exercise);
        }
        return $exes;
    }
    
    function getBodyData($user_id) {
        $query = $this->con->prepare("SELECT id,date,weight,unit,chest_size,back_size,
        arm_size,forearm_size,waist_size,quad_size,calf_size FROM WorkoutBuddy_bod WHERE profile_id='$user_id");
        $query->execute();
        $query->bind_result($id,$date,$weight,$unit,$chest_size,$back_size,
        $arm_size,$forearm_size,$waist_size,$quad_size,$calf_size);
        
        $bodyStats = array();
        
        while($query->fetch()) {
            $body_data = array();
            $body_data['date'] = $date;
            $body_data['weight'] = $weight;
            $body_data['unit'] = $unit;
            $body_data['chest_size'] = $chest_size;
            $body_data['back_size'] = $back_size;
            $body_data['arm_size'] = $arm_size;
            $body_data['forearm_size'] = $forearm_size;
            $body_data['waist_size'] = $waist_size;
            $body_data['quad_size'] = $quad_size;
            $body_data['calf_size'] = $calf_size;
            
            array_push($bodyStats, $body_data);
        }
        return $bodyStats;
    }
    
    function getProgressPhotos($user_id) {
        $query = $this->con->prepare("SELECT id,date_time,local_photo FROM WorkoutBuddy_progressphoto WHERE user_profile_id='$user_id");
        $query->execute();
        $query->bind_result($id,$date_time,$local_photo);
        
        $photos = array();
        
        while($query->fetch()) {
            $progressPhoto = array();
            $progressPhoto['id'] = $id;
            $progressPhoto['date_time'] = $date_time;
            $progressPhoto['local_photo'] = $local_photo;
            
            array_push($photos, $progressPhoto);
        }
        return $photos;
    }
}
?>