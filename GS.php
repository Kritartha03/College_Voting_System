<?php
session_start();

// Check if the user has already voted
if (isset($_SESSION['voted'])) {
    // Redirect the user or display a message indicating they have already voted
    header("Location: already_voted.php");
    exit; // Stop further execution of the script
}

// Process form submission
if (isset($_POST['submit_vote'])) {
    // Connect to MySQL database
    $conn = new mysqli("localhost", "username", "password", "votingsystem");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve student_id from the session
    if (isset($_SESSION['roll_no'])) {
        $rollno = $_SESSION['roll_no'];
    }

    // echo "<script>alert('".$_SESSION['roll_no']."');</script>";

    $check_voted_sql = "SELECT student_id FROM students WHERE roll_no = $rollno";
    $result = $conn->query($check_voted_sql);


    
    if ($result->num_rows == 1) {
        // Fetch the single row
        $row = $result->fetch_assoc();
        
        // Access the 'student_id' field from the fetched row
        $student_id = $row['student_id'];
        // Do something with $student_id
    } else {
        // Either no rows or multiple rows found
        if ($result->num_rows == 0) {
            echo "No rows found!";
        } else {
            echo "Multiple rows found!"; // This shouldn't happen if 'roll_no' is unique
        }
    }

    echo $student_id;
    // Check if the student has already voted
    $check_voted_sql = "SELECT * FROM students WHERE student_id = $student_id AND status = 1";
    $result = $conn->query($check_voted_sql);

    if ($result->num_rows > 0) {
        // Student has already voted, redirect to already_voted.php
        $_SESSION['voted'] = true;
        header("Location: already_voted.php");
        exit;
    } else {
        // Student has not voted yet, proceed with voting

        // Loop through selected candidates
        foreach ($_POST['candidate_id'] as $position_id => $candidate_id) {
            // Update vote count in the candidate table
            $update_sql = "UPDATE candidate SET votes = votes + 1 WHERE position_id = $position_id AND candidate_id = $candidate_id";
            if ($conn->query($update_sql) !== TRUE) {
                echo "<div class='message'>Error updating vote count: " . $conn->error . "</div>";
            }
        }

        // Mark the user as voted
        $_SESSION['voted'] = true;

        // Update the status of the student to 1 (voted)
        $update_student_status_sql = "UPDATE students SET status = 1 WHERE student_id = $student_id";
        if ($conn->query($update_student_status_sql) !== TRUE) {
            echo "<div class='message'>Error updating student status: " . $conn->error . "</div>";
        }

        // echo "<div class='message'>Votes submitted successfully</div>";
        echo "<script>window.location.href = 'votedsucessfull.php';</script>";
    }

    $conn->close();
}


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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('../admin/img\ vote.avif');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .voting-section {
            margin-bottom: 20px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007bff;
            background-image: url('../admin/assets-cached.jpg');
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: red;
        }
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">

<div class="container-fluid">
    <img src="../admin/img2.webp" alt="logo" height="60px" width="70px">&nbsp;
  <h2>Voting System</h2>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active text-dark" aria-current="page" href="../index.php">Back</a>
      </li>
  </div>
</div>
</nav>
<div class="container">
    <h1 class="text-danger"><b><u>Voting Panel</u></b></h1>
    <form id="votingForm" method="post">
        <?php
        // Connect to MySQL database
        $conn = new mysqli("localhost", "username", "password", "votingsystem");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch positions from the database
        $sql_positions = "SELECT * FROM position";
        $result_positions = $conn->query($sql_positions);

        if ($result_positions->num_rows > 0) {
            while ($row_position = $result_positions->fetch_assoc()) {
                echo "<div class='voting-section'>";
                echo "<h2 class='text-success'>" . $row_position["voting_position"] . "</h2>";

                // Fetch candidates for each position from the candidate table where status=1
                $position_id = $row_position["position_id"];
                $sql_candidates = "SELECT * FROM candidate WHERE position_id = $position_id AND status=1";
                $result_candidates = $conn->query($sql_candidates);

                if ($result_candidates->num_rows > 0) {
                    while ($row_candidate = $result_candidates->fetch_assoc()) {
                        // Use the correct column name from your database table
                        echo '<input type="radio" name="candidate_id[' . $position_id . ']" value="' . $row_candidate["candidate_id"] . '">' . $row_candidate["username"] . '<br>';
                    }
                } else {
                    echo "<div class='message'>No candidates found for this position.</div>";
                }
                echo "</div>";
            }
            echo "<input type='submit' name='submit_vote' value='Vote'>";
        } else {
            echo "<div class='message'>No positions found.</div>";
        }

        $conn->close();
        ?>
    </form>
</div>
<script>
    document.getElementById('votingForm').addEventListener('submit', function (event) {
        var sections = document.querySelectorAll('.voting-section');
        var allSelected = true;
        sections.forEach(function (section) {
            var radios = section.querySelectorAll('input[type="radio"]');
            var selected = false;
            radios.forEach(function (radio) {
                if (radio.checked) {
                    selected = true;
                }
            });
            if (!selected) {
                allSelected = false;
            }
        });
        if (!allSelected) {
            event.preventDefault();
            alert('Please select a candidate for each section before submitting.');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
