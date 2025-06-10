<?php
session_start();
include 'conexion.php';

$usuario = $_POST['nombre'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if ($usuario && $contrasena) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $usuarioBD = $stmt->fetch();

    if ($usuarioBD && password_verify($contrasena, $usuarioBD['contrasena'])) {
        // Verificar si tiene rol asignado
        if (empty($usuarioBD['id_rol']) || $usuarioBD['id_rol'] == 0) {
            // Mostrar alerta y no iniciar sesión
            echo "<script>
                alert('Aún no se le ha asignado un rol. Un administrador debe asignárselo primero.');
                window.location.href = 'login.php';
            </script>";
            exit;
        }

        // Si tiene rol, iniciar sesión
        $_SESSION['usuario'] = $usuarioBD['usuario'];
        $_SESSION['nombre'] = $usuarioBD['nombre'];
        $_SESSION['id_rol'] = $usuarioBD['id_rol'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "Faltan datos.";
}
