<?php
session_start();
require_once '../models/consultas.php';
$consultas = new consultas();

if(isset($_POST['idcita']) && isset($_POST['accion'])) {
    $idcita = intval($_POST['idcita']);
    $accion = $_POST['accion'];
    $resultado = false;
    $mensaje = '';

    switch($accion) {
        case 'confirmar':
            $resultado = $consultas->confirmarCita($idcita);
            $mensaje = $resultado ? 'Cita confirmada correctamente' : 'Error al confirmar cita';
            break;
        case 'completar':
            $resultado = $consultas->completarCita($idcita);
            $mensaje = $resultado ? 'Cita completada correctamente' : 'Error al completar cita';
            break;
        case 'cancelar':
            $resultado = $consultas->cancelarCita($idcita);
            $mensaje = $resultado ? 'Cita cancelada correctamente' : 'Error al cancelar cita';
            break;
        default:
            $mensaje = 'Acción no válida';
            break;
    }

    echo json_encode(['success' => $resultado, 'message' => $mensaje]);
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}