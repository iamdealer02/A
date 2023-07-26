<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";

$conn = new mysqli($servername, $username, $password, $dbname);


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
    
        echo (isset($_POST['edit']) && $_POST['student_email'] == $row['STUDENT_EPITA_EMAIL']) ?
            "<form id='checkform' name='checkform' action='../../actions/populationpage/edit_student.php' method='POST'><input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'><button type='submit' name='edit' class='edit' style='border: none; background-color: transparent;'><img src='../../connectionquery/images/checked.png' style='width: 30px; height: 30px;'></button></form>" :
            "<form method='POST'> 
            <input type='hidden' name='student_email' value='".$row['STUDENT_EPITA_EMAIL']."'><button type='submit' name='edit' class='edit' style='border: none; background-color: transparent;'>
            <img src='../../connectionquery/images/pen.png' style='width: 30px; height: 30px;'>
            </button></form>
            
            <form id='deleteform' action='../../actions/populationpage/delete_student.php?email=".$row['STUDENT_EPITA_EMAIL']."' method='POST'>
                <button type='submit' name='delete' class='delete' onclick='return confirmation()' style='border: none; background-color: transparent;'>
                    <img src='../../connectionquery/images/delete.png' style='width: 30px; height: 30px;'>
                </button>
            </form>
            </td>
        </tr>";
    }

    echo("<script>
    function confirmation() {
        return confirm('Are you sure you want to delete this student?');
    }
    </script>");

    return $rows;
}
?>

