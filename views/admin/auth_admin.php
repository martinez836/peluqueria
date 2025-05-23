<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION["documento"]) || !isset($_SESSION["rol"]) || $_SESSION["rol"] !== "administrador") {
    // Guardar el mensaje de error en la sesión
    $_SESSION['error'] = "Acceso denegado. Debe iniciar sesión como administrador.";
    
    // Obtener la URL actual
    $current_url = $_SERVER['REQUEST_URI'];
    // Guardar la URL actual en la sesión para redirigir después del login
    $_SESSION['redirect_after_login'] = $current_url;
    
    // Redirigir al usuario
    header("Location: ../usuario/index.php");
    exit();
} 