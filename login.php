<?php
    //getting data from forms
    //$email = $_POST['email'];
    //$password = $_POST['password'];

    //database connection
    $conn = new mysqli("localhost", "root", "", "tempstore");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }else{
        echo "Login successful";
    }

?>