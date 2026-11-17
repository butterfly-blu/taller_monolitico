<?php 
class Vehiculo{
    private $conexDB;
    public $marca;
    public $modelo;
    public $anio;
    public $categoria;
    public $estado;

    public function __construct($conexDB)
    {
        $this->conexDB = $conexDB;
    }
public function registrar(){
    $stmt = $this->conexDB->prepare(
            "INSERT INTO vehiculos (marca, modelo, anio, categoria, estado) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssiss", $this->marca, $this->modelo, $this->anio, $this->categoria, $this->estado);
        return $stmt->execute();
}
public function listarTodos()
    {
        $res = $this->conexDB->query("SELECT * FROM vehiculos ORDER BY id DESC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function listarDisponibles()
    {
        $res = $this->conexDB->query("SELECT * FROM vehiculos WHERE estado = 'disponible' ORDER BY marca");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function cambiarEstado($id, $nuevoEstado)
    {
        $stmt = $this->conexDB->prepare("UPDATE vehiculos SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevoEstado, $id);
        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->conexDB->prepare("SELECT * FROM vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>
