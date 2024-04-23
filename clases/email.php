<?php
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CorreoElectronico {

    private $mail;

    public function __construct() {
        // Configurar el objeto PHPMailer
        $this->mail = new PHPMailer(true);
        $this->configurarSMTP();
    }

    private function configurarSMTP() {
        // Configuración del servidor SMTP
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.titan.email'; // Cambia esto por tu servidor SMTP
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'hchaparro@golemsiseg.com'; // Cambia esto por tu usuario SMTP
        $this->mail->Password   = 'qazwsxXX456bn..';   // Cambia esto por tu clave SMTP
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port       = 465;
    }

    public function enviarCorreoRegistroExitoso($email, $nombre, $clave, $linkAcceso) {
        try {
            // Configuración del remitente y destinatario
            $this->mail->setFrom('hchaparro@golemsiseg.com', 'Golem');
            $this->mail->addAddress($email, $nombre);

            // Configuración del correo
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Registro Golem';
            $this->mail->Body    = $this->generarContenidoCorreo($nombre, $clave, $linkAcceso);

            // Enviar el correo electrónico
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            // Manejar errores de envío de correo electrónico
            return false;
        }
    }

    private function generarContenidoCorreo($nombre, $clave, $linkAcceso) {
        // Aquí puedes personalizar el contenido del correo electrónico
        // Puedes usar HTML y CSS para hacerlo más atractivo
        $contenido = "<p>Hola $nombre,</p>";
        $contenido .= "<p>Te damos la bienvenida a nuestro sitio. Tu clave de acceso es: $clave</p>";
        $contenido .= "<p>Puedes acceder al sitio a través de este enlace: <a href='$linkAcceso'>Acceder</a></p>";
        $contenido .= "<p>Gracias por registrarte.</p>";

        return $contenido;
    }
	
	public function enviarCorreos($destinatarios) {
    try {
        foreach ($destinatarios as $destinatario) {
            $email = $destinatario['email'];
            $nombre = $destinatario['nombre'];
            $contenidoHTML = $destinatario['contenidoHTML'];
            $asunto = $destinatario['asunto'];

            // Configuración del remitente y destinatario
            $this->mail->setFrom('hchaparro@golemsiseg.com', 'Golem');
            $this->mail->addAddress($email, $nombre);

            // Configuración del correo
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $contenidoHTML;

            // Enviar el correo electrónico
            $this->mail->send();
        }

        return true;
    } catch (Exception $e) {
        // Manejar errores de envío de correo electrónico
        return false;
    }
}

}
