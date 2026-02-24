<?php
/**
 * Fichier de configuration (modèle) pour la connexion à la base de données.
 * * INSTRUCTIONS POUR LE DÉPLOIEMENT :
 * 1. Renseignez vos propres identifiants de connexion ci-dessous.
 * 2. Renommez ce fichier en "database.php".
 */

// --- Paramètres de connexion au serveur ---
$host     = 'localhost'; // Adresse du serveur
$dbname   = 'dev_crea';  // Nom de la base de données cible
$username = 'root';      // Nom d'utilisateur (par défaut 'root' sur MAMP/XAMPP)
$password = 'root';      // Mot de passe

// Initialisation de la connexion PDO avec MySQL
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
