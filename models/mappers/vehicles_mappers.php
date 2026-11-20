<?php

namespace app\models\mappers;

use app\models\entities\Vehicle;

class VehiclesMappers
{
    public static function to_entity(array $row_db): Vehicle
    {
        return new Vehicle(
            (int) $row_db["id"],
            $row_db["marca"],
            $row_db["modelo"],
            (int) $row_db["anio"],
            (string) $row_db["categoria"],
            $row_db["estado"],
        );
    }
}
