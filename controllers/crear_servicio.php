<?php
require_once '../models/consultas.php';

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
                // Redirigir con mensaje de éxito
                header('Location: ../views/admin/servicios.php?mensaje=Servicio creado exitosamente');
                exit();
            } else {
                // Redirigir con mensaje de error
                header('Location: ../views/admin/servicios.php?error=No se pudo crear el servicio');
                exit();
            }
        } else {
            // Redirigir con mensaje de error si faltan campos
            header('Location: ../views/admin/servicios.php?error=El nombre del servicio es requerido');
            exit();
        }
    } else {
        // Redirigir con mensaje de error si faltan campos
        header('Location: ../views/admin/servicios.php?error=Faltan campos requeridos');
        exit();
    }
} else {
    // Redirigir si no es una petición POST
    header('Location: ../views/admin/servicios.php');
    exit();
} 