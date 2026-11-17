<?php
class Conexion
{
    private $hostDB = "localhost";
    private $userDB = "root";
    private $pwdDB = "";
    private $nameDB = "alquiler_vehiculos_db";

    public function conectar()
    {
       $conexDB = new mysqli($this->hostDB, $this->userDB, $this->pwdDB, $this->nameDB);
        if ($conexDB->connect_error) {
            die("Error de conexión: " . $conexDB->connect_error);
        }
        $conexDB->set_charset("utf8mb4");
        return $conexDB;
    }
}