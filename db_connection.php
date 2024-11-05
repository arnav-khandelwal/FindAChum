<?php
// Database credentials
$host = 'localhost';        // Typically 'localhost'
$dbname = 'findchums';   // Replace with your database name
$username = 'root';      // Replace with your database username
$password = '123456';      // Replace with your database password

// Create a connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
