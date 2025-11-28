<?php
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        require_once __DIR__ . "/config.local.php";
    } else {
        require_once __DIR__ . "/config.prod.php";
    }
?>