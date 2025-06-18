<?php
session_start();
header('Content-Type: application/json');
include '../ElGranMesonProject/conexion.php'; // debe retornar PDO en $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservacion_id = $_POST['reservacion_id'];
    $nuevo_estatus = $_POST['nuevo_estatus'];

    try {
        // Primero obtén la descripción del estatus según el id
        $stmtEstatus = $pdo->prepare("SELECT nombre FROM estatus_reservacion WHERE id = :nuevo_estatus");
        $stmtEstatus->bindParam(':nuevo_estatus', $nuevo_estatus, PDO::PARAM_INT);
        $stmtEstatus->execute();
        $estatusData = $stmtEstatus->fetch(PDO::FETCH_ASSOC);

        if (!$estatusData) {
            echo "El estatus seleccionado no existe.";
            exit;
        }

        $nueva_descripcion = $estatusData['descrip'];

        // Actualiza en reservaciones los campos
        $stmt = $pdo->prepare("UPDATE reservaciones SET id_estatus = :id_estatus WHERE id_reservacion = :reservacion_id");
        $stmt->bindParam(':id_estatus', $nuevo_estatus, PDO::PARAM_INT);        
        $stmt->bindParam(':reservacion_id', $reservacion_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error al actualizar el estatus de la reservacion.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
