<?php
// Establish database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $role = $_POST['role'];
    $roll_no = $_POST['roll_no'];
    $password=$_POST['password'];
    $course=$_POST['course']; // Retrieve course from form data

    // Check if the election status is 1
$election_query = "SELECT election_id, election_name FROM election WHERE status = 1";
$election_result = $conn->query($election_query);

if ($election_result->num_rows == 1) {
    $row_election = $election_result->fetch_assoc();
    $election_id = $row_election['election_id'];
    $election_name = $row_election['election_name'];

    // Assuming other necessary variables are already defined
    // Check if the candidate already exists
    $select_query = "SELECT * FROM students WHERE username='$name' AND roll_no='$roll_no' AND password='$password' AND course='$course'";
    $result = $conn->query($select_query);

    if ($result->num_rows == 0) {
        echo "<script>alert('Name or Roll No. not found in the students table')</script>";
        echo "<script>window.open('candidate-register.php', '_self')</script>";
    } else {
        // Fetch voting position from the position table
        $position_query = "SELECT voting_position FROM position WHERE position_id='$role'";
        $position_result = $conn->query($position_query);

        if ($position_result->num_rows > 0) {
            $row_position = $position_result->fetch_assoc();
            $voting_position = $row_position['voting_position'];

            // Insert candidate into candidate table with dynamically fetched $election_id
            $sql_candidate = "INSERT INTO candidate (username, course_id, position_id, voting_position, election_id, status) 
                              VALUES ('$name', '$course', '$role', '$voting_position', '$election_id', '0')";

            if ($conn->query($sql_candidate) === TRUE) {
                echo "<script>alert('Nomination successful!')</script>";
                echo "<script>window.open('index.php', '_self')</script>";
                exit();
            } else {
                echo "Error: " . $sql_candidate . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Position ID does not exist')</script>";
            echo "<script>window.open('candidate-register.php', '_self')</script>";
        }
    }
} else {
    echo "<script>alert('Nomination for the election $election_name is not started yet')</script>";
    echo "<script>window.open('candidate-register.php', '_self')</script>";
}
}

// Close connection
$conn->close();
?>
