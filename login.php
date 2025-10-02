<?php
    //database connection
    $conn = new mysqli("localhost", "root", "", "tempstore");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }/*else{
        echo "Login successful";
    }*/

    //getting data from forms
    $email = $_POST['email'];
    $password = $_POST['password'];

    //SQL query to check if the user exists
    $sql = "SELECT * FROM dbuser WHERE email='$email' AND password='$password'";

    //Run the query
    $result = $conn->query($sql);

    //Check if we found a user
    if ($result->num_rows > 0) {
        echo "✅ Login successful. Welcome, " . $email;
    } else {
        echo "❌ Invalid email or password.";
    }

    //Close connection
    $conn->close();

?>