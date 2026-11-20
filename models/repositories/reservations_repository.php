<?php

namespace app\models\repositories;

use app\models\database\RentalDBInterface;
use app\models\entities\Reservation;
use app\models\mappers\ReservationsMappers;

class ReservationsRepository implements ReservationsRepositoryInterface
{
    private RentalDBInterface $rental_db;

    public function __construct(RentalDBInterface $rental_db)
    {
        $this->rental_db = $rental_db;
    }

    // La reserva queda 'activa' porque es el valor por defecto de la tabla
    public function save_new_reservation(Reservation $reservation): bool
    {
        $sql = "insert into reservas(cliente_id,vehiculo_id,fecha_inicio,fecha_fin)values";
        $sql .= "(" . $reservation->get_customer_id() . "," . $reservation->get_vehicle_id() . ",";
        $sql .= "'" . $reservation->get_start_date() . "','" . $reservation->get_end_date() . "')";
        return $this->rental_db->exc_query($sql);
    }

    // Historial de un vehículo: cada reserva con el nombre del cliente
    public function get_history_by_vehicle(int $vehicle_id): array
    {
        $sql = "select r.*, c.nombre as cliente ";
        $sql .= "from reservas r inner join clientes c on c.id = r.cliente_id ";
        $sql .= "where r.vehiculo_id=$vehicle_id order by r.fecha_inicio desc";
        return $this->to_entities($this->rental_db->exc_select($sql));
    }

    // Historial de un cliente: cada reserva con el nombre del vehículo
    public function get_history_by_customer(int $customer_id): array
    {
        $sql = "select r.*, concat(v.marca, ' ', v.modelo) as vehiculo ";
        $sql .= "from reservas r inner join vehiculos v on v.id = r.vehiculo_id ";
        $sql .= "where r.cliente_id=$customer_id order by r.fecha_inicio desc";
        return $this->to_entities($this->rental_db->exc_select($sql));
    }

    public function find_active_by_vehicle(int $vehicle_id): Reservation|null
    {
        $sql = "select * from reservas where vehiculo_id=$vehicle_id ";
        $sql .= "and estado='activa' order by id desc limit 1";
        $rows_db = $this->rental_db->exc_select($sql);
        foreach ($rows_db as $item) {
            return ReservationsMappers::to_entity($item);
        }
        return null;
    }

    public function update_reservation_status(int $id, string $status): bool
    {
        $sql = "update reservas set ";
        $sql .= " estado='" . $status . "' ";
        $sql .= " where id=" . $id;
        return $this->rental_db->exc_query($sql);
    }

    private function to_entities(array $rows_db): array
    {
        $reservations = [];
        foreach ($rows_db as $item) {
            array_push($reservations, ReservationsMappers::to_entity($item));
        }
        return $reservations;
    }
}
