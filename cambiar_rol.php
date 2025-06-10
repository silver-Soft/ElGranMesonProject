<?php
include 'conexion.php'; // debe retornar PDO en $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $nuevo_rol = $_POST['nuevo_rol'];

    try {
        // Primero obtén la descripción del rol según el id
        $stmtRol = $pdo->prepare("SELECT descrip FROM roles WHERE id_rol = :nuevo_rol");
        $stmtRol->bindParam(':nuevo_rol', $nuevo_rol, PDO::PARAM_INT);
        $stmtRol->execute();
        $rolData = $stmtRol->fetch(PDO::FETCH_ASSOC);

        if (!$rolData) {
            echo "El rol seleccionado no existe.";
            exit;
        }

        $nueva_descripcion = $rolData['descrip'];

        // Actualiza en usuarios ambos campos
        $stmt = $pdo->prepare("UPDATE usuarios SET id_rol = :id_rol, rol = :rol WHERE id = :usuario_id");
        $stmt->bindParam(':id_rol', $nuevo_rol, PDO::PARAM_INT);
        $stmt->bindParam(':rol', $nueva_descripcion);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error al actualizar el rol del usuario.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
