<?php
session_start();

// Check if action is logout
if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Destroy the session
    session_destroy();
    // Return a response to indicate success
    http_response_code(200);
    exit;
}

// Handle other AJAX requests here if needed
?>
