<?php
include('main/connect.php');
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
            padding-left: 58%;
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
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" align="right">
              LOGIN
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Admin login</a></li>
              <li><a class="dropdown-item" href="login.php">Student login</a></li>
            </ul>
          </li>

      </div>
    </div>
  </nav>
    <div class="container">
        <h3 style="font-weight: bold; text-align: center;">Student Registration</h3><hr><br>
        <form method="POST" action="db.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
          </div><br>
          
          <div class="form-group">
            <label for="roll_no">Roll No:</label>
            <input type="roll_no" class="form-control" id="roll_no" placeholder="Enter your Roll No" name="roll_no" maxlength="12" minlength="12" required>
          </div><br>

          <div class="form-group">
            <label for="name">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your Email ID" name="email" required>
          </div><br>

          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your Password" name="password" maxlength="12" minlength="6" required>
          </div><br>

          <div class="form-group">
            <label for="cpassword">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" placeholder="Re-enter Password" name="cpassword" maxlength="12" minlength="6" required>
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
            <label for="semester">Semester:</label>
            <input type="text" class="form-control" id="semester" placeholder="Enter your Semester" name="semester" maxlength="1" minlength="1" required>
          </div><br>

          <hr>
          <center><button id="submit" name="tenant_register" class="btn btn-primary btn-block" onclick="return Validate()">Register</button></center><br>
          <div class="form-group text-right" align="center">
            <label class="">Already have an account? <br> <br> <a href="login.php">Login</a></label><br>
          </div><br><br>
        </form>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>