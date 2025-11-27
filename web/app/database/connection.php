<?php
    //database connection
    include realpath(__DIR__ . '/../config/site.php');

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>