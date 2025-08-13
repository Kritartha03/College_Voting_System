<?php

include('../main/connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['election_id'])) {
    $election_id = $_POST['election_id'];

    // Get the filename from the database based on the election ID
    // Assuming the filename is stored in the 'result' column
    $result = $conn->query("SELECT result FROM election WHERE election_id = $election_id");
    $row = $result->fetch_assoc();
    $filename = $row['result'];

    // Delete the file if it exists
    if (!empty($filename) && file_exists($filename)) {
        unlink($filename);
    }

    // Update the database to remove the filename
    $conn->query("UPDATE election SET result = NULL WHERE election_id = $election_id");

    // Redirect back to admin-index.php or any other appropriate page
    header("Location: admin-index.php");
    exit;
} else {
    // Redirect to an error page or handle the error accordingly
    header("Location: error.php");
    exit;
}
?>