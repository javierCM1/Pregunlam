<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class FileEmailSender
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'pregunlam@gmail.com';
            $this->mail->Password = 'gbkf fqcc bnje twon';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
        } catch (Exception $e) {
            $this->sendEmailToFile("El correo no pudo ser enviado. Error: {$mail->ErrorInfo}");
        }
    }

    //implementar envio de correos
    public function sendEmailToFile($message)
    {
        file_put_contents('C:\xampp\htdocs\Pregunlam\dev.log', $message, FILE_APPEND);
    }

    public function sendEmail($from,$to,$subject,$message)
    {
        try {
            $this->mail->setFrom($from);
            $this->mail->addAddress($to);

            $this->mail->isHTML();
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;

            $this->mail->send();
        } catch (Exception $e) {
            $this->sendEmailToFile("El correo no pudo ser enviado. Error: {$this->mail->ErrorInfo}");
        }
    }
}