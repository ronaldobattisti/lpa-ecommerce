<?php
    session_start(); //Server side persistent storage - 
    //persists between different page loads and allows the use of $_SERVER
    include 'connection.php';

    //getting data from forms
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isADM = 0;

    // Hash the password before saving - must have 255 char on db
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //prepare to run the query wo filling the values
    $stmt = $conn->prepare("INSERT INTO dbuser (user, email, password, isADM) VALUES (?, ?, ?, ?)");
    //Avoid SQL injection by making sure that data will be pushed in the correct format
    $stmt->bind_param("sssi", $name, $email, $hashedPassword, $isADM);

    //Run the query
    if ($stmt->execute()) {
        // ✅ Registration successful → go to index
        header("Location: index.php");
        exit();
    } else {
        // ❌ Registration failed → go back to registration
        header("Location: register.php?error=1");
        exit();
    }

    //Close connection
    $stmt->close();
    $conn->close();

?>