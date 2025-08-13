<?php
// Start the session
session_start();

// Include the database connection file
include_once 'main/connect.php';

// Check if the user is already logged in
if(isset($_SESSION['name'])) {
    // Redirect to index.php if user is already logged in
    header("Location: index.php");
    exit();
}

// Check if login form is submitted
if(isset($_POST['tenant_login'])){
    // Retrieve login form data
    $username = $_POST['name'];
    $roll_no = $_POST['rollno'];
    $password = $_POST['password'];
    
    // Sanitize input (to prevent SQL injection)
    $username = mysqli_real_escape_string($conn, $username);
    $roll_no = mysqli_real_escape_string($conn, $roll_no);
    $password = mysqli_real_escape_string($conn, $password);
    
    // Query to check if the user exists
    $select_query = "SELECT * FROM `students` WHERE username='$username' AND roll_no='$roll_no' AND password='$password'";
    $result = mysqli_query($conn, $select_query);
    
    // Check if a row is returned
    if(mysqli_num_rows($result) > 0){
        // Fetch user data
        $data = mysqli_fetch_array($result);
        
        // Set user data in session
        $_SESSION['name'] = $username;
        $_SESSION['roll_no'] = $roll_no;
        
        // Display JavaScript alert for successful login
        echo "<script>alert('Login successful! ".$_SESSION['name']."');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    } else {
        // If login fails, display an alert message and redirect back to login page
        echo "<script>alert('Incorrect credentials. Please try again.');</script>";
        header("Location: login.php?login_failed=true");
        exit();
    }
}
?>
