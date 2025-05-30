<?php
require_once '../models/consultas.php';
$consultas = new consultas();

header('Content-Type: application/json');

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
            echo json_encode([
                'success' => false,
                'message' => 'Solo se permiten imágenes JPG y PNG'
            ]);
            exit;
        }
        
        $ext = $permitidos[$tipo];
        $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;
        $ruta = 'assets/images/' . $nombreUnico;
        $rutaAbsoluta = __DIR__ . '/../' . $ruta;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
            $resultado = $consultas->crear_producto($nombre, $descripcion, $precio, $ruta, $stock);
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => '¡Producto creado exitosamente!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear el producto'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al subir la imagen'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se seleccionó una imagen válida'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos'
    ]);
}