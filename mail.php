<?php

namespace App\Mails;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class for send email, require phpmailer/phpmailer package.
 */
class Mail
{
    /**
     * Send email.
     * 
     * @param string $to
     *
     * @return PHPMailer
     */
	public function send($to)
	{
		$mail = new PHPMailer();
        $mail->setFrom($this->from);
        $mail->Subject = $this->subject;
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        $mail->addAddress($to);

        ob_start();
        $this->build();
        $mail->Body = ob_get_clean();

        if ($this->attach) {
            foreach ($this->attach as $item) {
                $mail->addAttachment($item);
            }
        }

        $mail->send();
	}
}
