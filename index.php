<?php
ini_set('display_errors', 1);
$titulo = "Alquiler de vehiculos ";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vehiculoss</title>
</head>

<body>
    <h1> <?php echo  $titulo; ?></h1>
    <br>
    <div>
        <a href="operaciones/registrar_vh.php">
            <p> Registrar Vehiculo</p>
        </a>
    </div>

    <div>
        <a href="operaciones/estados_vehi.php">
            <p> estado</p>
        </a>
    </div>
     <div>
        <a href="operaciones/registrar_cl.php">
            <p> Registro Cliente</p>
        </a>
    </div>
    <div>
        <a href="operaciones/consulta.php">
            <p> consulta </p>
        </a>
    </div>
    <div>
        <a href="operaciones/reserva.php">
            <p> Registrar reserva </p>
        </a>
    </div>
</body>

</html>