<?php
if (isset($_POST['delete'])) {
    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();
    $STUDENT_EPITA_EMAIL = $_GET['email'];
    $course_code = $_GET['course'];

    //Deleting all existing data related to the student.
    $sql = "UPDATE GRADES g
    SET g.grade_exam_type_ref='ADMIN_OVERRIDE', g.GRADE_SCORE=NULL
    WHERE g.grade_student_epita_email_ref = '".$STUDENT_EPITA_EMAIL."' 
    AND GRADE_COURSE_CODE_REF = '".$course_code."' ";

    if ($conn->query($sql) === TRUE) {
        header("Location: " .  $_SERVER['HTTP_REFERER']);
        exit;
      
    } else {
        echo "Connection error";
    }

    $conn->close();
}
?>