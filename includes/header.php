<?php
// On génère un ID unique pour le visiteur s'il n'existe pas
if (!isset($_COOKIE['user_token'])) {
    $token = bin2hex(random_bytes(16));
    setcookie('user_token', $token, time() + (86400 * 30), "/");
    $_COOKIE['user_token'] = $token;
}
$userToken = $_COOKIE['user_token'];
?>