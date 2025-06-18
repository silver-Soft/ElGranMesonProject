<?php
session_start();
include '../ElGranMesonProject/conexion.php'; // debe retornar PDO en $pdo

// Asegura que solo clientes puedan usar este módulo
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 10) {
    header('Location: login.php');
    exit;
}

$id_usuario     = $_SESSION['id_usuario'];
$num_personas   = $_POST['num_personas'] ?? null;
$fecha          = $_POST['fecha'] ?? null;
$id_horario     = $_POST['id_horario'] ?? null;
$con_mascotas   = isset($_POST['con_mascotas']) ? 1 : 0;
$num_mascotas   = $_POST['num_mascotas'] ?? null;

if (!$num_personas || !$fecha || !$id_horario) {
    die("Faltan datos obligatorios.");
}

// Validar que no tenga una reservación activa
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservaciones WHERE id_usuario = ? AND id_estatus = 1");
$stmt->execute([$id_usuario]);
$yaTieneActiva = $stmt->fetchColumn();

if ($yaTieneActiva > 0) {
    echo "<script>alert('Ya tienes una reservación activa. Cancélala o finalízala antes de crear una nueva.'); window.location.href='dashboard.php';</script>";
    exit;
}

try {
    // Insertar nueva reservación
    $stmt = $pdo->prepare("
        INSERT INTO reservaciones (
            id_usuario,
            num_personas,
            fecha,
            id_horario,
            con_mascotas,
            num_mascotas,
            id_estatus
        ) VALUES (
            :id_usuario, :num_personas, :fecha, :id_horario, :con_mascotas, :num_mascotas, 1
        )
    ");

    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':num_personas', $num_personas, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
    $stmt->bindParam(':con_mascotas', $con_mascotas, PDO::PARAM_BOOL);
    $stmt->bindValue(':num_mascotas', $con_mascotas ? $num_mascotas : null, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Obtener el ID recién insertado para usarlo en la pasarela de pago simulada
        $id_reservacion = $pdo->lastInsertId();
        header("Location: pago_simulado.php?id_reservacion=" . $id_reservacion);
        exit;
    } else {
        echo "Error al guardar la reservación.";
    }
} catch (PDOException $e) {
    echo "Error en base de datos: " . $e->getMessage();
}
?>
