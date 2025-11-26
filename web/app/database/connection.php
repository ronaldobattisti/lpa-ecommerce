<?php
    //database connection
    //$conn = new mysqli("ftpupload.net", "if0_40513248", "Rb19962025", "lpa_ecomms");
    $conn = new mysqli("localhost", "root", "", "lpa_ecomms");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>