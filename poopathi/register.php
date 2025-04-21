<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "✅ Registration successful! <a href='login.php'>Click here to login</a>";
    } else {
        if ($conn->errno === 1062) {
            echo "⚠️ Email or username already exists. Try again.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>

<h2>Register</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>
