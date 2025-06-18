<?php
session_start();
// Validación de permisos (IMPORTANTE para seguridad)
if (!isset($_SESSION['id_rol'])) {
    die(json_encode(['error' => 'No autenticado']));
}

if ($_SESSION['id_rol'] != 1 && $_SESSION['id_rol'] != 2) {
    die(json_encode(['error' => 'No autorizado']));
}

require '../../conexion.php'; // Ajusta la ruta según tu estructura

try {
    // Consulta de usuarios
    $stmt = $pdo->query("SELECT id_usuario, usuario, nombre, apellidos, rol FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta de roles
    $sql_roles = "SELECT id_rol, descrip FROM roles";
    $result_roles = $pdo->query($sql_roles);
    $roles = $result_roles->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die(json_encode(['error' => "Error en consultas: " . $e->getMessage()]));
}
?>

<!-- SOLO el fragmento HTML que irá dentro de dashboard-content -->
<h2>Usuarios del sistema</h2>
<table>
    <thead>
        <tr>
            <th class="encabezado">Id</th>
            <th class="encabezado">Usuario</th>
            <th class="encabezado">Nombre</th>
            <th class="encabezado">Apellidos</th>
            <th class="encabezado">Rol</th>
            <th class="encabezado">Cambiar rol</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td class="dato"><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                <td class="dato"><?= htmlspecialchars($usuario['usuario']) ?></td>
                <td class="dato"><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td class="dato"><?= htmlspecialchars($usuario['apellidos']) ?></td>
                <td class="dato"><?= htmlspecialchars($usuario['rol']) ?></td>
                <td class="dato">
                    <form method="POST" action="cambiar_rol.php" class="form-rol">
                        <input type="hidden" name="usuario_id" value="<?= $usuario['id_usuario'] ?>">
                        <select name="nuevo_rol">
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= htmlspecialchars($rol['id_rol']) ?>">
                                    <?= htmlspecialchars($rol['descrip']) ?>
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
    document.querySelectorAll('.form-rol').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('cambiar_rol.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Rol actualizado');
                    // Opcional: recargar solo la tabla
                    document.querySelector('.item[data-target="admin_usuarios.php"]').click();
                } else {
                    alert('Error: ' + data.error);
                }
            });
        });
    });
});
</script>