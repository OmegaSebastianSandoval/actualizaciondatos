<?php

/**
*
*/
class Administracion_panelController extends Administracion_mainController
{
	public $botonpanel = 1;

	public function indexAction()
	{
		$this->getLayout()->setTitle("Panel Administrativo");
		$infoModel = new Administracion_Model_DbTable_Informacion();
		$this->_view->info = $infoModel->getList("","")[0];
		$logModel = new Administracion_Model_DbTable_Log();
		$this->_view->log = $logModel->getList(" log_tipo = 'LOGIN' "," log_fecha DESC LIMIT 10 ");
				if ($_SESSION['kt_login_level'] == 10) {
			header("Location: /administracion/solicitudes");
			exit();
		}
		if ($_SESSION['kt_login_level'] == 13) {
			header("Location: /administracion/solicitudes/");
			exit();
		}
		if ($_SESSION['kt_login_level'] == 14) {
			header("Location: /administracion/solicitudes/crear");
			exit();
		}
	}

}