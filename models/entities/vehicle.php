<?php

namespace app\models\entities;

class Vehicle
{
    private int $id;
    private string $brand;
    private string $model;
    private int $year;
    private string $category;
    private string $status;

    public function __construct(
        int $id,
        string $brand,
        string $model,
        int $year,
        string $category,
        string $status
    ) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->category = $category;
        $this->status = $status;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_brand(): string
    {
        return $this->brand;
    }
    public function get_model(): string
    {
        return $this->model;
    }
    public function get_year(): int
    {
        return $this->year;
    }
    public function get_category(): string
    {
        return $this->category;
    }
    public function get_status(): string
    {
        return $this->status;
    }
}
