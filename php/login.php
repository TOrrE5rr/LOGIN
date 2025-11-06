<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE nombre = ?";
    $stmt = $Conn->prepare($sql);
    if (!$stmt) {
        die("Error en prepare: " . $Conn->error);
    }

    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($contrasena, $row['Contraseña'])) {


            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['rol'] = $row['id_rol']; 


            $sqlActividad = "INSERT INTO actividad (id_usuario, Fecha_inicio, Tipo_actl)
                             VALUES (?, NOW(), 'Sesión')";
            $stmtAct = $Conn->prepare($sqlActividad);
            $stmtAct->bind_param("i", $row['id_usuario']);
            $stmtAct->execute();

            $_SESSION['id_actividad'] = $Conn->insert_id;

            $stmtAct->close();

            if ($row['id_rol'] == '1') {
                header("Location: ../html/menuC.html");
            } else {
                header("Location: ../html/menuA.html");
            }
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $Conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
