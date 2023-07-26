<?php
function search(){

    $searchValue = $_POST['searchstudent'];
    $year = $_GET['year'];
    $per = $_GET['period'];
    $prog = $_GET['code'];



    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "epita";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME, s.STUDENT_EPITA_EMAIL,
    CONCAT(SUM(CASE WHEN ROUND((g.GRADE_SCORE * e.EXAM_WEIGHT) / e.EXAM_WEIGHT) > 10 THEN 1 ELSE 0 END), '/', COUNT(s.STUDENT_EPITA_EMAIL)) AS Passed_Total
    FROM CONTACTS c 
    INNER JOIN STUDENTS s ON c.CONTACT_EMAIL = s.STUDENT_CONTACT_REF 
    INNER JOIN GRADES g ON g.GRADE_STUDENT_EPITA_EMAIL_REF = s.STUDENT_EPITA_EMAIL 
    INNER JOIN EXAMS e ON g.GRADE_COURSE_CODE_REF = e.EXAM_COURSE_CODE
    WHERE s.STUDENT_POPULATION_CODE_REF = '$prog' 
    AND s.STUDENT_POPULATION_YEAR_REF = '$year' 
    AND s.STUDENT_POPULATION_PERIOD_REF = '$per'
    AND (
        (LOWER(TRIM(c.CONTACT_FIRST_NAME)) LIKE LOWER('%$searchValue%') AND LOWER(TRIM(c.CONTACT_LAST_NAME)) LIKE LOWER('%$searchValue%'))
        OR
        (LOWER(TRIM(CONCAT(c.CONTACT_FIRST_NAME, ' ', c.CONTACT_LAST_NAME))) LIKE LOWER('%$searchValue%'))
    )
    GROUP BY c.CONTACT_FIRST_NAME, c.CONTACT_LAST_NAME, s.STUDENT_EPITA_EMAIL
    ORDER BY c.CONTACT_FIRST_NAME";


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
        
        <td><form action='../../actions/populationpage/edit_student.php?email=".$row['STUDENT_EPITA_EMAIL']."'  method='POST'> <button name='edit' class='edit' style='border: none; background-color: transparent;'>
        <img src='../../connectionquery/images/pen.png' style='width: 30px; height: 30px;'>
    </button></form>
    <form id='deleteform' action='../../actions/populationpage/delete_student.php?email=".$row['STUDENT_EPITA_EMAIL']."' method='POST' onsubmit='return confirmation()'>

    <button type='submit' name='delete' class='delete' style='border: none; background-color: transparent;'>
        <img src='../../connectionquery/images/delete.png' style='width: 30px; height: 30px;'>
    </button></form>
    </td>
    </tr>");
    }
    unset($_POST['searchstudent']);

    return $rows;
}
?>
