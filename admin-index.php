<?php
session_start();

// Establish database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "your_username";
$password = "your_password";
$dbname = "votingsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $year = $_POST['year'];
    $election_name = isset($_POST['election_name']) ? $_POST['election_name'] : '';
    // Save the selected year and election name in session variables
    $_SESSION['selected_year'] = $year;
    $_SESSION['selected_election_name'] = $election_name;

    // Check if the election_id already exists
    $check_sql = "SELECT * FROM election WHERE year = '$year' AND election_name='$election_name'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Election ID already exists, display alert message
        // echo '<script>alert("This session of election already exist.");</script>';
    } else {
        // Insert data into the election table
        $sql = "INSERT INTO election (year, election_name) VALUES ('$year', '$election_name')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to admin-index.php after successful submission
            header("Location: admin-index.php");
            exit;
        } else {
            // Error alert message
            echo '<script>alert("Error: ' . $sql . '\n' . $conn->error . '");</script>';
        }

        // Remove session variables after inserting data into the database
        unset($_SESSION['selected_year']);
        unset($_SESSION['selected_election_name']);
    }
}

if(isset($_POST['verify'])){
    $election_id = $_POST['election_id'];
    $election_year = $_POST['year'];
    // Deactivate all other nominations
    $conn->query("UPDATE election SET status = 0 WHERE year != $election_id");
    // Activate the selected nomination
    $conn->query("UPDATE election SET status = 1 WHERE year = $election_year AND election_id = $election_id");
    echo '<script>alert("Nomination Started.");</script>';
}

if(isset($_POST['delete'])){
    $election_id = $_POST['election_id'];
    $election_year = $_POST['year'];
    // Update the status of the selected election to 0
    // Deactivate all other nominations
    $conn->query("UPDATE election SET status = 0 WHERE year != $election_id");
    $conn->query("UPDATE election SET status = 0 WHERE year = $election_year AND election_id = $election_id");
    echo '<script>alert("Nomination Ended.");</script>';
}

if(isset($_POST['start_election'])){
    $election_year = $_POST['year'];
    $election_id = $_POST['election_id'];
    // Deactivate all other nominations
    $conn->query("UPDATE election SET ele_status = 0 WHERE year != $election_id");
    $conn->query("UPDATE election SET ele_status = 1 WHERE year = $election_year AND election_id = $election_id");
    echo '<script>alert("Election Started.");</script>';
}

if(isset($_POST['stop_election'])){
    $election_year = $_POST['year'];
    $election_id = $_POST['election_id'];
    // Update the status of the election to 0
    // Deactivate all other nominations
    $conn->query("UPDATE election SET ele_status = 0 WHERE year != $election_id");
    $conn->query("UPDATE election SET ele_status = 0 WHERE year = $election_year AND election_id = $election_id");
    echo '<script>alert("Election Ended.");</script>';
}

?>

<!-- Your HTML code goes here -->

<?php
// Close connection
// $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        .btn {
            margin-top: 20px;
        }

        .position-content {
            margin-top: 50px;
        }
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
        .col-md-4{
            position: absolute;
            top: 65px;
            right: 1px;
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
    <h2 class="text-center mb-4">Create Election</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="year" class="form-label">Year:</label>
            <select class="form-select" id="year" name="year" required>
                <?php
                // Starting year
                $start_year = 2024;
                // Current year
                $current_year = date('Y');

                // Loop through the years starting from 2023 to the current year
                for ($year = $start_year; $year <= $current_year; $year++) {
                    echo '<option value="' . $year . '">' . $year . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="election_name" class="form-label">Election Name:</label>
            <input type="text" class="form-control" id="election_name" name="election_name" required>
        </div>
        <center><button type="submit" class="btn btn-primary" name="create">Create</button></center>
    </form>
</div>
<div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">List of Elections</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Election_ID</th>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Election Name</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Nomination</th>
                                        <th class="text-center">Election</th>
                                        <th class="text-center">Result</th>
                                        <th class="text-center">View Result</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php 
$i = 1;
$candidates = $conn->query("SELECT * FROM election");
while($row = $candidates->fetch_assoc()):
?>
<tr>
    <td class="text-center"><?php echo $row['election_id'] ?></td>
    <td class="text-center">
        <?php echo isset($row['year']) ? ucwords($row['year']) : '' ?>
    </td>
    <td class="text-center" ><?php echo isset($row['election_name']) ? $row['election_name'] : '' ?></td>
    <td class="text-center">
        <?php if($row['status'] == 1): ?>
            <span class="badge badge-verified text-success">Nomination Started</span>
        <?php else: ?>
            <span class="badge badge-not-verified text-danger">Nomination yet to be start</span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <?php if($row['status'] == 1): ?>
            <!-- Add the delete button -->
            <form action="" method="POST" style="display: inline;">
                <input type="hidden" name="election_id" value="<?php echo $row['election_id'] ?>">
                <input type="hidden" name="year" value="<?php echo $row['year'] ?>">
                <input type="submit" name="delete" class="btn btn-danger btn-sm" value="End Nomination">
            </form>
        <?php else: ?>
            <!-- Add the verify button -->
            <form action="" method="POST" style="display: inline;">
                <input type="hidden" name="election_id" value="<?php echo $row['election_id'] ?>">
                <input type="hidden" name="year" value="<?php echo $row['year'] ?>">
                <input type="submit" name="verify" class="btn btn-success btn-sm" value="Start Nomination">
            </form>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <?php if($row['ele_status'] == 1): ?>
            <form action="" method="POST" style="display: inline;">
                <input type="hidden" name="election_id" value="<?php echo $row['election_id'] ?>">
                <input type="hidden" name="year" value="<?php echo $row['year'] ?>">
                <input type="submit" name="stop_election" class="btn btn-secondary btn-sm" value="Stop Election">
            </form>
        <?php else: ?>
            <form action="" method="POST" style="display: inline;">
            <input type="hidden" name="election_id" value="<?php echo $row['election_id'] ?>">
                <input type="hidden" name="year" value="<?php echo $row['year'] ?>">
                <input type="submit" name="start_election" class="btn btn-success btn-sm" value="Start Election">
            </form>
        <?php endif; ?>
        
    </td>
    <td>
    <?php if (!empty($row['result'])): ?>
    <!-- Display message if file has already been uploaded -->
    <div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
        <div>Result file uploaded.</div>
        <!-- Add delete button -->
        <form action="delete_report.php" method="POST" class="ml-auto">
            <input type="hidden" name="election_id" value="<?php echo $row['election_id']; ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
<?php else: ?>
    <!-- Display file upload form if no file has been uploaded -->
    <form action="upload_report.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="election_id" value="<?php echo $row['election_id']; ?>">
        <input type="file" name="pdf_report" accept="application/pdf" required>
        <button type="submit" class="btn btn-success">Upload Result</button>
    </form>
<?php endif; ?>

</td>

    <td class="text-center">
    <?php
    // echo "<script>alert('" . $row['result'] . "')</script>";
 
    if(!empty($row['result'])): ?>
        <a href="<?php echo $row['result']; ?>" target="_blank" class="btn btn-success btn-sm">View Result</a>

    <?php endif; ?>
</td>

</tr>
<?php endwhile; ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
    <div class="col-md-12"><br>
    <center>
        <form method="post" action="truncate_candidates.php">
            <p class="text-danger">This section will clear all the Candidates of the current election.</p>
            <button type="submit" class="btn btn-primary" onclick="return confirmDelete()" name="truncate_candidates">Clear All Candidate</button>
        </form>
    </center>
</div>
    </div>

    </div>
    
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to remove all the candidates?");
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
