<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Election</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .form-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mt-5 mb-4">College Election</h1>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "votingsystem";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the voter has already voted
        if (isset($_POST['voter_id'])) {
            $voter_id = $_POST['voter_id'];
            $check_vote_sql = "SELECT * FROM voters WHERE voter_id='$voter_id' AND status = 1";
            $check_vote_result = $conn->query($check_vote_sql);
            if ($check_vote_result->num_rows > 0) {
                echo "<script>alert('You have already voted.');</script>";
            } else {
                // Check if all positions have been selected
                $allPositionsSelected = true;
                foreach ($_POST['position'] as $position_id => $candidate_id) {
                    if (empty($candidate_id)) {
                        $allPositionsSelected = false;
                        break;
                    }
                }

                if ($allPositionsSelected) {
                    // Iterate over each position and insert into election table
                    foreach ($_POST['position'] as $position_id => $candidate_id) {
                        // Insert vote into election table
                        $sql = "INSERT INTO election (candidate_id, position_id) VALUES ('$candidate_id', '$position_id')";
                        if ($conn->query($sql) !== TRUE) {
                            echo "Error inserting vote into election table: " . $conn->error;
                        }
                    }
                    // Update voter status to 'voted'
                    $update_status_sql = "UPDATE voters SET status = 1 WHERE voter_id = '$voter_id'";
                    if ($conn->query($update_status_sql) !== TRUE) {
                        echo "Error updating voter status: " . $conn->error;
                    }
                    echo "<script>alert('Voting Successful!');</script>"; // Display voting success message
                } else {
                    echo "<script>alert('Please select a candidate for all positions.');</script>"; // Display error message
                }
            }
        } else {
            echo "<script>alert('Voter ID not found.');</script>"; // Display error message
        }
    }

    // //Logout button
    // include('logout.php');

    // Fetch voter data
    $sql = "SELECT * FROM voters";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $voter_row = $result->fetch_assoc();
        $voter_id = $voter_row['voter_id'];
        $voter_name = $voter_row['username'];

        echo "<h3>Welcome, $voter_name!</h3>";

        // Query to fetch candidates grouped by position_id
        $sql = "SELECT candidate.*, position.position_id, position.voting_position 
        FROM candidate 
        INNER JOIN position ON candidate.position_id = position.position_id 
        ORDER BY candidate.position_id";
        $result = $conn->query($sql);

        $current_position = null;

        if ($result->num_rows > 0) {
            echo "<form id='electionForm' method='post'>";
            while ($row = $result->fetch_assoc()) {
                $position_id = $row["position_id"];
                $voting_position = $row["voting_position"];
                $candidate_id = $row["candidate_id"];
                $candidate_name = $row["username"];

                if ($position_id != $current_position) {
                    if ($current_position !== null) {
                        echo "</div>"; // Close previous form-container div
                    }
                    $current_position = $position_id;
                    echo "<div class='form-container'>";
                    echo "<h2>$voting_position</h2>";
                }

                echo "<div class='form-group'>";
                echo "<label for='candidate$candidate_id'><input type='radio' id='candidate$candidate_id' name='position[$position_id]' value='$candidate_id'> Vote for $candidate_name</label>";
                echo "</div>";
            }
            echo "</div>"; // Close last form-container div
            echo "<input type='hidden' name='voter_id' value='$voter_id'>";
            echo "<button type='submit' class='btn btn-primary' id='submitButton' name='vote'>Vote</button>";
            echo "</form>";
        } else {
            echo "No candidates found.";
        }
    } else {
        echo "No voters found.";
    }

    $conn->close();
    ?>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
document.getElementById('electionForm').addEventListener('submit', function(event) {
    var positions = document.querySelectorAll('input[type="radio"]');
    var checkedPositions = {};
    for (var i = 0; i < positions.length; i++) {
        var positionId = positions[i].name;
        if (!checkedPositions[positionId]) {
            checkedPositions[positionId] = false;
        }
        if (positions[i].checked) {
            checkedPositions[positionId] = true;
        }
    }
    for (var key in checkedPositions) {
        if (!checkedPositions[key]) {
            event.preventDefault(); // Prevent form submission
            alert('Please select a candidate for all positions.');
            return;
        }
    }
});
</script>


</body>
</html>
