<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$thread_id = $_POST['thread_id'];
$comment = htmlspecialchars($_POST['comment']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO comments (thread_id, user_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $thread_id, $user_id, $comment);
$stmt->execute();

header("Location: thread.php?id=$thread_id");
exit();
