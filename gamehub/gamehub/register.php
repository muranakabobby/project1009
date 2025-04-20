<?php
include 'db.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = "⚠️ This email is already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $message = "✅ Registration successful! <a href='login.php' style='color: #00bcd4;'>Click here to log in</a>";
    }

    $check->close();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - GameHub</title>
    <style>
        body {
            background: url('background3.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        form {
            background: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.7);
        }
        input {
            background: #1e1e1e;
            border: none;
            padding: 12px;
            margin: 10px 0;
            color: white;
            width: 100%;
            font-size: 16px;
        }
        button {
            background-color: #00bcd4;
            border: none;
            color: white;
            padding: 12px 20px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0097a7;
        }
        .message {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }
        a {
            color: #00bcd4;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <?php if (!empty($message)): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="email" name="email" required placeholder="Email"><br>
        <input type="password" name="password" required placeholder="Password"><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>