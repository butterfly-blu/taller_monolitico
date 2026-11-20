<?php

namespace app\controllers\customers;

interface CustomersControllerInterface
{
    public  function get_customers(): array;
    public function customers_create(array $post_data);
}
