<?php
require_once '../models/consultas.php';
$consultas = new consultas();
if(
    isset($_POST["cedula"]) &&
    isset($_POST["nombre"]) &&
    isset($_POST["apellido"]) &&
    isset($_POST["telefono"]) &&
    isset($_POST["correo"]) &&
    isset($_POST["servicio"]) && 
    isset($_POST["fecha"]) &&
    !empty($_POST["cedula"]) &&
    !empty($_POST["nombre"]) &&
    !empty($_POST["apellido"]) &&
    !empty($_POST["telefono"]) &&
    !empty($_POST["correo"]) &&
    !empty($_POST["servicio"]) &&
    !empty($_POST["fecha"])
)
{
    // Obtener y sanitizar los datos del formulario
    $cedula = filter_var(trim($_POST["cedula"]), FILTER_SANITIZE_NUMBER_INT);
    $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_SPECIAL_CHARS);
    $apellido = filter_var(trim($_POST["apellido"]), FILTER_SANITIZE_SPECIAL_CHARS);
    $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_NUMBER_INT);
    $correo = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
    $servicio = filter_var(trim($_POST["servicio"]), FILTER_SANITIZE_SPECIAL_CHARS);
    $fecha = filter_var(trim($_POST["fecha"]), FILTER_SANITIZE_SPECIAL_CHARS);

    // Aquí puedes llamar a tu método de la clase consultas para guardar la cita
    $resultado = $consultas->registrar_cita($cedula, $nombre, $apellido, $telefono, $correo, $servicio, $fecha);
    // Verificar si la cita se creó correctamente
    // Redirigir a la página de citas o mostrar un mensaje de éxito
    if($resultado) {
        
        header("Location: ../views/usuario/index.php");
        
    } else {
        echo "Error al crear la cita";
    }
} else {
    echo "Por favor complete todos los campos";
}