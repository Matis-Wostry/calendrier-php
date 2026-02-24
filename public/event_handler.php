<?php
/**
 * TRAITEMENT DE LA CRÉATION D'UN ÉVÉNEMENT
 * Ce script réceptionne les données du formulaire d'ajout, traite l'image 
 * et enregistre le tout en base de données.
 */

session_start();
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = htmlspecialchars($_POST['title']);
    $date = $_POST['event_date'];
    $user_id = $_COOKIE['user_token'] ?? 'anonymous';
    $image_path = null;

    if (isset($_FILES['event_image']) && $_FILES['event_image']['size'] > 0) {

        $tmp_name = $_FILES['event_image']['tmp_name'];
        $original_name = $_FILES['event_image']['name'];

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        $is_real_image = getimagesize($tmp_name);

        if (in_array($file_extension, $allowed_extensions) && $is_real_image !== false) {

            $upload_dir = 'uploads/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $filename = uniqid() . '-' . basename($original_name);
            $destination = $upload_dir . $filename;

            if (move_uploaded_file($tmp_name, $destination)) {
                $image_path = $destination;
            }
        }
    }

    if (!empty($title) && !empty($date) && substr($date, -2) !== '00') {
        try {
            $sql = "INSERT INTO events (title, event_date, user_id, image) VALUES (:title, :date, :user_id, :image)";
            $stmt = $db->prepare($sql);

            $stmt->execute([
                ':title' => $title,
                ':date' => $date,
                ':user_id' => $user_id,
                ':image' => $image_path
            ]);
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }
}

header('Location: index.php');
exit;
