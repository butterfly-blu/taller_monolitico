<?php
require "../models/entities/vehicle.php";
require "../models/entities/customer.php";
require "../models/entities/reservation.php";
require "../models/mappers/vehicles_mappers.php";
require "../models/mappers/customers_mappers.php";
require "../models/mappers/reservations_mappers.php";
require "../models/database/rental_db_interface.php";
require "../models/database/rental_db.php";
require "../models/repositories/vehicles_repository_interface.php";
require "../models/repositories/vehicles_repository.php";
require "../models/repositories/customers_repository_interface.php";
require "../models/repositories/customers_repository.php";
require "../models/repositories/reservations_repository_interface.php";
require "../models/repositories/reservations_repository.php";
require "../models/config/models_config.php";

require "../controllers/mappers/vehicles_mappers.php";
require "../controllers/mappers/customers_mappers.php";
require "../controllers/mappers/reservations_mappers.php";
require "../controllers/vehicles/vehicles_controller_interface.php";
require "../controllers/vehicles/vehicles_controller.php";
require "../controllers/customers/customers_controller_interface.php";
require "../controllers/customers/customers_controller.php";
require "../controllers/reservations/reservations_controller_interface.php";
require "../controllers/reservations/reservations_controller.php";
require "../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "";
$public = "../public/";

$vehicles_controller = ControllersConfig::get_vehicles_controller();
$customers_controller = ControllersConfig::get_customers_controller();
$reservations_controller = ControllersConfig::get_reservations_controller();

// Listas para los select
$vehicles = $vehicles_controller->get_vehicles();
$customers = $customers_controller->get_customers();

// Las consultas se envían por GET (solo leen datos, no los modifican)
$action = $_GET["accion"] ?? "";
$title = "";
$message = "";
$history = [];
$vehicle = null;
$available = [];

try {
    if ($action == "historial_vehiculo") {
        $title = "Historial del vehículo";
        $history = $reservations_controller->get_history_by_vehicle((int) ($_GET["vehicle_id"] ?? 0));
    } elseif ($action == "disponibilidad") {
        $title = "Disponibilidad del vehículo";
        $vehicle = $vehicles_controller->get_vehicle((int) ($_GET["vehicle_id"] ?? 0));
    } elseif ($action == "historial_cliente") {
        $title = "Historial del cliente";
        $history = $reservations_controller->get_history_by_customer((int) ($_GET["customer_id"] ?? 0));
    } elseif ($action == "disponibles") {
        $title = "Vehículos disponibles";
        $available = $vehicles_controller->get_available_vehicles();
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>
    <main class="contenedor contenedor-ancho">
        <h1>Consultas</h1>

        <section class="seccion-consulta">
            <h3>Vehículo</h3>
            <?php if (count($vehicles) == 0) { ?>
                <p class="mensaje-aviso">No hay vehículos registrados.</p>
            <?php } else { ?>
                <form method="get" class="fila-consulta">
                    <select name="vehicle_id" required>
                        <?php foreach ($vehicles as $item) { ?>
                            <option value="<?php echo $item->get_id(); ?>">
                                <?php echo htmlspecialchars($item->get_brand() . " " . $item->get_model()); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="accion" value="historial_vehiculo" class="boton">Ver historial</button>
                    <button type="submit" name="accion" value="disponibilidad" class="boton boton-secundario">Ver disponibilidad</button>
                </form>
            <?php } ?>
        </section>

        <section class="seccion-consulta">
            <h3>Cliente</h3>
            <?php if (count($customers) == 0) { ?>
                <p class="mensaje-aviso">No hay clientes registrados.</p>
            <?php } else { ?>
                <form method="get" class="fila-consulta">
                    <select name="customer_id" required>
                        <?php foreach ($customers as $item) { ?>
                            <option value="<?php echo $item->get_id(); ?>"><?php echo htmlspecialchars($item->get_name()); ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="accion" value="historial_cliente" class="boton">Ver historial</button>
                </form>
            <?php } ?>
        </section>

        <section class="seccion-consulta">
            <h3>Vehículos disponibles</h3>
            <form method="get" class="fila-consulta">
                <button type="submit" name="accion" value="disponibles" class="boton">Ver todos los disponibles</button>
            </form>
        </section>

        <?php if ($message != "") { ?>
            <p class="mensaje-error"><?php echo htmlspecialchars($message); ?></p>
        <?php } elseif ($title != "") { ?>
            <h2><?php echo $title; ?></h2>

            <?php if ($action == "historial_vehiculo" || $action == "historial_cliente") { ?>
                <?php if (count($history) == 0) { ?>
                    <p class="mensaje-aviso">No se encontraron reservas.</p>
                <?php } else { ?>
                    <div class="tabla-contenedor">
                        <table class="tabla">
                            <tr>
                                <th>Reserva</th>
                                <th><?php echo $action == "historial_vehiculo" ? "Cliente" : "Vehículo"; ?></th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Estado</th>
                            </tr>
                            <?php foreach ($history as $item) { ?>
                                <tr>
                                    <td>#<?php echo $item->get_id(); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($action == "historial_vehiculo" ? $item->get_customer_name() : $item->get_vehicle_name()); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item->get_start_date()); ?></td>
                                    <td><?php echo htmlspecialchars($item->get_end_date()); ?></td>
                                    <td><span class="badge badge-<?php echo htmlspecialchars($item->get_status()); ?>"><?php echo htmlspecialchars($item->get_status()); ?></span></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>

            <?php } elseif ($action == "disponibilidad" && $vehicle != null) { ?>
                <div class="tabla-contenedor">
                    <table class="tabla">
                        <tr>
                            <th>Vehículo</th>
                            <th>Estado</th>
                            <th>¿Se puede reservar?</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($vehicle->get_brand() . " " . $vehicle->get_model()); ?></td>
                            <td><span class="badge badge-<?php echo htmlspecialchars($vehicle->get_status()); ?>"><?php echo htmlspecialchars($vehicle->get_status()); ?></span></td>
                            <td><?php echo $vehicle->get_status() == "disponible" ? "Sí" : "No"; ?></td>
                        </tr>
                    </table>
                </div>

            <?php } elseif ($action == "disponibles") { ?>
                <?php if (count($available) == 0) { ?>
                    <p class="mensaje-aviso">No hay vehículos disponibles.</p>
                <?php } else { ?>
                    <div class="tabla-contenedor">
                        <table class="tabla">
                            <tr>
                                <th>N.</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Año</th>
                                <th>Categoría</th>
                            </tr>
                            <?php foreach ($available as $item) { ?>
                                <tr>
                                    <td><?php echo $item->get_id(); ?></td>
                                    <td><?php echo htmlspecialchars($item->get_brand()); ?></td>
                                    <td><?php echo htmlspecialchars($item->get_model()); ?></td>
                                    <td><?php echo $item->get_year(); ?></td>
                                    <td><?php echo htmlspecialchars($item->get_category()); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </main>
    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>
