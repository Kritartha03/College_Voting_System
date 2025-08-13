<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include('main/connect.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-top: 10px;
            text-align: center;
            display: block;
        }
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
        
    </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
    <h2>Password Change</h2>
    <form action="#" method="POST">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" maxlength="5" minlength="3" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" maxlength="5" minlength="3" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" maxlength="5" minlength="3" required>

        <button type="submit" class="button btn btn-primary" name="change_password">Change Password</button>
        <br>
    </form>
</div>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $servername = "localhost"; // Change this to your server name
    $username = "your_username"; // Change this to your database username
    $password = "your_password"; // Change this to your database password
    $dbname = "votingsystem"; // Change this to your database name

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password must be the same');</script>";
    } else {
        $email = $_SESSION['name'];

        // Fetch the user's password from the database based on the email
        $stmt = $conn->prepare("SELECT password FROM students WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            if (password_verify($old_password, $hashed_password)) {
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE students SET password = ? WHERE username = ?");
                $update_stmt->bind_param("ss", $new_hashed_password, $email);
                if ($update_stmt->execute()) {
                    echo "<script>alert('Password Changed Successfully!.');</script>";
                } else {
                    echo "<script>alert('Error');</script>";
                }
            } else {
                echo "<script>alert('Incorrect old password');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
    }
}
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1K2j5fLvUpc5G7X8IaxwTZI5NqAOfW1" crossorigin="anonymous"></script>    
</body>
</html>
