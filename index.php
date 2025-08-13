<?php
session_start();

// Check if logout is requested
if(isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // If yes, destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: index.php");
    exit();
}

// Include the database connection file if needed
// include('admin/db_connect.php');

// Check if nomination started and get election name
function isNominationStarted() {
    // Assuming you have already connected to the database
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $database = "votingsystem";
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch nomination status, election name, and year
    $query = "SELECT status, election_name, year FROM election WHERE status = 1";

    // Execute the query
    $result = $conn->query($query);

    // Check if there are any rows returned
    if ($result && $result->num_rows > 0) {
        // Nomination started
        $row = $result->fetch_assoc();

        return array("status" => true, "election_name" => $row['election_name'], "year" => $row['year']);
    } else {
        // Nomination not started
        return array("status" => false, "election_name" => "", "year" => "");
    }

    // Close the connection
    $conn->close();
}

function isElectionStarted() {
    // Assuming you have already connected to the database
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $database = "votingsystem";
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch nomination status, election name, and year
    $query = "SELECT ele_status FROM election WHERE ele_status = 1";

    // Execute the query
    $result = $conn->query($query);

    // Check if there are any rows returned
    if ($result && $result->num_rows > 0) {
        // Nomination started
        $row = $result->fetch_assoc();

        // echo "<script>alert('".$row['ele_status']."')</script>";

        return array("ele_status" => $row['ele_status']);
    } else {
        // echo "<script>alert('0')</script>";
        // Nomination not started
        return array("ele_status" => false);
    }

    // Close the connection
    $conn->close();
}

$nominationData = isNominationStarted();
$isNominationStarted = $nominationData['status'];
$electionName = $nominationData['election_name'];
$electionYear = $nominationData['year'];
$iselectiondata = isElectionStarted();
$elestatus = $iselectiondata['ele_status'];
$electionStartedMessage = '';

if ($elestatus == 1) {
    $electionStartedMessage = "The Election has started";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body{
            background-image: url('img3.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
        .button{
            position: absolute;
            right: 50%;
            top: 75%;
        }
        /* Add style for the rectangular div */
        .rectangle {
            position: absolute;
            right: 30px;
            top: 100px;
            width: 30%;
            height: fit-content; /* Adjust height as needed */
            border: 1px solid black;
            border-radius: 20px;
            overflow: hidden;
        }
        .message {
            color: green;
            text-align: center;
            white-space: nowrap;
        }
        .move-left {
    animation: moveLeft 10s linear infinite;
}

@keyframes moveLeft {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(calc(-100% - 4vw));
    }
}

.move-right {
    animation: moveRight 10s linear infinite;
}

@keyframes moveRight {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}


    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="img2.webp" alt="logo" height="60px" width="70px">&nbsp;
            <h2>Voting System</h2>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php if(!isset($_SESSION['name'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right">Register</a>
                            <ul class="dropdown-menu">
                                <!-- <li><a class="dropdown-item" href="candidate-register.php">Candidate Nomination</a></li> -->
                                <li><a class="dropdown-item" href="register.php">Student Register</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(!isset($_SESSION['name'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right">LOGIN</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="admin/admin-login.php">Admin login</a></li>
                                <li><a class="dropdown-item" href="login.php">Student login</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['name'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right">Nomination</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="candidate-register.php">Candidate Nomination</a></li>
                                <!-- <li><a class="dropdown-item" href="register.php">Student Register</a></li> -->
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['name'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right"><?php echo $_SESSION['name']; ?></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="user-profile.php" id="logout">Profile</a></li>
                                <li><a class="dropdown-item" href="./index.php?logout=true" id="logout" onclick="return confirmDelete()">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
     
    <?php if(!isset($_SESSION['name'])): ?>
        <div class="button">
            <a href="login.php"><button type="button" class="btn btn-primary btn-lg">Voters Login</button></a>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['name']) && $elestatus==1): ?>
        <div class="button">
            <a href="main/GS.php"><button type="button" class="btn btn-secondary btn-lg">Start Voting</button></a>
        </div>
    <?php endif; ?>

    <div class="rectangle">
    <center><p class="text-danger"><b><u>NOTIFICATION</b></u></p></center>
    <p class="message <?php echo $isNominationStarted ? 'move-left' : ''; ?>">
        <?php 
        if ($isNominationStarted) {
            echo "Nomination has started for the election '" . $electionName . "' of the year " . $electionYear;
        } 
        ?>
    </p>
    <?php if ($electionStartedMessage !== ''): ?>
        <p class="message move-right"><?php echo $electionStartedMessage; ?></p>
    <?php endif; ?>
</div>

    <div class="container">
        <?php
        // Check if the 'nomination_started' parameter is set in the URL
        if(isset($_GET['nomination_started']) && $_GET['nomination_started'] == 'true') {
            echo "<div class='alert alert-success' role='alert'>Nomination Started</div>";
        }
        ?>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to Logout?");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ensure you have jQuery included -->
</body>
</html>
