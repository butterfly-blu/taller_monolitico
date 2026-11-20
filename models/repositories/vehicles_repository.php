<?php

namespace app\models\repositories;

use app\models\database\RentalDBInterface;
use app\models\entities\Vehicle;
use app\models\mappers\VehiclesMappers;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    private RentalDBInterface $rental_db;

    public function __construct(RentalDBInterface $rental_db)
    {
        $this->rental_db = $rental_db;
    }

    public function get_vehicles_all(): array
    {
        $sql = "select * from vehiculos order by id";
        return $this->to_entities($this->rental_db->exc_select($sql));
    }

    public function get_vehicles_available(): array
    {
        $sql = "select * from vehiculos where estado='disponible' order by marca";
        return $this->to_entities($this->rental_db->exc_select($sql));
    }

    public function find_vehicle_by_id(int $id): Vehicle|null
    {
        $sql = "select * from vehiculos where id=$id";
        $rows_db = $this->rental_db->exc_select($sql);
        foreach ($rows_db as $item) {
            return VehiclesMappers::to_entity($item);
        }
        return null;
    }

    public function save_new_vehicle(Vehicle $vehicle): bool
    {
        $sql = "insert into vehiculos(marca,modelo,anio,categoria,estado)values";
        $sql .= "('" . $vehicle->get_brand() . "','" . $vehicle->get_model() . "',";
        $sql .= $vehicle->get_year() . ",";
        $sql .= "'" . $vehicle->get_category() . "','" . $vehicle->get_status() . "')";
        return $this->rental_db->exc_query($sql);
    }

    public function update_vehicle_status(int $id, string $status): bool
    {
        $sql = "update vehiculos set ";
        $sql .= " estado='" . $status . "' ";
        $sql .= " where id=" . $id;
        return $this->rental_db->exc_query($sql);
    }

    // Convierte las filas de la BD en una lista de entidades
    private function to_entities(array $rows_db): array
    {
        $vehicles = [];
        foreach ($rows_db as $item) {
            array_push($vehicles, VehiclesMappers::to_entity($item));
        }
        return $vehicles;
    }
}
