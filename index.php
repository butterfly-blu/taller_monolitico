<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/src/conexion_db.php';
require_once __DIR__ . '/src/Vehiculo.php';
$conexDB = (new Conexion())->conectar();
$vehiculos = (new Vehiculo($conexDB))->listarTodos();
$mensaje = isset($_GET['ok']) ? "Operación realizada correctamente." : "";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Alquiler de Vehículos</title>
    <link rel="stylesheet" href="css/estilos.css">
  
</head>
<body> 
<header class="navbar">
        <nav class="navbar-links">
            <a href="index.php" class="navbar-marca">Alquiler de Vehículos</a>
            <a href="views/registrar_vh.php">Registrar vehículo</a>
            <a href="views/registrar_cl.php">Registrar cliente</a>
            <a href="views/estados_vehi.php">Vehiculos y devoluciones</a>
            <a href="views/consulta.php">Consultas</a>
            <a href="views/reserva.php" class="navbar-destacado">Nueva reserva</a>
        </nav>
    </header>

<main class="contenedor-catalogo">
        <h1 class="titulo-principal">Nuestros Vehículos</h1>

        <?php if ($mensaje != "") { ?>
            <p class="mensaje-ok"><?php echo $mensaje; ?></p>
        <?php } ?>

        <?php if (count($vehiculos) == 0) { ?>
            <div class="contenedor" style="text-align: center;">
                <p>Aún no hay vehículos registrados.</p>
                <br>
                <a href="views/registrar_vh.php" class="boton">Registrar primer vehículo</a>
            </div>
        <?php } else { ?>
            <section class="grid-vehiculos">
                <?php foreach ($vehiculos as $v) { ?>
                    <article class="tarjeta-auto">
                      <?php $categoria = strtolower($v['categoria']);

if ($categoria == 'camioneta' || $categoria == 'suv') {
    $foto = "img/captur.jpeg";
} elseif ($categoria == 'deportivo') {
    $foto = "img/bmwS3.jpeg";
} else {
    // Si escribes cualquier otra cosa (Deportivo, Moto, Urbano, etc.), usa esta:
    $foto = "img/default.jpg";
}
?>
<img src="<?php echo $foto; ?>" alt="Foto de <?php echo htmlspecialchars($v['marca']); ?>">                        
                        <div class="tarjeta-cuerpo">
                            <div class="tarjeta-header">
                                <span class="tarjeta-titulo">
                                    <?php echo htmlspecialchars($v['marca'] . " " . $v['modelo']); ?>
                                </span>
                                <span class="badge badge-<?php echo $v['estado']; ?>">
                                    <?php echo $v['estado']; ?>
                                </span>
                            </div>

                            <ul class="tarjeta-detalles">
                                <li><strong>Año:</strong> <?php echo $v['anio']; ?></li>
                                <li><strong>Categoría:</strong> <?php echo htmlspecialchars($v['categoria'] ?: 'Estándar'); ?></li>
                                <li><strong>ID de flota:</strong> #<?php echo $v['id']; ?></li>
                            </ul>

                            <?php if ($v['estado'] == 'disponible') { ?>
                                <a href="views/reserva.php" class="boton">Reservar</a>
                            <?php } else { ?>
                                <span class="boton boton-deshabilitado">No disponible</span>
                            <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

<?php $conexDB->close();?>
</body>
<footer class="footer">
    <p class="footer-titulo"> TALLER MONOLITICO - PROGRAMACION AVANZADA</p>
</footer>
</html>