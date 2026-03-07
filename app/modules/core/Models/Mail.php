<?php

/**
 * Modelo del modulo Core que se encarga de inicializar  la clase de envio de correos
 */
class Core_Model_Mail
{
    /**
     * classe de  phpmailer
     * @var class
     */
    private $mail;

    /**
     * asigna los valores a la clase e instancia el phpMailer
     */
    public function __construct()
    {

        $this->mail = new PHPMailer;
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPSecure = "tls";
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "deliveryclubelnogal@gmail.com";
        $this->mail->Password = "igijajtcfiayccjs";
        $this->mail->setFrom("deliveryclubelnogal@gmail.com", "Club el Nogal");
    }
    /**
     * retorna la  instancia de email
     * @return class email
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * envia el correo
     * @return bool envia el estado del correo
     */
    public function sed()
    {

        if (APPLICATION_ENV != 'production') {
            $this->mail->clearAddresses();
            $this->mail->clearCCs();
            $this->mail->clearBCCs();
            $this->mail->addAddress('desarrollo8@omegawebsystems.com', 'Desarrollo 8');
        }

        if ($this->mail->send()) {
            return true;
        } else {
            $this->mail->Username = "deliveryclubelnogal@gmail.com";
            $this->mail->Password = "Admin.2008";
            $this->mail->send();

            return false;
        }
    }
}
