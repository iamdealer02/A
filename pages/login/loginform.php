
<?php
// loginform.php

// Start the session to access session variables
session_start();

// Check if there's an error message in the session
if (isset($_SESSION['error'])) {
    // Display the error message
    echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';

    // Clear the error message from the session so that it won't be displayed again
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #333;
            
         
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h3 {
            color: #555;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        input[type="submit"],
        input[type="reset"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form name="frmUser" method= "post" >
        <h3> ENTER YOUR LOGIN DETAILS HERE </h3>
        <h4> Username: </h4>
        <input type="text" name="user_name">
        <h4> Password: </h4>
        <input type="password" name="password">
        <br><br>
        <input type="submit" name="login" value="Submit">

        <input type="reset">
    </form>
<?php 
    require_once '../../connectionquery/login.php';
    login_admin();
    //function for setting up the session username and password so that we know that the session has been
    //started and the pages can't be accessed unless you have logged in.
?>

</body>
</html>
