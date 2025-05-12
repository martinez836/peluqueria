<?php

class Conexion {
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = '';
    private $bd = 'peluqueria';

    public function conectar() {
        $mysqli = new mysqli($this->host, $this->usuario, $this->password, $this->bd);
        
        if ($mysqli->connect_error) {
            die("Conexión fallida: " . $mysqli->connect_error);
        }
        return $mysqli;
    }
}
?>