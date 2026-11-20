<?php
$base = "";
$public = "../public/";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar vehículo</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>
    <main class="contenedor">
        <h1>Registrar vehículo</h1>

        <form action="actions/registrar_vehiculo.php" method="post" class="formulario">
            <div class="fila-doble">
                <div class="campo">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" required>
                </div>
                <div class="campo">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" required>
                </div>
            </div>

            <div class="fila-doble">
                <div class="campo">
                    <label for="anio">Año</label>
                    <input type="number" name="anio" id="anio" min="1901" max="<?php echo date('Y') + 1; ?>" required>
                </div>
                <div class="campo">
                    <label for="categoria">Categoría</label>
                    <input type="text" name="categoria" id="categoria" required>
                </div>
            </div>

            <div class="campo">
                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                    <option value="disponible">Disponible</option>
                    <option value="alquilado">Alquilado</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
            </div>

            <button type="submit" class="boton">Guardar</button>
        </form>

        <a class="enlace-volver" href="vehiculos.php">Volver</a>
    </main>
    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>
