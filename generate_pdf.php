<?php
include('../main/connect.php');
// Include FPDF library
require('../fpdf/fpdf.php');

// Function to generate PDF
function generatePDF() {
    // Create instance of FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);

    // Add table headers
    $pdf->Cell(30,10,'Election ID',1,0,'C');
    $pdf->Cell(30,10,'Year',1,0,'C');
    $pdf->Cell(40,10,'Election Name',1,0,'C');
    $pdf->Cell(40,10,'Candidate Name',1,0,'C');
    $pdf->Cell(30,10,'Portfolio',1,0,'C');
    $pdf->Cell(30,10,'Votes',1,1,'C');

    // Fetch data from database and add to the PDF
    $i = 1;
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $database = "votingsystem";
    $conn = new mysqli($servername, $username, $password, $database);
    $candidates = $conn->query("SELECT e.*, cp.position_id FROM election e INNER JOIN candidate cp ON position_id = cp.position_id");
    while($row = $candidates->fetch_assoc()) {
        $sql = "SELECT c.username, c.voting_position, MAX(c.votes) AS max_votes
                FROM candidate c
                WHERE c.position_id = '{$row['position_id']}'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $candidate_data = $result->fetch_assoc();
            $pdf->Cell(30,10,$i++,1,0,'C');
            $pdf->Cell(30,10,ucwords($row['year']),1,0,'C');
            $pdf->Cell(40,10,$row['election_name'],1,0,'C');
            $pdf->Cell(40,10,$candidate_data['username'],1,0,'C');
            $pdf->Cell(30,10,$candidate_data['voting_position'],1,0,'C');
            $pdf->Cell(30,10,$candidate_data['max_votes'],1,1,'C');
        }
    }

    // Output PDF
    $pdf->Output('D', 'winners_list.pdf');
}

if(isset($_POST['generate_pdf'])) {
    generatePDF();
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
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <center><h3 class="mb-0">Winners List</h3></center>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Election ID</th>
                                <th class="text-center">Year</th>
                                <th class="text-center">Election Name</th>
                                <th class="text-center">Candidate Name</th>
                                <th class="text-center">Portfolio</th>
                                <th class="text-center">Votes</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $candidates = $conn->query("SELECT e.*, cp.position_id FROM election e INNER JOIN candidate cp ON position_id = cp.position_id");
                            while($row = $candidates->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="text-center">
                                        <?php echo isset($row['year']) ? ucwords($row['year']) : '' ?>
                                    </td>
                                    <td class="text-center"><?php echo isset($row['election_name']) ? $row['election_name'] : '' ?></td>
                                    <td class="text-center">
                                        <?php
                                        $sql = "SELECT c.username, c.voting_position, MAX(c.votes) AS max_votes
                                                FROM candidate c
                                                WHERE c.position_id = '{$row['position_id']}'";

                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            $candidate_data = $result->fetch_assoc();
                                            echo $candidate_data['username'];
                                        } else {
                                            echo 'No candidate found';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            echo $candidate_data['voting_position'];
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            echo $candidate_data['max_votes'];
                                        } else {
                                            echo '';
                                        }
                                        ?>
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
<div class="container">
    <form method="post">
        <button type="submit" name="generate_pdf" class="btn btn-primary">Download PDF</button>
    </form>
</div>
<!-- Bootstrap JS (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
