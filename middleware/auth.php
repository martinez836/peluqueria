<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Establecer headers para evitar el caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

function verificarSesion($rol = null) {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION["documento"])) {
        $_SESSION['error'] = "Debe iniciar sesión para acceder a esta página.";
        header("Location: /views/usuario/index.php");
        exit();
    }

    // Si se especifica un rol, verificar que el usuario tenga ese rol
    if ($rol !== null && (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== $rol)) {
        $_SESSION['error'] = "No tiene permisos para acceder a esta página.";
        header("Location: /views/usuario/index.php");
        exit();
    }
} 