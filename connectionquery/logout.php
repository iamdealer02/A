<?php
/*
unsetting a session or emptying the dictionary to pop all the keys and value
that exists for the session. Hence the user is logged out.
*/
session_start();
session_unset();
header("location:../pages/login/loginform.php")
?>