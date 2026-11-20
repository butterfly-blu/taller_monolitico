<?php

namespace app\models\entities;

class Reservation
{
    private int $id;
    private int $customer_id;
    private int $vehicle_id;
    private string $start_date;
    private string $end_date;
    private string $status;
    // Solo se llenan en los historiales (vienen de un JOIN)
    private string $customer_name;
    private string $vehicle_name;

    public function __construct(
        int $id,
        int $customer_id,
        int $vehicle_id,
        string $start_date,
        string $end_date,
        string $status,
        string $customer_name = "",
        string $vehicle_name = ""
    ) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->vehicle_id = $vehicle_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->customer_name = $customer_name;
        $this->vehicle_name = $vehicle_name;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_customer_id(): int
    {
        return $this->customer_id;
    }
    public function get_vehicle_id(): int
    {
        return $this->vehicle_id;
    }
    public function get_start_date(): string
    {
        return $this->start_date;
    }
    public function get_end_date(): string
    {
        return $this->end_date;
    }
    public function get_status(): string
    {
        return $this->status;
    }
    public function get_customer_name(): string
    {
        return $this->customer_name;
    }
    public function get_vehicle_name(): string
    {
        return $this->vehicle_name;
    }
}
