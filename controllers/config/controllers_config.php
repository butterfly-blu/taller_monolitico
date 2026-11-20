<?php 
namespace app\controllers\config;
use app\controllers\vehiculos\VehiculosController;
use app\controllers\vehicles\VehiclesControllerInterface;
use app\controllers\customers\CustomersController;
use app\controllers\customers\CustomersControllerInterface;
use app\controllers\reservations\ReservationsController;
use app\controllers\reservations\ReservationsControllerInterface;
use app\models\config\ModelsConfig;

class ControllersConfig
{
    public static function get_vehicles_controller(): VehiclesControllerInterface
    {
        return new VehiclesController(ModelsConfig::get_vehicles_repository());
    }

    public static function get_customers_controller(): CustomersControllerInterface
    {
        return new CustomersController(ModelsConfig::get_customers_repository());
    }

    public static function get_reservations_controller(): ReservationsControllerInterface
    {
        return new ReservationsController(
            ModelsConfig::get_reservations_repository(),
            ModelsConfig::get_vehicles_repository()
        );
    }
}


?>
