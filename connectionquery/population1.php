<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";

$conn = new mysqli($servername, $username, $password, $dbname);

// $prog = $_GET['prog'];
// $year = $_GET['year'];
// $per = $_GET['per'];

function get_students_by_population($prog, $year, $per) {
    global $conn;

    $sql = "SELECT c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME, s.STUDENT_EPITA_EMAIL,
    CONCAT(SUM(CASE WHEN ROUND((g.GRADE_SCORE * e.EXAM_WEIGHT) / e.EXAM_WEIGHT) > 10 THEN 1 ELSE 0 END), '/', COUNT(s.STUDENT_EPITA_EMAIL)) AS Passed_Total
    FROM CONTACTS c 
    INNER JOIN STUDENTS s ON c.CONTACT_EMAIL = s.STUDENT_CONTACT_REF 
    INNER JOIN GRADES g ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL 
    INNER JOIN EXAMS e ON g.GRADE_COURSE_CODE_REF = e.EXAM_COURSE_CODE
    WHERE s.STUDENT_POPULATION_CODE_REF = '$prog' AND s.STUDENT_POPULATION_YEAR_REF = '$year' AND s.STUDENT_POPULATION_PERIOD_REF = '$per'
    GROUP BY c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME, s.STUDENT_EPITA_EMAIL
    ORDER BY c.CONTACT_FIRST_NAME";
  

    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        echo("<tr>
        <td>".$row['CONTACT_FIRST_NAME']."</td>
        <td>".$row['CONTACT_LAST_NAME']."</td>
        <td>".$row['STUDENT_EPITA_EMAIL']."</td>
        <td>".$row['Passed_Total']."</td>
    </tr>");
    }

    return $rows;
}

// Call the function to get the population data


// Now, the '$population_data' array contains the data fetched from the query as dictionaries.
// You can use this array to process the data as needed.

// Display the array using print_r

?>
