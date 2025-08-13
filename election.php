<?php
// Establish database connection
$servername = "localhost"; // assuming your MySQL server is running on localhost
$username = "your_username";
$password = "your_password";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates with status 1 and their respective positions
$sql_candidates = "SELECT c.*, p.voting_position, p.position_id 
                   FROM candidate c
                   INNER JOIN position p ON c.position_id = p.position_id
                   WHERE c.status = 1";

$result_candidates = $conn->query($sql_candidates);

// Initialize message variables
$successMessage = "";
$errorMessage = "";

if ($result_candidates->num_rows > 0) {
    // Loop through each candidate
    while($row_candidate = $result_candidates->fetch_assoc()) {
        $candidate_id = $row_candidate["candidate_id"]; // Assuming candidate id is named "id" in the candidate table
        $username = $row_candidate["username"]; // Assuming username is named "username" in the candidate table
        $position_id = $row_candidate["position_id"]; // Fetching position id from the candidate table
        $position_name = $row_candidate["voting_position"]; // Fetching position name from the position table

        // Insert candidate into election table
        $sql_insert = "INSERT INTO election (candidate_id, username, voting_position, position_id) 
                       VALUES ('$candidate_id', '$username', '$position_name', '$position_id')";

        if ($conn->query($sql_insert) === TRUE) {
            // Set success message
            $successMessage .= "<script>alert('Candidate $username recorded in the election table with position $position_name.');</script>";
        } else {
            // Set error message
            $errorMessage .= "Error recording candidate $username: " . $conn->error . "<br>";
        }
    }
} else {
    $errorMessage = "No candidates with status 1 found.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Result</title>
</head>
<body>
    <div>
        <?php echo $successMessage; ?>
    </div>
    <div>
        <?php echo $errorMessage; ?>
    </div>
</body>
</html>
