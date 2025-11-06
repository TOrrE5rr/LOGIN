<?php
include 'conexion.php';
session_start();

if (isset($_SESSION['id_usuario']) && isset($_SESSION['id_actividad'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_actividad = $_SESSION['id_actividad'];
    
    $sqlUpdate = "UPDATE actividad SET Fecha_fin = NOW() WHERE id_actl = ? AND id_usuario = ?";
    $stmt = $Conn->prepare($sqlUpdate);
    $stmt->bind_param("ii", $id_actividad, $id_usuario);
    $stmt->execute();
    $stmt->close();
}


session_destroy();

header("Location: ../html/index.html");
exit;
?>
