<?php
session_start();
require_once '../models/consultas.php';
$consultas = new consultas();
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
    // Verificar si la cita se creó correctamente
    // Redirigir a la página de citas o mostrar un mensaje de éxito
    if($resultado) {
        $_SESSION['cita_registrada'] = true;
        header("Location: ../views/usuario/agendarCita.php");
        exit();
    } else {
        echo "Error al crear la cita";
    }
} else {
    echo "Por favor complete todos los campos";
}