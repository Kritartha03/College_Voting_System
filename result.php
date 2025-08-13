<?php
include('../main/connect.php');
// Include FPDF library
require('../fpdf/fpdf.php');

// Function to generate PDF
function generatePDF($election_id) {
    // Create instance of FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10); // Decrease font size here

    // Add empty cell to adjust left border
    $pdf->Cell(5,10,'',0,0); // Adjust the width as needed

    // Add table headers
    $pdf->Cell(20,10,'Election ID',1,0,'C');
    $pdf->Cell(20,10,'Year',1,0,'C');
    $pdf->Cell(40,10,'Election Name',1,0,'C');
    $pdf->Cell(40,10,'Candidate Name',1,0,'C');
    $pdf->Cell(50,10,'Portfolio',1,0,'C');
    $pdf->Cell(25,10,'Votes',1,1,'C');

    // Fetch data from database and add to the PDF
    $i = 1;
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $database = "votingsystem";
    $conn = new mysqli($servername, $username, $password, $database);
    $sql = "SELECT c.*, e.year, e.election_name
            FROM candidate c
            JOIN election e ON c.election_id = e.election_id
            WHERE c.election_id = $election_id
            AND (c.position_id, c.votes) IN (
                SELECT position_id, MAX(votes)
                FROM candidate
                WHERE election_id = $election_id
                GROUP BY position_id
            )";
    $candidates = $conn->query($sql);
    while($row = $candidates->fetch_assoc()) {
        // Add empty cell to adjust left border
        $pdf->Cell(5,10,'',0,0); // Adjust the width as needed

        $pdf->Cell(20,10,$election_id,1,0,'C'); // Display the same election ID for each row
        $pdf->Cell(20,10,ucwords($row['year']),1,0,'C');
        $pdf->Cell(40,10,$row['election_name'],1,0,'C');
        $pdf->Cell(40,10,$row['username'],1,0,'C');
        $pdf->Cell(50,10,$row['voting_position'],1,0,'C');
        $pdf->Cell(25,10,$row['votes'],1,1,'C');
    }

    // Output PDF with the same election ID for the file name
    $pdf->Output('D', 'winners_list_'.$election_id.'.pdf');
}

if(isset($_POST['generate_pdf'])) {
    $election_id = $_POST['election_id'];
    generatePDF($election_id);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winners List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1000px;
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

        .collapse {
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
                <a class="nav-link active  text-dark" aria-current="page" href="index.php">Back</a>
              </li>
          </div>
        </div>
      </nav>
<div class="container mt-4">
    <?php
    // Fetch distinct election IDs
    $distinct_elections = $conn->query("SELECT DISTINCT election_id FROM election");

    // Loop through distinct election IDs
    while ($election = $distinct_elections->fetch_assoc()) {
        $election_id = $election['election_id'];

        // Fetch election details
        $election_details = $conn->query("SELECT * FROM election WHERE election_id = $election_id")->fetch_assoc();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <center><h3 class="mb-0"><?php echo $election_details['election_name']; ?></h3>
                    <h5 class="text-success">Winner's List</h5>
                    </center>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Election ID</th>
                                    <th class="text-center">Year</th>
                                    <th class="text-center">Candidate Name</th>
                                    <th class="text-center">Portfolio</th>
                                    <th class="text-center">Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $candidates = $conn->query("SELECT c.*
                                FROM candidate c
                                JOIN (
                                    SELECT position_id, MAX(votes) AS max_votes
                                    FROM candidate
                                    WHERE election_id = $election_id
                                    GROUP BY position_id
                                ) max_votes_per_position
                                ON c.position_id = max_votes_per_position.position_id
                                AND c.votes = max_votes_per_position.max_votes
                                WHERE c.election_id = $election_id");
                                while($row = $candidates->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?php echo $election_id; ?></td>
                                    <td class="text-center"><?php echo ucwords($election_details['year']); ?></td>
                                    <td class="text-center"><?php echo $row['username']; ?></td>
                                    <td class="text-center"><?php echo $row['voting_position']; ?></td>
                                    <td class="text-center"><?php echo $row['votes']; ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <form method="post">
                        <input type="hidden" name="election_id" value="<?php echo $election_id; ?>">
                        <center><button type="submit" name="generate_pdf" class="btn btn-primary">Download PDF</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>



<!-- Bootstrap JS (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
