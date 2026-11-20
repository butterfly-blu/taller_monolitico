<?php
require "../models/entities/vehicle.php";
require "../models/mappers/vehicles_mappers.php";
require "../models/database/rental_db_interface.php";
require "../models/database/rental_db.php";
require "../models/repositories/vehicles_repository_interface.php";
require "../models/repositories/vehicles_repository.php";
require "../models/config/models_config.php";

require "../controllers/mappers/vehicles_mappers.php";
require "../controllers/vehicles/vehicles_controller_interface.php";
require "../controllers/vehicles/vehicles_controller.php";
require "../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "";
$public = "../public/";

$controller = ControllersConfig::get_vehicles_controller();
$list = $controller->get_vehicles();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de vehículos</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>

    <main class="contenedor-catalogo">
        <h1 class="titulo-principal">Nuestros vehículos</h1>

        <?php if (count($list) == 0) { ?>
            <p class="mensaje-aviso">Todavía no hay vehículos. Registra el primero desde el menú.</p>
        <?php } else { ?>
            <section class="grid-vehiculos">
                <?php foreach ($list as $item) {
                    $id = $item->get_id();
                    $name = $item->get_brand() . " " . $item->get_model();
                    $status = $item->get_status();

                    // La foto depende de la categoría del carro
                    $category = strtolower(trim($item->get_category()));
                    if ($category == "camioneta" || $category == "suv") {
                        $image = $public . "img/captur.jpeg";
                    } elseif (str_contains($category, "deportivo")) {
                        $image = $public . "img/bmws3.jpeg";
                    } else {
                        $image = $public . "img/default.jpg";
                    }
                ?>
                    <article class="tarjeta-auto">
                        <img src="<?php echo $image; ?>" alt="Foto de <?php echo htmlspecialchars($name); ?>">

                        <div class="tarjeta-cuerpo">
                            <div class="tarjeta-header">
                                <span class="tarjeta-titulo"><?php echo htmlspecialchars($name); ?></span>
                                <span class="badge badge-<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($status); ?></span>
                            </div>

                            <ul class="tarjeta-detalles">
                                <li><b>Año:</b> <?php echo $item->get_year(); ?></li>
                                <li><b>Categoría:</b> <?php echo htmlspecialchars($item->get_category()); ?></li>
                                <li><b>ID de flota:</b> #<?php echo $id; ?></li>
                            </ul>

                            <details class="tarjeta-descripcion">
                                <summary>Ver descripción</summary>
                                <p>
                                    El <?php echo htmlspecialchars($name); ?> es un vehículo de categoría
                                    <?php echo htmlspecialchars($item->get_category()); ?>, modelo <?php echo $item->get_year(); ?>.
                                    Actualmente está <?php echo htmlspecialchars($status); ?>.
                                </p>
                            </details>

                            <?php if ($status == "disponible") { ?>
                                <a class="boton" href="reserva.php?vehicle_id=<?php echo $id; ?>">Reservar</a>
                            <?php } else { ?>
                                <span class="boton boton-deshabilitado">No disponible</span>
                            <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>