<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$thread_id = $_GET['id'] ?? 0;

// Get thread data
$stmt = $conn->prepare("SELECT * FROM threads WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $thread_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$thread = $result->fetch_assoc();

if (!$thread) {
    echo "Thread not found or permission denied.";
    exit();
}

// Update on submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = htmlspecialchars($_POST['title']);
    $body = htmlspecialchars($_POST['body']);

    $update = $conn->prepare("UPDATE threads SET title = ?, body = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("ssii", $title, $body, $thread_id, $_SESSION['user_id']);
    $update->execute();

    header("Location: forum.php");
    exit();
}
?>

<h2>Edit Thread</h2>
<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($thread['title']) ?>" required><br><br>
    <textarea name="body" required><?= htmlspecialchars($thread['body']) ?></textarea><br><br>
    <button type="submit">Update Thread</button>
</form>
