<?php
    inculde 'disable_cache.php';
    include 'connection.php';
    include 'start_session_safe.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT user, email FROM dbuser WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['user'];
        $email = $row['email'];
    }


?>