<?php
session_start();

if(isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page after logout
    header("Location: ../index.php");
    exit;
}

// Include the database connection file if needed
// include('admin/db_connect.php');
?>