<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../conexion_db.php';

$conexDB = conexion();

// Ejecuta una consulta preparada con un solo parámetro y devuelve las filas
function consultar($conexDB, $sql, $valor = null)
{
    $stmt = $conexDB->prepare($sql);
    if ($valor !== null) {
        $stmt->bind_param("i", $valor);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();

    $filas = array();
    while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
    }
    $stmt->close();
    return $filas;
}

// Listas para llenar los select
$vehiculos = consultar($conexDB, "SELECT id, marca, modelo FROM vehiculos ORDER BY marca");
$clientes = consultar($conexDB, "SELECT id, nombre FROM clientes ORDER BY nombre");

$titulo = "";
$filas = array();
$consultado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $consultado = true;

    if ($accion == 'historial_vehiculo') {
        $id = (int) $_POST['id_vehiculo'];
        $titulo = "Historial del vehículo";
        $filas = consultar($conexDB,
           "SELECT r.id AS reserva, c.nombre AS cliente, r.fecha_inicio, r.fecha_fin, r.estado
             FROM reservas r
             INNER JOIN clientes c ON c.id = r.cliente_id
             WHERE r.vehiculo_id = ?
             ORDER BY r.fecha_inicio DESC", $id);

    } elseif ($accion == 'historial_cliente') {
        $id = (int) $_POST['id_cliente'];
        $titulo = "Historial del cliente";
        $filas = consultar($conexDB,
            "SELECT r.id AS reserva, v.marca, v.modelo, r.fecha_inicio, r.fecha_fin, r.estado
             FROM reservas r
             INNER JOIN vehiculos v ON v.id = r.vehiculo_id
             WHERE r.cliente_id = ?
             ORDER BY r.fecha_inicio DESC", $id);

    } elseif ($accion == 'disponibilidad_vehiculo') {
        $id = (int) $_POST['id_vehiculo'];
        $titulo = "Disponibilidad del vehículo";
        $filas = consultar($conexDB,
            "SELECT marca, modelo, estado FROM vehiculos WHERE id = ?", $id);

    } elseif ($accion == 'vehiculos_disponibles') {
        $titulo = "Vehículos disponibles";
        $filas = consultar($conexDB,
            "SELECT id, marca, modelo, anio, categoria
             FROM vehiculos WHERE estado = 'disponible'");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
</head>
<body>
    <h1>Consultas</h1>

    <h3>Historial de un vehículo</h3>
    <form method="post">
        <select name="id_vehiculo" required>
            <?php foreach ($vehiculos as $v) { ?>
                <option value="<?php echo $v['id']; ?>">
                    <?php echo htmlspecialchars($v['marca'] . " " . $v['modelo']); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="accion" value="historial_vehiculo">Ver historial</button>
        <button type="submit" name="accion" value="disponibilidad_vehiculo">Ver disponibilidad</button>
    </form>

    <h3>Historial de un cliente</h3>
    <form method="post">
        <select name="id_cliente" required>
            <?php foreach ($clientes as $c) { ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo ($c['nombre']); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="accion" value="historial_cliente">Ver historial</button>
    </form>

    <h3>Vehículos disponibles</h3>
    <form method="post">
        <button type="submit" name="accion" value="vehiculos_disponibles">Ver todos los disponibles</button>
    </form>

    <?php if ($consultado) { ?>
        <hr>
        <h2><?php echo $titulo; ?></h2>
        <?php if (count($filas) == 0) { ?>
            <p>No se encontraron resultados.</p>
        <?php } else { ?>
            <table border="1" cellpadding="6">
                <tr>
                    <?php foreach (array_keys($filas[0]) as $columna) { ?>
                        <th><?php echo htmlspecialchars($columna); ?></th>
                    <?php } ?>
                </tr>
                <?php foreach ($filas as $fila) { ?>
                    <tr>
                        <?php foreach ($fila as $dato) { ?>
                            <td><?php echo htmlspecialchars((string) $dato); ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    <?php } ?>

    <p><a href="../index.php">Volver</a></p>
</body>
</html>
<?php $conexDB->close(); ?>