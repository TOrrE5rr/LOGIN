<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';

    $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $id_usuario = $row['id_usuario'];

        $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE usuarios SET Contraseña = ? WHERE id_usuario = ?";
        $stmtUpdate = $Conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $hash, $id_usuario);

        if ($stmtUpdate->execute()) {
            echo "<h3>Contraseña actualizada correctamente.</h3>";
            echo "<p><a href='../html/index.html'>Volver al inicio</a></p>";
        } else {
            echo "<h3> Error al actualizar la contraseña.</h3>";
        }

        $stmtUpdate->close();
    } else {
        echo "<h3> Correo no encontrado</h3>";
    }

    $stmt->close();
    $Conn->close();
} else {
    echo "Acceso Denegado";
}
?>
