<?php
require_once __DIR__ . '/MySQL.php';

class consultas
{
    public $mysql;

    public function __construct()
    {
        $this->mysql = new MySQL();
    }

    public function crear_producto($nombre,$descripcion,$precio,$imagen,$stock)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into productos (nombre,descripcion,precio,imagen,stock) values 
            (
                '$nombre',
                '$descripcion',
                $precio,
                '$imagen',
                $stock
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
            $this->mysql->desconectar();
            return $resultado;
    }
    public function crear_cliente($documento,$nombres,$apellidos,$ciudad,$direccion,$barrio,$telefono,$correo,$contrasenaEncriptada)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into clientes (documento,
                nombres,
                apellidos,
                ciudad,
                direccion,
                barrio,
                telefono,
                correo,
                contrasena
            ) values
            (
                $documento,
                '$nombres',
                '$apellidos',
                '$ciudad',
                '$direccion',
                '$barrio',
                '$telefono',
                '$correo',
                '$contrasenaEncriptada'
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    public function crear_servicio($nombre,$descripcion)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into servicios (nombreServicio,descripcion) values 
            (
                '$nombre',
                '$descripcion'
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
            $this->mysql->desconectar();
            return $resultado;
    }

    public function traer_servicios()
    {
        $this->mysql->conectar();
        $consulta = "SELECT nombreServicio,idservicios from servicios;";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traerProducto()
    {
        $this->mysql->conectar();
        $consulta = "SELECT idproductos as id, nombre, descripcion, precio, imagen, stock FROM productos";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    public function traerCliente($documento)
    {
        $this->mysql->conectar();
        $consulta = "SELECT * from clientes where documento = $documento;";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    


}