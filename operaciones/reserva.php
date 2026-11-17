<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../conexion_db.php';
require_once __DIR__ . '/../Reserva.php';

$conexDB = conexion();
$vehiculos = $conexDB->query("SELECT id, marca, modelo FROM vehiculos WHERE estado = 'disponible' ORDER BY marca");
$clientes = $conexDB->query("SELECT id, nombre FROM clientes ORDER BY nombre");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva = new Reserva(
        $conexDB,
        $_POST['cliente_id'],
        $_POST['vehiculo_id'],
        $_POST['fecha_inicio'],
        $_POST['fecha_fin']
    );
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
                    <?php while ($c = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo($c['nombre']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="campo">
                <label for="vehiculo_id">Vehículo</label>
                <select name="vehiculo_id" id="vehiculo_id" required>
                    <?php while ($v = $vehiculos->fetch_assoc()) { ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo ($v['marca'] . " " . $v['modelo']); ?></option>
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
</body>
</html>
<?php $conexDB->close(); ?>