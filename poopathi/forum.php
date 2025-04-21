<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Community Forum</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p><a href="logout.php">Logout</a></p>
    <h3>Community Threads</h3>
    <a href="new_thread.php">➕ Create New Thread</a><br><br>

    <?php
    $sql = "SELECT threads.*, users.username FROM threads 
            JOIN users ON threads.user_id = users.id 
            ORDER BY created_at DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
            echo "<h4><a href='thread.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h4>";
            echo "<small>By " . htmlspecialchars($row['username']) . " on " . $row['created_at'] . "</small><br>";

            // Show Edit/Delete only to the thread owner
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']) {
                echo "<a href='edit_thread.php?id=" . $row['id'] . "'>Edit</a> | ";
                echo "<a href='delete_thread.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this thread?')\">Delete</a>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No threads yet. Be the first to post!</p>";
    }
    ?>
</body>
</html>
