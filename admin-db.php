<?php
session_start();
// Database credentials
$dbHost = 'localhost:3306';
$dbUsername = 'your_username';
$dbPassword = 'your_password';
$dbName = 'votingsystem';

// Create a database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
// session_start();

if(isset($_POST['login'])){
    $admin_username = $_POST['email'];
    $_SESSION['email'] = $admin_username;
    $admin_password = $_POST['password'];
    
    $select_query = "SELECT * FROM `admin` WHERE email='$admin_username'";
    $result = mysqli_query($conn, $select_query);
    
    if (!$result) {
        // Error handling for database query
        echo "Error: " . mysqli_error($conn);
    } else {
        $row_count = mysqli_num_rows($result);
        if($row_count > 0){
            $row_data = mysqli_fetch_assoc($result);
            $_SESSION['email'] = $admin_username;
            if ($admin_password == $row_data['password']){
               
                echo "<script>window.open('index.php', '_self')</script>";
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
                echo "<script>window.open('admin-login.php', '_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid Credentials')</script>";
        }
    }
}

?>