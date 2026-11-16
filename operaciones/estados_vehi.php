<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../conexion_db.php';

$conexDB = conexion();
$result = $conexDB->query("SELECT * FROM vehiculos");


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado vehiculos </title>
</head>

<body>
    <h1> Estado vehiculos</h1>
    <br>
    
<?php if ($result->num_rows > 0) { ?>
        <table border="1" cellpadding="6">
            <tr>
                <th>N.</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Categoría</th>
                <th>Estado</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo ($row['marca']); ?></td>
                    <td><?php echo ($row['modelo']); ?></td>
                    <td><?php echo $row['anio']; ?></td>
                    <td><?php echo ($row['categoria']); ?></td>
                    <td><?php echo ($row['estado']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No hay vehículos registrados.</p>
    <?php } ?>

    <p><a href="../index.php">Volver</a></p>
    <div>
        <a href="../index.php">
            <p> registrar</p>
        </a>
    </div>

</body>
</html>
<?php $conexDB->close(); ?>