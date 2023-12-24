<?php

namespace App\Mails;

use Monitor;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public function __construct()
    {
        if (! class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            throw new Exception('Please execute `phpmailer/phpmailer`');
        }
    }

    public function send($to)
    {
        $mail = new PHPMailer();

        if ($_SERVER['REMOTE_ADDR'] == '::1') {
            $mail->isSMTP();
            $mail->Host = config('smtp')->host;
            $mail->SMTPAuth = true;
            $mail->Username = config('smtp')->username;
            $mail->Password = config('smtp')->password;
            $mail->Port = config('smtp')->port;
        }

        $mail->setFrom($this->from);
        $mail->Subject = $this->subject;
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        $mail->addAddress($to);

        if (isset($this->replyTo)) {
            $mail->addReplyTo($this->replyTo);
        }

        if (isset($this->cc)) {
            $mail->addCC($this->cc);
        }

        if (isset($this->bcc)) {
            $mail->addBCC($this->bcc);
        }

        ob_start();
        $this->build();
        $mail->Body = ob_get_clean();

        if ($this->attach) {
            foreach ($this->attach as $item) {
                $mail->addAttachment($item);
            }
        }

        $mail->send();

        include 'vendor/base-php/core/database/database.php';

        $schema = $capsule->getConnection('default')->getSchemaBuilder();

        if ($schema->hasTable('monitor')) {
            $monitor = new Monitor();
            $monitor->email($this, $to);
        }

        return $this;
    }
}
