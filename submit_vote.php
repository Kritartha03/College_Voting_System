<?php
// Connect to MySQL database
$conn = new mysqli("localhost", "username", "password", "votingsystem");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a candidate is selected
    if(isset($_POST['candidate_id']) && !empty($_POST['candidate_id'])) {
        $candidate_id = $_POST['candidate_id'];

        // Update vote count for the selected candidate
        $update_sql = "UPDATE election SET vote_count = vote_count + 1 WHERE candidate_id = $candidate_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "Vote submitted successfully";
        } else {
            echo "Error updating vote count: " . $conn->error;
        }
    } else {
        echo "Please select a candidate to vote";
    }
}

// Close connection
$conn->close();
?>
