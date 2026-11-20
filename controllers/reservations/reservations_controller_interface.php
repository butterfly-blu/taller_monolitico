<?php 
namespace app\controllers\reservations;

interface reservationsControllerInterface
{
    public function reservation_create(array $post_data): bool;
    public function return_vehicle(int $vehicle_id): bool;
    public function cancel_reservation(int $vehicle_id): bool;
    public function get_history_by_vehicle(int $vehicle_id): array;
    public function get_history_by_customer(int $customer_id): array;
}

?>