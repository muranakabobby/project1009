<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["email"] = $email;
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - GameHub</title>
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
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <input type="email" name="email" required placeholder="Email"><br>
        <input type="password" name="password" required placeholder="Password"><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
