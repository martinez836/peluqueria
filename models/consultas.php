<?php
require_once __DIR__ . '/MySQL.php';

class consultas
{
    public $mysql;

    public function __construct()
    {
        $this->mysql = new MySQL();
    }

    public function crear_producto($nombre,$descripcion,$precio,$imagen)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into productos (nombre,descripcion,precio,imagen) values 
            (
                '$nombre',
                '$descripcion',
                $precio,
                '$imagen'
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
            $this->mysql->desconectar();
            return $resultado;
    }
    public function traerProducto()
    {
        $this->mysql->conectar();
        $consulta = "SELECT nombre, descripcion, precio, imagen FROM productos";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
            return $resultado;
    }
}