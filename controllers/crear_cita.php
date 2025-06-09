<?php
session_start();
require_once '../models/consultas.php';
$consultas = new consultas();

header('Content-Type: application/json');

if(
    isset($_POST["cedula"]) &&
    isset($_POST["servicio"]) && 
    isset($_POST["fecha"]) &&
    !empty($_POST["cedula"]) &&
    !empty($_POST["servicio"]) &&
    !empty($_POST["fecha"])
)
{
    // Obtener y sanitizar los datos del formulario
    $fecha = filter_var(trim($_POST["fecha"]), FILTER_SANITIZE_SPECIAL_CHARS);
    $cedula = filter_var(trim($_POST["cedula"]), FILTER_SANITIZE_NUMBER_INT);
    $servicio = filter_var(trim($_POST["servicio"]), FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Aquí puedes llamar a tu método de la clase consultas para guardar la cita
    $resultado = $consultas->registrar_cita($fecha,$cedula, $servicio);
    
    if($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cita registrada exitosamente']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear la cita']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos']);
    exit();
}