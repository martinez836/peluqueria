<?php
require_once '../models/correo.php';

//verifica si el formulario fue enviado
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //recibir los datos del formulario
    $correoDestino = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    //verificacion de la direccion sea valida
    if(filter_var($correoDestino, FILTER_SANITIZE_EMAIL)){
        //instancia de la clase
        $correo = new Correo();

        //llamar al metodo para manejar la recuperacion de la contraseña

        $correo->recuperarContrasena($correoDestino); // metodo que se encarga del flujo
    } else {
        echo "La direccion de correo no es valida!!!";
    }
} else {
    echo "No se ha enviado el formulario!!!";
    
}
?>