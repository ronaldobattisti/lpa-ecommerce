<?php
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    $correct_input = true;

    //POST when submit, GET when visiting
    //If ensures that the code only runs when submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Prepare and execute query
        $stmt = $conn->prepare("SELECT * FROM lpa_clients WHERE lpa_client_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            //Password is stored hashed
            //bind_result will bind the value of the first collumn returned to the
            //first variable on its parameter and so on.
            $stmt->bind_result( $user_id,
                                $fname, 
                                $sname, 
                                $email, 
                                $hashed_password, 
                                $address, 
                                $phone, 
                                $payment, 
                                $last4,
                                $create_at,
                                $user_status,
                                $user_isadm);
            //now, user_id and hashed_password have the value returned from db
            $stmt->fetch();

            //password_verify does two things:
            //generates a hashed version of the inputed pass
            //and compares with te one stored in db
            if (password_verify($password, $hashed_password)) {
                //echo 'password correct';
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $fname . ' ' . $sname;
                $_SESSION['user_fname'] = $fname;
                $_SESSION['user_sname'] = $sname;
                $_SESSION['user_email'] = $email;
                $_SESSION['address'] = $address;
                $_SESSION['phone'] = $phone;
                $_SESSION['payment'] = $payment;
                $_SESSION['last4'] = $last4;
                $_SESSION['user_isadm'] = $user_isadm;

                include __DIR__ . '/config/site.php';
                //header() redirects the user
                header("Location: " . BASE_URL . "/index.php");
                //exit to stop script
                exit;
            } else {
                $correct_input = false;
                echo "<script>alert('Wrong password. Please, try again.');</script>";
                $error = "Invalid password.";
            }
        } else {
            echo "<script>alert('E-mail not registered');</script>";
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
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <div class="auth-container">
        <form method="post" action="login.php" class="auth-form">

            <?php if (!$correct_input): ?>
            <div class="alert">
                <p><i class="bi bi-exclamation-triangle-fill"></i> Incorrect e-mail or password. Please try again.</p>
            </div>
            <?php endif; ?>

            <h2>Welcome Back</h2>
            <p class="subtitle">Log in to access your account</p>

            <div class="input-group">
            <label for="email">E-mail</label>
            <input
                type="text"
                id="email"
                class="input-field"
                name="email"
                autocomplete="email"
                placeholder="Enter your e-mail"
                required
            >
            </div>

            <div class="input-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                class="input-field"
                name="password"
                placeholder="Enter your password"
                required
            >
            </div>

            <div class="auth-links">
            <p>
                <a href="recover-password.html">Forgot your password?</a>
            </p>
            <p>
                Don't have an account?
                <a href="register.php">Sign up</a>
            </p>
            </div>

            <button type="submit" class="button-submit">Login</button>
        </form>
        </div>


    </body>
    <?php include __DIR__ . '/includes/footer.html'; ?>
</html>

