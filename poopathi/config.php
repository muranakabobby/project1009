<?php
$host = "localhost";
$user = "root";         // default AMPPS MySQL user
$password = "mysql";    // default AMPPS MySQL password
$dbname = "forum_db";   // name of your database

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
