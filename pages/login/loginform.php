<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> LOGIN HERE </h1>
    <form name="frmUser" method= "post" align="center">
        <h3> ENTER YOUR LOGIN DETAILS HERE </h3>
        <h4> username : </h4>
        <input type = "text" name = "user_name">
        <h4> Password : </h4>
        <input type= "password" name = "password">
        <br><br>
        <input type = "submit" name="login" value = "Submit">
        <input type = "reset">
</form> 
<?php 
    require_once '../../connectionquery/login.php';
    login_admin();
?>

</body>
</html>
