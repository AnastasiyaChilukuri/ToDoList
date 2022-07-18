<?php
include_once '../DB_settings.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$title = !empty($_POST['task-title']) ? $_POST['task-title'] : die("To insert, task-title is mandatory, but POST['task-title'] is empty");
$deadline = !empty($_POST['task-deadline']) ? $_POST['task-deadline'] : die("To insert, task-deadline is mandatory, but POST['task-deadline'] is empty");;
$notes = !empty($_POST['task-comments']) ? $_POST['task-comments'] : "";

$sql = "INSERT INTO tasks (title, deadline, notes, creation_time) VALUES ('$title', '$deadline', '$notes', NOW())";
$result = $conn->query($sql);

if (!$result) {
    die("Sql query to insert failed! please retry");
}
$conn->close();
echo "sucess!"
?>