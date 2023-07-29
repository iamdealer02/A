<?php
/*
Function to extract the population of the students by passing the PROGRAM, YEAR , PERIOD
we want of. We get the arguments by using the url encode.
*/
function get_students_by_population($prog, $year, $per) {
    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

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
    /*
     We uses the Php if/else and isset to perform Edit action. If isset(edit) , i.e, the Edit button (pen icon) has been accessed
     we replace the table data with input type for the entire row, using the if/else. The pen icon is changed to a checked icon.
    */
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        echo "<tr> 
       
            <td>".(isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL'] ?
                '<input type="text" name="new_firstname" value="'.$row['CONTACT_FIRST_NAME'].'" form="checkform">' :
                $row['CONTACT_FIRST_NAME'])."</td>
            <td>".(isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL'] ?
                '<input type="text" name="new_lastname" value="'.$row['CONTACT_LAST_NAME'].'" form="checkform">' :
                $row['CONTACT_LAST_NAME'])."</td>
            <td>".$row['STUDENT_EPITA_EMAIL']."</td>
            <td>".$row['Passed_Total']."</td>
            <td>";
        /*
        To check for which student to edit for (as it in the while loop and only isset('edit') condition is not enough) we will
        also check which email has been POST to edit for that particular student.
        We then POST the new values in the form and use sql query to update the database.
        */

    
        echo (isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL']) ?
            "<form id='checkform' name='checkform' action='../../actions/populationpage/edit_student.php' method='POST'><input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'><button type='submit' name='edit' class='edit' style='border: none; background-color: transparent;'><img src='../../connectionquery/images/checked.png' style='width: 20px; height: 20px;'></button></form>" :
            "<div class='imgform'><form method='POST'> 
            <input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'><button type='submit' name='edit' class='edit' style='border: none; background-color: transparent;'>
            <img src='../../connectionquery/images/pen.png' style='width: 20px; height: 20px;'>
            </button></form>
            
            <form id='deleteform' action='../../actions/populationpage/delete_student.php?email=".$row['STUDENT_EPITA_EMAIL']."' method='POST'>
                <button type='submit' name='delete' class='delete' onclick='return confirmation()' style='border: none; background-color: transparent;'>
                    <img src='../../connectionquery/images/delete.png' style='width: 20px; height: 20px;'>
                </button>
            </form>
            </div>
            </td>
        </tr>";
    }
    /*
    We also have a Delete Action which runs a javascript Confirmation function. The button when clicked, sends the student_email to the query to
    delete it from the database wherever it can exists.
    */

    echo("<script>
    function confirmation() {
        return confirm('Are you sure you want to delete this student?');
    }
    </script>");

    return $rows;
}
?>

