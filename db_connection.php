<?php
// Database connection details
session_start();
define('SITEURL','http://localhost/Online-Food-Order');
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'foodorder';


// Create a connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
