<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conexDB = new mysqli('localhost', 'root', '', 'alquiler_vehiculos_db');
echo "Conexión correcta";

?>