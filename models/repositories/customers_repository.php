<?php

namespace app\models\repositories;

use app\models\database\RentalDBInterface;
use app\models\entities\Customer;
use app\models\mappers\CustomersMappers;

class CustomersRepository implements CustomersRepositoryInterface
{
    private RentalDBInterface $rental_db;

    public function __construct(RentalDBInterface $rental_db)
    {
        $this->rental_db = $rental_db;
    }

    public function get_customers_all(): array
    {
        $sql = "select * from clientes order by nombre";
        $rows_db = $this->rental_db->exc_select($sql);
        $customers = [];
        foreach ($rows_db as $item) {
            array_push($customers, CustomersMappers::to_entity($item));
        }
        return $customers;
    }

    public function save_new_customer(Customer $customer): bool
    {
        $sql = "insert into clientes(nombre,telefono,correo,numero_licencia)values";
        $sql .= "('" . $customer->get_name() . "','" . $customer->get_phone() . "',";
        $sql .= "'" . $customer->get_email() . "','" . $customer->get_license_number() . "')";
        return $this->rental_db->exc_query($sql);
    }
}
?>