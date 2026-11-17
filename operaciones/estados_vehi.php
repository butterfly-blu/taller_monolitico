<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/conexion_db.php';
require_once __DIR__ . '/../src/Reserva.php';
require_once __DIR__ . '/../src/Vehiculo.php';

$conexDB = (new Conexion())->conectar();
$objVehiculo = new Vehiculo($conexDB);
$objReserva = new Reserva($conexDB);

// Si se hace clic en "Devolver vehículo"
if (isset($_GET['devolver_id'])) {
    $objReserva->devolverVehiculo((int)$_GET['devolver_id']);
    header('Location: estados_vehi.php');
    exit;
}

// Si se hace clic en "Cancelar reserva"
if (isset($_GET['cancelar_id'])) {
    $objReserva->cancelarReserva((int)$_GET['cancelar_id']);
    header('Location: estados_vehi.php');
    exit;
}
$vehiculos = $objVehiculo->listarTodos();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado vehiculos </title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor contenedor-ancho">
    <h1> Estado vehiculos y devoluciones y cancelaciones </h1>
    <br>
    

            <?php if (count($vehiculos) > 0) { ?>
        <table class="tabla">
            <tr>
                <th>N.</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($vehiculos as $v) { ?>
                <tr>
                   <td><?php echo $v['id']; ?></td>
                    <td><?php echo htmlspecialchars($v['marca']); ?></td>
                    <td><?php echo htmlspecialchars($v['modelo']); ?></td>
                    <td><?php echo $v['anio']; ?></td>
                    <td><?php echo htmlspecialchars($v['categoria']); ?></td>
                    <td><?php echo $v['estado']; ?></td>
                    <td>
                        <?php if ($v['estado'] == 'alquilado') { ?>
                            <a href="estados_vehi.php?devolver_id=<?php echo $v['id']; ?>">Devolver vehículo</a>
                       <a href="estados_vehi.php?cancelar_id=<?php echo $v['id']; ?>">Cancelar reserva</a>
                            <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No hay vehículos registrados.</p>
    <?php } ?>
<br>
        <a href="../index.php" class="enlace-volver">Volver</a>
    </main>
        <?php $conexDB->close(); ?>
</body>
</html>
