<?php
// Página de resultado de una acción. Variables: $base, $public, $title, $success, $message, $back_link, $back_text
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/menu.php"; ?>
    <main class="contenedor">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p class="<?php echo $success ? 'mensaje-ok' : 'mensaje-error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
        <div class="enlaces">
            <a class="enlace-volver" href="<?php echo $back_link; ?>"><?php echo htmlspecialchars($back_text); ?></a>
            <a class="enlace-volver" href="<?php echo $base; ?>vehiculos.php">Ir al catálogo</a>
        </div>
    </main>
    <?php include __DIR__ . "/footer.php"; ?>
</body>

</html>