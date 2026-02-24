<?php
/**
 * TRAITEMENT DE LA MISE À JOUR D'UN ÉVÉNEMENT
 * Ce script permet de modifier les informations d'un événement existant 
 * après avoir vérifié les droits de l'utilisateur.
 */
session_start();
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['event_id'])) {

    $event_id = $_POST['event_id'];
    $title = htmlspecialchars($_POST['title']);
    $date = $_POST['event_date'];
    $user_id = $_COOKIE['user_token'] ?? '';

    $image_path = null;

    $checkStmt = $db->prepare("SELECT id FROM events WHERE id = :id AND user_id = :user_id");
    $checkStmt->execute([':id' => $event_id, ':user_id' => $user_id]);

    if ($checkStmt->fetch()) {

        if (isset($_FILES['event_image']) && $_FILES['event_image']['size'] > 0) {
            $tmp_name = $_FILES['event_image']['tmp_name'];
            $original_name = $_FILES['event_image']['name'];
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions) && getimagesize($tmp_name) !== false) {
                $upload_dir = 'uploads/';
                $filename = uniqid() . '-' . basename($original_name);
                $destination = $upload_dir . $filename;

                if (move_uploaded_file($tmp_name, $destination)) {
                    $image_path = $destination;
                }
            }
        }

        try {
            if ($image_path) {
                $sql = "UPDATE events SET title = :title, event_date = :date, image = :image WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':title' => $title,
                    ':date' => $date,
                    ':image' => $image_path,
                    ':id' => $event_id
                ]);
            } else {
                $sql = "UPDATE events SET title = :title, event_date = :date WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':title' => $title,
                    ':date' => $date,
                    ':id' => $event_id
                ]);
            }
        } catch (PDOException $e) {
            die("Erreur SQL lors de la mise à jour : " . $e->getMessage());
        }
    }
}

header('Location: index.php');
exit;
