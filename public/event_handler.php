<?php
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $date = $_POST['event_date'];
    $user_id = $_COOKIE['user_token'] ?? 'anonymous';

    if (!empty($title) && !empty($date)) {
        try {
            $stmt = $db->prepare("INSERT INTO events (title, event_date, user_id) VALUES (:title, :date, :user_id)");
            $stmt->execute([
                ':title' => $title,
                ':date' => $date,
                ':user_id' => $user_id
            ]);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}

header('Location: index.php');
exit;