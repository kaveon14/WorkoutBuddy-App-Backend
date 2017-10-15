<?php

class DbOperation {
    
    
    private $con;
    
    function __construct() {
        
        require_once dirname(__FILE__).'/DbConnect.php';
        
        $db = new DbConnect();
        
        $this->con = $db->connect();
    }
    
    function getDefaultExercises() {
        $stmt = $this->con->prepare('SELECT exercise_name from WorkoutBuddy_defaultexercise');
        $stmt->execute();
        $stmt->bind_result($exercise_name);
        
        $exercises = array();
        
    
        while($stmt->fetch()) {
            $exercise = array();
            $exercise['exercise_name'] = $exercise_name;
    
            
            array_push($exercises,$exercise);
        }
        return $exercises;
    }
    
}

?>