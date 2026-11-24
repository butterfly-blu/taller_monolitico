<?php
require "../../models/entities/vehicle.php";
require "../../models/mappers/vehicles_mappers.php";
require "../../models/database/rental_db_interface.php";
require "../../models/database/rental_db.php";
require "../../models/repositories/vehicles_repository_interface.php";
require "../../models/repositories/vehicles_repository.php";
require "../../models/config/models_config.php";

require "../../controllers/mappers/vehicles_mappers.php";
require "../../controllers/vehicles/vehicles_controller_interface.php";
require "../../controllers/vehicles/vehicles_controller.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "../";
$public = "../../public/";
$title = "Registrar vehículo";
$back_link = "../registrar_vh.php";
$back_text = "Registrar otro vehículo";
$success = false;
$message = "";

try {
    $controller = ControllersConfig::get_vehicles_controller();
    $success = $controller->vehicle_create($_POST);
    $message = $success ? "El vehículo se guardó correctamente." : "Error al guardar el vehículo.";
} catch (Exception $e) {
    $message = $e->getMessage();
}

include __DIR__ . "/../partials/resultado.php";
