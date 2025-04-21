<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$thread_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM threads WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $thread_id, $_SESSION['user_id']);
$stmt->execute();

header("Location: forum.php");
exit();
