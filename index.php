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
        <a href="operaciones/registrar.php">
            <p> registrar</p>
        </a>
    </div>
    <div>
        <a href="operaciones/estados_vehi.php">
            <p> estado</p>
        </a>
    </div>

</body>

</html>