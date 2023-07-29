<?php

require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    $new_firstname = $_POST['new_firstname'];
    $new_lastname = $_POST['new_lastname'];
    $STUDENT_EPITA_EMAIL = $_POST['student_email'];

    //updating the details of the student in every possible table.
    $sql = "UPDATE CONTACTS c
    INNER JOIN students s ON s.student_contact_ref = c.contact_email
    SET CONTACT_FIRST_NAME='".$new_firstname."' , CONTACT_LAST_NAME='".$new_lastname."'
    WHERE s.STUDENT_EPITA_EMAIL = '".$STUDENT_EPITA_EMAIL."'";

    if ($conn->query($sql)== TRUE) {
    }
    else{
        echo "Connection error";
    }
    $conn->close();
    header("Location: " .  $_SERVER['HTTP_REFERER']);


?>