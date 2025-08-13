<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include('main/connect.php');

// Fetch user details from the database
$username = $_SESSION['name'];
$query = "SELECT s.username, s.roll_no, s.password, s.status, c.department 
          FROM students s 
          JOIN courses c ON s.course = c.course_id 
          WHERE s.username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);


// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ygtJBxY8MeovjRrXRtKN3B+KlNt65MOIVADIn6zvDlNTqxFQnJWlZk5U02zK+oaX" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 0 auto;
        }
        h1, h3 {
            text-align: center;
            color: #333;
        }
        .table th, .table td {
            border-top: none;
            border-color: #dee2e6;
            padding: 12px 15px;
        }
        .table th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 500;
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
    <img src="img2.webp" alt="logo" height="60px" width="70px">&nbsp;
  <h2>Voting System</h2>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active text-dark" aria-current="page" href="index.php">Back</a>
      </li>
  </div>
</div>
</nav>
    <div class="container">
        <h3 class="mb-4">Welcome, <?php echo $username; ?></h3>
        <table class="table table-bordered">
            <tr>
                <th>Attribute</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $row['username']; ?></td>
            </tr>
            <tr>
                <td>Roll No</td>
                <td><?php echo $row['roll_no']; ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><?php echo $row['password']; ?></td>
            </tr>
            <tr>
                <td>Course</td>
                <td><?php echo $row['department']; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?php echo ($row['status'] == 0) ? 'Not Voted' : 'Voted'; ?></td>
            </tr>
        </table><br>
        <center><a href="student-pass.php">Change Password</a></center>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1K2j5fLvUpc5G7X8IaxwTZI5NqAOfW1" crossorigin="anonymous"></script>
</body>
</html>