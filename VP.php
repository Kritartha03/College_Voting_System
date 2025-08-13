<?php
session_start();
// Check if $_SESSION['data'] is set and not null
$data = $_SESSION['data'];
// $data = isset($_SESSION['data']) ? $_SESSION['data'] : null;
if ($_SESSION['status'] == 1) {
  $status = '<b class="text-success">Voted</b>';
} else {
  $status = '<b class="text-danger">Not Voted</b>';
}
// include('../candidate-db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voting Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    .align{
      text-align: right;
    }
  </style>
</head>

<body class="bg-secondary text-light">
  <div class="container my-5">
    <a href="panel.php"><button class="btn btn-dark text-light px-3">Back</button></a>
    <div class="align"><a href="logout.php"><button class="btn btn-dark text-light px-3 ">Logout</button></a></div>
    <br>
    <h2 class="my-3"> Vice President</h2>
    <div class="row my-5">
      <div class="col-md-7">

        <!--groups-->
        <?php

        include('../voter-login-db.php');
        
        // Database connection
        $host = 'localhost:3306';
        $dbname = 'votingsystem'; // Assuming your database name is 'votingsystem'
        $username = 'your_username';
        $password = 'your_password';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to fetch candidates for president position
            $sql = "SELECT * FROM candidate WHERE position_id = '3'";
            $stmt = $pdo->query($sql);

            // Fetch results
            $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($candidates as $candidate) {
                ?>
                <div class="row">
                  <div class="col-md-4">
                    <img src="photo1.jpg" alt="group image" height="60px" width="70px">
                  </div>
                  <div class="col-md-8">
                    <strong class="text-dark h5">Candidate Name:</strong>
                    <?php echo $candidate['username'] ?>
                    <br>
                    <strong class="text-dark h5">Votes:</strong>
                    <?php 
                    // Assuming 'role' represents the number of votes for each candidate
                    echo isset($candidate['role']) ? $candidate['role'] : '0'; 
                    ?>
                    <br>
                  </div>
                </div>
                
                <form action="election.php" method="post">
                  <input type="hidden" name="groupvotes" value="<?php echo $candidate['username'] ?>">
                  <input type="hidden" name="candidate_id" value="<?php echo isset($candidate['role']) ? $candidate['role'] : '0'; ?>">

                  <?php
                  
                  if($_SESSION['status']==1){
                    ?>
                    <button class="bg-danger my-3 text-white px-3">Voted</button>
                    <?php
                  }
                  else{
                    ?>
                    <button class="bg-success my-3 text-white px-3" type="submit">vote</button>
                    <?php
                  }

                  ?>
                </form>
                <hr>
            <?php
            }
        } catch (PDOException $e) {
            // Handle exception
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
      </div>

      <div class="col-md-5">
        <!--user profile-->
        <img src="photo1.jpg" alt="user image" height="60px" width="70px">
        <br><br>
        <strong class="text-dark h5">Name:</strong>
        <?php echo $data['username']; ?>

        <br><br>
        <strong class="text-dark h5">status:</strong>
        <?php echo $status; ?>
      </div>
    </div>
  </div>
  <div class="text-center">
    <a href="GS.php" class="btn btn-primary">Next</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
