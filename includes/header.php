<?php
/**
 * GESTION DE L'IDENTITE UTILISATEUR (Système d'authentification anonyme)
 * Ce bloc permet d'identifier de manière unique chaque visiteur sans avoir besoin d'un système de connexion (login/mot de passe).
 */
if (!isset($_COOKIE['user_token'])) {
    // random_bytes(16) génère des octets aléatoires.
    // bin2hex() convertit ces octets en une chaîne de 32 caractères lisibles (lettres et chiffres).
    $token = bin2hex(random_bytes(16));
    setcookie('user_token', $token, time() + (86400 * 30), "/");
    $_COOKIE['user_token'] = $token;
}
$userToken = $_COOKIE['user_token'];
?>