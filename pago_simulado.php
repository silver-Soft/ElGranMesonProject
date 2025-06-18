<?php
session_start();
include '../ElGranMesonProject/conexion.php'; // debe retornar PDO en $pdo

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 10) {
    header('Location: login.php');
    exit;
}

$id_reservacion = $_GET['id_reservacion'] ?? null;

if (!$id_reservacion) {
    echo "ID de reservación inválido.";
    exit;
}

// Consultar detalles de la reservación
$stmt = $pdo->prepare("
    SELECT r.*, h.horario 
    FROM reservaciones r 
    JOIN horarios h ON r.id_horario = h.id_horario 
    WHERE r.id_reservacion = :id_reservacion AND r.id_usuario = :id_usuario
");
$stmt->execute([
    ':id_reservacion' => $id_reservacion,
    ':id_usuario' => $_SESSION['id_usuario']
]);

$reservacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservacion) {
    echo "Reservación no encontrada o no autorizada.";
    exit;
}

// Monto ficticio por reservación
$monto = 500.00 + ($reservacion['num_mascotas'] ?? 0) * 100;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Simulado</title>
</head>
<body>
    <h2>Pasarela de Pago (Simulada)</h2>
    <p><strong>Fecha:</strong> <?= htmlspecialchars($reservacion['fecha']) ?></p>
    <p><strong>Horario:</strong> <?= htmlspecialchars($reservacion['horario']) ?></p>
    <p><strong>Número de personas:</strong> <?= $reservacion['num_personas'] ?></p>
    <?php if ($reservacion['con_mascotas']): ?>
        <p><strong>Mascotas:</strong> <?= $reservacion['num_mascotas'] ?></p>
    <?php endif; ?>
    <p><strong>Total a pagar:</strong> $<?= number_format($monto, 2) ?></p>

    <form action="confirmar_pago.php" method="POST">
        <input type="hidden" name="id_reservacion" value="<?= $id_reservacion ?>">
        <input type="hidden" name="monto" value="<?= $monto ?>">
        <input type="hidden" name="metodo_pago" value="Tarjeta de prueba">
        <button type="submit">Pagar ahora</button>
    </form>
</body>
</html>
