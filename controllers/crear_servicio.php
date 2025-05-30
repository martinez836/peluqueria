<?php
require_once '../models/consultas.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que los campos requeridos estén presentes
    if (isset($_POST['nombreServicio']) && isset($_POST['descripcion'])) {
        
        // Obtener y sanitizar los datos del formulario
        $nombreServicio = filter_var(trim($_POST['nombreServicio']), FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Validar que los campos no estén vacíos
        if (!empty($nombreServicio)) {
            $consultas = new consultas();
            
            // Intentar crear el servicio
            $resultado = $consultas->crear_servicio($nombreServicio, $descripcion);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => '¡Servicio creado exitosamente!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear el servicio'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'El nombre del servicio es requerido'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
} 