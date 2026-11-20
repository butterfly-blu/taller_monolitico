<?php

namespace app\models\repositories;

use app\models\entities\Customer;

interface CustomersRepositoryInterface
{
    public function get_customers_all(): array;
    public function save_new_customer(Customer $customer): bool;
}
?>