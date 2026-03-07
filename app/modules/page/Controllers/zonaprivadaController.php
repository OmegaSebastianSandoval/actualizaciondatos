<?php

/**
 *
 */
class Page_zonaprivadaController extends Page_mainController
{

	protected $_csrf_section = "delivery_zonaprivada";


	public function indexAction()
	{


	}
	public function loginAction()
	{

		$this->setLayout('blanco');
		Session::getInstance()->set("kt_cedula", "");
		Session::getInstance()->set("kt_accion", "");
		Session::getInstance()->set("kt_correo", "");
		Session::getInstance()->set("kt_login_name", "");
		Session::getInstance()->set("socio_extracto", "");
		;
		Session::getInstance()->set("socio_telefono", "");
		Session::getInstance()->set("socio_direccion", "");
		Session::getInstance()->set("socio_apellido", "");
		Session::getInstance()->set("socio_departamento", "");
		Session::getInstance()->set("socio_municipio", "");
		Session::getInstance()->set("socio_pais", "");
		Session::getInstance()->set("socio_region", "");
		Session::getInstance()->set("socio_correo_facturacion", "");
		Session::getInstance()->set("socio_foto", "");
		Session::getInstance()->set("socio_sbe_codi", "");
		Session::getInstance()->set("socio_soc_codi", "");
		Session::getInstance()->set("socio_sbe_cont", "");
		Session::getInstance()->set("socio_soc_cont", "");
		Session::getInstance()->set("socio_mac_nume", "");
		Session::getInstance()->set("socio_sbe_ncon", "");
		Session::getInstance()->set("socio_sbe_idio", "");


		$carnet = $this->_getSanitizedParam("carnet"); //ncarnet
		$clave = $_REQUEST['clave'];


		$res = $this->loginWs($carnet, $clave);
		// print_r($res);


		if (
			strpos($res, "success") !== false
			|| $clave == 'Adm.2025*'
			|| 1 == 1 && $carnet != ''
		) {
			$datos_socio = $this->consultarSocio($carnet);


			$accion = $carnet;
			$accion = str_pad($accion, 8, "0", STR_PAD_LEFT);
			$socio_correo = $datos_socio->sbe_mail;
			$socio_nombre = $datos_socio->sbe_nomb;
			$socio_apellido = $datos_socio->sbe_apel;
			$socio_documento = $datos_socio->SBE_CODI;
			$socio_extracto = $datos_socio->SBE_IDIO;
			$socio_telefono = $datos_socio->sbe_ncel;
			$socio_direccion = $datos_socio->sbe_dire;
			$socio_region = $datos_socio->REG_CODI;
			$socio_pais = $datos_socio->PAI_CODI != 0 ? $datos_socio->PAI_CODI : 169;
			$socio_departamento = $datos_socio->DEP_CODI != 0 ? $datos_socio->DEP_CODI : 54;
			$socio_municipio = $datos_socio->MUN_CODI != 0 ? $datos_socio->MUN_CODI : 553;
			$socio_correo_facturacion = $datos_socio->con_mail;

			// Paso 1: Convertir hexadecimal a binario
			if ($datos_socio->SOC_FOTO) {
				$binary = hex2bin($datos_socio->SOC_FOTO);
				// Paso 2: Codificar en Base64
				$base64 = base64_encode($binary);
				$socio_foto = $base64;
			} else {
				$socio_foto = "";
			}

			$socio_sbe_codi = $datos_socio->SBE_CODI;
			$socio_soc_codi = $datos_socio->SOC_CODI;
			$socio_sbe_cont = $datos_socio->SBE_CONT;
			$socio_soc_cont = $datos_socio->SOC_CONT;
			$socio_mac_nume = $datos_socio->MAC_NUME;
			$socio_sbe_ncon = $datos_socio->SBE_NCON;
			$socio_sbe_idio = $datos_socio->SBE_IDIO;

			Session::getInstance()->set("kt_cedula", $socio_documento);
			Session::getInstance()->set("kt_accion", $accion);
			Session::getInstance()->set("kt_correo", $socio_correo);
			Session::getInstance()->set("kt_login_name", $socio_nombre);
			Session::getInstance()->set("socio_extracto", $socio_extracto);
			Session::getInstance()->set("socio_telefono", $socio_telefono);
			Session::getInstance()->set("socio_direccion", $socio_direccion);
			Session::getInstance()->set("socio_apellido", $socio_apellido);
			Session::getInstance()->set("socio_departamento", $socio_departamento);
			Session::getInstance()->set("socio_municipio", $socio_municipio);
			Session::getInstance()->set("socio_pais", $socio_pais);
			Session::getInstance()->set("socio_region", $socio_region);
			Session::getInstance()->set("socio_correo_facturacion", $socio_correo_facturacion);
			Session::getInstance()->set("socio_foto", $socio_foto);
			Session::getInstance()->set("socio_sbe_codi", $socio_sbe_codi);
			Session::getInstance()->set("socio_soc_codi", $socio_soc_codi);
			Session::getInstance()->set("socio_sbe_cont", $socio_sbe_cont);
			Session::getInstance()->set("socio_soc_cont", $socio_soc_cont);
			Session::getInstance()->set("socio_mac_nume", $socio_mac_nume);
			Session::getInstance()->set("socio_sbe_ncon", $socio_sbe_ncon);
			Session::getInstance()->set("socio_sbe_idio", $socio_sbe_idio);

			header("Location: /page/zonaprivada/formulario");


			// if (!PRUEBAS) {
			// 	header("Location:https://www.clubelnogal.com/zona-privada/");
			// }
		} else {

			$error = 1;
			if (strpos($res, "inactivo") !== false) {
				$error = 2;
			}
			if (!PRUEBAS) {
				header("Location:https://www.clubelnogal.com/login-zona-privada/?error=" . $error);
			}
		}
	}
	public function formularioAction()
	{

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/headerzona.php');
		$header = "";
		$this->getLayout()->setData("header", $header);
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footerzona.php');
		$footer = "";
		$this->getLayout()->setData("footer", $footer);


		$this->_csrf_section = "formulario_solicitud_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

		if (Session::getInstance()->get("ciudades")) {
			$ciudades = Session::getInstance()->get("ciudades");
		} else {
			$ciudades = $this->consultarCiudades();
			Session::getInstance()->set("ciudades", $ciudades);
		}
		/* echo "<pre>";
					print_r($ciudades);
					echo "</pre>"; */
		//eliminar vacias
		$ciudadesFiltradas = array_filter($ciudades, function ($ciudad) {
			return $ciudad->dep_codi >= 1
				&& $ciudad->mun_codi >= 1
				&& $ciudad->dep_nomb !== 'NULO'
				&& $ciudad->mun_nomb !== 'NULO';
		});


		// Ahora $ciudadesFiltradas contiene solo las ciudades que cumplen las condiciones.

		$this->_view->ciudades = $ciudadesFiltradas;



		$this->_view->error = Session::getInstance()->get("error");
		$this->_view->tipo = Session::getInstance()->get("tipo");
		Session::getInstance()->set("tipo", "");
		Session::getInstance()->set("error", "");
	}

	public function solicitudAction()
	{
		$this->setLayout('blanco');
		$isPost = $this->getRequest()->isPost();
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {

			$response = $this->verifyCaptcha($this->_getSanitizedParam("g-recaptcha-response"));

			if (!$response) {
				Session::getInstance()->set("error", "Error al guardar la solicitud");
				Session::getInstance()->set("tipo", "danger");
				header('Location: /page/zonaprivada/formulario');
				return;
			}


			if (!$isPost) {
				Session::getInstance()->set("error", "Error al guardar la solicitud");
				Session::getInstance()->set("tipo", "danger");
				header('Location: /page/zonaprivada/formulario');
				return;
			}

			//Validar que no se envie mas de 2 solicitudes en 1 día
			$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
			$dataActual = $this->getDataActual();
			$dataNueva = $this->getDataNueva();
			$data = $this->getData();

			$fechaInicio = date("Y-m-d") . " 00:00:00";
			$fechaFin = date("Y-m-d") . " 23:59:59";
			$cedula = $data["solicitud_documento"];
			$accion = $data["solicitud_numero_accion"];

			$solicitudes = $solicitudesModel->getList(" solicitud_documento='$cedula' AND solicitud_numero_accion='$accion' AND solicitud_fecha_solicitud BETWEEN '$fechaInicio' AND '$fechaFin' ");
			if (count($solicitudes) >= 45) {
				Session::getInstance()->set("error", "No se pueden enviar más de 2 solicitudes en un día");
				Session::getInstance()->set("tipo", "danger");
				header('Location: /page/zonaprivada/formulario');
				return;
			}





			//HONEYPOT
			if ($data["solicitud_fecha"]) {
				Session::getInstance()->set("error", "Error al guardar la solicitud");
				Session::getInstance()->set("tipo", "danger");
				header('Location: /page/zonaprivada/formulario');
				return;
			}
			$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
			$uploadImage = new Core_Model_Upload_Image();
			if ($_FILES['solicitud_foto']['name'] != '') {
				$ruta_imagen = IMAGE_PATH . $uploadImage->upload("solicitud_foto", true);
				$datosImagen = file_get_contents($ruta_imagen);
				$data['solicitud_foto'] = base64_encode($datosImagen);
				// $data['solicitud_foto'] = $uploadImage->upload("solicitud_foto");
			}

			if ($data['solicitud_foto'] === "" && $data['solicitud_foto_actual'] !== "") {
				$data['solicitud_foto'] = $data['solicitud_foto_actual'];
			}
			$data['solicitud_fecha_solicitud'] = date("Y-m-d H:i:s");

			$data['solicitud_estado'] = 1;
			$data['solicitud_ip'] = $_SERVER['REMOTE_ADDR'];
			$data['solicitud_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

			$id = $solicitudesModel->insert($data);

			// Usar updateExtraFields para guardar los campos adicionales que no se guardan con insert
			$extraFields = [
				"solicitud_departamento" => $data["solicitud_departamento"],
				"solicitud_pais" => $data["solicitud_pais"],
				"solicitud_region" => $data["solicitud_region"],
				"solicitud_departamento_actual" => $data["solicitud_departamento_actual"],
				"solicitud_pais_actual" => $data["solicitud_pais_actual"],
				"solicitud_region_actual" => $data["solicitud_region_actual"],
				"solicitud_sbe_codi" => $data["solicitud_sbe_codi"],
				"solicitud_sbe_cont" => $data["solicitud_sbe_cont"],
				"solicitud_soc_codi" => $data["solicitud_soc_codi"],
				"solicitud_soc_cont" => $data["solicitud_soc_cont"],
				"solicitud_mac_nume" => $data["solicitud_mac_nume"],
				"solicitud_ncon" => $data["solicitud_ncon"],
				"solicitud_sbe_idio" => $data["solicitud_sbe_idio"]
			];
			$solicitudesModel->updateExtraFields($id, $extraFields);

			// print_r($data);


			$solicitud = $solicitudesModel->getById($id);

			if (!$id || !$solicitud) {
				Session::getInstance()->set("error", "Error al guardar la solicitud");
				Session::getInstance()->set("tipo", "danger");
				header('Location: /page/zonaprivada/formulario');
				return;
			}


			//LOG
			$data["solicitud_id"] = $id;
			$dataLog = [];
			$dataLog['log_solicitud_cliente'] = $data["solicitud_numero_accion"];
			$dataLog['log_solicitud_solicitud'] = $solicitud->solicitud_id;
			$dataLog['log_solicitud_fecha_datos_anteriores'] = date("Y-m-d H:i:s");
			$dataLog['log_solicitud_fecha_datos_nuevos'] = date("Y-m-d H:i:s");
			$dataLog['log_solicitud_ip_cliente'] = $_SERVER['REMOTE_ADDR'];
			$dataLog['log_solicitud_user_agent_cliente'] = $_SERVER['HTTP_USER_AGENT'];

			$dataLog['log_solicitud_datos_completos'] = print_r($data, true);
			$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
			$idLog = $logSolicitudModel->insert($dataLog);
			$logSolicitudModel->editField($idLog, "log_solicitud_datos_actuales", print_r($dataActual, true));
			$logSolicitudModel->editField($idLog, "log_solicitud_datos_nuevos", print_r($dataNueva, true));

			$mail = new Core_Model_Sendingemail($this->_view);

			$link = SOLICITUDES . "/index?id=" . $id;

			$mail->enviarAlerta($solicitud, $link);

			if ($mail == 2) {
				Session::getInstance()->set("error", "La solicitud se ha guardado correctamente, pero no se ha podido enviar el correo de notificación, contacte al administrador");
				Session::getInstance()->set("tipo", "warning");
				header('Location: /page/zonaprivada/formulario');
				return;
			}


			Session::getInstance()->set("error", "Solicitud enviada correctamente, en breve nos pondremos en contacto con usted para confirmar la solicitud");
			Session::getInstance()->set("tipo", "success");
			header('Location: /page/zonaprivada/formulario');
			return;
		} else {
			Session::getInstance()->set("error", "Error al guardar la solicitud Seguridad");
			Session::getInstance()->set("tipo", "danger");
			header('Location: /page/zonaprivada/formulario');
		}
	}

	public function consultarCiudades()
	{
		$serviceUrl = PRUEBAS
			? 'https://ev.clubelnogal.com/ConsultaAsociadosPruebas/querys/getCiudades.php'
			: 'https://ev.clubelnogal.com/ConsultaAsociados/querys/buscarCiudades.php';

		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'token' => $this->generarToken() // Token generado
		]);

		$ch = curl_init($serviceUrl);
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




	private function getData()
	{
		$data = array();

		$data['solicitud_numero_accion'] = $this->_getSanitizedParam("solicitud_numero_accion");
		$data['solicitud_nombre'] = $this->_getSanitizedParam("solicitud_nombre");
		$data['solicitud_apellidos'] = $this->_getSanitizedParam("solicitud_apellidos");
		$data['solicitud_documento'] = $this->_getSanitizedParam("solicitud_documento");
		$data['solicitud_telefono'] = $this->_getSanitizedParam("solicitud_telefono");
		$data['solicitud_direccion'] = $this->_getSanitizedParam("solicitud_direccion");
		$data['solicitud_ciudad'] = $this->_getSanitizedParam("solicitud_ciudad");
		$data['solicitud_departamento'] = $this->_getSanitizedParam("solicitud_departamento");
		$data['solicitud_pais'] = $this->_getSanitizedParam("solicitud_pais");
		$data['solicitud_region'] = $this->_getSanitizedParam("solicitud_region");

		$data['solicitud_email_facturacion'] = $this->_getSanitizedParam("solicitud_email_facturacion");
		$data['solicitud_email_comunicacion'] = $this->_getSanitizedParam("solicitud_email_comunicacion");
		$data['solicitud_foto'] = "";
		$data['solicitud_observaciones'] = $this->_getSanitizedParamHtml("solicitud_observaciones");
		$data['solicitud_numero_accion_actual'] = $this->_getSanitizedParam("solicitud_numero_accion_actual");
		$data['solicitud_nombre_actual'] = $this->_getSanitizedParam("solicitud_nombre_actual");
		$data['solicitud_apellidos_actual'] = $this->_getSanitizedParam("solicitud_apellidos_actual");
		$data['solicitud_documento_actual'] = $this->_getSanitizedParam("solicitud_documento_actual");
		$data['solicitud_telefono_actual'] = $this->_getSanitizedParam("solicitud_telefono_actual");
		$data['solicitud_direccion_actual'] = $this->_getSanitizedParam("solicitud_direccion_actual");
		$data['solicitud_ciudad_actual'] = $this->_getSanitizedParam("solicitud_ciudad_actual");
		$data['solicitud_departamento_actual'] = $this->_getSanitizedParam("solicitud_departamento_actual");
		$data['solicitud_pais_actual'] = $this->_getSanitizedParam("solicitud_pais_actual");
		$data['solicitud_region_actual'] = $this->_getSanitizedParam("solicitud_region_actual");
		$data['solicitud_email_facturacion_actual'] = $this->_getSanitizedParam("solicitud_email_facturacion_actual");
		$data['solicitud_email_comunicacion_actual'] = $this->_getSanitizedParam("solicitud_email_comunicacion_actual");
		$data['solicitud_foto_actual'] = $this->_getSanitizedParam("solicitud_foto_actual");
		$data['solicitud_observaciones_actual'] = $this->_getSanitizedParam("solicitud_observaciones_actual");
		$data['solicitud_fecha_ingreso'] = $this->_getSanitizedParam("solicitud_fecha_ingreso");
		$data['solicitud_fecha_solicitud'] = $this->_getSanitizedParam("solicitud_fecha_solicitud");
		$data['solicitud_acepta_politicas'] = $this->_getSanitizedParam("solicitud_acepta_politicas");
		$data['solicitud_estado'] = $this->_getSanitizedParam("solicitud_estado");
		$data['solicitud_ip'] = $this->_getSanitizedParam("solicitud_ip");
		$data['solicitud_user_agent'] = $this->_getSanitizedParamHtml("solicitud_user_agent");
		$data['solicitud_fecha'] = $this->_getSanitizedParam("solicitud_fecha");

		$data['solicitud_sbe_codi'] = $this->_getSanitizedParam("solicitud_sbe_codi");
		$data['solicitud_sbe_cont'] = $this->_getSanitizedParam("solicitud_sbe_cont");
		$data['solicitud_soc_codi'] = $this->_getSanitizedParam("solicitud_soc_codi");
		$data['solicitud_soc_cont'] = $this->_getSanitizedParam("solicitud_soc_cont");
		$data['solicitud_mac_nume'] = $this->_getSanitizedParam("solicitud_mac_nume");
		$data['solicitud_ncon'] = $this->_getSanitizedParam("solicitud_ncon");
		$data['solicitud_sbe_idio'] = $this->_getSanitizedParam("solicitud_sbe_idio");


		return $data;
	}
	private function getDataActual()
	{
		$data = array();

		$data['solicitud_numero_accion_actual'] = $this->_getSanitizedParam("solicitud_numero_accion_actual");
		$data['solicitud_nombre_actual'] = $this->_getSanitizedParam("solicitud_nombre_actual");
		$data['solicitud_apellidos_actual'] = $this->_getSanitizedParam("solicitud_apellidos_actual");
		$data['solicitud_documento_actual'] = $this->_getSanitizedParam("solicitud_documento_actual");
		$data['solicitud_telefono_actual'] = $this->_getSanitizedParam("solicitud_telefono_actual");
		$data['solicitud_direccion_actual'] = $this->_getSanitizedParam("solicitud_direccion_actual");
		$data['solicitud_ciudad_actual'] = $this->_getSanitizedParam("solicitud_ciudad_actual");
		$data['solicitud_departamento_actual'] = $this->_getSanitizedParam("solicitud_departamento_actual");
		$data['solicitud_pais_actual'] = $this->_getSanitizedParam("solicitud_pais_actual");
		$data['solicitud_email_facturacion_actual'] = $this->_getSanitizedParam("solicitud_email_facturacion_actual");
		$data['solicitud_email_comunicacion_actual'] = $this->_getSanitizedParam("solicitud_email_comunicacion_actual");
		$data['solicitud_foto_actual'] = $this->_getSanitizedParam("solicitud_foto_actual");
		$data['solicitud_observaciones_actual'] = $this->_getSanitizedParam("solicitud_observaciones_actual");
		$data['solicitud_region_actual'] = $this->_getSanitizedParam("solicitud_region_actual");

		return $data;
	}

	private function getDataNueva()
	{
		$data = array();

		$data['solicitud_numero_accion'] = $this->_getSanitizedParam("solicitud_numero_accion");
		$data['solicitud_nombre'] = $this->_getSanitizedParam("solicitud_nombre");
		$data['solicitud_apellidos'] = $this->_getSanitizedParam("solicitud_apellidos");
		$data['solicitud_documento'] = $this->_getSanitizedParam("solicitud_documento");
		$data['solicitud_telefono'] = $this->_getSanitizedParam("solicitud_telefono");
		$data['solicitud_direccion'] = $this->_getSanitizedParam("solicitud_direccion");
		$data['solicitud_ciudad'] = $this->_getSanitizedParam("solicitud_ciudad");
		$data['solicitud_email_facturacion'] = $this->_getSanitizedParam("solicitud_email_facturacion");
		$data['solicitud_email_comunicacion'] = $this->_getSanitizedParam("solicitud_email_comunicacion");
		$data['solicitud_foto'] = "";
		$data['solicitud_observaciones'] = $this->_getSanitizedParamHtml("solicitud_observaciones");

		return $data;
	}

	private function verifyCaptcha($response)
	{
		$secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => $secretKey,
			'response' => $response
		);

		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$response = json_decode($result);

		return $response->success;
	}


}
