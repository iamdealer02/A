<?php

    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    //getting the variables posted in the form/ getting variables from the URL.
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $epita_email = $_POST['epita_email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $birthdate = $_POST['birthdate'];
    $year = $_GET['year'];
    $period = $_GET['period'];
    $program = $_GET['code'];

    //Inserting the new student in Contacts first
    $sql1 = "INSERT INTO contacts (contact_email, contact_first_name, contact_last_name, contact_address, contact_city, contact_country, contact_birthdate)
    VALUES ('".$email."', '".$first_name."', '".$last_name."', '".$address."', '".$city."', '".$country."', '".$birthdate."')";

    if ($conn->query($sql1) === TRUE) {
        // Successful insertion into the "contacts" table
    } else {
        echo "Connection error";
    }

    //next to the students table
    $sql2 = "INSERT INTO students (student_epita_email, student_contact_ref, student_enrollment_status, student_population_period_ref, student_population_year_ref, student_population_code_ref)
    VALUES ('".$epita_email."', '".$email."', 'completed', '".$period."', '".$year."', '".$program."')";

    if ($conn->query($sql2) === TRUE) {
        // Successful insertion into the "students" table
    } else {
        echo "Connection error";
    }

    //Fetching all the courses in that particular program we want to add the student 
    $sql_courses = "SELECT course_code, course_rev from courses c join programs p on c.course_code = p.program_course_code_ref where program_assignment = '".$program."'";
    $result_courses = $conn->query($sql_courses);

    //running a loop through all the courses in that program:
    while($row = $result_courses->fetch_assoc()){
        //adding the student to the course
        $sql_grade = "INSERT into grades 
        VALUES('".$epita_email."', '".$row['course_code']."', '".$row['course_rev']."', 'N/A', NULL)";
        $result = $conn->query($sql_grade);
    };
    
    //header refering to the original page
    header("Location: " .  $_SERVER['HTTP_REFERER']);
    $conn->close();


?>