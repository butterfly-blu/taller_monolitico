<?php

namespace app\models\config;

use app\models\database\RentalDBInterface;
use app\models\database\RentalDB;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\repositories\VehiclesRepository;
use app\models\repositories\CustomersRepositoryInterface;
use app\models\repositories\CustomersRepository;
use app\models\repositories\ReservationsRepositoryInterface;
use app\models\repositories\ReservationsRepository;

class ModelsConfig
{
    private static ?RentalDBInterface $rental_db = null;

    // Una sola conexión compartida por todos los repositorios
    public static function get_rental_db(): RentalDBInterface
    {
        if (self::$rental_db === null) {
            self::$rental_db = new RentalDB();
        }
        return self::$rental_db;
    }

    public static function get_vehicles_repository(): VehiclesRepositoryInterface
    {
        return new VehiclesRepository(ModelsConfig::get_rental_db());
    }

    public static function get_customers_repository(): CustomersRepositoryInterface
    {
        return new CustomersRepository(ModelsConfig::get_rental_db());
    }

    public static function get_reservations_repository(): ReservationsRepositoryInterface
    {
        return new ReservationsRepository(ModelsConfig::get_rental_db());
    }
}
