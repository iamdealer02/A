<?php

function get_grades_by_course_and_population ($course, $progname, $yearr, $speriod){

    require_once '../../connectionquery/db_connection.php';

    // Call the db_connect function to get the database connection object
    $conn = db_connect();

    $sql = "SELECT s.STUDENT_EPITA_EMAIL, c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME, 
    CASE 
        WHEN MAX(g.grade_exam_type_ref) = 'ADMIN_OVERRIDE' THEN MAX(g.GRADE_SCORE)
        ELSE ROUND(SUM(g.GRADE_SCORE * e.EXAM_WEIGHT) / SUM(e.EXAM_WEIGHT))
    END AS GRADES 
    FROM CONTACTS c 
    INNER JOIN STUDENTS s ON s.STUDENT_CONTACT_REF = c.CONTACT_EMAIL 
    INNER JOIN GRADES g ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL 
    LEFT JOIN EXAMS e ON g.GRADE_COURSE_CODE_REF = e.EXAM_COURSE_CODE AND g.GRADE_COURSE_REV_REF = e.EXAM_COURSE_REV
     AND g.GRADE_EXAM_TYPE_REF = e.EXAM_TYPE
    WHERE g.GRADE_COURSE_CODE_REF = '".$course."' AND s.STUDENT_POPULATION_CODE_REF = '".$progname."' 
    AND s.STUDENT_POPULATION_YEAR_REF = ".$yearr."  AND s.STUDENT_POPULATION_PERIOD_REF = '".$speriod."'
    GROUP BY s.STUDENT_EPITA_EMAIL, c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME";
    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {

        die("Query execution failed: " . $conn->error);
    }
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        echo "<tr> 
    
            <td>".$row['STUDENT_EPITA_EMAIL']."</td>
            <td>".$row['CONTACT_FIRST_NAME']."</td>
            <td>".$row['CONTACT_LAST_NAME']."</td>
            <td>".(isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL'] ?
            '<input type="number" name="new_grade" value="'.$row['GRADES'].'" form="checkform">' :
            $row['GRADES'])."</td>
            <td>";
        /*
        To check for which student to edit for (as it in the while loop and only isset('edit') condition is not enough) we will
        also check which email has been POST to edit for that particular student.
        We then POST the new values in the form and use sql query to update the database.
        */

        echo (isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL']) ?
            "<form id='checkform' name='checkform' action='../../actions/grades/edit_grades.php?course_code=".$course."' method='POST'>
            <input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'>
            <button type='submit' name='check' class='check' style='border: none; background-color: transparent;'>
            <img src='../../connectionquery/images/checked.png' style='width: 20px; height: 20px;'></button></form>" :
            "<div class='imgform' style='display:flex; flex-direction: row; '><form method='POST'> 
            <input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'><button type='submit' name='edit' class='edit' style='border: none; background-color: transparent;'>
            <img src='../../connectionquery/images/pen.png' style='width: 20px; height: 20px;'>
            </button></form>
            
            <form id='deleteform' action='../../actions/grades/delete_grades.php?email=".$row['STUDENT_EPITA_EMAIL']."&course=".$course."' method='POST'>
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
        return confirm('Are you sure you want to delete the grade for the student?');
    }
    </script>");

    return $rows;
}
?>

