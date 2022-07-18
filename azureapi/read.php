<?php
include_once '../DB_Azure_settings.php';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$task_list_json = array();

try {
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $task_list_json[] = $row;
    }
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

$conn->close();
echo json_encode($task_list_json);
?>