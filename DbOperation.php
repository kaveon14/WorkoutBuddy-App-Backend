<?php

class DbOperation {
    
    
    private $con;
    
    function __construct() {
        
        require_once dirname(__FILE__).'/DbConnect.php';
        
        $db = new DbConnect();
        
        $this->con = $db->connect();
    }

    function getDefaultExercises() {
        $query = $this->con->prepare('SELECT exercise_name from WorkoutBuddy_defaultexercise');
        $query->execute();
        $query->bind_result($exercise_name);
        
        $exercises = array();
        
    
        while($query->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $exercise_name;
    
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
    
}

?>