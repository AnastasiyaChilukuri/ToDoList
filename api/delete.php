<?php
include_once '../DB_settings.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$creation_time = !empty($_POST['task-creation'])?$_POST['task-creation']:die("To delete an entry, task-creation(time when task is created) is mandatory, but POST['task-creation'] is empty");

$sql = "DELETE FROM tasks  WHERE creation_time = '$creation_time'";
$result = $conn->query($sql);

if (!$result) {
    die("Sql query to insert failed! please retry");
}

echo "Delete sucess";
$conn->close();
?>