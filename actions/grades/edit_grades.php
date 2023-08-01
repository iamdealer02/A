<?php


    $student_epita_email = $_POST['student_email'];
    $new_grade = $_POST['new_grade'];
    $course_code = $_GET['course_code'];

    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    $sql = "UPDATE GRADES
            SET grade_exam_type_ref = 'ADMIN_OVERRIDE', GRADE_SCORE = '".$new_grade."'
            WHERE GRADE_STUDENT_EPITA_EMAIL_REF = '".$student_epita_email."' AND GRADE_COURSE_CODE_REF = '".$course_code."'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Update successful
    } else {
        echo "Connection error";
    }

    $conn->close();
    header("Location: " . $_SERVER['HTTP_REFERER']);

?>