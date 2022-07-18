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
echo "came here";
$creation_time = $_POST['task-creation'];

$sql = "DELETE FROM tasks  WHERE creation_time = '$creation_time'";
$result = $conn->query($sql);

if (!$result) {
    echo "0 results";
}

echo " delete sucess";
$conn->close();
?>