<?php
// Asegurarnos de que los errores de PHP no interfieran con nuestra respuesta JSON
error_reporting(0);
header('Content-Type: application/json');

session_start();
require_once '../models/consultas.php';

try {
    $consultas = new consultas();

    if(isset($_POST['idcita']) && 
       isset($_POST['fecha']) && 
       isset($_POST['servicio']) && 
       isset($_POST['estado'])) {
        
        // Sanitizar los datos de entrada
        $idcita = filter_var($_POST['idcita'], FILTER_SANITIZE_NUMBER_INT);
        $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
        $servicio = filter_var($_POST['servicio'], FILTER_SANITIZE_NUMBER_INT);
        $estado = filter_var($_POST['estado'], FILTER_SANITIZE_STRING);

        // Validar que los datos no estén vacíos después de sanitizar
        if(empty($idcita) || empty($fecha) || empty($servicio) || empty($estado)) {
            throw new Exception('Los datos proporcionados no son válidos');
        }

        // Actualizar la cita
        $resultado = $consultas->actualizarCita($idcita, $fecha, $servicio, $estado);

        if($resultado) {
            echo json_encode([
                'success' => true,
                'message' => 'Cita actualizada correctamente'
            ]);
        } else {
            throw new Exception('Error al actualizar la cita en la base de datos');
        }
    } else {
        throw new Exception('Faltan datos requeridos');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 