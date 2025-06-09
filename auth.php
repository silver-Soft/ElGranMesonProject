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
        $_SESSION['usuario'] = $usuarioBD['usuario'];
        $_SESSION['nombre'] = $usuarioBD['nombre'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "Faltan datos.";
}
