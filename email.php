<?php

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
	public $to;
	public $class;

	public function init()
	{
		return $this;
	}

	public function to($to)
	{
		$this->to = $to;
		return $this;
	}

	public function send($class)
	{
		$class->build();
		$this->class = $class;

		$mail = new PHPMailer();
        $mail->setFrom($class->from);
        $mail->Subject = $class->subject;
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        $mail->addAddress($this->to);

        if ($class->view != '') {
            ob_start();

            foreach ($class->with as $key => $value) {
                $data[$key] = $value;
            }

            view($class->view, $data);

            $mail->Body = ob_get_clean();
        }

        if ($class->attach) {
            foreach ($class->attach as $item) {
                $mail->addAttachment($item);
            }
        }

        $mail->send();
	}
}
