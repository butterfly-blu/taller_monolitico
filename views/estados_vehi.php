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

$list = ControllersConfig::get_vehicles_controller()->get_vehicles();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flota y devoluciones</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>
    <main class="contenedor contenedor-ancho">
        <h1>Flota y devoluciones</h1>

        <?php if (count($list) == 0) { ?>
            <p class="mensaje-aviso">No hay vehículos registrados.</p>
        <?php } else { ?>
            <div class="tabla-contenedor">
                <table class="tabla">
                    <tr>
                        <th>N.</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($list as $item) {
                        $status = $item->get_status();
                    ?>
                        <tr>
                            <td><?php echo $item->get_id(); ?></td>
                            <td><?php echo htmlspecialchars($item->get_brand()); ?></td>
                            <td><?php echo htmlspecialchars($item->get_model()); ?></td>
                            <td><?php echo $item->get_year(); ?></td>
                            <td><?php echo htmlspecialchars($item->get_category()); ?></td>
                            <td><span class="badge badge-<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($status); ?></span></td>
                            <td>
                                <?php if ($status == "alquilado") { ?>
                                    <div class="acciones">
                                        <form action="actions/devolver_vehiculo.php" method="post">
                                            <input type="hidden" name="vehicle_id" value="<?php echo $item->get_id(); ?>">
                                            <button type="submit" class="boton boton-pequeno">Devolver</button>
                                        </form>
                                        <form action="actions/cancelar_reserva.php" method="post">
                                            <input type="hidden" name="vehicle_id" value="<?php echo $item->get_id(); ?>">
                                            <button type="submit" class="boton boton-secundario boton-pequeno">Cancelar reserva</button>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <span>—</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </main>
    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>
