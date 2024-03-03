<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../email/PHPMailer/src/Exception.php';
require '../email/PHPMailer/src/PHPMailer.php';
require '../email/PHPMailer/src/SMTP.php';



$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
	 $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->Host = 'smtp.titan.email'; // Consulta esta información con el soporte de HostGator
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hchaparro@golemsiseg.com'; // Tu dirección de correo electrónico
    $mail->Password   = 'qazwsxXX456bn..'; // Tu contraseña de correo electrónico
$mail->SMTPSecure = 'ssl'; 
$mail->Port = 465; // 

    // Configura el remitente y el destinatario
    $mail->setFrom('hchaparro@golemsiseg.com', 'Remitente');
    $mail->addAddress('hugenri04@gmail.com', 'Destinatario');

    // Configura el asunto y el cuerpo del mensaje
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Cuerpo del mensaje';

    // Envía el correo electrónico
    $mail->send();
    echo 'El mensaje se envió correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>
