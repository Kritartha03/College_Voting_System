<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Voter Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .collapse{
            justify-content: center;
            padding-left: 58%;
        }
        .btn{
            position: absolute;
            right: 48%;
            top: 60%;
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
                  <li><a class="dropdown-item" href="admin-login.php">Admin login</a></li>
                  <li><a class="dropdown-item" href="login.php">Student login</a></li>
                </ul>
              </li>

          </div>
        </div>
      </nav>
      <div class="container">
        <h3 style="font-weight: bold; text-align: center;">Student Login</h3><hr><br><br>
        <form method="POST" action="voter-login-db.php">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="name" class="form-control" id="name" placeholder="Enter Name" name="name" required>
          </div><br>
          <div class="form-group">
            <label for="rollno">ROll No:</label>
            <input type="rollno" class="form-control" id="rollno" placeholder="Enter Roll No." name="rollno" maxlength="12" minlength="12" required>
          </div><br>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" maxlength="12" minlength="3">
          </div>
          <center><input type="submit" id="submit" name="tenant_login" class="btn btn-primary btn-block" value="Login"></center>
        </form>
      </div><br><br><br><br><br><br><br><br><br><br>
      <div align='center'>
        <p>Don't have an Account?</p>
        <a href="register.php">Register</a>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>