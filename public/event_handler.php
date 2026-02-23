<?php
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $date = $_POST['event_date'];
    $user_id = $_COOKIE['user_token'];

    if (!empty($title) && !empty($date)) {
        $stmt = $db->prepare("INSERT INTO events (title, event_date, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $date, $user_id]); 
    }
}
header('Location: index.php');
exit;