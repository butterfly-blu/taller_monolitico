<?php

namespace app\models\database;

use mysqli;
use mysqli_sql_exception;

class RentalDB implements RentalDBInterface
{
    private string $host_db = "localhost";
    private string $user_db = "root";
    private string $pwd_db = "";
    private string $name_db = "alquiler_vehiculos_db";
    private int $port_db = 3306;

    private $conex = null;

    public function __construct()
    {
        try {
            $this->conex = new mysqli(
                $this->host_db,
                $this->user_db,
                $this->pwd_db,
                $this->name_db,
                $this->port_db
            );
        } catch (mysqli_sql_exception $e) {
            print("No se pudo conectar a la base de datos: " . $e->getMessage());
            die();
        }
        $this->conex->set_charset("utf8mb4");
    }

    // Ejecuta un SELECT y devuelve las filas
    public function exc_select($sql): array
    {
        $result = $this->conex->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            array_push($rows, $row);
        }
        return $rows;
    }

    // Ejecuta un INSERT o UPDATE. Devuelve false si la consulta falla
    public function exc_query($sql): bool
    {
        try {
            return (bool) $this->conex->query($sql);
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
}

?>