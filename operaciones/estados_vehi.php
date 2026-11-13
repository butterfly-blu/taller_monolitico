<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../conexion_db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {$conexDB = conexion();
    $sql = " SELECT * FROM 'vehiculos'";
    $result = $conexDB->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "ID: " . $row['id'];
        echo "Marca: " . $row['marca'];
        echo "Año: " . $row['anio'];
        echo "Categoria: " . $row['categoria'];
         echo "Estado: " . $row['estado'];
        echo "<br>";
    }}
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
    <title>Estado vehiculos </title>
</head>

<body>
    <h1> Estado vehiculos</h1>
    <br>
    <div>
        <a href="../index.php">
            <p> registrar</p>
        </a>
    </div>
</body>
</html>