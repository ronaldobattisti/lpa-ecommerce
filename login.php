<?php
    include 'connection.php';
    include 'start_session_safe.php';
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

                /*$correct_input = true;
                //Setting adm condition
                if ($user_isadm > 0){
                    $_SESSION['user_isadm'] = true;
                } else $_SESSION['user_isadm'] = false;*/

                //header() redirects the user
                header("Location: index.php");
                //exit to stop script
                exit;
            } else {
                $correct_input = false;
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
    <div><?php include 'header.php'; ?></div>

    <div>
        <form method="post" action="login.php">
            <?php if (!$correct_input): ?>
                <div>
                    <p>Incorrect e-mail or password, please try again</p>
                </div>
            <?php endif;?>

            <div>
                <label for="email">E-mail:</label>
                <input type="text" id="email" class="input-field" name="email" autocomplete="email" placeholder="Enter your e-mail here" required>
            </div>

            <div>
                <label for="password">Password:</label>
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

    <div><?php include 'footer.html'; ?></div>
</body>
</html>

