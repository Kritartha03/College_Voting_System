<?php
// Establish database connection
$servername = "localhost:3306"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>