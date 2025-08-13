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

if(isset($_POST['save'])){
    // Retrieving data from the form
    $name = $_POST['voting_position'];
   
    
    // SQL query to insert data into the database
    $sql = "INSERT INTO `position` (voting_position) VALUES ('$name')";
    
    // Executing the query
    if ($conn->query($sql) === TRUE) {
		   echo"<script>alert('added successfulyy')</script> ";
		
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;

    }
    
}
?>
<?php
if(isset($_POST['delete'])){
    $position_id=$_POST['delete_id'];
    
    $sql2="DELETE FROM `position` WHERE position_id='$position_id'";
    $res2=mysqli_query($conn,$sql2);
    if($res2==true)
    {
      echo"<script>alert('Deleted successfuly')</script>";
    }
   
 }
     
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Positions</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    /* Internal CSS styling */
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
	body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .text-center {
      text-align: center;
    }

    .btn {
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-primary {
      background-color: #007bff;
      color: #fff;
      border: none;
    }

    .btn-danger {
      background-color: #dc3545;
      color: #fff;
      border: none;
    }

    .btn-primary:hover, .btn-danger:hover {
      opacity: 0.8;
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
                <a class="nav-link active" aria-current="page" href="index.php">Back</a>
              </li>
          </div>
        </div>
      </nav>
<div class="container">
    <h2 align="center">Add Positions</h2>
    <form id="login-form"action=""method="POST">
      <div class="form-group">
        <label for="id">voting_positions:</label>
        <input type="text" id="position_id" name="voting_position" required>
      
		<button class="button btn btn-info btn-sm"name="save">save</button>
    
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<table>
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Positions</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i = 1;
    $course = $conn->query("SELECT * FROM `position` ORDER BY position_id ASC");
    while($row = $course->fetch_assoc()):
    ?>
    <tr>
      <td class="text-center"><?php echo $i++ ?></td>
      <td><?php echo $row['voting_position'] ?></td>
      <td class="text-center">
        
        <form method="post" action=" " >
          <input type="hidden" name="delete_id" value="<?php echo $row['position_id']; ?>">
          <input type="submit" name="delete" class="btn btn-danger" value="Delete">
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<br>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>