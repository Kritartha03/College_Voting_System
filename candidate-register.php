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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
      .collapse{
            justify-content: center;
            padding-left: 60%;
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
          
      </div>
    </div>
  </nav>
    <div class="container">
        <h3 style="font-weight: bold; text-align: center;">Candidate Nomination Form</h3><hr><br>
        <form method="POST" action="candidate-db.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
          </div><br>
          
          <div class="form-group">
            <label for="roll_no">Roll No:</label>
            <input type="roll_no" class="form-control" id="roll_no" placeholder="Enter your Roll No" name="roll_no" maxlength="12" minlength="12" required>
          </div><br>

          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your Password" name="password" maxlength="12" minlength="3" required>
          </div><br>

          <div class="form-group">
            <label for="cpassword">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" placeholder="Re-enter Password" name="cpassword" maxlength="12" minlength="3" required>
          </div><br>

          <div class="form-group">
            <label for="course">Course:</label>
            <select class="form-control" name="course" required>
              <option></option>
              <?php 
                                                    $course = $conn->query("SELECT * FROM courses order by department asc");
                                                    while($row=$course->fetch_assoc()):
                                                    ?>
                                                        <option value="<?php echo $row['course_id'] ?>"><?php echo $row['department'] ?></option>
                                                    <?php endwhile; ?>

            </select>
          </div><br>

          <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" name="role" required>
              <option></option>
              <?php 
              // Fetch positions with fewer than two candidates
              $positions = $conn->query("SELECT p.position_id, p.voting_position, COUNT(c.position_id) AS candidate_count
                                         FROM position p
                                         LEFT JOIN candidate c ON p.position_id = c.position_id
                                         GROUP BY p.position_id
                                         HAVING candidate_count < 2");
              while($row = $positions->fetch_assoc()):
              ?>
              <option value="<?php echo $row['position_id'] ?>"><?php echo $row['voting_position'] ?></option>
              <?php endwhile; ?>
            </select>
          </div><br>

          <hr>
          <center><button id="submit" name="tenant_register" class="btn btn-primary btn-block" onclick="return Validate()">Register</button></center><br>
        </form>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>