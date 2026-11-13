<?php

function conexion() {
$hostDB = "localhost";
$userDB = "root";
$pwdDB = "";            
$nameDB = "alquiler_vehiculos_db"; 
$conexDB = new mysqli($hostDB, $userDB, $pwdDB, $nameDB);
if ($conexDB->connect_error) {
        print($conexDB->connect_error);
        die();
    }
    return $conexDB;
}

?>