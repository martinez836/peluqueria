<?php
require_once '../models/consultas.php';
session_start();
    $consultas = new consultas();
    if(isset($_POST["documento"]) &&
        isset($_POST["contrasena"]) &&
        !empty($_POST["documento"]) &&
        !empty($_POST["contrasena"])
    )
    {
        $documento = filter_var($_POST['documento'],FILTER_SANITIZE_NUMBER_INT);
        $contrasena = filter_var($_POST['contrasena'], FILTER_SANITIZE_SPECIAL_CHARS);

        $resultado = $consultas->traerCliente($documento);
        if($cliente = mysqli_fetch_assoc($resultado))
        {
            
            if(password_verify($contrasena,$cliente["contrasena"]))
            {
                
                if ($cliente['rol'] === "administrador") {
                    $_SESSION['documento'] = $cliente['documento'];
                    $_SESSION['nombres'] = $cliente['nombres'];
                    header("Location: ../views/admin/dashboard.php");
                    exit();
                } 
                else {
                    $_SESSION['documento'] = $cliente['documento'];
                    $_SESSION['nombres'] = $cliente['nombres'];
                    $_SESSION['apellidos'] = $cliente['apellidos'];
                    $_SESSION['direccion'] = $cliente['direccion'];
                    $_SESSION['ciudad'] = $cliente['ciudad'];
                    $_SESSION['barrio'] = $cliente['barrio'];
                    $_SESSION['correo'] = $cliente['correo'];
                    $_SESSION['telefono'] = $cliente['telefono'];
                    header("Location: ../views/usuario/agendarCita.php");
                    exit();
                }
                
            }
        }
        header("Location: ../views/usuario/agendarCita.php?error=1");
        exit();
    }
