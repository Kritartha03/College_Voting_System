<?php
session_start();

// Establish database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "your_username";
$password = "your_password";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted to truncate the candidate table
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['truncate_candidates'])) {
    // Update the status column in the students table
    $update_status_query = "UPDATE students SET status = 0";
    if ($conn->query($update_status_query) === TRUE) {
        // Truncate the candidate table
        $truncate_query = "TRUNCATE TABLE candidate";

        if ($conn->query($truncate_query) === TRUE) {
            echo "<script>alert('Candidate table truncated successfully and students status updated!')</script>";
            echo "<script>window.open('admin-index.php', '_self')</script>"; // Redirect to the homepage or any other page
            exit();
        } else {
            echo "Error: " . $truncate_query . "<br>" . $conn->error;
        }
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
