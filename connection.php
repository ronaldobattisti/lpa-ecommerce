<?php
    //database connection
    $conn = new mysqli("localhost", "root", "", "lpa_ecomms");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>