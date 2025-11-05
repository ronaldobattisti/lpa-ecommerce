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
                header("Location: " . BASE_URL . "/login.php");
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
<body class="body">
  <div><?php include __DIR__ . '/includes/header.php'; ?></div>

  <div class="register-container">
    <h2>Create an Account</h2>

    <form action="register.php" method="post" class="register-form">

      <div class="form-row">
        <div class="form-group">
          <label for="fname">First name</label>
          <input type="text" id="fname" name="fname" placeholder="John" required>
        </div>

        <div class="form-group">
          <label for="sname">Last name</label>
          <input type="text" id="sname" name="sname" placeholder="Doe" required>
        </div>
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="example@email.com" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="********" required>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="123 Main St" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="(61) 123-456-789" required>
      </div>

      <div class="form-footer">
        <p>Already have an account? <a href="login.php">Sign in here</a></p>
      </div>

      <button type="submit" class="btn-submit">Sign Up</button>
    </form>
  </div>

  <?php include __DIR__ . '/includes/footer.html'; ?>
</body>

</html>