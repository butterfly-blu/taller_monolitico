<?php
require "../models/entities/vehicle.php";
require "../models/entities/customer.php";
require "../models/mappers/vehicles_mappers.php";
require "../models/mappers/customers_mappers.php";
require "../models/database/rental_db_interface.php";
require "../models/database/rental_db.php";
require "../models/repositories/vehicles_repository_interface.php";
require "../models/repositories/vehicles_repository.php";
require "../models/repositories/customers_repository_interface.php";
require "../models/repositories/customers_repository.php";
require "../models/config/models_config.php";

require "../controllers/mappers/vehicles_mappers.php";
require "../controllers/mappers/customers_mappers.php";
require "../controllers/vehicles/vehicles_controller_interface.php";
require "../controllers/vehicles/vehicles_controller.php";
require "../controllers/customers/customers_controller_interface.php";
require "../controllers/customers/customers_controller.php";
require "../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "";
$public = "../public/";

$customers = ControllersConfig::get_customers_controller()->get_customers();
$vehicles = ControllersConfig::get_vehicles_controller()->get_available_vehicles();

// Si se llega desde el botón Reservar del catálogo, ese vehículo queda seleccionado
$selected_vehicle = empty($_GET["vehicle_id"]) ? 0 : (int) $_GET["vehicle_id"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva reserva</title>
    <link rel="stylesheet" href="<?php echo $public; ?>css/estilos.css">
</head>

<body>
    <?php include __DIR__ . "/partials/menu.php"; ?>
    <main class="contenedor">
        <h1>Nueva reserva</h1>

        <?php if (count($customers) == 0 || count($vehicles) == 0) { ?>
            <p class="mensaje-aviso">Para reservar necesitas al menos un cliente y un vehículo disponible.</p>
        <?php } else { ?>
            <form action="actions/registrar_reserva.php" method="post" class="formulario">
                <div class="campo">
                    <label for="cliente_id">Cliente</label>
                    <select name="cliente_id" id="cliente_id" required>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?php echo $customer->get_id(); ?>">
                                <?php echo htmlspecialchars($customer->get_name()); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="vehiculo_id">Vehículo</label>
                    <select name="vehiculo_id" id="vehiculo_id" required>
                        <?php foreach ($vehicles as $vehicle) { ?>
                            <option value="<?php echo $vehicle->get_id(); ?>" <?php if ($vehicle->get_id() == $selected_vehicle) { echo "selected"; } ?>>
                                <?php echo htmlspecialchars($vehicle->get_brand() . " " . $vehicle->get_model()); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="fechas">
                    <div class="campo">
                        <label for="fecha_inicio">Desde</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="campo">
                        <label for="fecha_fin">Hasta</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <button type="submit" class="boton">Reservar</button>
            </form>
        <?php } ?>

        <a class="enlace-volver" href="vehiculos.php">Volver</a>
    </main>
    <?php include __DIR__ . "/partials/footer.php"; ?>
</body>

</html>
