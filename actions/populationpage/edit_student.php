<?php

    $servername= "localhost";
    $username= "root";
    $password ="1234";
    $dbname= "epita";

    $conn = new mysqli($servername, $username, $password, $dbname );

    $new_firstname = $_POST['new_firstname'];
    $new_lastname = $_POST['new_lastname'];
    $STUDENT_EPITA_EMAIL = $_POST['student_email'];


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