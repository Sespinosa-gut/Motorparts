<?php
include "PHP/conexion.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT imagen FROM inventario WHERE id_inventario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imagen);
        $stmt->fetch();
        header("Content-Type: image/jpeg");
        echo $imagen;
    } else {
        header("Content-Type: image/png");
        readfile("IMG/default.png");
    }
}
?>
