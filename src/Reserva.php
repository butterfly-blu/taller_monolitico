<?php 
require_once __DIR__ . '/Vehiculo.php';

class Reserva{
    private $conexDB;
    public $cliente_id;
    public $vehiculo_id;
    public $fecha_inicio;
    public $fecha_fin;
    public function __construct($conexDB)
    {
        $this->conexDB = $conexDB;
    }
    public function registrar()
    {
        if ($this->fecha_fin < $this->fecha_inicio) {
            return "La fecha de fin no puede ser menor a la fecha de inicio.";
        }

        // 1. Guardar la reserva
        $stmt = $this->conexDB->prepare(
            "INSERT INTO reservas (cliente_id, vehiculo_id, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, 'activa')"
        );
        $stmt->bind_param("iiss", $this->cliente_id, $this->vehiculo_id, $this->fecha_inicio, $this->fecha_fin);
        
        if (!$stmt->execute()) {
            return "Error al registrar la reserva.";
        }

        // 2. Cambiar el estado del vehículo a 'alquilado'
        $vehiculo = new Vehiculo($this->conexDB);
        $vehiculo->cambiarEstado($this->vehiculo_id, 'alquilado');

        return ""; // Todo salió bien
    }
    // Devolver vehículo: libera el auto y finaliza su reserva activa
    public function devolverVehiculo($vehiculoId)
    {
        $stmt = $this->conexDB->prepare("UPDATE reservas SET estado = 'completada' WHERE vehiculo_id = ? AND estado = 'activa'");
        $stmt->bind_param("i", $vehiculoId);
        $stmt->execute();

        $vehiculo = new Vehiculo($this->conexDB);
        $vehiculo->cambiarEstado($vehiculoId, 'disponible');
    }

    public function historialPorVehiculo($vehiculoId)
    {
        $stmt = $this->conexDB->prepare(
            "SELECT r.id AS reserva, c.nombre AS cliente, r.fecha_inicio, r.fecha_fin, r.estado
             FROM reservas r
             INNER JOIN clientes c ON c.id = r.cliente_id
             WHERE r.vehiculo_id = ? ORDER BY r.fecha_inicio DESC"
        );
        $stmt->bind_param("i", $vehiculoId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function historialPorCliente($clienteId)
    {
        $stmt = $this->conexDB->prepare(
            "SELECT r.id AS reserva, v.marca, v.modelo, r.fecha_inicio, r.fecha_fin, r.estado
             FROM reservas r
             INNER JOIN vehiculos v ON v.id = r.vehiculo_id
             WHERE r.cliente_id = ? ORDER BY r.fecha_inicio DESC"
        );
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>