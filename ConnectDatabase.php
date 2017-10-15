<?php
    echo $_SERVER['SCRIPT_NAME'];
    $con = mysqli_connect('127.0.0.1','kaveon14','playstation31','WorkoutBuddy_database');
    

    if(mysqli_connect_errno($con)) {
        echo '<p>Failed to connect to database</p>'.mysqli_connect_error();
    } else {
        echo '<p>Connected</p>';
    }

    $row = mysqli_query($con,"select exercise_name from WorkoutBuddy_defaultexercise ");
    $data = mysqli_fetch_array($row);
    
    for($x=0;$x<57;$x++) {
        echo 'Name: '.$data[0].'<br/>';
        $data = mysqli_fetch_array($row);
    }
?>