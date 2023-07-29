<?php
function get_population_data() {
    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    // Sql query to fetch the data from the Database
    $sql = "SELECT
    STUDENT_POPULATION_CODE_REF,
    s.STUDENT_POPULATION_YEAR_REF AS STUDENT_POPULATION_YEAR_REF,
    s.STUDENT_POPULATION_PERIOD_REF AS STUDENT_POPULATION_PERIOD_REF,
    COUNT(STUDENT_EPITA_EMAIL) AS POPULATION_COUNT
    FROM STUDENTS s
    GROUP BY STUDENT_POPULATION_CODE_REF,s.STUDENT_POPULATION_PERIOD_REF,s.STUDENT_POPULATION_YEAR_REF
    ORDER BY STUDENT_POPULATION_CODE_REF";
        

    // Execute the query
    $result = $conn->query($sql);   //running the query 

    if (!$result) {
        die("Query execution failed: " . $conn->error);
        //Connection execution fail
    }
    while ($row = $result->fetch_assoc()) {
        /*
        fetching the result using fetch_assoc() in the while function so that we iterate through 
        all the records that exists in the database
        */
        $prog = $row['STUDENT_POPULATION_CODE_REF']; //fetching the value as the row generates a dictionary with key/value pair
        $year = $row['STUDENT_POPULATION_YEAR_REF'];
        $per = $row['STUDENT_POPULATION_PERIOD_REF'];
        $phpLink = "../population/population.php?year=" . urlencode($year) . "&period=" . urlencode($per) . "&code=" . urlencode($prog);
        /*
        passing some of the arguments in the url as we can use them as the arguments to run the next query. Encoding them
        provides an extra layer of security. The phplink redirects to the HTML base page. The queries from connection_query folder is called in all the HTML pages.
        */

       // echoing/fetching the data in the html page in the table. The onclick function redirects to the phplink variable.
       //Hence, every row in the column redirects the page where the BASE PAGE remains the same, but the data changes according
       //to the arguments passed.
        echo("<tr onclick=\"window.location='$phpLink';\">
            <td>".$row['STUDENT_POPULATION_CODE_REF']."</td>
            <td>".$row['STUDENT_POPULATION_PERIOD_REF']."</td>
            <td>".$row['STUDENT_POPULATION_YEAR_REF']."</td>
            <td>".$row['POPULATION_COUNT']."</td>
        </tr>");
    }
}

?>
