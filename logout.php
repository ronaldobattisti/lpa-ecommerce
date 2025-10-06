<?php
    // Step 1: Start the session
    session_start();

    // Step 2: Unset all session variables
    session_unset();

    // Step 3: Destroy the session completely
    session_destroy();

    // Step 4: Redirect to the login page (or home)
    header("Location: index.php");
    exit;
?>