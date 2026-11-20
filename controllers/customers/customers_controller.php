<?php
namespace app\controllers\customers;

use app\controllers\mappers\CustomersControllerMappers;
use app\models\repositories\CustomersRepositoryInterface;
use Exception;

class CustomersController implements CustomersControllerInterface
{
    private CustomersRepositoryInterface $customers_model;

    public function __construct(CustomersRepositoryInterface $customers_model)
    {
        $this->customers_model = $customers_model;
    }

    public function get_customers(): array
    {
        return $this->customers_model->get_customers_all();
    }

    public function customer_create(array $post_data): bool
    {
        $customer = CustomersControllerMappers::to_entity($post_data);

        if ($customer->get_name() == "") {
            throw new Exception("El nombre es obligatorio.", 1);
        }
        if ($customer->get_email() != "" && !filter_var($customer->get_email(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no es válido.", 2);
        }

        return $this->customers_model->save_new_customer($customer);
    }
}
?>
