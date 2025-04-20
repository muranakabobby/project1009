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

// Retrieve messages
$sql = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Messages</title>
</head>
<body>
    <h2>Contact Messages</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Output each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["id"] ."</td>";
                echo "<td>". $row["name"] ."</td>";
                echo "<td>". $row["email"] ."</td>";
                echo "<td>". $row["subject"] ."</td>";
                echo "<td>". $row["message"] ."</td>";
                echo "<td>
                        <a href='edit_message.php?id=" . $row["id"] . "'>Edit</a> |
                        <a href='delete_message.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this message?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No messages found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
