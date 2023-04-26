<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer;
use PHPMailer\SMTP;
use PHPMailer\Exception;

class Mail
{
    private $mail;
    public $Subject;
    public $Body;
    function __construct()
    {
        $this->mail = $this->set_mail();
    }

    private function set_mail()
    {
        $settings = Settings::get('mail');

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();
        $mail->Host       = $settings['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $settings['username'];
        $mail->Password   = $settings['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port       = 465;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet    = 'UTF-8';
        $mail->isHTML(true);

        $mail->setFrom('kadarkut@taborkert.hu', 'Kadarkúti Gyermektábor');
        return $mail;
    }

    public function addAddress($email, $name = '')
    {
        $this->mail->addAddress($email, $name);
    }

    public function addAttachment($path, $name = '')
    {
        $this->mail->addAttachment($path, $name);
    }

    public function send()
    {
        try {
            $this->mail->Subject = $this->Subject;
            $this->mail->Body    = $this->Body;
            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
