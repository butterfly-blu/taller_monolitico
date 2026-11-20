<?php

namespace app\controllers\Reservations;

use app\controllers\mappers\ReservationsControllerMappers;
use app\models\repositories\ReservationsRepositoryInterface;
use app\models\repositories\VehiclesRepositoryInterface;
use Exception;

class ReservationsController implements ReservationsControllerInterface
{
    private ReservationsRepositoryInterface $Reservations_model;
    private VehiclesRepositoryInterface $vehicles_model;

    public function __construct(
        ReservationsRepositoryInterface $Reservations_model,
        VehiclesRepositoryInterface $vehicles_model
    ) {
        $this->Reservations_model = $Reservations_model;
        $this->Vehicles_model = $vehicles_model;
    }

    // Crea la reserva y deja el vehícle como alquilado
    public function reservation_create(array $post_data): bool
    {
        $reservation = ReservationsControllerMappers::to_entity($post_data);

        if (empty($reservation->get_customer_id()) || empty($reservation->get_vehicle_id())) {
            throw new Exception("Debes elegir un cliente y un vehículo.", 1);
        }
        if ($reservation->get_end_date() < $reservation->get_start_date()) {
            throw new Exception("La fecha de fin no puede ser anterior a la fecha de inicio.", 2);
        }
        if ($reservation->get_start_date() < date("Y-m-d")) {
            throw new Exception("La fecha de inicio no puede ser anterior a hoy.", 3);
        }

        // Se comprueba otra vez que el vehícle siga disponible
        $vehicle = $this->Vehicles_model->find_vehicle_by_id($reservation->get_vehicle_id());
        if (empty($vehicle) || $vehicle->get_status() != "disponible") {
            throw new Exception("El vehícle no se encuentra disponible.", 4);
        }

        $saved = $this->Reservations_model->save_new_reservation($reservation);
        if (!$saved) {
            return false;
        }
        return $this->Vehicles_model->update_vehicle_status($vehicle->get_id(), "alquilado");
    }

    // Devolver: la reserva activa pasa a completada y el vehícle queda disponible
    public function return_vehicle(int $vehicle_id): bool
    {
        $reservation = $this->Reservations_model->find_active_by_vehicle($vehicle_id);
        if (!empty($reservation)) {
            $updated = $this->Reservations_model->update_reservation_status($reservation->get_id(), "completada");
            if (!$updated) {
                return false;
            }
        }
        return $this->Vehicles_model->update_vehicle_status($vehicle_id, "disponible");
    }

    // Cancelar: la reserva activa pasa a cancelada y el vehícle queda disponible
    public function cancel_reservation(int $vehicle_id): bool
    {
        $reservation = $this->Reservations_model->find_active_by_vehicle($vehicle_id);
        if (empty($reservation)) {
            throw new Exception("El vehícle no tiene una reserva activa.", 5);
        }
        $updated = $this->Reservations_model->update_reservation_status($reservation->get_id(), "cancelada");
        if (!$updated) {
            return false;
        }
        return $this->Vehicles_model->update_vehicle_status($vehicle_id, "disponible");
    }

    public function get_history_by_vehicle(int $vehicle_id): array
    {
        return $this->Reservations_model->get_history_by_vehicle($vehicle_id);
    }

    public function get_history_by_customer(int $customer_id): array
    {
        return $this->Reservations_model->get_history_by_customer($customer_id);
    }
}
