<?php
    include 'connection.php';
    include 'start_session_safe.php';

    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        
        //add_cart.php
        if (isset($_POST['itemID'])) {
            $itemID = $_POST['itemID'];
            //echo 'user id is: ' . $_SESSION['user_id'];
            $sql = "SELECT * FROM dbcart WHERE userID = $user_id";
            echo $user_id;
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0){
                echo 'Already have a cart';
            } else {
                $stmt = $conn->prepare("INSERT INTO dbcart (userID, itemID, quant) VALUES (?, ?, 1)");
                $stmt->bind_param("ii", $user_id, $itemID);
            }
////
            if ($stmt->execute()) {
            // ✅ Registration successful → go to index
            header("Location: index.php");
            exit();
            } else {
                // ❌ Registration failed → go back to registration
                header("Location: register.php?error=1");
                exit();
            }
////
            // Example: add to cart table or session
            // $_SESSION['cart'][$itemID] = ($_SESSION['cart'][$itemID] ?? 0) + 1;
        } else {
            echo "No itemID received!";
        }
    } else {
        header('login.php');
    }
?>