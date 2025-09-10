<?php
$host = "localhost";
$user = "root";
$pass = "Toronja4@.2";
$db   = "motorparts";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
