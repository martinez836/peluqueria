<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die('Conexión fallida: ' . $mysqli->connect_error);
}

// Requiere PHPMailer
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];

    // Verifica si el correo existe en la base de datos
    $stmt = $mysqli->prepare("SELECT * FROM clientes WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Generar un código de recuperación aleatorio
        $codigo = bin2hex(random_bytes(5));

        // Guardar el código en la tabla de recuperación
        $stmt = $mysqli->prepare("INSERT INTO recuperacion (correo_recuperacion, codigo_recuperacion) VALUES (?, ?)");
        $stmt->bind_param("ss", $correo, $codigo);
        $stmt->execute();

        // Crear el enlace de recuperación
        $enlace = "http://localhost/peluqueria/views/nuevaContrasena.php?correo=" . urlencode($correo) . "&codigo=" . $codigo;

        // Crear el mensaje de recuperación
        $asunto = "Recuperación de contraseña";
        $mensaje = "Haz clic en este enlace para recuperar tu contraseña: <a href='$enlace'>Recuperar Contraseña</a>";

        // Usar PHPMailer para enviar el correo
        try {
            $mail = new PHPMailer(true);
            
            // Configuración de SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'recuperacionContrasenas03@gmail.com';  // Tu correo SMTP
            $mail->Password = 'xctk wzlm wuhr gisd';  // Contraseña de la aplicación serviplus para Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente
            $mail->setFrom('recuperacionContrasenas03@gmail.com', 'Servicio de Recuperación');

            // Destinatario
            $mail->addAddress($correo);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            // Enviar el correo
            $mail->send();
            echo "Se ha enviado un correo de recuperación a $correo.";
            header("refresh:3;url=../views/usuario/index.php");        

        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "El correo no está registrado.";
    }
}
?>
