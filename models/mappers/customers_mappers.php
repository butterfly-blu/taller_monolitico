<?php

namespace app\models\mappers;

use app\models\entities\Customer;

class   CustomersMappers
{
    public static function to_entity(array $row_db): Customer
    {
        return new Customer(
            (int)$row_db["id"],
            $row_db["nombre"],
            (string) $row_db["telefono"],
            (string) $row_db["correo"],
            (string) $row_db["numero_licencia"],
        );
    }
}
