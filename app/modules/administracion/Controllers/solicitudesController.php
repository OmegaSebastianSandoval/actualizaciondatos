<?php

/**
 * Controlador de Solicitudes que permite la  creacion, edicion  y eliminacion de los solicitud del Sistema
 */
class Administracion_solicitudesController extends Administracion_mainController
{
	public $botonpanel = 17;

	/**
	 * $mainModel  instancia del modelo de  base de datos solicitud
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_solicitudes";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador solicitudes .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Solicitudes();
		$this->namefilter = "parametersfiltersolicitudes";
		$this->route = "/administracion/solicitudes";
		$this->namepages = "pages_solicitudes";
		$this->namepageactual = "page_actual_solicitudes";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		ini_set('memory_limit', '512M');
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  solicitud con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		if ($_SESSION['kt_login_level'] == 14) {
			header('Location: /administracion/solicitudes/crear');
			exit;
		}
		$title = "Administración de solicitud";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " solicitud_estado ASC, solicitud_fecha_solicitud DESC";
		$list = $this->mainModel->getList($filters, $order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
			$page = Session::getInstance()->get($this->namepageactual);
			$start = ($page - 1) * $amount;
		} else if (!$page) {
			$start = 0;
			$page = 1;
			Session::getInstance()->set($this->namepageactual, $page);
		} else {
			Session::getInstance()->set($this->namepageactual, $page);
			$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list) / $amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->list_solicitud_estado = $this->getSolicitudestado();

		$this->_view->error = Session::getInstance()->get("error");
		$this->_view->tipo_error = Session::getInstance()->get("tipo_error");
		$response = Session::getInstance()->get("response");
		if ($response) {
			$this->_view->response = json_decode($response);
		}
		Session::getInstance()->set("error", "");
		Session::getInstance()->set("tipo_error", "");
		Session::getInstance()->set("response", "");
		if (Session::getInstance()->get("ciudades")) {
			$ciudades = Session::getInstance()->get("ciudades");
		} else {
			$ciudades = $this->consultarCiudades();
			Session::getInstance()->set("ciudades", $ciudades);
		}
		//eliminar vacias
		$ciudadesFiltradas = array_filter($ciudades, function ($ciudad) {
			return $ciudad->dep_codi >= 1
				&& $ciudad->mun_codi >= 1
				&& $ciudad->dep_nomb !== 'NULO'
				&& $ciudad->mun_nomb !== 'NULO';
		});


		$departamentos = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$departamentos[$ciudad->dep_codi] = $ciudad->dep_nomb;
		}
		$ciudadesArray = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$ciudadesArray[$ciudad->dep_codi][$ciudad->mun_codi] = $ciudad->mun_nomb;
		}

		$this->_view->ciudades = $ciudadesArray;
		$this->_view->ciudadesList = $ciudadesFiltradas;
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  solicitud  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudes_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_solicitud_estado = $this->getSolicitudestado();
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



		$departamentos = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$departamentos[$ciudad->dep_codi] = $ciudad->dep_nomb;
		}
		$ciudadesArray = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$ciudadesArray[$ciudad->dep_codi][$ciudad->mun_codi] = $ciudad->mun_nomb;
		}


		/* echo "<pre>";
															print_r($ciudadesArray[54][553]);
															echo "</pre>"; */

		// Ahora $ciudadesFiltradas contiene solo las ciudades que cumplen las condiciones.

		$this->_view->ciudades = $ciudadesArray;
		$this->_view->ciudadesList = $ciudadesFiltradas;


		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->solicitud_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar solicitud";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear solicitud";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear solicitud";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	public function infoAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudes_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_solicitud_estado = $this->getSolicitudestado();

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



		$departamentos = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$departamentos[$ciudad->dep_codi] = $ciudad->dep_nomb;
		}
		$ciudadesArray = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$ciudadesArray[$ciudad->dep_codi][$ciudad->mun_codi] = $ciudad->mun_nomb;
		}


		/* echo "<pre>";
															print_r($ciudadesArray[54][553]);
															echo "</pre>"; */

		// Ahora $ciudadesFiltradas contiene solo las ciudades que cumplen las condiciones.

		$this->_view->ciudades = $ciudadesArray;
		$this->_view->ciudadesList = $ciudadesFiltradas;

		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			$logSolicitudesModel = new Administracion_Model_DbTable_Logsolicitudes();
			if ($content->solicitud_id) {
				$this->_view->content = $content;
				$title = "Visualizar solicitud";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
				$this->_view->logs = $logSolicitudesModel->getList("log_solicitud_solicitud = '{$id}'")[0];

				if ($content->solicitud_estado && $content->solicitud_estado != 1 && $content->solicitud_usuario) {
					$usuariosModel = new Administracion_Model_DbTable_Usuario();
					$this->_view->usuario_aprobacion = $usuariosModel->getById($content->solicitud_usuario);
				}
			}
		}
	}

	/**
	 * Inserta la informacion de un solicitud  y redirecciona al listado de solicitud.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$id = $this->mainModel->insert($data);

			$data['solicitud_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR SOLICITUD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un solicitud  y redirecciona al listado de solicitud.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		/* &update=1&solicitud_estado=2 */
		$update = $this->_getSanitizedParam("update");
		$estado = $this->_getSanitizedParam("solicitud_estado_home");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->solicitud_id) {
				$data = $this->getData();

				// Verifica si el estado de la solicitud ha cambiado
				if ($content->solicitud_estado != $data["solicitud_estado"]) {

					if ($data["solicitud_estado"] == 2) {

						$response = $this->updateUser($data);

						$res = json_decode($response);

						// print_r($res);
						$this->mainModel->editField($id, "solicitud_response", print_r($res, JSON_PRETTY_PRINT));


						if ($res->status === false || $res->status === 'false' || $res->status != 'success' || !$res) {
							Session::getInstance()->set("error", "Error al actualizar el usuario en el sistema externo.");
							Session::getInstance()->set("tipo_error", "danger");
							Session::getInstance()->set("response", $response);

							header('Location: ' . $this->route . '');
							exit;
						} else {
							Session::getInstance()->set("response", $response);
						}
					}


					$fieldsToUpdate = [
						"solicitud_nombre",
						"solicitud_apellidos",
						"solicitud_documento",
						"solicitud_telefono",
						"solicitud_direccion",
						"solicitud_ciudad",
						"solicitud_departamento",
						"solicitud_pais",
						"solicitud_region",
						"solicitud_email_facturacion",
						"solicitud_email_comunicacion",
						"solicitud_observaciones",
					];

					foreach ($fieldsToUpdate as $field) {
						if ($content->{$field} != $data[$field]) {
							$this->mainModel->editField($id, $field, $data[$field]);
						}
					}



					// Actualiza el estado de la solicitud en la base de datos
					$extraFields = [
						"solicitud_estado" => $data["solicitud_estado"],
						"solicitud_fecha_aprobacion" => date("Y-m-d H:i:s"),
						"solicitud_usuario" => Session::getInstance()->get("kt_login_id"),
						"solicitud_usuario_ip" => $_SERVER['REMOTE_ADDR'],
						"solicitud_usuario_user_agent" => $_SERVER['HTTP_USER_AGENT'],
					];
					foreach ($extraFields as $field => $value) {
						$this->mainModel->editField($id, $field, $value);
					}




					// Obtiene y actualiza el log de la solicitud
					$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
					$logSolicitud = $logSolicitudModel->getList("log_solicitud_solicitud = '{$id}'")[0];

					// Actualiza información de usuario en el log de la solicitud
					$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_usuario_modifica", Session::getInstance()->get("kt_login_id"));
					$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_ip_usuario", $_SERVER['REMOTE_ADDR']);
					$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_user_agent_usuario", $_SERVER['HTTP_USER_AGENT']);
					$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_fecha_datos_nuevos", date("Y-m-d H:i:s"));

					// Obtiene los datos actualizados de la solicitud y los almacena en el log
					$solicitud = $this->mainModel->getById($id);
					$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_datos_completos_fin", print_r($solicitud, true));

					// Dependiendo del estado, establece el mensaje de sesión y enva un correo
					$sendingemail = new Core_Model_Sendingemail($this->_view); // Crear una única instancia del modelo de email
					$sendingemail->solicitudRespuesta($solicitud); // Enviar correo de aprobación

					if ($data["solicitud_estado"] == 2) { // Estado aprobado
						Session::getInstance()->set("error", "La solicitud ha sido aprobada.");
						Session::getInstance()->set("tipo_error", "success");
					} elseif ($data["solicitud_estado"] == 3) { // Estado rechazado
						Session::getInstance()->set("error", "La solicitud ha sido rechazada.");
						Session::getInstance()->set("tipo_error", "danger");
					} else {
						Session::getInstance()->set("error", "La solicitud ha sido actualizada.");
						Session::getInstance()->set("tipo_error", "info");
					}
				} else {
					Session::getInstance()->set("error", "No se ha actualizado el estado de la solicitud.");
					Session::getInstance()->set("tipo_error", "warning");
				}


				// $this->mainModel->update($data, $id);
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	public function crearAction()
	{
		if ($_SESSION['kt_login_level'] == 10) {
			header('Location: ' . $this->route);
			exit;
		}
		// $this->setLayout('blanco');
		$title = "Crear solicitud de actualización de datos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->_view->route = $this->route;
		$this->_csrf_section = "crear_solicitudes_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

		// Obtener ciudades para el formulario
		if (Session::getInstance()->get("ciudades")) {
			$ciudades = Session::getInstance()->get("ciudades");
		} else {
			$ciudades = $this->consultarCiudades();
			Session::getInstance()->set("ciudades", $ciudades);
		}

		// Filtrar ciudades válidas
		$ciudadesFiltradas = array_filter($ciudades, function ($ciudad) {
			return $ciudad->dep_codi >= 1
				&& $ciudad->mun_codi >= 1
				&& $ciudad->dep_nomb !== 'NULO'
				&& $ciudad->mun_nomb !== 'NULO';
		});
		foreach ($ciudadesFiltradas as $ciudad) {
			$departamentos[$ciudad->dep_codi] = $ciudad->dep_nomb;
		}
		$ciudadesArray = [];
		foreach ($ciudadesFiltradas as $ciudad) {
			$ciudadesArray[$ciudad->dep_codi][$ciudad->mun_codi] = $ciudad->mun_nomb;
		}
		$this->_view->ciudades = $ciudadesArray;

		$this->_view->ciudadesList = $ciudadesFiltradas;


		// Si hay datos del socio en sesión, mostrarlos
		$this->_view->datos_socio = Session::getInstance()->get("datos_socio_crear");
		$this->_view->error = Session::getInstance()->get("error_crear");
		$this->_view->tipo_error = Session::getInstance()->get("tipo_error_crear");

		// Limpiar mensajes de sesión (pero no los datos del socio)
		Session::getInstance()->set("error_crear", "");
		Session::getInstance()->set("tipo_error_crear", "");

		// Si viene el parámetro limpiar=1, limpiar todos los datos de sesión
		if ($this->_getSanitizedParam("limpiar") == 1) {
			Session::getInstance()->set("datos_socio_crear", null);
			Session::getInstance()->set("error_crear", "");
			Session::getInstance()->set("tipo_error_crear", "");
			header('Location: ' . $this->route . '/crear');
			exit;
		}


		$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
		$usuarioId = Session::getInstance()->get("kt_login_id");
		$meta = 30;
		$fechaInicio = date("Y-m-d 00:00:00");
		$fechaFin = date("Y-m-d 23:59:59");

		$solicitudesHoyUsuario = $solicitudesModel->getList("solicitud_solicitado_por = '{$usuarioId}'  AND (solicitud_fecha_solicitud >= '{$fechaInicio}' AND solicitud_fecha_solicitud <= '{$fechaFin}')");
		$this->_view->meta = $meta;
		$this->_view->solicitudesHoyUsuario = count($solicitudesHoyUsuario);

	}

	public function fotocarnetAction()
	{
		if ($_SESSION['kt_login_level'] == 10) {
			header('Location: ' . $this->route);
			exit;
		}

		$title = "Actualizar foto de carnet";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->_view->route = $this->route;
		$this->_csrf_section = "fotocarnet_solicitudes_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

		$this->_view->datos_socio = Session::getInstance()->get("datos_socio_foto");
		$this->_view->error = Session::getInstance()->get("error_foto");
		$this->_view->tipo_error = Session::getInstance()->get("tipo_error_foto");

		Session::getInstance()->set("error_foto", "");
		Session::getInstance()->set("tipo_error_foto", "");

		if ($this->_getSanitizedParam("limpiar") == 1) {
			Session::getInstance()->set("datos_socio_foto", null);
			Session::getInstance()->set("error_foto", "");
			Session::getInstance()->set("tipo_error_foto", "");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}
	}

	public function buscar_socio_fotoAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$numero_carnet = trim((string) $this->_getSanitizedParam("numero_carnet"));

			if (!$numero_carnet) {
				Session::getInstance()->set("error_foto", "Debe ingresar un número de carnet.");
				Session::getInstance()->set("tipo_error_foto", "danger");
				header('Location: ' . $this->route . '/fotocarnet');
				exit;
			}

			$datos_socio = $this->consultar_Socio($numero_carnet);

			if (!$datos_socio || (is_array($datos_socio) && count($datos_socio) == 0) || $datos_socio->mensaje === 'No encontrado') {
				Session::getInstance()->set("error_foto", "No se encontró ningún socio con el número de carnet: " . $numero_carnet);
				Session::getInstance()->set("tipo_error_foto", "warning");
				Session::getInstance()->set("datos_socio_foto", null);
				header('Location: ' . $this->route . '/fotocarnet');
				exit;
			}

			if (is_array($datos_socio)) {
				$datos_socio = $datos_socio[0];
			}

			$datos_socio = $this->prepararDatosSocioSesion($datos_socio, $numero_carnet);

			Session::getInstance()->set("datos_socio_foto", $datos_socio);
			Session::getInstance()->set("error_foto", "");
			Session::getInstance()->set("tipo_error_foto", "");
		}

		header('Location: ' . $this->route . '/fotocarnet');
	}

	public function guardar_fotoAction()
	{
		ini_set('post_max_size', '50M');
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] != $csrf) {
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		$datos_socio = Session::getInstance()->get("datos_socio_foto");
		if (!$datos_socio) {
			Session::getInstance()->set("error_foto", "No se encontraron datos del socio. Realice la búsqueda nuevamente.");
			Session::getInstance()->set("tipo_error_foto", "danger");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		if (!isset($_FILES['solicitud_foto_file']) || $_FILES['solicitud_foto_file']['size'] <= 0) {
			Session::getInstance()->set("error_foto", "Debe seleccionar una imagen para actualizar la foto.");
			Session::getInstance()->set("tipo_error_foto", "warning");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimeType = finfo_file($finfo, $_FILES['solicitud_foto_file']['tmp_name']);
		finfo_close($finfo);

		$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
		if (!in_array($mimeType, $allowedTypes)) {
			Session::getInstance()->set("error_foto", "Tipo de archivo no permitido. Solo se aceptan imágenes JPG y PNG.");
			Session::getInstance()->set("tipo_error_foto", "danger");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		if ($_FILES['solicitud_foto_file']['size'] > 5242880) {
			Session::getInstance()->set("error_foto", "El archivo es demasiado grande (máximo 5MB).");
			Session::getInstance()->set("tipo_error_foto", "danger");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		$uploadImage = new Core_Model_Upload_Image();
		$rutaImagen = IMAGE_PATH . $uploadImage->upload('solicitud_foto_file', true);
		$datosImagen = file_get_contents($rutaImagen);
		$fotoNueva = base64_encode($datosImagen);
		$fotoActual = $this->normalizarFotoBase64($this->obtenerValorSocio($datos_socio, ['socio_foto', 'SOC_FOTO'], ''));

		if (!$fotoNueva) {
			Session::getInstance()->set("error_foto", "No fue posible procesar la imagen seleccionada.");
			Session::getInstance()->set("tipo_error_foto", "danger");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		$dataWs = [
			'solicitud_sbe_codi' => $this->obtenerValorSocio($datos_socio, ['SBE_CODI', 'sbe_codi']),
			'solicitud_numero_accion' => $this->obtenerValorSocio($datos_socio, ['numero_carnet', 'SBE_NCAR', 'sbe_ncar']),
			'solicitud_soc_cont' => $this->obtenerValorSocio($datos_socio, ['SOC_CONT', 'soc_cont']),
			'solicitud_mac_nume' => $this->obtenerValorSocio($datos_socio, ['MAC_NUME', 'mac_nume']),
			'solicitud_soc_codi' => $this->obtenerValorSocio($datos_socio, ['SOC_CODI', 'soc_codi']),
			'solicitud_pais' => $this->obtenerValorSocio($datos_socio, ['PAI_CODI', 'pai_codi']),
			'solicitud_departamento' => $this->obtenerValorSocio($datos_socio, ['DEP_CODI', 'dep_codi']),
			'solicitud_ciudad' => $this->obtenerValorSocio($datos_socio, ['MUN_CODI', 'mun_codi']),
			'solicitud_region' => $this->obtenerValorSocio($datos_socio, ['REG_CODI', 'reg_codi']),
			'solicitud_nombre' => $this->obtenerValorSocio($datos_socio, ['sbe_nomb', 'SBE_NOMB']),
			'solicitud_apellidos' => $this->obtenerValorSocio($datos_socio, ['sbe_apel', 'SBE_APEL']),
			'solicitud_email_comunicacion' => $this->obtenerValorSocio($datos_socio, ['sbe_mail', 'SBE_MAIL']),
			'solicitud_telefono' => $this->obtenerValorSocio($datos_socio, ['sbe_ncel', 'SBE_NCEL']),
			'solicitud_direccion' => $this->obtenerValorSocio($datos_socio, ['sbe_dire', 'SBE_DIRE']),
			'solicitud_email_facturacion' => $this->obtenerValorSocio($datos_socio, ['con_mail', 'SBE_MAIL_FACT']),
			'solicitud_foto' => $fotoNueva,
		];

		$response = $this->updateUser($dataWs);

		$res = json_decode($response);

		if (!$res || !isset($res->status) || $res->status != 'success') {
			Session::getInstance()->set("error_foto", "Error al actualizar la foto en el sistema externo.");
			Session::getInstance()->set("tipo_error_foto", "danger");
			header('Location: ' . $this->route . '/fotocarnet');
			exit;
		}

		$ahora = date("Y-m-d H:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		$dataSolicitud = [
			'solicitud_numero_accion' => $dataWs['solicitud_numero_accion'],
			'solicitud_nombre' => $dataWs['solicitud_nombre'],
			'solicitud_apellidos' => $dataWs['solicitud_apellidos'],
			'solicitud_documento' => $dataWs['solicitud_sbe_codi'],
			'solicitud_telefono' => $dataWs['solicitud_telefono'],
			'solicitud_direccion' => $dataWs['solicitud_direccion'],
			'solicitud_ciudad' => $dataWs['solicitud_ciudad'],
			'solicitud_email_facturacion' => $dataWs['solicitud_email_facturacion'],
			'solicitud_email_comunicacion' => $dataWs['solicitud_email_comunicacion'],
			'solicitud_foto' => $fotoNueva,
			'solicitud_observaciones' => 'Actualización de foto de carnet (sin aprobación).',
			'solicitud_numero_accion_actual' => $dataWs['solicitud_numero_accion'],
			'solicitud_nombre_actual' => $dataWs['solicitud_nombre'],
			'solicitud_apellidos_actual' => $dataWs['solicitud_apellidos'],
			'solicitud_documento_actual' => $dataWs['solicitud_sbe_codi'],
			'solicitud_telefono_actual' => $dataWs['solicitud_telefono'],
			'solicitud_direccion_actual' => $dataWs['solicitud_direccion'],
			'solicitud_ciudad_actual' => $dataWs['solicitud_ciudad'],
			'solicitud_email_facturacion_actual' => $dataWs['solicitud_email_facturacion'],
			'solicitud_email_comunicacion_actual' => $dataWs['solicitud_email_comunicacion'],
			'solicitud_foto_actual' => $fotoActual,
			'solicitud_observaciones_actual' => 'Foto anterior',
			'solicitud_fecha_ingreso' => $ahora,
			'solicitud_fecha_solicitud' => $ahora,
			'solicitud_acepta_politicas' => 0,
			'solicitud_estado' => 2,
			'solicitud_ip' => $ip,
			'solicitud_user_agent' => $userAgent,
			'solicitud_usuario' => Session::getInstance()->get("kt_login_id"),
			'solicitud_usuario_ip' => $ip,
			'solicitud_usuario_user_agent' => $userAgent,
			'solicitud_source' => 'solo_foto',
			'solicitud_declara_titular' => 0,
		];
		$modelSolicitudImagenes = new Administracion_Model_DbTable_Solicitudesimagenes();
		$id = $modelSolicitudImagenes->insert($dataSolicitud);
		$modelSolicitudImagenes->editField($id, 'solicitud_solicitado_por', Session::getInstance()->get("kt_login_id"));
		$modelSolicitudImagenes->editField($id, 'solicitud_response', print_r($res, JSON_PRETTY_PRINT));
		$modelSolicitudImagenes->editField($id, 'solicitud_fecha_aprobacion', $ahora);

		$extraFields = [
			"solicitud_departamento" => $dataWs['solicitud_departamento'],
			"solicitud_pais" => $dataWs['solicitud_pais'],
			"solicitud_region" => $dataWs['solicitud_region'],
			"solicitud_departamento_actual" => $dataWs['solicitud_departamento'],
			"solicitud_pais_actual" => $dataWs['solicitud_pais'],
			"solicitud_region_actual" => $dataWs['solicitud_region'],
			"solicitud_sbe_codi" => $dataWs['solicitud_sbe_codi'],
			"solicitud_sbe_cont" => $this->obtenerValorSocio($datos_socio, ['SBE_CONT', 'sbe_cont']),
			"solicitud_soc_codi" => $dataWs['solicitud_soc_codi'],
			"solicitud_soc_cont" => $dataWs['solicitud_soc_cont'],
			"solicitud_mac_nume" => $dataWs['solicitud_mac_nume'],
			"solicitud_ncon" => $this->obtenerValorSocio($datos_socio, ['SBE_NCON', 'sbe_ncon']),
			"solicitud_sbe_idio" => $this->obtenerValorSocio($datos_socio, ['SBE_IDIO', 'sbe_idio']),
		];
		$modelSolicitudImagenes->updateExtraFields($id, $extraFields);

		$logSolicitudimagenesModel = new Administracion_Model_DbTable_Logsolicitudesimagenes();
		$fotoActualHash = $fotoActual ? hash('sha256', $fotoActual) : '';
		$fotoNuevaHash = hash('sha256', $fotoNueva);

		$logData = [
			'log_solicitud_solicitud' => $id,
			'log_solicitud_cliente' => $dataWs['solicitud_numero_accion'],
			'log_solicitud_fecha_datos_anteriores' => $ahora,
			'log_solicitud_fecha_datos_nuevos' => $ahora,
			'log_solicitud_ip_cliente' => $ip,
			'log_solicitud_user_agent_cliente' => $userAgent,
			'log_solicitud_usuario' => Session::getInstance()->get("kt_login_id"),
			'log_solicitud_ip_usuario' => $ip,
			'log_solicitud_user_agent_usuario' => $userAgent,
			'log_solicitud_datos_completos' => print_r([
				'tipo_operacion' => 'solo_foto',
				'solicitud_source' => 'solo_foto',
				'numero_accion' => $dataWs['solicitud_numero_accion'],
				'foto_actual_hash' => $fotoActualHash,
				'foto_nueva_hash' => $fotoNuevaHash,
				'foto_actual_length' => strlen((string) $fotoActual),
				'foto_nueva_length' => strlen((string) $fotoNueva),
			], true),
			'log_solicitud_datos_nuevos' => print_r([
				'tipo_operacion' => 'solo_foto',
				'status_webservice' => $res->status,
			], true),
		];
		$logSolicitudimagenesModel->insert($logData);

		Session::getInstance()->set("datos_socio_foto", null);
		Session::getInstance()->set("error_foto", "La foto fue actualizada correctamente sin proceso de aprobación.");
		Session::getInstance()->set("tipo_error_foto", "success");
		header('Location: ' . $this->route . '/fotocarnet');
		exit;
	}

	public function buscar_socioAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$numero_carnet = $this->_getSanitizedParam("numero_carnet");

			if (!$numero_carnet) {
				Session::getInstance()->set("error_crear", "Debe ingresar un número de carnet.");
				Session::getInstance()->set("tipo_error_crear", "danger");
				header('Location: ' . $this->route . '/crear');
				exit;
			}

			$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
			$fecha_limite = date("Y-m-d H:i:s", strtotime("-365 days"));
			$ultimaSolicitud = $solicitudModel->getList("solicitud_numero_accion = '{$numero_carnet}' AND solicitud_fecha_solicitud > '{$fecha_limite}' ", "solicitud_fecha_solicitud DESC")[0];
			if ($ultimaSolicitud && $ultimaSolicitud->solicitud_estado == 1) {
				Session::getInstance()->set("error_crear", "Ya existe una solicitud pendiente para el número de carnet: " . $numero_carnet);
				Session::getInstance()->set("tipo_error_crear", "warning");
				header('Location: ' . $this->route . '/crear');
				exit;
			}
			if ($ultimaSolicitud && $ultimaSolicitud->solicitud_estado == 2) {
				Session::getInstance()->set("error_crear", "Ya existe una solicitud aprobada para el número de carnet: " . $numero_carnet);
				Session::getInstance()->set("tipo_error_crear", "warning");
				header('Location: ' . $this->route . '/crear');
				exit;
			}

			// Consultar datos del socio
			$datos_socio = $this->consultar_Socio($numero_carnet);

			if (!$datos_socio || (is_array($datos_socio) && count($datos_socio) == 0) || $datos_socio->mensaje === 'No encontrado') {
				Session::getInstance()->set("error_crear", "No se encontró ningún socio con el número de carnet: " . $numero_carnet);
				Session::getInstance()->set("tipo_error_crear", "warning");
				Session::getInstance()->set("datos_socio_crear", null);
				header('Location: ' . $this->route . '/crear');
				exit;
			}

			// Si es un array, tomar el primer elemento
			if (is_array($datos_socio)) {
				$datos_socio = $datos_socio[0];
			}

			// Agregar el número de carnet al objeto ya que no viene en la respuesta
			$datos_socio->numero_carnet = $numero_carnet;
			$fotoRaw = $this->obtenerValorSocio($datos_socio, ['SOC_FOTO', 'socio_foto'], '');
			$datos_socio->socio_foto = $this->normalizarFotoBase64($fotoRaw);

			// Guardar datos en sesión
			Session::getInstance()->set("datos_socio_crear", $datos_socio);
			Session::getInstance()->set("error_crear", "");
			Session::getInstance()->set("tipo_error_crear", "");
		}

		header('Location: ' . $this->route . '/crear');
	}

	public function guardar_solicitudAction()
	{
		ini_set('post_max_size', '50M');
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			// Obtener datos del formulario
			$data = $this->getData();

			// Preparar datos adicionales
			$data['solicitud_fecha_solicitud'] = date("Y-m-d H:i:s");
			$data['solicitud_fecha_ingreso'] = date("Y-m-d H:i:s");
			$data['solicitud_ip'] = $_SERVER['REMOTE_ADDR'];
			$data['solicitud_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			// $data['solicitud_acepta_politicas'] = 1;
			$data['solicitud_estado'] = 1; // Pendiente - No se aprueba automáticamente

			// Procesar la imagen si se subió una nueva
			$uploadImage = new Core_Model_Upload_Image();

			if (Session::getInstance()->get('kt_login_id') != 1) {
				if (isset($_FILES['solicitud_foto_file']) && $_FILES['solicitud_foto_file']['size'] > 0) {
					$imageData = IMAGE_PATH . $uploadImage->upload('solicitud_foto_file', true);
					$datosImagen = file_get_contents($imageData);
					$base64Image = base64_encode($datosImagen);
					$data['solicitud_foto'] = $base64Image;
				}
			}
			// Insertar la solicitud
			$id = $this->mainModel->insert($data);
			$this->mainModel->editField($id, "solicitud_solicitado_por", Session::getInstance()->get("kt_login_id"));


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
			$this->mainModel->updateExtraFields($id, $extraFields);

			unset($data['solicitud_foto']);
			unset($data['solicitud_foto_actual']);
			if ($id) {
				// Crear log de la solicitud
				$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
				$logData = [
					'log_solicitud_solicitud' => $id,
					'log_solicitud_cliente' => $data["solicitud_numero_accion"],
					'log_solicitud_fecha_datos_anteriores' => date("Y-m-d H:i:s"),
					'log_solicitud_fecha_datos_nuevos' => date("Y-m-d H:i:s"),
					'log_solicitud_ip_cliente' => $_SERVER['REMOTE_ADDR'],
					'log_solicitud_user_agent_cliente' => $_SERVER['HTTP_USER_AGENT'],
					'log_solicitud_datos_completos' => print_r($data, true),
					'log_solicitud_usuario' => Session::getInstance()->get("kt_login_id"),
					'log_solicitud_ip_usuario' => $_SERVER['REMOTE_ADDR'],
					'log_solicitud_user_agent_usuario' => $_SERVER['HTTP_USER_AGENT'],
				];
				$logSolicitudModel->insert($logData);

				// Obtener la solicitud guardada
				$solicitud = $this->mainModel->getById($id);

				if (!$solicitud) {
					Session::getInstance()->set("error_crear", "Error al recuperar los datos de la solicitud.");
					Session::getInstance()->set("tipo_error_crear", "danger");
					header('Location: ' . $this->route . '/crear');
					exit;
				}

				// Enviar correo de alerta al administrador
				$mail = new Core_Model_Sendingemail($this->_view);
				$link = SOLICITUDES . "/index?id=" . $id;
				$mail->enviarAlerta($solicitud, $link);

				// Establecer mensaje de éxito
				Session::getInstance()->set("error", "La solicitud ha sido enviada correctamente y está en revisión.");
				Session::getInstance()->set("tipo_error", "success");

				// Limpiar datos de sesión
				Session::getInstance()->set("datos_socio_crear", null);
			} else {
				Session::getInstance()->set("error_crear", "Error al crear la solicitud. Por favor intente nuevamente.");
				Session::getInstance()->set("tipo_error_crear", "danger");
				header('Location: ' . $this->route . '/crear');
				exit;
			}
		}

		header('Location: ' . $this->route . '/crear?limpiar=1');
		exit;

	}
	public function aprobarAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		/* &update=1&solicitud_estado=2 */
		$update = $this->_getSanitizedParam("update");
		$estado = $this->_getSanitizedParam("solicitud_estado_home");


		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			//print_r($content);
			// Convertir a array
			$data = (array) $content;


			if ($content->solicitud_id && $update == 1 && $estado) {



				$data["solicitud_estado"] = $estado;
				if ($estado == 2) {

					$response = $this->updateUser($data);
					error_log("Respuesta del servicio externo: " . print_r($response, true));

					$res = json_decode($response);

					// print_r($res);
					$this->mainModel->editField($id, "solicitud_response", print_r($res, JSON_PRETTY_PRINT));

					error_log("Respuesta del servicio externo: " . print_r($res, true));
					if ($res->status === false || $res->status === 'false' || $res->status != 'success' || !$res) {
						Session::getInstance()->set("error", "Error al actualizar el usuario en el sistema externo.");
						Session::getInstance()->set("tipo_error", "danger");
						Session::getInstance()->set("response", $response);

						header('Location: ' . $this->route . '');
						exit;
					} else {
						Session::getInstance()->set("response", $response);
					}
				}


				$fieldsToUpdate = [
					"solicitud_nombre",
					"solicitud_apellidos",
					"solicitud_documento",
					"solicitud_telefono",
					"solicitud_direccion",
					"solicitud_ciudad",
					"solicitud_departamento",
					"solicitud_pais",
					"solicitud_region",
					"solicitud_email_facturacion",
					"solicitud_email_comunicacion",
					"solicitud_observaciones",
				];

				foreach ($fieldsToUpdate as $field) {
					if ($content->{$field} != $data[$field]) {
						$this->mainModel->editField($id, $field, $data[$field]);
					}
				}



				// Actualiza el estado de la solicitud en la base de datos
				$extraFields = [
					"solicitud_estado" => $data["solicitud_estado"],
					"solicitud_fecha_aprobacion" => date("Y-m-d H:i:s"),
					"solicitud_usuario" => Session::getInstance()->get("kt_login_id"),
					"solicitud_usuario_ip" => $_SERVER['REMOTE_ADDR'],
					"solicitud_usuario_user_agent" => $_SERVER['HTTP_USER_AGENT'],
				];
				foreach ($extraFields as $field => $value) {
					$this->mainModel->editField($id, $field, $value);
				}




				// Obtiene y actualiza el log de la solicitud
				$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
				$logSolicitud = $logSolicitudModel->getList("log_solicitud_solicitud = '{$id}'")[0];

				// Actualiza información de usuario en el log de la solicitud
				$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_usuario_modifica", Session::getInstance()->get("kt_login_id"));
				$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_ip_usuario", $_SERVER['REMOTE_ADDR']);
				$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_user_agent_usuario", $_SERVER['HTTP_USER_AGENT']);
				$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_fecha_datos_nuevos", date("Y-m-d H:i:s"));

				// Obtiene los datos actualizados de la solicitud y los almacena en el log
				$solicitud = $this->mainModel->getById($id);
				$logSolicitudModel->editField($logSolicitud->log_solicitud_id, "log_solicitud_datos_completos_fin", print_r($solicitud, true));

				// Dependiendo del estado, establece el mensaje de sesin y envía un correo
				$sendingemail = new Core_Model_Sendingemail($this->_view); // Crear una única instancia del modelo de email
				$sendingemail->solicitudRespuesta($solicitud); // Enviar correo de aprobación

				if ($data["solicitud_estado"] == 2) { // Estado aprobado
					Session::getInstance()->set("error", "La solicitud ha sido aprobada.");
					Session::getInstance()->set("tipo_error", "success");
				} elseif ($data["solicitud_estado"] == 3) { // Estado rechazado
					Session::getInstance()->set("error", "La solicitud ha sido rechazada.");
					Session::getInstance()->set("tipo_error", "danger");
				} else {
					Session::getInstance()->set("error", "La solicitud ha sido actualizada.");
					Session::getInstance()->set("tipo_error", "info");
				}
			} else {
				Session::getInstance()->set("error", "No se ha actualizado el estado de la solicitud.");
				Session::getInstance()->set("tipo_error", "warning");
			}


			// $this->mainModel->update($data, $id);

		}
		header('Location: ' . $this->route . '' . '');
	}
	public function updateUser($data)
	{
		$loginServiceUrl = PRUEBAS
			? 'https://ev.clubelnogal.com/ConsultaAsociadosPruebas/querys/actualizarUsuario.php'
			: 'https://ev.clubelnogal.com/ConsultaAsociados/querys/actualizarUsuario.php';



		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'token' => $this->generarToken(), //token que recibe de la base de
			'SBE_CODI' => $data['solicitud_sbe_codi'],
			'SBE_NCAR' => $data['solicitud_numero_accion'],
			'SOC_CONT' => $data['solicitud_soc_cont'],
			'MAC_NUME' => $data['solicitud_mac_nume'],
			'SOC_CODI' => $data['solicitud_soc_codi'],
			'PAI_CODI' => $data["solicitud_pais"],
			'DEP_CODI' => $data["solicitud_departamento"],
			'MUN_CODI' => $data["solicitud_ciudad"],
			'REG_CODI' => $data["solicitud_region"],
			'SBE_NOMB' => $data["solicitud_nombre"],
			'SBE_APEL' => $data["solicitud_apellidos"],
			'SBE_MAIL' => $data["solicitud_email_comunicacion"],
			'SBE_NCEL' => $data["solicitud_telefono"],
			'SBE_DIRE' => $data["solicitud_direccion"],
			'SBE_MAIL_FACT' => $data["solicitud_email_facturacion"],
			'SOC_FOTO' => $data["solicitud_foto"],

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


	public function updateActionOLD()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->solicitud_id) {
				$data = $this->getData();
				$this->mainModel->update($data, $id);
			}
			$data['solicitud_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR SOLICITUD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un solicitud  y redirecciona al listado de solicitud.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);
					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR SOLICITUD';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Solicitudes.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		if ($this->_getSanitizedParam("solicitud_numero_accion") == '') {
			$data['solicitud_numero_accion'] = '0';
		} else {
			$data['solicitud_numero_accion'] = $this->_getSanitizedParam("solicitud_numero_accion");
		}
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
		$data['solicitud_foto'] = $this->_getSanitizedParam("solicitud_foto");
		$data['solicitud_observaciones'] = $this->_getSanitizedParam("solicitud_observaciones");
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
		$data['solicitud_user_agent'] = $this->_getSanitizedParam("solicitud_user_agent");
		$data['solicitud_usuario'] = $this->_getSanitizedParam("solicitud_usuario");
		$data['solicitud_usuario_ip'] = $this->_getSanitizedParam("solicitud_usuario_ip");
		$data['solicitud_usuario_user_agent'] = $this->_getSanitizedParam("solicitud_usuario_user_agent");

		$data['solicitud_sbe_codi'] = $this->_getSanitizedParam("solicitud_sbe_codi");
		$data['solicitud_sbe_cont'] = $this->_getSanitizedParam("solicitud_sbe_cont");
		$data['solicitud_soc_codi'] = $this->_getSanitizedParam("solicitud_soc_codi");
		$data['solicitud_soc_cont'] = $this->_getSanitizedParam("solicitud_soc_cont");
		$data['solicitud_mac_nume'] = $this->_getSanitizedParam("solicitud_mac_nume");
		$data['solicitud_ncon'] = $this->_getSanitizedParam("solicitud_ncon");
		$data['solicitud_sbe_idio'] = $this->_getSanitizedParam("solicitud_sbe_idio");
		$data['solicitud_source'] = $this->_getSanitizedParam("solicitud_source");

		return $data;
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

	/**
	 * Genera los valores del campo solicitud_estado.
	 *
	 * @return array cadena con los valores del campo solicitud_estado.
	 */
	private function getSolicitudestado()
	{
		$array = array();
		$array['1'] = 'Pendiente';
		$array['2'] = 'Aprobado';
		$array['3'] = 'Rechazado';
		return $array;
	}

	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);
			if ($filters->solicitud_numero_accion != '') {
				$filtros = $filtros . " AND solicitud_numero_accion LIKE '%" . $filters->solicitud_numero_accion . "%'";
			}
			if ($filters->solicitud_nombre != '') {
				$filtros = $filtros . " AND solicitud_nombre LIKE '%" . $filters->solicitud_nombre . "%'";
			}
			if ($filters->solicitud_apellidos != '') {
				$filtros = $filtros . " AND solicitud_apellidos LIKE '%" . $filters->solicitud_apellidos . "%'";
			}
			if ($filters->solicitud_fecha_solicitud != '') {
				$filtros = $filtros . " AND solicitud_fecha_solicitud LIKE '%" . $filters->solicitud_fecha_solicitud . "%'";
			}
			if ($filters->solicitud_estado != '') {
				$filtros = $filtros . " AND solicitud_estado ='" . $filters->solicitud_estado . "'";
			}
		}
		return $filtros;
	}

	/**
	 * Recibe y asigna los filtros de este controlador
	 *
	 * @return void
	 */
	protected function filters()
	{
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			$parramsfilter['solicitud_numero_accion'] = $this->_getSanitizedParam("solicitud_numero_accion");
			$parramsfilter['solicitud_nombre'] = $this->_getSanitizedParam("solicitud_nombre");
			$parramsfilter['solicitud_apellidos'] = $this->_getSanitizedParam("solicitud_apellidos");
			$parramsfilter['solicitud_fecha_solicitud'] = $this->_getSanitizedParam("solicitud_fecha_solicitud");
			$parramsfilter['solicitud_estado'] = $this->_getSanitizedParam("solicitud_estado");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
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

	private function prepararDatosSocioSesion($datos_socio, $numero_carnet)
	{
		$datos_socio->numero_carnet = $numero_carnet;
		$fotoRaw = $this->obtenerValorSocio($datos_socio, ['SOC_FOTO', 'socio_foto'], '');
		$datos_socio->socio_foto = $this->normalizarFotoBase64($fotoRaw);
		return $datos_socio;
	}

	private function obtenerValorSocio($socio, $keys, $default = '')
	{
		foreach ($keys as $key) {
			if (is_object($socio) && isset($socio->{$key}) && $socio->{$key} !== null && $socio->{$key} !== '') {
				return trim((string) $socio->{$key});
			}
			if (is_array($socio) && isset($socio[$key]) && $socio[$key] !== null && $socio[$key] !== '') {
				return trim((string) $socio[$key]);
			}
		}
		return $default;
	}

	private function normalizarFotoBase64($valor)
	{
		if (empty($valor)) {
			return '';
		}

		$foto = trim((string) $valor);

		if (strpos($foto, 'data:image') === 0) {
			$partes = explode(',', $foto, 2);
			$foto = isset($partes[1]) ? $partes[1] : '';
		}

		$foto = preg_replace('/\s+/', '', $foto);

		if ($foto !== '' && ctype_xdigit($foto) && strlen($foto) % 2 === 0) {
			$binario = @hex2bin($foto);
			if ($binario !== false) {
				return base64_encode($binario);
			}
		}

		return $foto;
	}

	public function testAction()
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		$this->setLayout('blanco');
		echo "<h2>Prueba de Log de Solicitudes</h2>";

		// Datos de prueba simulando una solicitud real
		$data = [
			'solicitud_id' => 999,
			'solicitud_numero_accion' => '12345678',
			'solicitud_nombre' => 'Juan',
			'solicitud_apellidos' => 'Pérez García',
			'solicitud_documento' => '1234567890',
			'solicitud_telefono' => '3001234567',
			'solicitud_direccion' => 'Calle 123 #45-67',
			'solicitud_ciudad' => 'Bogotá',
			'solicitud_departamento' => 'Cundinamarca',
			'solicitud_pais' => 'Colombia',
			'solicitud_region' => 'Andina',
			'solicitud_email_facturacion' => 'facturacion@test.com',
			'solicitud_email_comunicacion' => 'comunicacion@test.com',
			'solicitud_foto' => '',
			'solicitud_observaciones' => 'Observaciones de prueba'
		];

		$dataActual = [
			'solicitud_nombre_actual' => 'Juan Antiguo',
			'solicitud_apellidos_actual' => 'Prez Antiguo',
			'solicitud_telefono_actual' => '3009876543',
			'solicitud_direccion_actual' => 'Calle Antigua 99',
			'solicitud_ciudad_actual' => 'Medelln'
		];

		$dataNueva = [
			'solicitud_nombre' => 'Juan',
			'solicitud_apellidos' => 'Pérez García',
			'solicitud_telefono' => '3001234567',
			'solicitud_direccion' => 'Calle 123 #45-67',
			'solicitud_ciudad' => 'Bogotá'
		];

		echo "<h3>Intentando guardar log...</h3>";
		$dataLog = [];
		$dataLog['log_solicitud_cliente'] = $data["solicitud_numero_accion"];
		$dataLog['log_solicitud_solicitud'] = $data['solicitud_id'];
		$dataLog['log_solicitud_fecha_datos_anteriores'] = date("Y-m-d H:i:s");
		$dataLog['log_solicitud_ip_cliente'] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
		$dataLog['log_solicitud_user_agent_cliente'] = $_SERVER['HTTP_USER_AGENT'] ?? 'Test User Agent';
		$dataLog['log_solicitud_datos_completos'] = print_r($data, true);
		$dataLog['log_solicitud_fecha_datos_nuevos'] = $dataLog['log_solicitud_fecha_datos_anteriores'];

		echo "<h4>Datos a insertar:</h4>";
		echo "<pre>";
		print_r($dataLog);
		echo "</pre>";

		// Intentar insertar
		$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
		$idLog = $logSolicitudModel->insert($dataLog);
		echo "<h3>Resultado de la inserción:</h3>";
		echo $idLog;
		return;
		try {
			// Preparar datos del log
			$dataLog = [];
			$dataLog['log_solicitud_cliente'] = $data["solicitud_numero_accion"];
			$dataLog['log_solicitud_solicitud'] = $data['solicitud_id'];
			$dataLog['log_solicitud_fecha_datos_anteriores'] = date("Y-m-d H:i:s");
			$dataLog['log_solicitud_ip_cliente'] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
			$dataLog['log_solicitud_user_agent_cliente'] = $_SERVER['HTTP_USER_AGENT'] ?? 'Test User Agent';
			$dataLog['log_solicitud_datos_completos'] = print_r($data, true);

			$dataLog['log_solicitud_fecha_datos_nuevos'] = '0000-00-00 00:00:00';

			echo "<h4>Datos a insertar:</h4>";
			echo "<pre>";
			print_r($dataLog);
			echo "</pre>";

			// Intentar insertar
			$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
			$idLog = $logSolicitudModel->insert($dataLog);

			if ($idLog) {
				echo "<p style='color: green;'><strong>✓ Log insertado exitosamente con ID: $idLog</strong></p>";

				// Intentar actualizar campos adicionales
				$logSolicitudModel->editField($idLog, "log_solicitud_datos_actuales", print_r($dataActual, true));
				$logSolicitudModel->editField($idLog, "log_solicitud_datos_nuevos", print_r($dataNueva, true));



				// Verificar que se guard consultndolo
				$logGuardado = $logSolicitudModel->getById($idLog);
				
			} else {
				echo "<p style='color: red;'><strong>✗ ERROR: No se pudo insertar el log (retornó false/0)</strong></p>";
			}
		} catch (Exception $e) {
			echo "<p style='color: red;'><strong>✗ EXCEPCIÓN: " . $e->getMessage() . "</strong></p>";
			echo "<pre>" . $e->getTraceAsString() . "</pre>";
		}

		echo "<hr>";
		echo "<h3>Verificar tabla en base de datos</h3>";
		echo "<p>Ejecuta esta consulta SQL para verificar:</p>";
		echo "<code>SELECT * FROM log_solicitudes ORDER BY log_solicitud_id DESC LIMIT 1;</code>";
	}
}
