<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$name = $email = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the message
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $sql = "UPDATE contact_messages SET name='$name', email='$email', subject='$subject', message='$message' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Message updated successfully.";
        header("Location: view_messages.php");
        exit();
    } else {
        echo "Error updating message: " . $conn->error;
    }
} else {
    // Fetch the existing message data
    $sql = "SELECT * FROM contact_messages WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $email = $row["email"];
        $subject = $row["subject"];
        $message = $row["message"];
    } else {
        echo "Message not found.";
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Message</title>
</head>
<body>
    <h2>Edit Message</h2>
    <form method="POST" action="">
        Name:<br>
        <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>
        Email:<br>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>
        Subject:<br>
        <input type="text" name="subject" value="<?php echo $subject; ?>" required><br><br>
        Message:<br>
        <textarea name="message" rows="4" cols="40" required><?php echo $message; ?></textarea><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
