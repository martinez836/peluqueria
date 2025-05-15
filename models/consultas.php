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
    /* public function verificarDocumentoExistente($documento) {
        $this->mysql->conectar();
        $consulta = "SELECT COUNT(*) as cantidad FROM clientes WHERE documento = $documento;";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        return $row['cantidad'] > 0;
        
    } */
    public function crear_cliente($documento,$nombres,$apellidos,$ciudad,$direccion,$barrio,$telefono,$correo,$contrasenaEncriptada, $rol,$fechaNacimiento)
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
                contrasena,
                rol,
                fechaNacimiento
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
                '$contrasenaEncriptada',
                '$rol',
                '$fechaNacimiento'
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
            Insert into servicios (nombre,descripcion) values 
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
        $consulta = "SELECT nombreServicio, idservicios from servicios;";
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
    
    public function agregarDetallePedido($idPedido, $idProducto, $cantidad, $subTotal)
    {
        $this->mysql->conectar();
        $consulta = "insert into detallePedido (cantidad,subtotal,pedidos_idpedidos,productos_idproductos) values (
            $cantidad,
            $subTotal,
            $idPedido,
            $idProducto
        )";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    public function  agregarPedido($total,$documento)
    {
        $this->mysql->conectar();
        $consulta = "insert into pedidos (fecha,total,estado,clientes_documento) values (
            now(),
            $total,
            1,
            $documento
        )";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        return $resultado;
    }

    public function registrar_cita($fecha,$cedula, $servicio)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into citas (fecha,clientes_documento,servicios_idservicios,estado) values 
            (
                '$fecha',
                $cedula,
                '$servicio',
                'pendiente'
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    
}