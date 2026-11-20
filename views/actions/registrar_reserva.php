<?php
require "../../models/entities/vehicle.php";
require "../../models/entities/reservation.php";
require "../../models/mappers/vehicles_mappers.php";
require "../../models/mappers/reservations_mappers.php";
require "../../models/database/rental_db_interface.php";
require "../../models/database/rental_db.php";
require "../../models/repositories/vehicles_repository_interface.php";
require "../../models/repositories/vehicles_repository.php";
require "../../models/repositories/reservations_repository_interface.php";
require "../../models/repositories/reservations_repository.php";
require "../../models/config/models_config.php";

require "../../controllers/mappers/reservations_mappers.php";
require "../../controllers/reservations/reservations_controller_interface.php";
require "../../controllers/reservations/reservations_controller.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "../";
$public = "../../public/";
$title = "Nueva reserva";
$back_link = "../reserva.php";
$back_text = "Hacer otra reserva";
$success = false;
$message = "";

try {
    $controller = ControllersConfig::get_reservations_controller();
    $success = $controller->reservation_create($_POST);
    $message = $success ? "La reserva se guardó y el vehículo quedó alquilado." : "Error al guardar la reserva.";
} catch (Exception $e) {
    $message = $e->getMessage();
}

include __DIR__ . "/../partials/resultado.php";
