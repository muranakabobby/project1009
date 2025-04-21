<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $body = htmlspecialchars($_POST['body']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO threads (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $body);
    $stmt->execute();

    header("Location: forum.php");
    exit();
}
?>

<h2>Create a New Thread</h2>
<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>
    
    <label>Body:</label><br>
    <textarea name="body" rows="6" cols="50" required></textarea><br><br>
    
    <button type="submit">Post Thread</button>
</form>
