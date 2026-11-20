<?php
$base = "";
$public = "../public/";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar cliente</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>
    <main class="contenedor">
        <h1>Registrar cliente</h1>

        <form action="actions/registrar_cliente.php" method="post" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>

            <div class="fila-doble">
                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" required>
                </div>
                <div class="campo">
                    <label for="numero_licencia">Número de licencia</label>
                    <input type="text" name="numero_licencia" id="numero_licencia" required>
                </div>
            </div>

            <div class="campo">
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" required>
            </div>

            <button type="submit" class="boton">Guardar</button>
        </form>

        <a class="enlace-volver" href="vehiculos.php">Volver</a>
    </main>
    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>
