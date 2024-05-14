<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Por favor, complete todos los campos del formulario.";
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'latinpowermusic.com.mx';
        $mail->SMTPAuth = true;
        $mail->Username = 'charly@latinpowermusic.com.mx';
        $mail->Password = '#charly12345';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('charly@latinpowermusic.com.mx', $name);
        $mail->addAddress('charly@latinpowermusic.com.mx');  // Reemplazar con la dirección de destino

        $mail->isHTML(true);
        $mail->Subject = "Nuevo mensaje de $name: $subject";
        $mail->Body    = nl2br("Nombre: $name\nCorreo electrónico: $email\n\nMensaje:\n$message\n");

        $mail->send();
        http_response_code(200);
        echo "Gracias! Su mensaje ha sido enviado.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Algo salió mal y no pudimos enviar su mensaje. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Hubo un problema con su envío. Por favor, inténtelo de nuevo.";
}
?>