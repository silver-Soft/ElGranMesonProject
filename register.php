<?php
include 'conexion.php';

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';

if ($usuario && $contrasena && $nombre && $apellidos) {
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, contrasena, nombre, apellidos) VALUES (?, ?, ?, ?)");
        $stmt->execute([$usuario, $hash, $nombre, $apellidos]);
        echo "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>.";
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
} else {
    echo "Faltan datos.";
}
