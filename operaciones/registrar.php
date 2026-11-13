<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../conexion_db.php';
$titulo = "Registrar vehiculo ";
$marca = " ";
$modelo = " ";
$anio = " ";
$categoria = " ";
$estado = " ";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $categoria = $_POST['categoria'];
    $estado = $_POST['estado'];
    $conexDB = conexion();
    $sql = "INSERT INTO vehiculos(marca, modelo, anio,categoria, estado) values ('$marca' ,'$modelo','$anio','$categoria' ,'$estado')";
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
    <title>Registrar vehiculo</title>
</head>

<body>
    <h1> <?php echo  $titulo; ?></h1>
    <br>
    <form method="post">
        <div>
            <label for="marca"> Marca : </label>
            <input type="text" name="marca" id="marca" value="<?php echo $marca; ?>" required>
        </div>
        <br>
        <div>
            <label for="modelo"> Modelo : </label>
            <input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" required>
        </div>
        <br>

        <div>
            <label for="anio"> Año : </label>
            <input type="number" name="anio" id="anio" value="<?php echo $anio; ?>" required>
        </div>
        <br>

        <div>
            <label for="categoria"> Categoria : </label>
            <input type="text" name="categoria" id="categoria" value="<?php echo $categoria; ?>" required>
        </div>
        <br>
        <label for="estado">Estado :</label>
        <select name="estado" id="estado">
            <option value="disponible">Disponible</option>
            <option value="alquilado">Alquilado</option>
            <option value="mantenimiento">Mantenimiento</option>
        </select>
    </form>
    <br>
    <div>
        <button type="submit">Registrar</button>
    </div>
    <div>
        <a href="../index.php">
            <p> volver</p>
        </a>
    </div>
</body>

</html>