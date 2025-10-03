<?php
    //database connection
    $conn = new mysqli("localhost", "root", "", "tempstore");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>