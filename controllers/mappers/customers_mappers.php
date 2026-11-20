<?php
namespace app\controllers\mappers;

use app\models\entities\Customer;

class CustomersControllerMappers
{
    public static function to_entity(array $request) : Customer 
    {
        return new Customer(
            empty($request["id"]) ? 0 : (int) $request["id"],
            trim($request["nombre"] ?? ""),
            trim($request["telefono"] ?? ""),
            trim($request["correo"] ?? ""),
            trim($request["numero_licencia"] ?? ""),
        );
    }
}
?>
