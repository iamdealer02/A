<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";


$conn = new mysqli($servername, $username, $password, $dbname);

function get_grades_by_course_and_population ($course, $progname, $yearr, $speriod){
    global $conn;

    $sql = "SELECT s.STUDENT_EPITA_EMAIL,
        c.CONTACT_FIRST_NAME,
        c.CONTACT_LAST_NAME,
        SUM(ROUND(g.GRADE_SCORE * e.EXAM_WEIGHT / e.EXAM_WEIGHT)) / COUNT(s.STUDENT_EPITA_EMAIL) AS GRADES
        FROM CONTACTS c 
        INNER JOIN STUDENTS s ON s.STUDENT_CONTACT_REF = c.CONTACT_EMAIL 
        INNER JOIN GRADES g ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL 
        INNER JOIN EXAMS e ON g.GRADE_COURSE_CODE_REF = e.EXAM_COURSE_CODE
        WHERE g.GRADE_COURSE_CODE_REF = '$course' AND s.STUDENT_POPULATION_CODE_REF = '$progname' AND s.STUDENT_POPULATION_YEAR_REF = '$yearr' AND s.STUDENT_POPULATION_PERIOD_REF = '$speriod'
        GROUP BY s.STUDENT_EPITA_EMAIL, c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME
        ";
    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        echo("<tr>
        <td>".$row['STUDENT_EPITA_EMAIL']."</td>
        <td>".$row['CONTACT_FIRST_NAME']."</td>
        <td>".$row['CONTACT_LAST_NAME']."</td>
        <td>".$row['GRADES']."</td>
    </tr>");
    }

    return $rows;
}
// Call the function to get the population data


// Now, the '$population_data' array contains the data fetched from the query as dictionaries.
// You can use this array to process the data as needed.

// Display the array using print_r

?>
