<?php

/**
 *
 */

class Page_mainController extends Controllers_Abstract
{

	public $template;
	public $editarpage = 0;
	public function init()
	{
		$this->setLayout('page_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();
		$this->_view->infopage = $infopageModel->getById(1);


		$this->getLayout()->setData("metadescription", $this->_view->infopage->info_pagina_descripcion);
		$this->getLayout()->setData("metakeywords", $this->_view->infopage->info_pagina_tags);
		$this->getLayout()->setData("info_pagina_scripts", $this->_view->infopage->info_pagina_scripts);

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);
		$this->usuario();

	}
	public function consultarSocio($ncar)
	{


		$loginServiceUrl = PRUEBAS
			? 'https://ev.clubelnogal.com/ConsultaAsociadosPruebas/querys/buscarUsuarioConInactivos.php'
			: 'https://ev.clubelnogal.com/ConsultaAsociados/querys/buscarUsuarioZonaPrivadaConInactivos.php';

		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'token' => $this->generarToken(), //tken que recibe de la base de
			// 'codi' => $codi,
			'ncar' => $ncar
		]);

		$ch = curl_init($loginServiceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


		$response = curl_exec($ch);
		$response = json_decode($response);

		if (curl_errno($ch)) {
			echo 'Error cURL: ' . curl_error($ch);
			exit;
		}
		curl_close($ch);
		return $response;
	}
	public function generarToken()
	{




		$loginServiceUrl = 'https://ev.clubelnogal.com/tokens/querys/consultar_token.php';
		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'inputUsername' => 'webnogal', //tken que recibe de la base de
			'inputPassword' => 'nogal2023*'
		]);

		$ch = curl_init($loginServiceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($ch);
		$response = json_decode($response);

		if (curl_errno($ch)) {
			echo 'Error cURL (token): ' . curl_error($ch);
			exit;
		}

		curl_close($ch);
		/* echo "<pre>";
							print_r($response);
							echo "</pre>"; */
		// return $response;

		return PRUEBAS ? "naxquJ6KkSJU5F8w2qq3W08NJBe6vQDc" : $response->token;
	}
	public function loginWs($cedula, $clave)
	{
		$loginServiceUrl = PRUEBAS
			? 'https://ev.clubelnogal.com/iniciosesionPruebas/querys/loginPassword.php'
			: 'https://ev.clubelnogal.com/iniciosesion/querys/loginPassword.php';

		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'token' => $this->generarToken(), //token que recibe de la base de
			'user' => $cedula,
			'pass' => $clave,
		]);

		$ch = curl_init($loginServiceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo 'Error cURL: ' . curl_error($ch);
			exit;
		}

		curl_close($ch);
		return $response;
	}
	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
	}


}
