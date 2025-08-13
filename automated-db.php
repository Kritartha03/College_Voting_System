<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close connection to create a new one with the selected database
$conn->close();

// Connect to the newly created database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create admin table
$sql_admin = "CREATE TABLE IF NOT EXISTS admin (
    Admin_id INT(6) PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

// Execute SQL queries
if ($conn->query($sql_admin) === TRUE) {
    echo "Table ADMIN created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}


$sql_users = "CREATE TABLE IF NOT EXISTS voters (
    voter_id INT(6) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    roll_no VARCHAR(30) NOT NULL,
    password INT NOT NULL,
    course VARCHAR(20) NOT NULL
)";

// Execute SQL queries
if ($conn->query($sql_users) === TRUE) {
    echo "Tables voters created successfully<br>";
} else {
    echo "Error creating tables: " . $conn->error;
}

$sql_users = "CREATE TABLE IF NOT EXISTS candidate (
    candidate_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30),
    roll_no VARCHAR(30),
    password VARCHAR(20),
    course VARCHAR(30),
    id_type VARCHAR(30) 
)";

// Execute SQL queries
if ($conn->query($sql_users) === TRUE) {
    echo "Tables candidate created successfully<br>";
} else {
    echo "Error creating tables: " . $conn->error;
}

$sql_users = "CREATE TABLE IF NOT EXISTS position (
    position_id INT(6) PRIMARY KEY,
    candidate_id INT(10),
    FOREIGN KEY (candidate_id) REFERENCES candidate(candidate_id),
    voting_position VARCHAR(20)
)";

// Execute SQL queries
if ($conn->query($sql_users) === TRUE) {
    echo "Tables position created successfully<br>";
} else {
    echo "Error creating tables: " . $conn->error;
}

$sql_users = "CREATE TABLE IF NOT EXISTS election (
    election_id INT AUTO_INCREMENT PRIMARY KEY,
    voter_id INT(10),
    FOREIGN KEY (voter_id) REFERENCES voters(voter_id),
    voting_position VARCHAR(20),
    candidate_id INT(10),
    FOREIGN KEY (candidate_id) REFERENCES candidate(candidate_id),
    date_created date NOT NULL DEFAULT current_timestamp()
)";
// Execute SQL queries
if ($conn->query($sql_users) === TRUE) {
    echo "Tables election created successfully<br>";
} else {
    echo "Error creating tables: " . $conn->error;
}


$conn->close();
?>