<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../conexion_db.php';
$titulo = "Registro Clientes ";
$nombre ="";
$telefono ="";
$correo ="";
$numero_licencia ="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $numero_licencia = $_POST['numero_licencia'];

    $conexDB = conexion();
    $sql= "INSERT INTO clientes(nombre, telefono, correo, numero_licencia) 
    VALUES ('$nombre','$telefono,','$correo',' $numero_licencia')";

    $result = $conexDB->query($sql);
   
    if ($result) {
        header('Location: ../index.php');
    } else {
        header('Location: ../index.php?error_insert=1');
        exit;
    }
    $conexDB->close();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registro clientes </title>
</head>

<body>
    <h1> <?php echo  $titulo; ?></h1>
    <br>
    <form method="post">
        <div>
            <label for="nombre">Nombre : </label>
            <input type="text" name="nombre" id="monbre" value="<?php echo $nombre; ?>" required>
        </div>
        <br>
        <div>
            <label for="telefono">Telefono: </label>
            <input type="number" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required>
        </div>
        <br>

        <div>
            <label for="correo"> Correo : </label>
            <input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
        </div>
        <br>

        <div>
            <label for="numero_licencia"> Numero de licencia : </label>
            <input type="number" name="numero_licencia" id="numero_licencia" value="<?php echo $numero_licencia; ?>" required>
        </div>
    <br>
    <div>
        <button type="submit">Registrar</button>
    </div>
      </form>
    <div>
        
        <a href="../index.php">
            <p> volver</p>
        </a>
    </div>
</body>

</html>