<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Send an email, require phpmailer/phpmailer package.
 */
class Email
{
    /**
     * Sender of the email.
     *
     * $view string
     */
    public $from;

    /**
     * Recipients of the email.
     *
     * $view array
     */
    public $to = [];

    /**
     * Subject of the email.
     *
     * $view string
     */
    public $subject;

    /**
     * Body of the email.
     *
     * $view string
     */
    public $body = '';

    /**
     * View corresponding to the body of the email.
     *
     * $view string
     */
    public $view = '';

    /**
     * Data that will be displayed in the email view.
     *
     * $view array
     */
    public $data;

    /**
     * Attachments that will be sent in the email.
     *
     * $view array
     */
    public $attach = [];

    /**
     * Initialize the class to use from a global function.
     *
     * @return Email
     */
    public static function init()
    {
        $class = new static;
        return $class;
    }

    /**
     * Set the sender of the email.
     *
     * @param $from string
     * @return Email
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the recipients of the email.
     *
     * @param $to array
     * @return Email
     */
    public function to($to)
    {
        $this->to[] = $to;
        return $this;
    }

    /**
     * Set the subject of the email.
     *
     * @param $subject string
     * @return Email
     */
    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Set the body of the email.
     *
     * @param $body string
     * @return Email
     */
    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set the view corresponding to the body of the email.
     *
     * @param $view string
     * @return Email
     */
    public function view($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Set the data that will be displayed in the email view.
     *
     * @param $data array
     * @return Email
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the attachments that will be sent in the email.
     *
     * @param $data array
     * @return Email
     */
    public function attach($attach)
    {
        $this->attach[] = $attach;
        return $this;
    }

    /**
     * Send the email with the parameters established above.
     *
     * @return Email
     */
    public function send()
    {
        $mail = new PHPMailer();
        $mail->setFrom($this->from);
        $mail->Subject = $this->subject;
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

        foreach ($this->to as $item) {
            $mail->addAddress($item);
        }

        if ($this->view != '') {
            ob_start();

            foreach ($this->data as $key => $value) {
                $data[$key] = $value;
            }

            view($this->view, $data);

            $mail->Body = ob_get_clean();
        }

        if ($this->body != '') {
            $mail->Body = $this->body;
        }

        if ($this->attach != []) {
            foreach ($this->attach as $item) {
                $mail->addAttachment($item);
            }
        }

        $mail->send();

        return $this;
    }
}

/**
 * Initialize global helper.
 *
 * @return Email
 */
function email()
{
    return Email::init();
}
