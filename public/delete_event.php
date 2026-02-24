<?php
/**
 * TRAITEMENT DE LA SUPPRESSION D'UN ÉVÉNEMENT
 * Ce script gère la suppression sécurisée d'un enregistrement et de son image associée.
 */

require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['event_id'])) {

    $event_id = $_POST['event_id'];
    $user_id = $_COOKIE['user_token'] ?? '';

    if (!empty($user_id)) {
        try {
            $stmt = $db->prepare("SELECT user_id, image FROM events WHERE id = :id");
            $stmt->execute([':id' => $event_id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($event && $event['user_id'] === $user_id) {
                if (!empty($event['image']) && file_exists($event['image'])) {
                    unlink($event['image']);
                }

                $deleteStmt = $db->prepare("DELETE FROM events WHERE id = :id");
                $deleteStmt->execute([':id' => $event_id]);
            }
        } catch (PDOException $e) {
            die("Erreur SQL lors de la suppression : " . $e->getMessage());
        }
    }
}

header('Location: index.php');
exit;
