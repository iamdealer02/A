<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";

$conn = new mysqli($servername, $username, $password, $dbname);

function get_population_data() {
    global $conn;

    $sql = "SELECT
    STUDENT_POPULATION_CODE_REF,
    s.STUDENT_POPULATION_YEAR_REF AS STUDENT_POPULATION_YEAR_REF,
    s.STUDENT_POPULATION_PERIOD_REF AS STUDENT_POPULATION_PERIOD_REF,
    COUNT(STUDENT_EPITA_EMAIL) AS POPULATION_COUNT
FROM STUDENTS s
GROUP BY STUDENT_POPULATION_CODE_REF,s.STUDENT_POPULATION_PERIOD_REF,s.STUDENT_POPULATION_YEAR_REF
ORDER BY STUDENT_POPULATION_CODE_REF";
    

    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    while ($row = $result->fetch_assoc()) {
        $prog = $row['STUDENT_POPULATION_CODE_REF'];
        $year = $row['STUDENT_POPULATION_YEAR_REF'];
        $per = $row['STUDENT_POPULATION_PERIOD_REF'];
        $phpLink = "../population/population.php?year=" . urlencode($year) . "&period=" . urlencode($per) . "&code=" . urlencode($prog);
    
        echo("<tr onclick=\"window.location='$phpLink';\">
            <td>".$row['STUDENT_POPULATION_CODE_REF']."</td>
            <td>".$row['STUDENT_POPULATION_PERIOD_REF']."</td>
            <td>".$row['STUDENT_POPULATION_YEAR_REF']."</td>
            <td>".$row['POPULATION_COUNT']."</td>
        </tr>");
    }
}

// Call the function to get the population data

?>
