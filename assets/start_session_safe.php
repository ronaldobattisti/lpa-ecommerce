<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Ensure a CSRF token exists for the session
    if (empty($_SESSION['csrf_token'])) {
        // random_bytes available in PHP 7+
        try {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (Exception $e) {
            // fallback
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
?>
