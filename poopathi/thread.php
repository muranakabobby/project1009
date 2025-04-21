<?php
session_start();
require 'config.php';

$thread_id = $_GET['id'] ?? 0;

// Get thread info
$stmt = $conn->prepare("SELECT threads.*, users.username FROM threads 
                        JOIN users ON threads.user_id = users.id 
                        WHERE threads.id = ?");
$stmt->bind_param("i", $thread_id);
$stmt->execute();
$thread = $stmt->get_result()->fetch_assoc();

// Get comments
$cstmt = $conn->prepare("SELECT comments.*, users.username FROM comments 
                         JOIN users ON comments.user_id = users.id 
                         WHERE thread_id = ? ORDER BY created_at ASC");
$cstmt->bind_param("i", $thread_id);
$cstmt->execute();
$comments = $cstmt->get_result();
?>

<h2><?= htmlspecialchars($thread['title']) ?></h2>
<p><?= nl2br(htmlspecialchars($thread['body'])) ?></p>
<p><small>Posted by <?= htmlspecialchars($thread['username']) ?> on <?= $thread['created_at'] ?></small></p>

<hr>
<h3>Replies</h3>
<?php while ($comment = $comments->fetch_assoc()): ?>
    <div style="margin-bottom: 10px; border-bottom: 1px solid #eee;">
        <b><?= htmlspecialchars($comment['username']) ?>:</b><br>
        <?= nl2br(htmlspecialchars($comment['comment'])) ?><br>
        <small><?= $comment['created_at'] ?></small>
    </div>
<?php endwhile; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <hr>
    <form method="POST" action="post_comment.php">
        <input type="hidden" name="thread_id" value="<?= $thread_id ?>">
        <textarea name="comment" placeholder="Write a reply..." required></textarea><br>
        <button type="submit">Post Comment</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Login</a> to reply.</p>
<?php endif; ?>
