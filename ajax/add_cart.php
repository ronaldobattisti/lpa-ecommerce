<?php
    include 'app/database/connection.php';
    include 'assets/start_session_safe.php';

    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];//doesn't work into sql query if I use $_SESSION
        
        //add_cart.php
        if (isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];//easier to work with
            //echo 'user id is: ' . $_SESSION['user_id'];
            $sql = "SELECT * FROM lpa_cart WHERE lpa_cart_user_id = $user_id AND lpa_cart_item_id  = $item_id";
            //echo $user_id;
            $result = $conn->query($sql);

            //if cortumer has already added the item into the cart, do nothing and go to index
            if ($result->num_rows > 0){
                header('Location: index.php');
            } else {//otherwise, add it
                $stmt = $conn->prepare("INSERT INTO lpa_cart (  lpa_cart_user_id, 
                                                                lpa_cart_item_id, 
                                                                lpa_cart_item_qty) 
                                                                VALUES (?, ?, 1)");
                $stmt->bind_param("ii", $user_id, $item_id);
                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    header("Location: register.php?error=1");
                    exit();
                }
            }
        } else {
            echo "An error has ocurred with the item id, please call the support";
        }
    } else {
        echo "No itemID received!";
    }
?>