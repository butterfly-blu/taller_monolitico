<?php

namespace app\models\repositories;

use app\models\entities\Reservation;

interface ReservationsRepositoryInterface
{
    public function save_new_reservation(Reservation $reservation): bool;
    public function get_history_by_vehicle(int $vehicle_id): array;
    public function get_history_by_customer(int $customer_id): array;
    public function find_active_by_vehicle(int $vehicle_id): Reservation|null;
    public function update_reservation_status(int $id, string $status): bool;
}
