<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;

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
    <center><h2 class="mb-4">Candidates List</h2></center>
    <div class="table-responsive">
        <table class="table table-hover" border="black">
            <thead class="thead-dark">
                <tr>
                    <th>Candidate ID</th>
                    <th>Name</th>
                    <th>Portfolio</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

                $sql = "SELECT candidate_id, username, voting_position FROM candidate WHERE status = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["candidate_id"]. "</td><td>" . $row["username"]. "</td><td>" . $row["voting_position"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>0 results</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
