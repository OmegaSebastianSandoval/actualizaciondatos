<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

	public function indexAction()
	{
		
	}



	public function actualizacionAction()
	{
		// Agregar headers de seguridad
		// header("X-Frame-Options: DENY");
		// header("X-Content-Type-Options: nosniff");
		// header("X-XSS-Protection: 1; mode=block");
		// header("Referrer-Policy: strict-origin-when-cross-origin");

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/headerzona.php');
		$this->getLayout()->setData("header", $header);
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footerzona.php');
		$this->getLayout()->setData("footer", $footer);
		$this->_csrf_section = "formulario_actualizacion_public_" . bin2hex(random_bytes(16));
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		// Session::getInstance()->set("ciudades", null);
		// Obtener ciudades
		if (Session::getInstance()->get("ciudades")) {
			$ciudades = Session::getInstance()->get("ciudades");
		} else {
			$ciudades = $this->consultarCiudades();
			Session::getInstance()->set("ciudades", $ciudades);
		}


		// // Filtrar ciudades vacías
		$ciudadesFiltradas = array_filter($ciudades, function ($ciudad) {
			return $ciudad->dep_codi >= 1
				&& $ciudad->mun_codi >= 1
				&& $ciudad->dep_nomb !== 'NULO'
				&& $ciudad->mun_nomb !== 'NULO';
		});


		$this->_view->ciudades = $ciudadesFiltradas;

		// Mensajes de error o éxito
		$this->_view->error = Session::getInstance()->get("error");
		$this->_view->tipo = Session::getInstance()->get("tipo");
		Session::getInstance()->set("tipo", "");
		Session::getInstance()->set("error", "");
	}

	public function verificar_carnetAction()
	{
		$this->setLayout('blanco');
		header('Content-Type: application/json');
		ob_clean();
		$carnet = $this->_getSanitizedParam("carnet");
		$documento = $this->_getSanitizedParam("documento");

		if (empty($carnet)) {
			echo json_encode(['success' => false, 'message' => 'Debe ingresar el número de carnet']);
			return;
		}

		// Validar longitud de carnet (entre 3 y 20 dígitos)
		if (strlen($carnet) < 3 || strlen($carnet) > 20 || !ctype_digit($carnet)) {
			echo json_encode(['success' => false, 'message' => 'El número de carnet no es válido']);
			return;
		}

		// Validar longitud de documento si está presente (entre 5 y 20 dígitos)
		if (!empty($documento) && (strlen($documento) < 4 || strlen($documento) > 20)) {
			echo json_encode(['success' => false, 'message' => 'El número de documento no es válido']);
			return;
		}

		try {
			$response = $this->consultar_Socio($carnet);
			if (!$response || (is_array($response) && count($response) == 0) || $response->mensaje === 'No encontrado') {
				echo json_encode(['success' => false, 'message' => 'No se encontró el socio con el carnet ingresado']);
				return;
			}

			if (is_object($response)) {
				$socio = $response;
			}

			// Si se envi el documento, validar que coincida con SBE_CODI
			if (!empty($documento)) {
				$sbe_codi = $socio->SBE_CODI ?? '';

				if ($documento !== $sbe_codi) {
					echo json_encode([
						'success' => false,
						'message' => 'El documento no coincide con el carnet ingresado',
						'carnet_verificado' => true
					]);
					return;
				}
			}

			// Guardar TODOS los datos del socio en sesión del lado del servidor
			$datosSesion = [
				'solicitud_numero_accion_actual' => $carnet,
				'solicitud_nombre_actual' => $socio->sbe_nomb ?? '',
				'solicitud_apellidos_actual' => $socio->sbe_apel ?? '',
				'solicitud_documento_actual' => $socio->SBE_CODI ?? '',
				'solicitud_telefono_actual' => $socio->sbe_ncel ?? '',
				'solicitud_direccion_actual' => $socio->sbe_dire ?? '',
				'solicitud_ciudad_actual' => $socio->MUN_CODI ?? '',
				'solicitud_departamento_actual' => $socio->DEP_CODI ?? '',
				'solicitud_pais_actual' => $socio->PAI_CODI ?? '',
				'solicitud_region_actual' => $socio->REG_CODI ?? '',
				'solicitud_email_facturacion_actual' => $socio->sbe_mail ?? '',
				'solicitud_email_comunicacion_actual' => $socio->con_mail ?? '',
				'solicitud_foto_actual' => $socio->SOC_FOTO ?? '',
				'solicitud_sbe_codi' => $socio->SBE_CODI ?? '',
				'solicitud_sbe_cont' => $socio->SBE_CONT ?? '',
				'solicitud_soc_codi' => $socio->SOC_CODI ?? '',
				'solicitud_soc_cont' => $socio->SOC_CONT ?? '',
				'solicitud_mac_nume' => $socio->MAC_NUME ?? '',
				'solicitud_ncon' => $socio->SBE_NCON ?? '',
				'solicitud_sbe_idio' => $socio->SBE_IDIO ?? '',
				'timestamp' => time(),
				'expires' => time() + 1800,
				'integrity_hash' => hash_hmac('sha256', ($socio->SBE_CODI ?? '') . $carnet, session_id())
			];

			// Guardar en sesión
			Session::getInstance()->set('datosActualesSocio', $datosSesion);

			// Enviar al frontend SOLO los datos necesarios para validación
			$datosSocio = [
				'success' => true,
				'carnet_verificado' => true,
				'documento_verificado' => !empty($documento),
				'socio' => [
					'numero_carnet' => $carnet,
					'SBE_CODI' => $socio->SBE_CODI ?? '',
					'sbe_nomb' => $socio->sbe_nomb ?? '',
					'sbe_apel' => $socio->sbe_apel ?? '',
					'sbe_mail' => $socio->sbe_mail ?? '',
					'con_mail' => $socio->con_mail ?? '',
					'sbe_tele' => $socio->sbe_ncel ?? '',
					'sbe_dire' => $socio->sbe_dire ?? '',
					'ciu_codi' => $socio->MUN_CODI ?? '',
					'soc_foto' => $socio->SOC_FOTO ?? '',
					'dep_codi' => $socio->DEP_CODI ?? '',
					'pai_codi' => $socio->PAI_CODI ?? '',
					'reg_codi' => $socio->REG_CODI ?? '',
				]
			];

			echo json_encode($datosSocio);
			return;
		} catch (Exception $e) {
			// Log del error para debugging interno
			error_log('Error verificar_carnet: ' . $e->getMessage() . ' - Line: ' . $e->getLine());
			// Mensaje genérico al usuario
			echo json_encode(['success' => false, 'message' => 'Error al consultar el socio. Por favor intente nuevamente']);
			return;
		}
	}

	public function guardar_actualizacionAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$fuente = $this->_getSanitizedParam("solicitud_source");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] != $csrf) {
			Session::getInstance()->set("error", "Error de seguridad. Token CSRF inválido");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Verificar captcha
		$response = $this->verifyCaptcha($this->_getSanitizedParam("g-recaptcha-response"));
		if (!$response) {
			Session::getInstance()->set("error", "Error en la verificación del captcha");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Honeypot validation
		$honeypot = $this->_getSanitizedParam("solicitud_fecha");
		if (!empty($honeypot)) {
			Session::getInstance()->set("error", "Error al procesar la solicitud");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar que el carnet exista
		$carnet = $this->_getSanitizedParam("solicitud_numero_accion");
		if (empty($carnet)) {
			Session::getInstance()->set("error", "Debe verificar el número de carnet antes de enviar la solicitud");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Obtener documento desde sesin (más seguro)
		$datosActuales = Session::getInstance()->get('datosActualesSocio');
		$cedula = $datosActuales['solicitud_documento_actual'] ?? '';

		// Validar que existen datos en sesión
		if (empty($datosActuales)) {
			Session::getInstance()->set("error", "No se encontraron datos de verificación. Por favor verifique nuevamente");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar expiracin de la sesión (prevenir replay attacks)
		if (!isset($datosActuales['expires']) || time() > $datosActuales['expires']) {
			Session::getInstance()->set("error", "La sesión ha expirado. Por favor verifique sus datos nuevamente");
			Session::getInstance()->set("tipo", "danger");
			Session::getInstance()->set('datosActualesSocio', null);
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar que el documento del formulario coincida con el de sesión
		$documentoForm = $this->_getSanitizedParam("solicitud_documento");
		if ($documentoForm !== $cedula) {
			Session::getInstance()->set("error", "El documento no coincide con los datos verificados");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Verificar integridad de los datos de sesión
		$expectedHash = hash_hmac('sha256', $cedula . $carnet, session_id());
		if (!isset($datosActuales['integrity_hash']) || $datosActuales['integrity_hash'] !== $expectedHash) {
			Session::getInstance()->set("error", "Los datos de sesión han sido alterados. Por favor verifique nuevamente");
			Session::getInstance()->set("tipo", "danger");
			Session::getInstance()->set('datosActualesSocio', null);
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar que el carnet no haya cambiado
		if ($carnet !== $datosActuales['solicitud_numero_accion_actual']) {
			Session::getInstance()->set("error", "El número de carnet no coincide con los datos verificados");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar límite de solicitudes por día
		$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
		$fechaInicio = date("Y-m-d") . " 00:00:00";
		$fechaFin = date("Y-m-d") . " 23:59:59";

		$solicitudes = $solicitudesModel->getList(" solicitud_documento_actual='$cedula' AND solicitud_numero_accion='$carnet' AND solicitud_fecha_solicitud BETWEEN '$fechaInicio' AND '$fechaFin' ");

		if (count($solicitudes) >= 15) {
			Session::getInstance()->set("error", "No se pueden enviar más de 10 solicitudes en un día");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		// Validar límite de solicitudes por IP (prevenir ataques distribuidos)
		$ip = $_SERVER['REMOTE_ADDR'];
		$solicitudesPorIP = $solicitudesModel->getList(" solicitud_ip='$ip' AND solicitud_fecha_solicitud BETWEEN '$fechaInicio' AND '$fechaFin' ");

		if (count($solicitudesPorIP) >= 15) {
			Session::getInstance()->set("error", "Demasiadas solicitudes desde esta conexión. Por favor intente más tarde");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}

		try {
			// Verificar que existan datos en sesión
			if (!Session::getInstance()->get('datosActualesSocio')) {
				Session::getInstance()->set("error", "No se encontraron datos del socio en sesión");
				Session::getInstance()->set("tipo", "danger");
				if ($fuente == 'actualizacion_publica') {
					header('Location: /page/index/actualizacionpublica');
				} else {
					header('Location: /page/index/actualizacion');
				}
				return;
			}

			// Preparar datos
			$data = $this->getDataActualizacion();

			// Subir imagen si existe
			$uploadImage = new Core_Model_Upload_Image();
			if ($_FILES['solicitud_foto']['name'] != '') {
				// Validar MIME type real del archivo
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mimeType = finfo_file($finfo, $_FILES['solicitud_foto']['tmp_name']);
				finfo_close($finfo);

				$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
				if (!in_array($mimeType, $allowedTypes)) {
					Session::getInstance()->set("error", "Tipo de archivo no permitido. Solo se aceptan imágenes JPG y PNG");
					Session::getInstance()->set("tipo", "danger");
					if ($fuente == 'actualizacion_publica') {
						header('Location: /page/index/actualizacionpublica');
					} else {
						header('Location: /page/index/actualizacion');
					}
					return;
				}

				// Validar tamaño (máximo 5MB)
				if ($_FILES['solicitud_foto']['size'] > 5242880) {
					Session::getInstance()->set("error", "El archivo es demasiado grande (máximo 5MB)");
					Session::getInstance()->set("tipo", "danger");
					if ($fuente == 'actualizacion_publica') {
						header('Location: /page/index/actualizacionpublica');
					} else {
						header('Location: /page/index/actualizacion');
					}
					return;
				}

				$ruta_imagen = IMAGE_PATH . $uploadImage->upload("solicitud_foto", true);
				$datosImagen = file_get_contents($ruta_imagen);
				$data['solicitud_foto'] = base64_encode($datosImagen);
			}

			// Si no subió imagen nueva, usar la de sesión
			$datosActuales = Session::getInstance()->get('datosActualesSocio');
			if ($data['solicitud_foto'] === "" && !empty($datosActuales['solicitud_foto_actual'])) {
				$data['solicitud_foto'] = $datosActuales['solicitud_foto_actual'];
			}

			// Normalizar a base64 estándar para guardar en DB (evita guardar hexadecimal tipo ffd8...)
			$data['solicitud_foto'] = $this->normalizarFotoBase64($data['solicitud_foto']);

			$data['solicitud_fecha_solicitud'] = date("Y-m-d H:i:s");
			$data['solicitud_estado'] = 1; // Pendiente
			$data['solicitud_ip'] = $_SERVER['REMOTE_ADDR'];
			$data['solicitud_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

			// Insertar solicitud
			$id = $solicitudesModel->insert($data);

			// Guardar campos adicionales
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

			$solicitud = $solicitudesModel->getById($id);

			if (!$id || !$solicitud) {
				Session::getInstance()->set("error", "Error al guardar la solicitud");
				Session::getInstance()->set("tipo", "danger");
				if ($fuente == 'actualizacion_publica') {
					header('Location: /page/index/actualizacionpublica');
				} else {
					header('Location: /page/index/actualizacion');
				}
				return;
			}

			// LOG
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

			// Enviar correo de notificacin
			$mail = new Core_Model_Sendingemail($this->_view);
			$link = SOLICITUDES . "/index?id=" . $id;
			$mail->enviarAlerta($solicitud, $link);

			Session::getInstance()->set("error", "Solicitud enviada correctamente. En breve nos pondremos en contacto con usted para confirmar la actualización de datos");
			Session::getInstance()->set("tipo", "success");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		} catch (Exception $e) {
			// Log del error para debugging interno
			error_log('Error guardar_actualizacion: ' . $e->getMessage() . ' - Line: ' . $e->getLine() . ' - File: ' . $e->getFile());
			// Mensaje genérico al usuario
			Session::getInstance()->set("error", "Error al procesar la solicitud. Por favor intente nuevamente o contacte al administrador");
			Session::getInstance()->set("tipo", "danger");
			if ($fuente == 'actualizacion_publica') {
				header('Location: /page/index/actualizacionpublica');
			} else {
				header('Location: /page/index/actualizacion');
			}
			return;
		}
	}

	private function getDataActualizacion()
	{
		$data = [];

		// Datos nuevos (del formulario)
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
		$data['solicitud_foto'] = $this->_getSanitizedParam("solicitud_foto_base64");
		$data['solicitud_observaciones'] = $this->_getSanitizedParam("solicitud_observaciones");

		// Datos actuales (desde sesión - más seguro)
		$datosActuales = Session::getInstance()->get('datosActualesSocio');
		$data['solicitud_numero_accion_actual'] = $datosActuales['solicitud_numero_accion_actual'] ?? '';
		$data['solicitud_nombre_actual'] = $datosActuales['solicitud_nombre_actual'] ?? '';
		$data['solicitud_apellidos_actual'] = $datosActuales['solicitud_apellidos_actual'] ?? '';
		$data['solicitud_documento_actual'] = $datosActuales['solicitud_documento_actual'] ?? '';
		$data['solicitud_telefono_actual'] = $datosActuales['solicitud_telefono_actual'] ?? '';
		$data['solicitud_direccion_actual'] = $datosActuales['solicitud_direccion_actual'] ?? '';
		$data['solicitud_ciudad_actual'] = $datosActuales['solicitud_ciudad_actual'] ?? '';
		$data['solicitud_departamento_actual'] = $datosActuales['solicitud_departamento_actual'] ?? '';
		$data['solicitud_pais_actual'] = $datosActuales['solicitud_pais_actual'] ?? '';
		$data['solicitud_region_actual'] = $datosActuales['solicitud_region_actual'] ?? '';
		$data['solicitud_email_facturacion_actual'] = $datosActuales['solicitud_email_facturacion_actual'] ?? '';
		$data['solicitud_email_comunicacion_actual'] = $datosActuales['solicitud_email_comunicacion_actual'] ?? '';
		$data['solicitud_foto_actual'] = $datosActuales['solicitud_foto_actual'] ?? '';
		$data['solicitud_observaciones_actual'] = $datosActuales['solicitud_observaciones_actual'] ?? '';

		// Campos adicionales (desde sesión)
		$data['solicitud_sbe_codi'] = $datosActuales['solicitud_sbe_codi'] ?? '';
		$data['solicitud_sbe_cont'] = $datosActuales['solicitud_sbe_cont'] ?? '';
		$data['solicitud_soc_codi'] = $datosActuales['solicitud_soc_codi'] ?? '';
		$data['solicitud_soc_cont'] = $datosActuales['solicitud_soc_cont'] ?? '';
		$data['solicitud_mac_nume'] = $datosActuales['solicitud_mac_nume'] ?? '';
		$data['solicitud_ncon'] = $datosActuales['solicitud_ncon'] ?? '';
		$data['solicitud_sbe_idio'] = $datosActuales['solicitud_sbe_idio'] ?? '';

		$data['solicitud_fecha_ingreso'] = date("Y-m-d H:i:s");
		$data['solicitud_acepta_politicas'] = $this->_getSanitizedParam("solicitud_acepta_politicas") ? 1 : 0;
		$data['solicitud_declara_titular'] = $this->_getSanitizedParam("solicitud_declara_titular") ? 1 : 0;
		$data['solicitud_usuario'] = 0;
		$data['solicitud_usuario_ip'] = '';
		$data['solicitud_usuario_user_agent'] = '';

		$data['solicitud_source'] = $this->_getSanitizedParam("solicitud_source");

		return $data;
	}

	private function verifyCaptcha($response)
	{
		if (empty($response)) {
			return false;
		}

		$secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';
		$url = 'https://www.google.com/recaptcha/api/siteverify';

		$data = [
			'secret' => $secretKey,
			'response' => $response,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$options = [
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			]
		];

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$resultJson = json_decode($result);

		return $resultJson->success;
	}

	private function normalizarFotoBase64($valor)
	{
		if (empty($valor)) {
			return '';
		}

		$foto = trim((string) $valor);

		// Si llega como data URL, extraer solo la parte base64
		if (strpos($foto, 'data:image') === 0) {
			$partes = explode(',', $foto, 2);
			$foto = isset($partes[1]) ? $partes[1] : '';
		}

		$foto = preg_replace('/\s+/', '', $foto);

		// Si viene en hexadecimal (SOC_FOTO), convertir a base64
		if ($foto !== '' && ctype_xdigit($foto) && strlen($foto) % 2 === 0) {
			$binario = @hex2bin($foto);
			if ($binario !== false) {
				return base64_encode($binario);
			}
		}

		return $foto;
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

	public function consultar_Socio($ncar)
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


	public function actualizacionpublicaAction()
	{

	
		$this->_csrf_section = "formulario_actualizacion_public_" . bin2hex(random_bytes(16));
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		// Session::getInstance()->set("ciudades", null);
		// Obtener ciudades
		if (Session::getInstance()->get("ciudades")) {
			$ciudades = Session::getInstance()->get("ciudades");
		} else {
			$ciudades = $this->consultarCiudades();
			Session::getInstance()->set("ciudades", $ciudades);
		}


		// // Filtrar ciudades vacías
		$ciudadesFiltradas = array_filter($ciudades, function ($ciudad) {
			return $ciudad->dep_codi >= 1
				&& $ciudad->mun_codi >= 1
				&& $ciudad->dep_nomb !== 'NULO'
				&& $ciudad->mun_nomb !== 'NULO';
		});

		
		
		$this->_view->ciudades = $ciudadesFiltradas;
		

		$this->_view->error = Session::getInstance()->get("error");
		$this->_view->tipo = Session::getInstance()->get("tipo");
		Session::getInstance()->set("tipo", "");
		Session::getInstance()->set("error", "");
	}
}
