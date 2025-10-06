<?php
    session_start(); //Server side persistent storage - 
    //persists between different page loads and allows the use of $_SERVER
    include 'connection.php';

    //POST when submit, GET when visiting
    //If ensures that the code only runs when submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Prepare and execute query
        $stmt = $conn->prepare("SELECT id, user, password FROM dbuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            //Password is stored hashed
            //bind_result will bind the value of the first collumn returned to the
            //first variable on its parameter and so on.
            $stmt->bind_result($user_id, $user_name, $hashed_password);
            //now, user_id and hashed_password have the value returned from db
            $stmt->fetch();
            echo 'The inputed password is: ' . $password;

            echo 'The correct password is: ' . $hashed_password;

            //password_verify does two things:
            //generates a hashed version of the inputed pass
            //and compares with te one stored in db
            echo 'before the if statement';
            if (password_verify($password, $hashed_password)) {
                echo 'password correct';
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                //header() redirects the user
                header("Location: index.php");
                //exit to stop script
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <div>
        <form method="post" action="login.php">
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
                <p>Forgot your password?<br>
                Click <a href="recover-password.html">here</a> and follow the instructions</p>
            </div>

            <div>
                <p>Don't have an accout?<br>
                Click <a href="register.php">here</a> to sign up</p>
            </div>

            <div>
                <button type="submit" class="button-submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>

<script>
    function loadContent(){
        fetch('header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        });
    }
    
    document.addEventListener('DOMContentLoaded', loadContent);
</script>

