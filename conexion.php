<?php
$host = 'localhost';
$db = 'gran_meson';
$user = 'root';
$pass = ''; // pon tu contraseña si la tienes
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit("Error de conexión: " . $e->getMessage());
}
