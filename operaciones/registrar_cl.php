<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/conexion_db.php';
require_once __DIR__ . '/../src/Cliente.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexDB = (new Conexion())->conectar();

   $cliente = new Cliente($conexDB);
   $cliente->nombre = $_POST['nombre'];
   $cliente->telefono = $_POST['telefono'];
   $cliente->correo = $_POST['correo'];
   $cliente->numero_licencia = $_POST['numero_licencia'];

    if ($cliente->registrar()) {
        header('Location: ../index.php?ok=1');
        exit;
    }
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
    <h1> Registro clientes </h1>
    <br>
    <form method="post">
        <div>
            <label for="nombre">Nombre : </label>
            <input type="text" name="nombre" id="nombre"  required>
        </div>
        <br>
        <div>
            <label for="telefono">Telefono: </label>
            <input type="number" name="telefono" id="telefono" required>
        </div>
        <br>

        <div>
            <label for="correo"> Correo : </label>
            <input type="email" name="correo" id="correo" required>
        </div>
        <br>

        <div>
            <label for="numero_licencia"> Numero de licencia : </label>
            <input type="number" name="numero_licencia" id="numero_licencia"  required>
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