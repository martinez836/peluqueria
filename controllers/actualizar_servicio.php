<?php
require_once '../models/consultas.php';

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombreServicio = $_POST['nombreServicio'];
    $descripcion = $_POST['descripcion'];

    // Validar que los campos requeridos no estén vacíos
    if (empty($id) || empty($nombreServicio)) {
        echo json_encode([
            'success' => false,
            'message' => 'El ID y nombre del servicio son requeridos'
        ]);
        exit;
    }

    try {
        $consultas = new consultas();
        $resultado = $consultas->actualizar_servicio($id, $nombreServicio, $descripcion);

        if ($resultado) {
            echo json_encode([
                'success' => true,
                'message' => 'Servicio actualizado correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar el servicio'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
} 