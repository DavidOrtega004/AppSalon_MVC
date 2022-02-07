<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        // Crear el objeto email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'bd02dce9e84515';
        $mail->Password = '367622e33aab47';

        $mail->setFrom('kekeyo789@gmail.com');
        $mail->addAddress('kekeyo789@gmail.com', 'David Ortega');
        $mail->Subject = 'Confirma tu cuenta';


        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . ", has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace: </strong></p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }
    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'bd02dce9e84515';
        $mail->Password = '367622e33aab47';

        $mail->setFrom('kekeyo789@gmail.com');
        $mail->addAddress('kekeyo789@gmail.com', 'David Ortega');
        $mail->Subject = 'Restablece tu contraseña';


        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:3000/recuperar?token=" . $this->token . "'>Reestablecer contraseña aquí</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cambio, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }
}