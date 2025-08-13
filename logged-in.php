<?php
// Start the session
session_start();

// Include the database connection file
include_once 'main/connect.php';

// Check if the user is logged in
if(isset($_SESSION['voter_id'])) {
    // Fetch the username from the database
    $user_id = $_SESSION['voter_id'];
    $sql = "SELECT username FROM voters WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    
    // Check if the query executed successfully
    if($result) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
    } else {
        // Error handling: If the query fails, set a default username
        $username = "My Profile";
    }
} else {
    // If the user is not logged in, set the default username
    $username = "My Profile";
}

// Check if logout request is made
if(isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: index.php");
    exit;
}

// Check if login request is made
if(isset($_POST['tenant_login'])){
    $username = $_POST['name'];
    $roll_no = $_POST['rollno'];
    $password = $_POST['password'];
    
    // Establish your database connection here
    
    // Assuming $conn is your database connection object
    
    $select_query = "SELECT * FROM `voters` WHERE username='$username' AND roll_no='$roll_no' AND password='$password'";
    $result = mysqli_query($conn, $select_query);
    
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_array($result);
        
        // Set user data in session
        if(isset($data['id'])) {
            $_SESSION['user_id'] = $data['id'];
        }
        
        // Redirect to logged-in.php
        header("Location: logged-in.php");
        exit(); // Exit to prevent further execution
    } else {
        // Redirect to login.php if login fails
        header("Location: login.php?login_failed=true");
        exit(); // Exit to prevent further execution
    }
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
            padding-left: 60%;
        }
        .button{
            position: absolute;
            right: 50%;
            top: 75%;
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
                        <a class="nav-link active" aria-current="page" href="logged-in.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right">
                            <?php echo $username; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="main/logout.php" id="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="button">
        <a href="main/GS.php"><button type="button" class="btn btn-secondary btn-lg">Start Voting</button></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if login attempt failed
        if(<?php echo isset($_GET['login_failed']) ? 'true' : 'false'; ?>) {
            alert("Invalid credentials. Please try again.");
        }
    </script>
</body>
</html>
