<?php
require_once '../models/consultas.php';
$consultas = new consultas();
if(isset($_POST['nombre']) && isset($_POST['descripcion']) && 
    isset($_POST['precio']) &&  
    isset($_POST["stock"]) &&
    !empty($_POST['nombre']) && 
    !empty($_POST['descripcion']) &&
    !empty($_POST['precio']) &&
    !empty($_POST["stock"])
){
//Obtener datos del formulario
$nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_SPECIAL_CHARS);
$precio = filter_var(trim($_POST['precio']), FILTER_SANITIZE_NUMBER_FLOAT);
$stock = filter_var(trim($_POST['stock']), FILTER_SANITIZE_NUMBER_FLOAT);
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
    $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
    
    if (!array_key_exists($tipo, $permitidos)) {
    die("Solo se permiten imágenes JPG y PNG.");
    }
    
    $ext = $permitidos[$tipo];
    $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;
    $ruta = 'assets/images/' . $nombreUnico;
    $rutaAbsoluta = __DIR__ . '/../' . $ruta;
    
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) 
    {

    $resultado = $consultas->crear_producto($nombre,$descripcion,$precio,$ruta,$stock);
    header("Location: ../views/admin/productos.php");
    } else {
    echo "Error al insertar el empleado.";
    }
    } else {
    echo "No se seleccionó una imagen válida.";
    }
echo "Empleado registrado con exito <br><br>";

header("refresh:3;url=../../views/usuario/index.php");
}
else{
    echo "datos erroneos";
}