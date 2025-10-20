<?php
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';

    //getting data from forms
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        //startard registration as non-adm

        // Hash the password before saving - must have 255 char on db
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //prepare to run the query wo filling the values
        $stmt = $conn->prepare("INSERT INTO lpa_clients (lpa_client_firstname, 
                                                        lpa_client_lastname, 
                                                        lpa_client_email, 
                                                        lpa_client_password, 
                                                        lpa_client_address,
                                                        lpa_client_phone) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
        //Avoid SQL injection by making sure that data will be pushed in the correct format
        $stmt->bind_param("ssssss", $fname, $sname, $email, $hashedPassword, $address, $phone);

        //Run the query
        if ($stmt->execute()) {
            // ✅ Registration successful → go to index
                include __DIR__ . '/config/site.php';
                header("Location: " . BASE_URL . "/index.php");
            exit();
        } else {
            // ❌ Registration failed → go back to registration
                include __DIR__ . '/config/site.php';
                header("Location: " . BASE_URL . "/register.php?error=1");
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
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <div>
        <form action="register.php" method="post">
            <div>
                <label for="name">Name:</label>
            </div>

            <div>
                <input type="text" id="fname" class="input-field" name="fname" autocomplete="Name" placeholder="John" required>
            </div>

            <div>
                <input type="text" id="sname" class="input-field" name="sname" autocomplete="Name" placeholder="Doe" required>
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
                <label for="adress">Address:</label>
            </div>

            <div>
                <input type="address" id="address" class="input-field" name="address" placeholder="Address" required>
            </div>

            <div>
                <label for="password">Phone:</label>
            </div>

            <div>
                <input type="phone" id="phone" class="input-field" name="phone" placeholder="(61) 123-456-789" required>
            </div>
            
            <div>
                <p>Do you already have an account?<br>
                Click <a href="login.php">here</a> to sign in</p>
            </div>

            <div>
                <button type="submit" class="button-submit">Sign Up</button>
            </div>
        </form>
    </div>
</body>
</html>