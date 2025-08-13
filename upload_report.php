<?php
include('../main/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_report'])) {
    // echo "<script></script>";

    $election_id = $_POST['election_id'];
    
    // Check if the test_result is already set
    $checkSql = "SELECT result FROM election WHERE election_id = $election_id";
    $checkResult = mysqli_query($conn, $checkSql);

    $row = mysqli_fetch_assoc($checkResult);

    if (!empty($row['result'])) {
        // If test_result is already set, do not allow another upload
        header('Location: admin-index.php?upload_error=1');
        exit();
    }

    $file = $_FILES['pdf_report'];

    // Define the directory where you want to save the uploaded files
    $uploadDir = '../uploads/';
    // Ensure the directory exists, if not, create it
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Get the file information
    $fileName = basename($file['name']);
    $uploadFilePath = $uploadDir . $fileName;




    // Move the uploaded file to the specified directory
    if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
        // File successfully uploaded, update the database
        $sql = "UPDATE election SET result = '$uploadFilePath' WHERE election_id = $election_id";
        if (mysqli_query($conn, $sql)) {
            // Redirect back to the technician panel with a success message
            header('Location: admin-index.php?upload_success=1');
        } else {
            // Error updating the database
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // Error uploading the file
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request.";
}
?>
