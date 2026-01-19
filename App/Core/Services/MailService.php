<?php

namespace App\Core\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    private static ?MailService $instance = null;
    private PHPMailer $mailer;


    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new MailService();
        }
        return self::$instance;
    }

    public function send(
        string $to,
        string  $subject,
        string $body
    ) {
        $mail = $this->mailer;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nouh.zennane2001@gmail.com';
        $mail->Password   = 'ynpk uvlq cyio ntop'; // NOT gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom("nouh.zennane2001@gmail.com", "APp");

        $mail->addAddress($to);

        $mail->Subject = $subject;

        $mail->Body    = $body;

        $mail->send();

        return true;
    }
}
