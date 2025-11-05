<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $id_rol = $_POST['id_rol']; 

    $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $query = "INSERT INTO Usuarios (Nombre, email, Contraseña, id_rol)
              VALUES (?, ?, ?, ?)";
    
    $stmt = $Conn->prepare($query);
    $stmt->bind_param("sssi", $nombre, $email, $password_hash, $id_rol);

    if ($stmt->execute()) {
        echo "registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

$Conn->close();
?>
