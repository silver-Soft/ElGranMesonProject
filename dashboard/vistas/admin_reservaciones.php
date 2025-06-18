<?php
session_start();
// Validación de permisos (IMPORTANTE para seguridad)
if (!isset($_SESSION['id_rol'])) {
    die(json_encode(['error' => 'No autenticado']));
}

if ($_SESSION['id_rol'] != 1 && $_SESSION['id_rol'] != 2) {
    die(json_encode(['error' => 'No puedes administrar reservaciones']));
}

require '../../conexion.php'; // Ajusta la ruta según tu estructura

try {
    // Consulta de reservaciones
    $stmt = $pdo->query("
        SELECT 
        r.id_reservacion,
        r.id_usuario,
        CONCAT(u.nombre, ' ', u.apellidos) AS nombre_usuario,
        r.id_horario,
        h.horario,
        r.id_estatus,
        e.nombre AS estatus_reservacion,
        r.id_orden
        FROM reservaciones r
        JOIN usuarios u ON r.id_usuario = u.id_usuario
        JOIN horarios h ON r.id_horario = h.id_horario
        JOIN estatus_reservacion e ON r.id_estatus = e.id;
    ");
    $reservaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta de estatus
    $sql_estatus = "SELECT * FROM estatus_reservacion WHERE id != 3";
    $result_estatus = $pdo->query($sql_estatus);
    $estatuses = $result_estatus->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die(json_encode(['error' => "Error en consultas: " . $e->getMessage()]));
}
?>

<h2>Reservaciones</h2>
<table>
    <thead>
        <tr>
            <th class="encabezado">Id reservación</th>
            <th class="encabezado">Id de orden</th>            
            <th class="encabezado">Usuario</th>
            <th class="encabezado">Horario</th>
            <th class="encabezado">Estatus</th>    
            <th class="encabezado">Detalles</th>        
            <th class="encabezado">Cambiar estatus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservaciones as $reservacion): ?>
            <tr>
                <td class="dato"><?= htmlspecialchars($reservacion['id_reservacion']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['id_orden']) ?></td>                
                <td class="dato"><?= htmlspecialchars($reservacion['nombre_usuario']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['horario']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['estatus_reservacion']) ?></td>
                <td class="dato">
                    <button type="button">Detalles</button>
                </td>
                <td class="dato">
                    <form method="POST" action="cambiar_estatus_res.php" class="form-estatus">
                        <input type="hidden" name="reservacion_id" value="<?= $reservacion['id_reservacion'] ?>">
                        <select name="nuevo_estatus">
                            <?php foreach ($estatuses as $estatus): ?>
                                <option value="<?= htmlspecialchars($estatus['id']) ?>">
                                    <?= htmlspecialchars($estatus['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Script para manejar el formulario sin recargar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de formularios de cambio de rol via AJAX
    document.querySelectorAll('.form-estatus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('cambiar_estatus_res.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Estatus actualizado');
                    // Opcional: recargar solo la tabla
                    document.querySelector('.item[data-target="admin_reservaciones.php"]').click();
                } else {
                    alert('Error: ' + data.error);
                }
            });
        });
    });
});
</script>