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
            Insert into productos (nombre,descripcion,precio,imagen,stock,estado) values 
            (
                '$nombre',
                '$descripcion',
                $precio,
                '$imagen',
                $stock,
                'activo'
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
    public function crear_servicio($nombreServicio,$descripcion)
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Insert into servicios (nombreServicio, descripcion, estado) values 
            (
                '$nombreServicio',
                '$descripcion',
                'activo'
            );
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traer_servicios()
    {
        $this->mysql->conectar();
        $consulta = "SELECT * from servicios WHERE estado = 'activo';";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traerProducto()
    {
        $this->mysql->conectar();
        $consulta = "SELECT idproductos as id, nombre, descripcion, precio, imagen, stock FROM productos WHERE estado = 'activo'";
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
            Select count(*) as citasConfirmada from citas where estado = 'confirmado';
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
            Select count(*) as citaCancelada from citas where estado = 'cancelado';
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $row = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $row['citaCancelada'];
    }
    public function traerCitaCompetada()
    {
        $this->mysql->conectar();
        $consulta = 
        "
            Select count(*) as citaCancelada from citas where estado = 'completado';
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
        $consulta = "SELECT p.*, c.nombres, c.apellidos 
                    FROM pedidos p 
                    INNER JOIN clientes c ON p.clientes_documento = c.documento 
                    WHERE p.estado != 'inactivo'
                    ORDER BY p.fecha DESC";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traerDetallePedido($idpedido) {
        $this->mysql->conectar();
        $consulta = "
            SELECT 
                p.idpedidos,
                p.fecha,
                p.total,
                p.estado,
                dp.cantidad,
                dp.subtotal,
                pr.nombre as nombre_producto,
                pr.descripcion as descripcion_producto,
                pr.precio as precio_unitario,
                pr.imagen as imagen_producto,
                c.direccion,
                c.barrio,
                c.nombres,
                c.apellidos
            FROM pedidos p
            INNER JOIN detallepedido dp ON p.idpedidos = dp.pedidos_idpedidos
            INNER JOIN productos pr ON dp.productos_idproductos = pr.idproductos
            INNER JOIN clientes c ON p.clientes_documento = c.documento
            WHERE p.idpedidos = $idpedido
        ";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traerCitas()
    {
        $this->mysql->conectar();
        $consulta = "SELECT c.*, cl.nombres, cl.apellidos, cl.telefono, cl.correo, cl.fechaNacimiento, s.nombreServicio 
                    FROM citas c 
                    INNER JOIN clientes cl ON c.clientes_documento = cl.documento 
                    INNER JOIN servicios s ON c.servicios_idservicios = s.idservicios 
                    WHERE c.estado != 'inactivo'
                    ORDER BY c.fecha DESC";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
    public function confirmarCita($idcita){
        $this->mysql->conectar();  // Obtenemos la conexión

        $consulta = "UPDATE citas SET estado = 'Confirmado' WHERE idcitas = $idcita";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado; // true si se ejecutó correctamente, false si no
    }

    public function actualizarCita($idcita, $fecha, $servicio, $estado) {
        $this->mysql->conectar();
        $consulta = "UPDATE citas SET 
            fecha = '$fecha',
            servicios_idservicios = $servicio,
            estado = '$estado'
            WHERE idcitas = $idcita";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function completarCita($idcita) {
        $this->mysql->conectar();  // Obtenemos la conexión
    
        $consulta = "UPDATE citas SET estado = 'Completado' WHERE idcitas = $idcita";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function cancelarCita($idcita) {
        $this->mysql->conectar();  // Obtenemos la conexión
    
        $consulta = "UPDATE citas SET estado = 'Cancelado' WHERE idcitas = $idcita";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function eliminarFechasDeshabilitadas($fechas)
    {
    $this->mysql->conectar();
    $conexion = $this->mysql->getConexion(); // Obtener la conexión correctamente

    if (empty($fechas)) {
        $this->mysql->desconectar();
        return false;
    }

    // Escapar cada fecha correctamente
    $fechasSeguras = array_map(function ($fecha) use ($conexion) {
        return "'" . mysqli_real_escape_string($conexion, $fecha) . "'";
    }, $fechas);

    // Convertir el array en una cadena para la consulta SQL
    $fechasQuery = implode(",", $fechasSeguras);

    // Ejecutar la consulta DELETE en la base de datos
    $consulta = "DELETE FROM fechas_deshabilitadas WHERE fecha IN ($fechasQuery);";

    $resultado = $this->mysql->efectuarConsulta($consulta);

    $this->mysql->desconectar();
    return $resultado;
    }

    public function actualizarEstadoPedido($idpedido, $estado) {
        $this->mysql->conectar();
        $consulta = "UPDATE pedidos SET estado = '$estado' WHERE idpedidos = $idpedido";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function actualizarStock($idProducto, $cantidad) {
        $this->mysql->conectar();
        $consulta = "UPDATE productos SET stock = stock - $cantidad WHERE idproductos = $idProducto";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function traerProductosStockBajo($limite = 5)
    {
        $this->mysql->conectar();
        $consulta = "SELECT idproductos as id, nombre, descripcion, precio, stock FROM productos WHERE stock <= $limite ORDER BY stock ASC";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function obtenerProductoPorId($id)
    {
        $this->mysql->conectar();
        $consulta = "SELECT idproductos as id, nombre, descripcion, precio, imagen, stock FROM productos WHERE idproductos = $id";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $producto = mysqli_fetch_assoc($resultado);
        $this->mysql->desconectar();
        return $producto;
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $imagen = null)
    {
        $this->mysql->conectar();
        
        $set_imagen = "";
        if ($imagen !== null) {
            $set_imagen = ", imagen = '$imagen'";
        }
        
        $consulta = "UPDATE productos SET 
            nombre = '$nombre',
            descripcion = '$descripcion',
            precio = $precio,
            stock = $stock
            $set_imagen
            WHERE idproductos = $id";
            
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function actualizar_servicio($id, $nombreServicio, $descripcion) {
        try {
            $this->mysql->conectar();
            $conexion = $this->mysql->getConexion();
            
            if (!$conexion) {
                throw new Exception("No se pudo establecer la conexión con la base de datos");
            }

            $sql = "UPDATE servicios SET nombreServicio = ?, descripcion = ? WHERE idservicios = ?";
            $stmt = $conexion->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssi", $nombreServicio, $descripcion, $id);
            $resultado = $stmt->execute();
            
            if (!$resultado) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            $stmt->close();
            $this->mysql->desconectar();
            return $resultado;
        } catch (Exception $e) {
            if (isset($stmt)) {
                $stmt->close();
            }
            if ($this->mysql->getConexion()) {
                $this->mysql->desconectar();
            }
            throw new Exception("Error al actualizar el servicio: " . $e->getMessage());
        }
    }

    public function cambiarEstadoProducto($id, $estado)
    {
        $this->mysql->conectar();
        $consulta = "UPDATE productos SET estado = '$estado' WHERE idproductos = $id";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function cambiarEstadoServicio($id, $estado)
    {
        $this->mysql->conectar();
        $consulta = "UPDATE servicios SET estado = '$estado' WHERE idservicios = $id";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function cambiarEstadoPedido($id, $estado)
    {
        $this->mysql->conectar();
        $consulta = "UPDATE pedidos SET estado = '$estado' WHERE idpedidos = $id";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }

    public function cambiarEstadoCita($id, $estado)
    {
        $this->mysql->conectar();
        $consulta = "UPDATE citas SET estado = '$estado' WHERE idcitas = $id";
        $resultado = $this->mysql->efectuarConsulta($consulta);
        $this->mysql->desconectar();
        return $resultado;
    }
};?>