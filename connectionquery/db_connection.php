<?php
/*
A single connection file
*/
function db_connect() {
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "epita";

    // Create a new mysqli object for the database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}