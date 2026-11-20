<?php

namespace app\models\entities;

class Customer
{
    private int $id;
    private string $name;
    private string $phone;
    private string $email;
    private string $license_number;

    public function __construct(
        int $id,
        string $name,
        string $phone,
        string $email,
        string $license_number
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->license_number = $license_number;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_name(): string
    {
        return $this->name;
    }
    public function get_phone(): string
    {
        return $this->phone;
    }
    public function get_email(): string
    {
        return $this->email;
    }
    public function get_license_number(): string
    {
        return $this->license_number;
    }
}
