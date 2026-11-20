<?php

namespace app\models\repositories;

use app\models\entities\Vehicle;

interface VehiclesRepositoryInterface
{
    public function get_vehicles_all(): array;
    public function get_vehicles_available(): array;
    public function find_vehicle_by_id(int $id): Vehicle|null;
    public function save_new_vehicle(Vehicle $vehicle): bool;
    public function update_vehicle_status(int $id, string $status): bool;
}
?>
