<?php
function csrf_token() {
    return isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
}

function csrf_field() {
    $t = csrf_token();
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($t, ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_check($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) return false;
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>