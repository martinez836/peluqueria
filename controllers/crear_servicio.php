<?php
require_once '../models/consultas.php';
$consultas = new consultas();


if(isset($_POST['nombre']) && isset($_POST['descripcion']) && 
    !empty($_POST['nombre']) && 
    !empty($_POST['descripcion'])
){
    // Obtener datos del formulario
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion = filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_SPECIAL_CHARS);
    
    $resultado = $consultas->crear_servicio($nombre,$descripcion);
    if($resultado)
    {
        header("Location: ../views/admin/dashboard.php");
    }
    else
    {
        echo("error");
    }
} 