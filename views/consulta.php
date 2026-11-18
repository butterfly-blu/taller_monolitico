<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../src/conexion_db.php';
require_once __DIR__ . '/../src/Reserva.php';
require_once __DIR__ . '/../src/Cliente.php';
require_once __DIR__ . '/../src/Vehiculo.php';

$conexDB = (new Conexion())->conectar();
$objVehiculo = new Vehiculo($conexDB);
$objCliente = new Cliente($conexDB);
$objReserva = new Reserva($conexDB);

$vehiculos = $objVehiculo->listarTodos();
$clientes = $objCliente->listarTodos();

$titulo = "";
$filas = [];
$consultado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $consultado = true;
    if ($accion == 'historial_vehiculo') {
        $titulo = "Historial del vehículo";
        $filas = $objReserva->historialPorVehiculo((int)$_POST['id_vehiculo']);
    } elseif ($accion == 'historial_cliente') {
        $titulo = "Historial del cliente";
        $filas = $objReserva->historialPorCliente((int)$_POST['id_cliente']);
    } elseif ($accion == 'disponibilidad_vehiculo') {
        $titulo = "Disponibilidad del vehículo";
        $v = $objVehiculo->buscarPorId((int)$_POST['id_vehiculo']);
        if ($v) {
            $filas = [['Marca' => $v['marca'], 'Modelo' => $v['modelo'], 'Estado' => $v['estado']]];
        }
    } elseif ($accion == 'vehiculos_disponibles') {
        $titulo = "Vehículos disponibles";
        $filas = $objVehiculo->listarDisponibles();
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor contenedor-ancho">
        <h1>Consultas</h1>

        <div class="seccion-consulta">
            <h3>Historial de un vehículo</h3>
            <form method="post" class="fila-consulta">
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
        </div>

        <div class="seccion-consulta">
            <h3>Historial de un cliente</h3>
            <form method="post" class="fila-consulta">
                <select name="id_cliente" required>
                    <?php foreach ($clientes as $c) { ?>
                        <option value="<?php echo $c['id']; ?>">
                            <?php echo ($c['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" name="accion" value="historial_cliente">Ver historial</button>
            </form>
        </div>

        <div class="seccion-consulta">
            <h3>Vehículos disponibles</h3>
            <form method="post" class="fila-consulta">
                <button type="submit" name="accion" value="vehiculos_disponibles">Ver todos los disponibles</button>
            </form>
        </div>

        <?php if ($consultado) { ?>
            <hr>
            <h2><?php echo $titulo; ?></h2>
            <?php if (count($filas) == 0) { ?>
                <p>No se encontraron resultados.</p>
            <?php } else { ?>
                <table class="tabla">
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
        <div>
            <a href="../index.php" class="enlace-volver">Volver</a>
        </div>
        <?php $conexDB->close(); ?>
</body>

</html>