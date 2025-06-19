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
        r.id_orden,
        r.num_personas,
        h.horario,
        r.num_mascotas  
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
                <button 
                    type="button" 
                    class="btn-detalles"
                    data-id="<?= $reservacion['id_reservacion'] ?>"
                    data-orden="<?= $reservacion['id_orden'] ?>"
                    data-nombre="<?= htmlspecialchars($reservacion['nombre_usuario']) ?>"
                    data-horario="<?= htmlspecialchars($reservacion['horario']) ?>"
                    data-comensales="<?= htmlspecialchars($reservacion['num_personas']) ?>"                    
                    data-mascotas="<?= htmlspecialchars($reservacion['num_mascotas']) ?>"
                    data-estatus="<?= htmlspecialchars($reservacion['estatus_reservacion']) ?>"
                >       
                    Detalles
                </button>
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

<div id="modal-detalles" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000088; z-index:9999; justify-content:center; align-items:center;">
    <div class="dialog-container">
        <h3>Detalles de reservación</h3>
        <p><strong>ID:</strong> <span id="det-id"></span></p>
        <p><strong>Orden:</strong> <span id="det-orden"></span></p>
        <p><strong>Nombre cliente:</strong> <span id="det-nombre"></span></p>
        <p><strong>Horario reservación:</strong> <span id="det-horario"></span></p>
        <p><strong>Estatus reservación:</strong> <span id="det-estatus"></span></p>
        <p><strong>Número de comensales:</strong> <span id="det-comensales"></span></p>
        <p><strong>Número de mascotas:</strong> <span id="det-mascotas"></span></p>
        <div style="width: 100%; display: flex; justify-content: center;" >
            <a onclick="cerrarModal()" class="boton boton--primario" style="margin-top: 8rem;">
                Cerrar
            </a>
        </div>                
    </div>
</div>


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
<script>
function cerrarModal() {
    document.getElementById('modal-detalles').style.display = 'none';
}

document.querySelectorAll('.btn-detalles').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('det-id').textContent = btn.dataset.id;
        document.getElementById('det-orden').textContent = btn.dataset.orden;
        document.getElementById('det-nombre').textContent = btn.dataset.nombre;
        document.getElementById('det-horario').textContent = btn.dataset.horario;
        document.getElementById('det-estatus').textContent = btn.dataset.estatus;
        document.getElementById('det-comensales').textContent = btn.dataset.comensales;
        document.getElementById('det-mascotas').textContent = btn.dataset.mascotas;

        document.getElementById('modal-detalles').style.display = 'flex';
    });
});
</script>
