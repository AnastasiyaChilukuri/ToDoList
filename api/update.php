<?php
include_once '../DB_settings.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$title = !empty($_POST['task-title']) ? $_POST['task-title'] : die("To update, task-title is mandatory, but POST['task-title'] is empty");
$deadline = !empty($_POST['task-deadline']) ? $_POST['task-deadline'] : die("To update, task-deadline is mandatory, but POST['task-deadline'] is empty");;
$notes = !empty($_POST['task-comments']) ? $_POST['task-comments'] : "";
$creation_time = !empty($_POST['task-creation'])?$_POST['task-creation']:die("To update an entry, task-creation(time when task is created) is mandatory, but POST['task-creation'] is empty");

$sql = "UPDATE tasks SET title = '$title', deadline = '$deadline', notes = '$notes' WHERE creation_time = '$creation_time'";
$result = $conn->query($sql);

if (!$result) {
    echo "0 results";
}
$conn->close();
?>