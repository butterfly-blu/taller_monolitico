<?php

namespace app\controllers\mappers;

use app\models\entities\Reservation;

class ReservationsControllerMappers
{
    public static function to_entity(array $request): Reservation
    {
        return new Reservation(
            empty($request["id"]) ? 0 : (int) $request["id"],
            (int) ($request["cliente_id"] ?? 0),
            (int) ($request["vehiculo_id"] ?? 0),
            $request["fecha_inicio"] ?? "",
            $request["fecha_fin"] ?? "",
            "activa",
        );
    }
}
