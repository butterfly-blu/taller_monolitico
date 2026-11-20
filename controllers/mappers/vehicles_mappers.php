<?php
namespace app\controllers\mappers;

use app\models\entities\Vehicle;

class VehiclesControlleMappers
{
    public static function to_entity(array $request) : Vehicle 
     {
        return new Vehicle(
            empty($request["id"]) ? 0 : (int) $request["id"],
            trim($request["marca"] ?? ""),
            trim($request["modelo"] ?? ""),
            (int) ($request["anio"] ?? 0),
            trim($request["categoria"] ?? ""),
            $request["estado"] ?? "disponible",
        );
    }
}
?>
