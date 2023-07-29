<?php

require_once '../../connectionquery/db_connection.php';

// Call the db_connect function to get the database connection object
$conn = db_connect();

$course_code = $_POST['session_course_ref'];
$course_rev = $_POST['course_rev'];
$course_last_rev = $_POST['course_last_rev'];
$course_name = $_POST['course_name'];
$course_description = $_POST['course_description'];
$teacher_name = $_POST['teacher_name'];
$teacher_epita_email = $_POST['teacher_epita_email'];
$session_count = $_POST['quantity'];

$year = $_GET['year'];
$period = $_GET['period'];
$prog = $_GET['code'];
$sql1 = "INSERT INTO courses (course_code, course_rev, duration, course_last_rev, course_name, course_description) VALUES
 ('". $course_code."', '". $course_rev."','".$session_count."' , '".$course_last_rev."', '".$course_name."', '".$course_description."')";

if ($conn->query($sql1) === TRUE) {
} else {
    echo "Connection error";
}
$sql3 = "INSERT INTO programs (program_course_code_ref, program_course_rev_ref, program_assignment) VALUES
 ('".$course_code."', '".$course_rev."', '".$prog."')";

if ($conn->query($sql3) === TRUE) {

} else {
    echo "Connection error";
}
e
$sql4 = "INSERT INTO teachers (teacher_contact_ref, teacher_epita_email, teacher_study_level) VALUES
 ('N/A', '".$teacher_epita_email."', NULL)";

if ($conn->query($sql4) === TRUE) {

} else {
    echo "Connection error";
}

$sql_students = "SELECT s.STUDENT_EPITA_EMAIL
FROM students s
WHERE s.STUDENT_POPULATION_CODE_REF = '".$prog."' AND s.STUDENT_POPULATION_YEAR_REF = '".$year."' AND s.STUDENT_POPULATION_PERIOD_REF = '".$period."'";
$result_students = $conn->query($sql_students);

while($row = $result_students->fetch_assoc()){
    $sql_grade = "INSERT into grades 
    VALUES('".$row['STUDENT_EPITA_EMAIL']."', '".$course_code."', '".$course_rev."', 'N/A', NULL)";
    $result = $conn->query($sql_grade);
};

$conn->close();
// header("Location: " .  $_SERVER['HTTP_REFERER']);

?>
