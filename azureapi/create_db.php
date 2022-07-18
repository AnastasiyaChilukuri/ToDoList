<?php
include_once '../DB_Azure_settings.php';

// Create connection
$conn = new mysqli($servername, $username, $password);

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/var/www/html/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE tasks (title VARCHAR(150), deadline DATETIME, notes VARCHAR(300), creation_time DATETIME)";
$result = $conn->query($sql);
echo "Table created!";

$conn->close();
?>