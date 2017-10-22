<?php

class DbOperation {
    
    private $con;
    
    function __construct() {
        
        require_once dirname(__FILE__).'/DbConnect.php';
        
        $db = new DbConnect();
        
        $this->con = $db->connect();
    }

    function getDefaultExercises() {
        $query = $this->con->prepare('SELECT exercise_name, exercise_description from WorkoutBuddy_defaultexercise');
        $query->execute();
        $query->bind_result($exercise_name, $exercise_description);

        $exercises = array();
        
        while($query->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $exercise_name;
            $exercise['exercise_description'] = $exercise_description;
    
            array_push($exercises,$exercise);
        }
        return $exercises;
    }
    
    function getCustomExercises($user_id) {
        $query = $this->con->prepare("SELECT exercise_name, exercise_description FROM WorkoutBuddy_customexercise where user_profile_id='$user_id' ");
        $query->execute();
        $query->bind_result($exercise_name,$exercise_description);
        
        $custom_exercises = array();
        
        while($query->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $exercise_name;
            $exercise['exercise_description'] = $exercise_description;

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
        $query = $this->con->prepare("SELECT main_workout_name FROM WorkoutBuddy_mainworkout where user_profile_id='$user_id'");
        $query->execute();
        $query->bind_result($main_workout_name);
        $main_workouts = array();
        
        while($query->fetch()) {
            $main_workout = array();
            $main_workout['MainWorkout'] = $main_workout_name;
            
            array_push($main_workouts, $main_workout);
        }
        return $main_workouts;
    }
    
    private function getSubWorkoutNames($main_workout_id) {
        $query = $this->con->prepare("SELECT sub_workout_name from WorkoutBuddy_subworkout where main_workout_id='$main_worokut_id'");
        $query->execute();
        $query->bind_results($sub_workout_name);
        $sub_workouts = array();
        
        while($query->fetch()) {
            $sub_workout = array();
            $sub_workout['SubWorkout'] = $sub_workout_name;
            
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
    
    function getSubWorkoutCustomExerciseIds($sub_workout_id) {
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
    
    function getSubWorkoutExercises($sub_workout_id) {
        $de_ids = $this->getSubWorkoutDefaultExerciseIds($sub_workout_id); 
        $de_ids = join("','",$de_ids);
        $query = $this->con->prepare("SELECT exercise_name FROM WorkoutBuddy_defaultexercise where id IN('$de_ids')");
        $query->execute();
        $query->bind_result($de_name);
        $exercises = array();
    
        while($query->fetch()) {
            $arr = array();
            $arr['exercise_name'] = $de_name;
            
            array_push($exercises, $arr);
        }
        
        $ce_ids = $this->getSubWorkoutCustomExerciseIds($sub_workout_id);
        $ce_ids = join("','", $ce_ids);
        $query = $this->con->prepare("SELECT exercise_name FROM WorkoutBuddy_customexercise where id IN('$ce_ids')");
        $query->execute();
        $query->bind_result($ce_name);
        
        while($query->fetch()) {
            $arr = array();
            $arr['exercise_name'] = $ce_name;
            
            array_push($exercises, $arr);
        }
        return $exercises;
    }
}
?>