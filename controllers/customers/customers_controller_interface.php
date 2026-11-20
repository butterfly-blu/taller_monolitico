<?php

namespace app\controllers\customers;

interface CustomersControllerInterface
{
    public  function get_customers(): array;
    public function customer_create(array $post_data): bool;
}
