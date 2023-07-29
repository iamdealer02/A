<?php
function get_courses_by_population($k) {
    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    $sql = "SELECT p.PROGRAM_ASSIGNMENT,  p.PROGRAM_COURSE_CODE_REF, MAX(c.duration) as SESSION_COUNT
    FROM PROGRAMS p
    INNER JOIN COURSES c ON p.PROGRAM_COURSE_CODE_REF = c.COURSE_CODE
    WHERE p.PROGRAM_ASSIGNMENT = '$k'
    GROUP BY p.PROGRAM_ASSIGNMENT, p.PROGRAM_COURSE_CODE_REF
    ORDER BY p.PROGRAM_COURSE_CODE_REF";


    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    $rows = array();
    //fething the variables using GET and passing it to the url to use it for the next query.
    $year = $_GET['year'];
    $period = $_GET['period'];
    while ($row = $result->fetch_assoc()) {
        $course = $row['PROGRAM_COURSE_CODE_REF'];
        $program = $row['PROGRAM_ASSIGNMENT'];
        $phpLink = "../course_grades/course_grades.php?year=" . urlencode($year) . "&period=" . urlencode($period) . "&program=" . urlencode($program) . "&course=" . urlencode($course) ;

        //redirecting the users to a new Grades window with a row
        echo("<tr onclick=\"window.location='$phpLink';\">
        <td>".$row['PROGRAM_ASSIGNMENT']."</td>
        <td>".$row['PROGRAM_COURSE_CODE_REF']."</td>
        <td>".$row['SESSION_COUNT']."</td>
        
    </tr>");
    }
    return $rows;
}
?>