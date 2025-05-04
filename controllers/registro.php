<?php
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
        echo "Todos los campos están completos<br>";
        var_dump($_POST);
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

        $resultado = $consultas->crear_cliente($documento,$nombres,$apellidos,$ciudad,$direccion,$barrio,$telefono,$correo,$contrasenaEncriptada);
        if($resultado)
        {
            header("Location: ../views/usuario/agendarCita.php");
        }
        else
        {
            echo "Error al registrar cliente.<br>";
            echo "Consulta: " . $consulta . "<br>"; // temporalmente
            echo "MySQL Error: " . mysqli_error($this->mysql->conexion);
        }
    }
    else
    {
        echo "Faltan campos o están vacíos<br>";
        var_dump($_POST);
    }