<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../src/conexion_db.php';
require_once __DIR__ . '/../src/Reserva.php';
require_once __DIR__ . '/../src/Cliente.php';
require_once __DIR__ . '/../src/Vehiculo.php';

$conexDB = (new Conexion())->conectar();
$clientes = (new Cliente($conexDB))->listarTodos();
$vehiculos = (new Vehiculo($conexDB))->listarDisponibles();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva = new Reserva($conexDB);
    $reserva->cliente_id = $_POST['cliente_id'];
    $reserva->vehiculo_id = $_POST['vehiculo_id'];
    $reserva->fecha_inicio = $_POST['fecha_inicio'];
    $reserva->fecha_fin = $_POST['fecha_fin'];
    
    $error = $reserva->registrar();
      if ($error == "") {
        header('Location: ../index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <main class="contenedor">
        <h1>Registrar reserva</h1>

        <?php if ($error != "") { ?>
            <p class="mensaje-error"><?php echo($error); ?></p>
        <?php } ?>

        <form method="post" class="formulario">
            <div class="campo">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" required>
                   <?php foreach ($clientes as $c) { ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="campo">
                <label for="vehiculo_id">Vehículo disponible </label>
                <select name="vehiculo_id" id="vehiculo_id" required>
                    <?php foreach ($vehiculos as $v) { ?>
                        <option value="<?php echo $v['id']; ?>">
                            <?php echo htmlspecialchars($v['marca'] . " " . $v['modelo']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="fechas">
                <div class="campo">
                    <label for="fecha_inicio">Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="campo">
                    <label for="fecha_fin">Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>

            <button type="submit" class="boton">Reservar</button>
        </form>

        <a href="../index.php" class="enlace-volver">Volver</a>
    </main>
    <?php $conexDB->close(); ?>
</body>
</html>
