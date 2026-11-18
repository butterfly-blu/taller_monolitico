<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/conexion_db.php';
require_once __DIR__ . '/../src/Vehiculo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexDB = (new Conexion())->conectar();

    $vehiculo = new Vehiculo($conexDB);
    $vehiculo->marca = $_POST['marca'];
    $vehiculo->modelo = $_POST['modelo'];
    $vehiculo->anio = $_POST['anio'];
    $vehiculo->categoria = $_POST['categoria'];
    $vehiculo->estado = $_POST['estado'];

    if ($vehiculo->registrar()) {
        header('Location: ../index.php?ok=1');
        exit;
    }}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar vehiculo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
    <h1> Registar Vehiculo</h1>
    <br>
    <form method="post" class="formulario">
        <div class="fechas">
            <div class="campo">
            <label for="marca"> Marca : </label>
            <input type="text" name="marca" id="marca" required>
        </div>
        <br>
        <div class="campo">
            <label for="modelo"> Modelo : </label>
            <input type="text" name="modelo" id="modelo"  required>
        </div>
         </div>
        <br>

             <div class="fechas">
            <div class="campo">
            <label for="anio"> Año : </label>
            <input type="number" name="anio" id="anio" required>
        </div>
        <br>

       <div class="campo">
            <label for="categoria"> Categoria : </label>
            <input type="text" name="categoria" id="categoria"  required>
        </div>
        </div>
        <br>
        <div class="campo">
        <label for="estado">Estado :</label>
        <select name="estado" id="estado">
            <option value="disponible">Disponible</option>
            <option value="alquilado">Alquilado</option>
            <option value="mantenimiento">Mantenimiento</option>
        </select>
        </div>
    <br>
    <div>
        <button type="submit" class="boton">Registrar</button>
    </div>
    
      </form>
    <div>
          <a href="../index.php" class="enlace-volver">Volver</a>

    </div>
</body>

</html>