<?php
if (isset($_POST['delete'])) {
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "epita";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Use proper escaping or prepared statements to prevent SQL injection
    $STUDENT_EPITA_EMAIL = $conn->real_escape_string($_GET['email']);

    $sql = "DELETE c, s, a, g
    FROM CONTACTS c
    INNER JOIN STUDENTS s ON c.CONTACT_EMAIL = s.STUDENT_CONTACT_REF
    INNER JOIN ATTENDANCE a ON s.STUDENT_EPITA_EMAIL = a.ATTENDANCE_STUDENT_REF
    INNER JOIN GRADES g ON a.ATTENDANCE_STUDENT_REF = g.GRADE_STUDENT_EPITA_EMAIL_REF
    WHERE s.STUDENT_EPITA_EMAIL = '" . $STUDENT_EPITA_EMAIL . "'";

    if ($conn->query($sql) === TRUE) {
        header("Location: " .  $_SERVER['HTTP_REFERER']);
        exit;
      
    } else {
        echo "Connection error";
    }

    $conn->close();
}
?>
