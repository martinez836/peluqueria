<?php
require_once '../models/consultas.php';

// Agregar logs para depuración
error_log("guardarFechas.php - Método: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST recibido");
    
    if (isset($_POST['fechas_deshabilitadas'])) {
        $fechasJson = $_POST['fechas_deshabilitadas'];
        error_log("Fechas recibidas: " . $fechasJson);
        
        $fechas = json_decode($fechasJson, true);
        
        if (is_array($fechas)) {
            error_log("Procesando " . count($fechas) . " fechas");
            $consultas = new consultas();
            $contador = 0;
            
            foreach ($fechas as $fecha) {
                // Validación básica de formato YYYY-MM-DD
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                    $resultado = $consultas->insertarFechaDeshabilitada($fecha);
                    if ($resultado) {
                        $contador++;
                    }
                } else {
                    error_log("Formato de fecha inválido: " . $fecha);
                }
            }
            
            error_log("Se insertaron " . $contador . " fechas");
        } else {
            error_log("Error al decodificar JSON de fechas");
        }
    } else {
        error_log("No se recibió el parámetro fechas_deshabilitadas");
    }
}

// Redirigir al dashboard con un parámetro para mostrar mensaje de éxito
header('Location: ../views/admin/dashboard.php');
exit;
?>