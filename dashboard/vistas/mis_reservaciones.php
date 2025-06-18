<?php
session_start();
// Validación de permisos (IMPORTANTE para seguridad)
if (!isset($_SESSION['id_rol'])) {
    die(json_encode(['error' => 'No autenticado']));
}

if ($_SESSION['id_rol'] != 10) {
    die(json_encode(['error' => 'No puedes ver tus reservaciones con un perfil diferente de cliente']));
}
require '../../conexion.php'; // Ajusta la ruta según tu estructura

try {
    // Consulta de reservaciones con parámetro
    $stmt = $pdo->prepare("
        SELECT 
        r.id_reservacion,        
        CONCAT(u.nombre, ' ', u.apellidos) AS nombre_usuario,        
        h.horario,        
        e.nombre AS estatus_reservacion,        
        o.monto,
        o.estatus_pago,
        o.metodo_pago,
        r.id_estatus
        FROM reservaciones r
        JOIN ordenes o ON r.id_reservacion = o.id_reservacion
        JOIN usuarios u ON r.id_usuario = u.id_usuario
        JOIN horarios h ON r.id_horario = h.id_horario
        JOIN estatus_reservacion e ON r.id_estatus = e.id
        WHERE u.id_usuario = ?
    ");

    // Ejecutar la consulta con el parámetro (usando el ID de usuario de la sesión)
    $stmt->execute([$_SESSION['id_usuario']]);
    $reservaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta de estatus (esta no necesita parámetros)
    $sql_estatus = "SELECT * FROM estatus_reservacion WHERE id != 2";
    $result_estatus = $pdo->query($sql_estatus);
    $estatuses = $result_estatus->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(json_encode(['error' => "Error en consultas: " . $e->getMessage()]));
}
?>

<h2>Mis reservaciones</h2>
<table>
    <thead>
        <tr>
            <th class="encabezado">Id reservación</th>
            <th class="encabezado">Estatus</th>
            <th class="encabezado">Nombre del usuario</th>
            <th class="encabezado">Horario</th>
            <th class="encabezado">Monto</th>
            <th class="encabezado">Estatus del pago</th>
            <th class="encabezado">Método de pago</th>
            <th class="encabezado">Cancelar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservaciones as $reservacion): ?>
            <tr>
                <td class="dato"><?= htmlspecialchars($reservacion['id_reservacion']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['estatus_reservacion']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['nombre_usuario']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['horario']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['monto']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['estatus_pago']) ?></td>
                <td class="dato"><?= htmlspecialchars($reservacion['metodo_pago']) ?></td>
                <td class="dato">
                    <?php if ($reservacion['id_estatus'] == 1): ?>
                        <button
                            type="button"
                            class="btn-cancelar"
                            data-reservacion-id="<?= $reservacion['id_reservacion'] ?>"
                            data-nuevo-estatus="3">
                            Cancelar
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Script para manejar el formulario sin recargar -->
<script>
    const botones = document.querySelectorAll('.btn-cancelar');
    console.log("Botones encontrados:", botones.length);

    botones.forEach(button => {
        button.addEventListener('click', () => {

            const reservacionId = button.getAttribute('data-reservacion-id');
            const nuevoEstatus = button.getAttribute('data-nuevo-estatus');

            if (!confirm('¿Estás seguro de cancelar esta reservación?')) {
                return;
            }

            fetch('cambiar_estatus_res.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        reservacion_id: reservacionId,
                        nuevo_estatus: nuevoEstatus
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error("Error en la solicitud.");
                    return response.text();
                })
                .then(result => {
                    console.log(result);
                    location.reload(); // o actualizar la fila en la tabla
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('No se pudo cancelar la reservación.');
                });
        });
    });
</script>