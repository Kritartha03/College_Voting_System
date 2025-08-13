<?php
// Establish database connection
$servername = "localhost:3306"; // Change this if your database is hosted elsewhere
$username = "your_username";
$password = "your_password";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// include ('login.php'); // Include database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $status = $_POST['status'];


    $select_query = "SELECT * FROM students WHERE username='$name' OR roll_no='$roll_no'";
 $result=mysqli_query($conn, $select_query);
 $rows_count = mysqli_num_rows($result);
 if ($rows_count > 0) {
     echo "<script> alert('Username and Roll No. already exist already exist')</script>";
     echo "<script>window.open('register.php', '_self')</script>";
 } else if ($password != $_POST['cpassword']) {
     echo "<script>alert('Passwords do not match')</script>";
     echo "<script>window.open('register.php', '_self')</script>";
 }

else{

    // Example SQL query to insert data into a table
    $sql = "INSERT INTO `students`(username, roll_no, email_id, password, course, semester, status) 
            VALUES ('$name', '$roll_no', '$email', '$password', '$course', '$semester', '0')";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Display success message
        echo "<script>alert('Registration successful!')</script>";
        // Redirect to next PHP page after displaying the alert
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

// Close connection
$conn->close();
?>