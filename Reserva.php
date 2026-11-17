<?php
class Reserva
{
    private $conexDB;
    private $clienteId;
    private $vehiculoId;
    private $inicio;
    private $fin;

    public function __construct($conexDB, $clienteId, $vehiculoId, $inicio, $fin)
    {
        $this->conexDB = $conexDB;
        $this->clienteId = (int) $clienteId;
        $this->vehiculoId = (int) $vehiculoId;
        $this->inicio = $conexDB->real_escape_string($inicio);
        $this->fin = $conexDB->real_escape_string($fin);
    }

    // ¿El vehículo sigue disponible?
    private function vehiculoDisponible()
    {
        $consulta = $this->conexDB->query("SELECT estado FROM vehiculos WHERE id = {$this->vehiculoId}");
        $vehiculo = $consulta->fetch_assoc();
        return $vehiculo && $vehiculo['estado'] == 'disponible';
    }

    // Registra la reserva. Devuelve "" si todo salió bien, o el mensaje de error
    public function registrar()
    {
        if ($this->fin < $this->inicio) {
            return "La fecha de fin no puede ser anterior a la fecha de inicio.";
        }

        if (!$this->vehiculoDisponible()) {
            return "El vehículo no se encuentra disponible.";
        }

        // La reserva queda 'activa' por defecto en la base de datos
        $sql = "INSERT INTO reservas (cliente_id, vehiculo_id, fecha_inicio, fecha_fin)
                VALUES ({$this->clienteId}, {$this->vehiculoId}, '{$this->inicio}', '{$this->fin}')";

        if (!$this->conexDB->query($sql)) {
            return "Error al guardar: " . $this->conexDB->error;
        }

        // Al reservar, el vehículo pasa a alquilado
        $this->conexDB->query("UPDATE vehiculos SET estado = 'alquilado' WHERE id = {$this->vehiculoId}");
        return "";
    }
}