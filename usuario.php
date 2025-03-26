<?php

class Usuario {
    private $id;
    private $nombre;
    private $email;
    private $saldo;

    public function __construct($id, $nombre, $email, $saldo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->saldo = $saldo;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public static function obtenerUsuarioActual() {
        if (!isset($_SESSION['usuario_id'])) {
            return null;
        }
        
        $id = $_SESSION['usuario_id'];
        $db = Config::getConexionDB();
        $query = $db->prepare("SELECT id, nombre, email, saldo FROM usuarios WHERE id = ?");
        $query->execute([$id]);
        $datos = $query->fetch(PDO::FETCH_ASSOC);

        return $datos ? new Usuario($datos['id'], $datos['nombre'], $datos['email'], $datos['saldo']) : null;
    }
}

?>
