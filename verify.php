<?php
include('../main/connect.php');

// Initialize alert message variable
$alertMessage = '';

if(isset($_POST['verify'])){
    $candidate_id = $_POST['candidate_id'];
    $conn->query("UPDATE candidate SET status = 1 WHERE candidate_id = $candidate_id");
    $alertMessage = "Candidate verified successfully.";
}

if(isset($_POST['delete'])){
    $candidate_id = $_POST['candidate_id'];
    // Update the status of the candidate to 0
    $conn->query("UPDATE candidate SET status = 0 WHERE candidate_id = $candidate_id");
    $alertMessage = "Candidate status updated to 0 successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Candidates</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .avatar {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-verified {
            background-color: #28a745;
        }

        .badge-not-verified {
            background-color: #dc3545;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
        }

        .card-header h3 {
            margin-bottom: 0;
        }

        .table thead th {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
    </style>
    <script>
        // JavaScript function to show alert message
        function showAlert(message) {
            alert(message);
        }
    </script>
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

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">List of Candidates</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Applied for</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
<?php $i = 1;
$candidates = $conn->query("SELECT * FROM candidate");
while($row = $candidates->fetch_assoc()):
?>
<tr>
    <td class="text-center"><?php echo $i++ ?></td>
    <td class="text-center">
        <?php echo isset($row['username']) ? ucwords($row['username']) : '' ?>
    </td>
    <td class="text-center"><?php echo isset($row['voting_position']) ? $row['voting_position'] : '' ?></td>
    <td class="text-center">
        <?php if($row['status'] == 1): ?>
            <span class="badge badge-verified">Verified</span>
        <?php else: ?>
            <span class="badge badge-not-verified">Not Verified</span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <?php if($row['status'] == 1): ?>
            <!-- Add the delete button -->
            <form action="" method="POST" style="display: inline;">
                <input type="hidden" name="candidate_id" value="<?php echo $row['candidate_id'] ?>">
                <input type="submit" name="delete" class="btn btn-danger btn-sm" value="Delete">
            </form>
        <?php else: ?>
            <!-- Add the verify button -->
            <form action="" method="POST" style="display: inline;">
                <input type="hidden" name="candidate_id" value="<?php echo $row['candidate_id'] ?>">
                <input type="submit" name="verify" class="btn btn-success btn-sm" value="Verify">
            </form>
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
    </div>

    <!-- Bootstrap JS -->
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if(isset($_POST['verify'])){
    $candidate_id = $_POST['candidate_id'];
    $conn->query("UPDATE candidate SET status = 1 WHERE candidate_id = $candidate_id");
    // header('Location: ../main/election.php');
}

if(isset($_POST['delete'])){
    $candidate_id = $_POST['candidate_id'];
    // Update the status of the candidate to 0
    $conn->query("UPDATE candidate SET status = 0 WHERE candidate_id = $candidate_id");
    $alertMessage = "Candidate status updated to 0 successfully.";
}

// Close connection
$conn->close();
?>
