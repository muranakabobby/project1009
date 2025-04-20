<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get message ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the message
    $sql = "DELETE FROM contact_messages WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Message deleted successfully.";
    } else {
        echo "Error deleting message: " . $conn->error;
    }
}

$conn->close();

// Redirect back to view page
header("Location: view_messages.php");
exit();
?>
