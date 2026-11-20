<?php
require "../../models/entities/customer.php";
require "../../models/mappers/customers_mappers.php";
require "../../models/database/rental_db_interface.php";
require "../../models/database/rental_db.php";
require "../../models/repositories/customers_repository_interface.php";
require "../../models/repositories/customers_repository.php";
require "../../models/config/models_config.php";

require "../../controllers/mappers/customers_mappers.php";
require "../../controllers/customers/customers_controller_interface.php";
require "../../controllers/customers/customers_controller.php";
require "../../controllers/config/controllers_config.php";

use app\controllers\config\ControllersConfig;

$base = "../";
$public = "../../public/";
$title = "Registrar cliente";
$back_link = "../registrar_cl.php";
$back_text = "Registrar otro cliente";
$success = false;
$message = "";

try {
    $controller = ControllersConfig::get_customers_controller();
    $success = $controller->customer_create($_POST);
    $message = $success ? "El cliente se guardó correctamente." : "Error al guardar el cliente.";
} catch (Exception $e) {
    $message = $e->getMessage();
}

include __DIR__ . "/../partials/resultado.php";
