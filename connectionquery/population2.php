<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";

$conn = new mysqli($servername, $username, $password, $dbname);

function get_courses_by_population($k, $l, $m) {
    global $conn;

    $sql = "SELECT p.PROGRAM_ASSIGNMENT, 
    s.SESSION_COURSE_REF, COUNT(s.SESSION_COURSE_REF) AS SESSION_COUNT
    FROM SESSIONS s
    INNER JOIN PROGRAMS p ON s.SESSION_COURSE_REF = p.PROGRAM_COURSE_CODE_REF
    WHERE p.PROGRAM_ASSIGNMENT = '$k' AND s.SESSION_POPULATION_YEAR = '$l' AND s.SESSION_POPULATION_PERIOD = '$m'
    GROUP BY s.SESSION_COURSE_REF
    ORDER BY s.SESSION_COURSE_REF";

    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $course = $row['SESSION_COURSE_REF'];
        $program = $row['PROGRAM_ASSIGNMENT'];
        $year = $_GET['year'];
        $period = $_GET['period'];
        $phpLink = "../course_grades/course_grades.php?year=" . urlencode($year) . "&period=" . urlencode($period) . "&program=" . urlencode($program) . "&course=" . urlencode($course) ;


        echo("<tr onclick=\"window.location='$phpLink';\">
        <td>".$row['PROGRAM_ASSIGNMENT']."</td>
        <td>".$row['SESSION_COURSE_REF']."</td>
        <td>".$row['SESSION_COUNT']."</td>
    </tr>");
    }

    return $rows;
}

// Call the function to get the population data

// Now, the '$population_data' array contains the data fetched from the query as dictionaries.
// You can use this array to process the data as needed.

// Display the array using print_r

?>