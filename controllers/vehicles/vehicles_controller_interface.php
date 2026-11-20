<?php
namespace app\controllers\vehicles;

use app\models\entities\Vehicle;

interface VehiclesControllerInterface
{
    public function get_vehicles(): array ;
    public function get_available_vehicles(); array;
    public function get_Vehicle(int $id): vehicle;
    public function vehicle_create(array $post_data): bool;

}
?>