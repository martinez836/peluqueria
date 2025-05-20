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
            'pendiente',
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
    public function traerCitaPendiente()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as citasPendientes from citas where estado = 'pendiente';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['citasPendientes'];
    }
    public function traerCitaConfirmada()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as citasConfirmada from citas where estado = 'confirmada';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['citasConfirmada'];
    }
    public function traerCitaCancelada()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as citaCancelada from citas where estado = 'cancelada';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['citaCancelada'];
    }
    public function traerPedidoPendiente()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as pedidoPendiente from pedidos where estado = 'pendiente';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['pedidoPendiente'];
    }
    public function traerPedidoEntregado()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as pedidoEntregado from pedidos where estado = 'entregado';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['pedidoEntregado'];
    }
    public function traerConteoCliente()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as Clientes from clientes where rol = 'cliente';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['Clientes'];
    }

    public function insertarFechaDeshabilitada($fecha)
    {
    $this->mysql->conectar();
    $consulta = "INSERT IGNORE INTO fechas_deshabilitadas (fecha) VALUES ('$fecha');";
    $resultado = $this->mysql->efectuarConsulta($consulta);
    $this->mysql->desconectar();
    return $resultado;
    }

    public function traerFechasDeshabilitadas()
    {
    $this->mysql->conectar();
    $consulta = "SELECT fecha FROM fechas_deshabilitadas;";
    $resultado = $this->mysql->efectuarConsulta($consulta);

    $fechas = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $fechas[] = $row['fecha'];
    }

    $this->mysql->desconectar();
    return $fechas;
    }    
    public function traerConteoPedido()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as Pedidos from pedidos;
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['Pedidos'];
    }
    public function traerPedidos()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select clientes.nombres,clientes.apellidos, pedidos.* from Pedidos join clientes on clientes.documento = clientes_documento;
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    public function traerCitas()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select clientes.nombres,clientes.apellidos,servicios.nombreServicio, citas.* from citas join clientes on clientes.documento = clientes_documento 
            JOIN servicios ON citas.servicios_idservicios = servicios.idservicios;
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
        

}