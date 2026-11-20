<?php

namespace app\controllers\vehicles;

use app\models\entities\Vehicle;

interface VehiclesControllerInterface
{
    public function get_vehicles(): array;
    public function get_available_vehicles(): array;
    public function get_vehicle(int $id): Vehicle;
    public function vehicle_create(array $post_data): bool;
}
