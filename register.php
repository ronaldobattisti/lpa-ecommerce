<?php
    //persists between different page loads and allows the use of $_SERVER
    include 'connection.php';
    //Server side persistent storage - 
    include 'start_session_safe.php';

    //getting data from forms
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <div>
        <form action="register.php" method="post">
            <div>
                <label for="name">Name:</label>
            </div>

            <div>
                <input type="text" id="name" class="input-field" name="name" autocomplete="Name" placeholder="John Doe" required>
            </div>
            <div>
                <label for="email">E-mail:</label>
            </div>

            <div>
                <input type="text" id="email" class="input-field" name="email" autocomplete="email" placeholder="Enter your e-mail here" required>
            </div>

            <div>
                <label for="password">Password:</label>
            </div>

            <div>
                <input type="password" id="password" class="input-field" name="password" placeholder="Password" required>
            </div>
            
            <div>
                <p>Do you already have an account?<br>
                Click <a href="login.html">here</a> to sign in</p>
            </div>

            <div>
                <button type="submit" class="button-submit">Sign Up</button>
            </div>
        </form>
    </div>
</body>
</html>

<script>
    function loadContent(){
        fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        });
    }
    
    document.addEventListener('DOMContentLoaded', loadContent);
</script>