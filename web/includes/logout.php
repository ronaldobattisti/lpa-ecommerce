<?php
    // Step 1: Start the session
    include __DIR__ . '/../assets/start_session_safe.php';

    // Step 2: Unset all session variables
    session_unset();

    // Step 3: Destroy the session completely
    session_destroy();

    // Step 4: Redirect to the login page (or home)
    include __DIR__ . '/../config/site.php';
    header("Location: " . BASE_URL . "/index.php");
    exit;
?>