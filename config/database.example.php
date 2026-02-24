<?php
// Modèle de configuration pour la base de données.
// À renseigner avec vos propres identifiants, puis renommer ce fichier en "database.php"

$host = 'localhost';
$dbname = 'dev_crea';
$username = 'root';
$password = 'root';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
