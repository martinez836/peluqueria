<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../models/consultas.php';
    $consultas = new consultas();
    if(
        isset($_POST["documento"]) &&
        isset($_POST["nombres"]) &&
        isset($_POST["apellidos"]) &&
        isset($_POST["ciudad"]) &&
        isset($_POST["direccion"]) &&
        isset($_POST["barrio"]) &&
        isset($_POST["telefono"]) &&
        isset($_POST["correo"]) &&
        isset($_POST["contrasena"]) &&
        !empty($_POST["documento"]) &&
        !empty($_POST["nombres"]) &&
        !empty($_POST["apellidos"]) &&
        !empty($_POST["ciudad"]) &&
        !empty($_POST["direccion"]) &&
        !empty($_POST["barrio"]) &&
        !empty($_POST["telefono"]) &&
        !empty($_POST["correo"]) &&
        !empty($_POST["contrasena"])
    )
    {
        try
        {
            /* echo "Todos los campos están completos<br>";
            var_dump($_POST); */
            $documento = filter_var($_POST['documento'], FILTER_SANITIZE_NUMBER_INT);
            $nombres = filter_var(trim($_POST['nombres']), FILTER_SANITIZE_SPECIAL_CHARS);
            $apellidos = filter_var(trim($_POST['apellidos']), FILTER_SANITIZE_SPECIAL_CHARS);
            $ciudad = filter_var(trim($_POST['ciudad']), FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion = filter_var(trim($_POST['direccion']), FILTER_SANITIZE_SPECIAL_CHARS);
            $barrio = filter_var(trim($_POST['barrio']), FILTER_SANITIZE_SPECIAL_CHARS);
            $telefono = filter_var(trim($_POST['telefono']), FILTER_SANITIZE_SPECIAL_CHARS);
            $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $contrasena = filter_var($_POST['contrasena'], FILTER_SANITIZE_SPECIAL_CHARS);
            $contrasenaEncriptada = password_hash($contrasena,PASSWORD_DEFAULT);
            $rol = "cliente";
            $fechaNacimiento = filter_var(trim($_POST['fechaNacimiento']), FILTER_SANITIZE_SPECIAL_CHARS);

            /* $clienteExistente = $consultas->verificarDocumentoExistente($documento);
            if ($clienteExistente) {
                echo "El documento ya está registrado en el sistema. Por favor, ingrese otro.";
                exit;  // Detener el flujo del script si el documento ya existe
            } */

            $resultado = $consultas->crear_cliente($documento,$nombres,$apellidos,$ciudad,$direccion,$barrio,$telefono,$correo,$contrasenaEncriptada, $rol, $fechaNacimiento);
            $_SESSION['mensaje_exito'] = "¡Cuenta creada con éxito!";
            header("Location: ../views/usuario/agendarCita.php");
        }
        catch(Exception $e)
        {
            if($e->getCode()=="1062")
            {
                 $_SESSION['mensaje_error'] = "El documento o correo ya está registrado.";
                 
            }
            else
            {
                $_SESSION['mensaje_error'] = "Error al registrar: " . $e->getMessage();
            }
            header("Location: ../views/usuario/registroSesion.php");
            exit;
        }
        
    }
    else
    {
        echo "Faltan campos o están vacíos<br>";
        var_dump($_POST);
    }