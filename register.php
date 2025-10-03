<?php
    include 'connection.php';

    //getting data from forms
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isADM = 0;

    //SQL query to check if the user exists
    $sql = "INSERT INTO dbuser (user, email, password, isADM) 
            VALUES ('$name', '$email', '$password', $isADM)";

    //Run the query
    if ($conn->query($sql) === TRUE) {
        echo "Welcome, " . $name . "!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //Close connection
    $conn->close();

?>