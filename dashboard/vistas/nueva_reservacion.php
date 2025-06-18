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
    // Obtener horarios desde la base de datos
    $sql_horarios = "SELECT * FROM horarios";
    $result_horarios = $pdo->query($sql_horarios);
    $horarios = $result_horarios->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    die(json_encode(['error' => "Error en consultas: " . $e->getMessage()]));
}
?>

<div>
    <form action="procesar_reservacion.php" method="POST" id="formReservacion">
        <label for="num_personas">Número de personas:</label>
        <input type="number" name="num_personas" id="num_personas" min="1" required>

        <label for="fecha">Fecha de la reservación:</label>
        <input type="date" name="fecha" id="fecha" required>

        <label for="id_horario">Horario:</label>
        <select name="id_horario" id="id_horario" required>
            <option value="">-- Selecciona un horario --</option>
            <?php foreach ($horarios as $horario): ?>
                <option value="<?= $horario['id_horario'] ?>"><?= $horario['horario'] ?></option>
            <?php endforeach; ?>
        </select>

        <div>
            <input type="checkbox" id="con_mascotas" name="con_mascotas" value="1">
            <label for="con_mascotas">Requiero servicio para mascotas</label>
        </div>

        <div id="campo_mascotas" style="display: none;">
            <label for="num_mascotas">Número de mascotas:</label>
            <input type="number" name="num_mascotas" id="num_mascotas" min="1">
        </div>

        <button type="submit">Ir a pago</button>
    </form>
</div>

<script>
document.getElementById('con_mascotas').addEventListener('change', function () {
    const campo = document.getElementById('campo_mascotas');
    campo.style.display = this.checked ? 'block' : 'none';

    const inputMascotas = document.getElementById('num_mascotas');
    if (this.checked) {
        inputMascotas.required = true;
    } else {
        inputMascotas.value = '';
        inputMascotas.required = false;
    }
});
</script>
