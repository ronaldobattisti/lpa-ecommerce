<?php
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        require __DIR__ . "/config.local.php";
    } else {
        require __DIR__ . "/config.prod.php";
    }
?>