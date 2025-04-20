<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Community Web App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Sixtyfour+Convergence&display=swap" rel="stylesheet">
</head>
<body>
<?php if (isset($_SESSION['email'])): ?>
        <p style="color:white;">✅ You are logged in as <strong><?= $_SESSION['email'] ?></strong></p>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="login.php">Login</a>
    <?php endif; ?>

    <header class="container text-center py-5">
        <h1 class="display-1">GAMEHUB</h1>
        <p class="lead">Your ultimate gaming community platform</p>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">GAMEHUB</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="games.php">Games</a></li>
                    <li class="nav-item"><a class="nav-link" href="community.php">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
    <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    



    <section id="home" class="hero-section container py-5">
        <div class="text-center">
            <h1 class="title">Welcome to Game World</h1>
            <p class="lead">Your ultimate gaming community platform</p>
            <h2 class="mb-4">Featured Games</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="MonsterHunter.jpg" class="card-img-top img-fluid" alt="Monster Hunter Wilds">
                        <div class="card-body">
                            <h5 class="card-title">Monster Hunter Wilds</h5>
                            <p class="card-text">Trending game of the week!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="cyberpunk.jpg" class="card-img-top img-fluid" alt="CyberPunk">
                        <div class="card-body">
                            <h5 class="card-title">CyberPunk</h5>
                            <p class="card-text">Hot Pick for Adventure Lovers!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="baldurgate.jpg" class="card-img-top" alt="Featured Game 3">
                        <div class="card-body">
                            <h5 class="card-title">Baldur's Gate 3</h5>
                            <p class="card-text">A must-play strategy game.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="games" class="container py-5">
        <h2 class="mb-4">Explore Game Categories</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="action2.jpg" class="card-img-top" alt="Action Games">
                    <div class="card-body">
                        <h5 class="card-title">Action Games</h5>
                        <p class="card-text">Experience fast-paced and thrilling action-packed games.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="rpg2.jpg" class="card-img-top" alt="RPG Games">
                    <div class="card-body">
                        <h5 class="card-title">RPG Games</h5>
                        <p class="card-text">Dive into immersive role-playing experiences with stunning graphics.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="strategy1.jpg" class="card-img-top" alt="Strategy Games">
                    <div class="card-body">
                        <h5 class="card-title">Strategy Games</h5>
                        <p class="card-text">Test your skills with challenging strategy-based gameplay.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="community" class="container py-5">
        <h2 class="mb-4">Community Forum</h2>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>Please <a href="login.php">log in</a> to join the conversation.</p>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <textarea name="message" class="form-control" required placeholder="Share something..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['message'])) {
                $stmt = $conn->prepare("INSERT INTO forum_posts (user_id, message) VALUES (?, ?)");
                $stmt->bind_param("is", $_SESSION['user_id'], $_POST['message']);
                $stmt->execute();
            }
            $result = $conn->query("SELECT forum_posts.message, forum_posts.created_at, users.username 
                                    FROM forum_posts 
                                    JOIN users ON forum_posts.user_id = users.id 
                                    ORDER BY forum_posts.created_at DESC");
        ?>
            <div class="mt-5">
                <h4>Recent Posts</h4>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['username']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['created_at']; ?></h6>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </section>

    <section id="events" class="container py-5">
        <h2 class="mb-4">Events & News</h2>
        <p>Stay updated with the latest gaming news, upcoming eSports events, and new game releases.</p>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
