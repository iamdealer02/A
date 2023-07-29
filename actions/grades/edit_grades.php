<?php

function get_grades_by_course_and_population ($course, $progname, $yearr, $speriod){

    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    $sql = "UPDATE GRADES
    SET g.grade_exam_type_ref='ADMIN_OVERRIDE', g.GRADE_SCORE='".$new_grade."'
    WHERE s.STUDENT_EPITA_EMAIL = '".$STUDENT_EPITA_EMAIL."'";
    // Execute the query
    if ($conn->query($sql)== TRUE) {
    }
    else{
        echo "Connection error";
    }
    $conn->close();
    header("Location: " .  $_SERVER['HTTP_REFERER']);
}

?>