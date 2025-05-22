<?php
session_start();
require_once '../models/consultas.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["documento"];
    $contrasena = $_POST["contrasena"];

    $consultas = new consultas();
    $resultado = $consultas->traerCliente($documento);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($contrasena, $usuario["contrasena"])) {
            $_SESSION["documento"] = $usuario["documento"];
            $_SESSION["nombres"] = $usuario["nombres"];
            $_SESSION["rol"] = $usuario["rol"];

            // Verificar si hay una URL de redirección guardada
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect_url = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']); // Limpiar la URL guardada
                header("Location: " . $redirect_url);
                exit();
            }

            // Si no hay redirección específica, redirigir según el rol
            if ($usuario["rol"] == "administrador") {
                header("Location: ../views/admin/dashboard.php");
            } else {
                header("Location: ../views/usuario/index.php");
            }
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: ../views/usuario/index.php");
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado";
        header("Location: ../views/usuario/index.php");
    }
    exit();
} else {
    header("Location: ../views/usuario/index.php");
    exit();
}
