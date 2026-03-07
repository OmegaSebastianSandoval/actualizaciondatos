<?php

/**
 * Modelo del modulo Core que se encarga de  enviar todos los correos nesesarios del sistema.
 */
class Core_Model_Sendingemail
{
    /**
     * Intancia de la calse emmail
     * @var class
     */
    protected $email;

    protected $_view;

    public function __construct($view)
    {
        $this->email = new Core_Model_Mail();
        $this->_view = $view;
    }


    public function forgotpassword($user)
    {
        if ($user) {
            $code = [];
            $code['user'] = $user->user_id;
            $code['code'] = $user->code;
            $codeEmail = base64_encode(json_encode($code));
            $this->_view->url = "http://" . $_SERVER['HTTP_HOST'] . "/administracion/index/changepassword?code=" . $codeEmail;
            $this->_view->host = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $this->_view->nombre = $user->user_names . " " . $user->user_lastnames;
            $this->_view->usuario = $user->user_user;
            /*fin parametros de la vista */
            //$this->email->getMail()->setFrom("desarrollo4@omegawebsystems.com","Intranet Coopcafam");
            $this->email->getMail()->addAddress($user->user_email, $user->user_names . " " . $user->user_lastnames);
            $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/forgotpassword.php');
            $this->email->getMail()->Subject = "Recuperación de Contraseña Gestor de Contenidos";
            $this->email->getMail()->msgHTML($content);
            $this->email->getMail()->AltBody = $content;
            if ($this->email->sed() == true) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function enviarAlerta($solicitud, $link)
    {
        $this->_view->solicitud = $solicitud;


        $nombre = Session::getInstance()->get("kt_login_name") . " " . Session::getInstance()->get("socio_apellido");
        $correo = Session::getInstance()->get("kt_correo");
        $this->_view->solicitud_id = $solicitud->solicitud_id;
        $this->_view->url_panel = $link;
        $this->email->getMail()->addAddress($correo, $nombre);
        $this->email->getMail()->addBCC("desarrollo8@omegawebsystems.com", "Solicitud de actualización de datos");
        //$this->email->getMail()->addBCC("proyectos@omegawebsystems.com", "Solicitud de actualización de datos");

        $usuariosModel = new Administracion_Model_DbTable_Usuario();
        $validadores = $usuariosModel->getList(" user_level = 10 AND user_state = 1 ", "");
        $administradores = $usuariosModel->getList(" user_id != '221' AND  user_level = 13 AND user_state = 1 ", "");
        $usuariosPorNotificar = array_merge($validadores, $administradores);

        foreach ($usuariosPorNotificar as $usuario) {
            if ($usuario->user_email) {
                $this->email->getMail()->addBCC($usuario->user_email, "Solicitud de actualización de datos");
            }
        }



        $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/alertasolicitud.php');
        $this->email->getMail()->Subject = 'Solicitud de actualización de datos';
        $this->email->getMail()->msgHTML($content);
        $this->email->getMail()->AltBody = $content;
        if ($this->email->sed() == true) {
            return 1;
        } else {
            return 2;
        }
    }

    public function solicitudRespuesta($solicitud)
    {
        $this->_view->solicitud = $solicitud;
        if ($solicitud->solicitud_estado == 2) {
            // Prioriza el correo de comunicación, si no, usa el de facturación
            $correo = !empty($solicitud->solicitud_email_comunicacion)
                ? $solicitud->solicitud_email_comunicacion
                : "jescobar@clubelnogal.com";

            $nombre = $solicitud->solicitud_nombre . " " . $solicitud->solicitud_apellidos;
            $asunto = "Aprobada - Solicitud de actualización de datos";
            $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/aprobada.php');
        } elseif ($solicitud->solicitud_estado == 3) {
            // Prioriza el correo de comunicación actual, si no, usa el de facturación
            $correo = !empty($solicitud->solicitud_email_comunicacion_actual)
                ? $solicitud->solicitud_email_comunicacion_actual
                : "jescobar@clubelnogal.com";

            $nombre = $solicitud->solicitud_nombre_actual . " " . $solicitud->solicitud_apellidos_actual;
            $asunto = "Rechazada - Solicitud de actualización de datos";
            $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/rechazada.php');
        }

        $this->email->getMail()->addAddress($correo, $nombre);
        $this->email->getMail()->addBCC("desarrollo8@omegawebsystems.com", $asunto);
        // $this->email->getMail()->addBCC($correo, $asunto);
        $usuariosModel = new Administracion_Model_DbTable_Usuario();
        $validadores = $usuariosModel->getList(" user_level = 10 AND user_state = 1 ", "");
        $administradores = $usuariosModel->getList(" user_level = 13 AND user_state = 1 ", "");
        $usuariosPorNotificar = array_merge($validadores, $administradores);

        foreach ($usuariosPorNotificar as $usuario) {
            if ($usuario->user_email) {
                $this->email->getMail()->addBCC($usuario->user_email, "Solicitud de actualización de datos");
            }
        }


        $this->email->getMail()->Subject = $asunto;
        $this->email->getMail()->msgHTML($content);
        $this->email->getMail()->AltBody = $content;
        if ($this->email->sed() == true) {
            return 1;
        } else {
            return 2;
        }
    }
}
