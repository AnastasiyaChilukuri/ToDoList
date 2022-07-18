<?php
$servername = "127.0.0.1";
$username = "root";
$password = "Anastasiya@123!";
$dbname = "Todolist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$title = $_POST['task-title'];
$deadline = $_POST['task-deadline'];
$notes = $_POST['task-comments'];

$sql = "INSERT INTO tasks (title, deadline, notes, creation_time) VALUES ('$title', '$deadline', '$notes', NOW())";
$result = $conn->query($sql);

if (!$result) {
    echo "0 results";
}
$conn->close();
?>