<?php
/*
When the user enters correct username and password, we run the function and set up the username and
password so that we know that the session has been started and the user can't access protected pages unless they login.
*/
function login_admin(){
    if (isset($_POST['login'])){
        $username = $_POST['user_name'];
        $password = $_POST['password'];
        $conn = new mysqli("localhost", "root", "1234", "epita");
        $sql = "SELECT firstname 
            FROM admins where username = '".$username."' and password = '".$password."' ";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            $_SESSION["id"] = $username;
            $_SESSION["name"] = strtoupper($row['firstname']);
            header("Location: ../../index.php");
            
        } else {
            header("Location: loginform.php");
            $_SESSION['error'] = "Oh snap! Invalid login details!";
            // echo('$_SESSION['error']');
        }
    };   
}
?>