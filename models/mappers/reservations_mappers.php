<?php
namespace app\models\mappers;

use app\models\entities\Reservation;

class ReservationsMappers
{
    public static function to_entity(array $row_db): Reservation
    {
        return new Reservation(
            (int) $row_db["id"],
            (int) $row_db["cliente_id"],
            (int) $row_db["vehiculo_id"],
            $row_db["fecha_inicio"],
            $row_db["fecha_fin"],
            $row_db["estado"],
            $row_db["cliente"] ?? "",
            $row_db["vehiculo"] ?? "",
        );
    }
}
?>