<?php
session_start();
include '../ElGranMesonProject/conexion.php'; // debe retornar PDO en $pdo

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 10) {
    header('Location: login.php');
    exit;
}

$id_reservacion = $_POST['id_reservacion'] ?? null;
$monto = $_POST['monto'] ?? null;
$metodo_pago = $_POST['metodo_pago'] ?? 'Simulado';

if (!$id_reservacion || !$monto) {
    echo "Datos incompletos para registrar el pago.";
    exit;
}

try {
    // Insertar orden de pago simulada
    $stmt = $pdo->prepare("
        INSERT INTO ordenes (id_reservacion, monto, metodo_pago, estatus_pago, referencia_externa)
        VALUES (:id_reservacion, :monto, :metodo_pago, 'exitoso', :referencia)
    ");
    $referencia = 'sandbox-' . uniqid();
    $stmt->execute([
        ':id_reservacion' => $id_reservacion,
        ':monto' => $monto,
        ':metodo_pago' => $metodo_pago,
        ':referencia' => $referencia
    ]);

    $id_orden = $pdo->lastInsertId();

    // Actualizar la reservación con el ID de la orden
    $stmtUpdate = $pdo->prepare("UPDATE reservaciones SET id_orden = :id_orden WHERE id_reservacion = :id_reservacion");
    $stmtUpdate->execute([
        ':id_orden' => $id_orden,
        ':id_reservacion' => $id_reservacion
    ]);

    echo "<script>alert('Pago exitoso. Reservación confirmada.'); window.location.href='dashboard.php';</script>";
    exit;

} catch (PDOException $e) {
    echo "Error al procesar pago: " . $e->getMessage();
}
?>
