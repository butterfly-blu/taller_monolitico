<?php
class Cliente {
    private $conexDB;
    public $nombre;
    public $telefono;
    public $correo;
    public $numero_licencia;
    public function __construct($conexDB)
    {
    $this->conexDB = $conexDB;
    }
public function registrar()
    {
        $stmt = $this->conexDB->prepare(
            "INSERT INTO clientes (nombre, telefono, correo, numero_licencia) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $this->nombre, $this->telefono, $this->correo, $this->numero_licencia);
        return $stmt->execute();
    }

    public function listarTodos()
    {
        $res = $this->conexDB->query("SELECT * FROM clientes ORDER BY nombre");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
