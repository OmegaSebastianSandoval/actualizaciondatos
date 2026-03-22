<?php

/**
 * clase que genera la insercion y edicion  de solicitud en la base de datos
 */
class Administracion_Model_DbTable_Solicitudesimagenes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'solicitudesimagenes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'solicitud_id';

	/**
	 * insert recibe la informacion de un solicitud y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$solicitud_numero_accion = $data['solicitud_numero_accion'];
		$solicitud_nombre = $data['solicitud_nombre'];
		$solicitud_apellidos = $data['solicitud_apellidos'];
		$solicitud_documento = $data['solicitud_documento'];
		$solicitud_telefono = $data['solicitud_telefono'];
		$solicitud_direccion = $data['solicitud_direccion'];
		$solicitud_ciudad = $data['solicitud_ciudad'];
		$solicitud_email_facturacion = $data['solicitud_email_facturacion'];
		$solicitud_email_comunicacion = $data['solicitud_email_comunicacion'];
		$solicitud_foto = $data['solicitud_foto'];
		$solicitud_observaciones = $data['solicitud_observaciones'];
		$solicitud_numero_accion_actual = $data['solicitud_numero_accion_actual'];
		$solicitud_nombre_actual = $data['solicitud_nombre_actual'];
		$solicitud_apellidos_actual = $data['solicitud_apellidos_actual'];
		$solicitud_documento_actual = $data['solicitud_documento_actual'];
		$solicitud_telefono_actual = $data['solicitud_telefono_actual'];
		$solicitud_direccion_actual = $data['solicitud_direccion_actual'];
		$solicitud_ciudad_actual = $data['solicitud_ciudad_actual'];
		$solicitud_email_facturacion_actual = $data['solicitud_email_facturacion_actual'];
		$solicitud_email_comunicacion_actual = $data['solicitud_email_comunicacion_actual'];
		$solicitud_foto_actual = $data['solicitud_foto_actual'];
		$solicitud_observaciones_actual = $data['solicitud_observaciones_actual'];
		$solicitud_fecha_ingreso = $data['solicitud_fecha_ingreso'];
		$solicitud_fecha_solicitud = $data['solicitud_fecha_solicitud'];
		$solicitud_acepta_politicas = $data['solicitud_acepta_politicas'];
		$solicitud_estado = $data['solicitud_estado'];
		$solicitud_ip = $data['solicitud_ip'];
		$solicitud_user_agent = $data['solicitud_user_agent'];
		$solicitud_usuario = $data['solicitud_usuario'];
		$solicitud_usuario_ip = $data['solicitud_usuario_ip'];
		$solicitud_usuario_user_agent = $data['solicitud_usuario_user_agent'];
		$solicitud_source = $data['solicitud_source'];
		$solicitud_declara_titular = $data['solicitud_declara_titular'];
		$query = "INSERT INTO solicitudesimagenes( solicitud_numero_accion, solicitud_nombre, solicitud_apellidos, solicitud_documento, solicitud_telefono, solicitud_direccion, solicitud_ciudad, solicitud_email_facturacion, solicitud_email_comunicacion, solicitud_foto, solicitud_observaciones, solicitud_numero_accion_actual, solicitud_nombre_actual, solicitud_apellidos_actual, solicitud_documento_actual, solicitud_telefono_actual, solicitud_direccion_actual, solicitud_ciudad_actual, solicitud_email_facturacion_actual, solicitud_email_comunicacion_actual, solicitud_foto_actual, solicitud_observaciones_actual, solicitud_fecha_ingreso, solicitud_fecha_solicitud, solicitud_acepta_politicas, solicitud_estado, solicitud_ip, solicitud_user_agent, solicitud_usuario, solicitud_usuario_ip, solicitud_usuario_user_agent, solicitud_source, solicitud_declara_titular) VALUES ( '$solicitud_numero_accion', '$solicitud_nombre', '$solicitud_apellidos', '$solicitud_documento', '$solicitud_telefono', '$solicitud_direccion', '$solicitud_ciudad', '$solicitud_email_facturacion', '$solicitud_email_comunicacion', '$solicitud_foto', '$solicitud_observaciones', '$solicitud_numero_accion_actual', '$solicitud_nombre_actual', '$solicitud_apellidos_actual', '$solicitud_documento_actual', '$solicitud_telefono_actual', '$solicitud_direccion_actual', '$solicitud_ciudad_actual', '$solicitud_email_facturacion_actual', '$solicitud_email_comunicacion_actual', '$solicitud_foto_actual', '$solicitud_observaciones_actual', '$solicitud_fecha_ingreso', '$solicitud_fecha_solicitud', '$solicitud_acepta_politicas', '$solicitud_estado', '$solicitud_ip', '$solicitud_user_agent', '$solicitud_usuario', '$solicitud_usuario_ip', '$solicitud_usuario_user_agent','$solicitud_source','$solicitud_declara_titular')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un solicitud  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$solicitud_numero_accion = $data['solicitud_numero_accion'];
		$solicitud_nombre = $data['solicitud_nombre'];
		$solicitud_apellidos = $data['solicitud_apellidos'];
		$solicitud_documento = $data['solicitud_documento'];
		$solicitud_telefono = $data['solicitud_telefono'];
		$solicitud_direccion = $data['solicitud_direccion'];
		$solicitud_ciudad = $data['solicitud_ciudad'];
		$solicitud_email_facturacion = $data['solicitud_email_facturacion'];
		$solicitud_email_comunicacion = $data['solicitud_email_comunicacion'];
		$solicitud_foto = $data['solicitud_foto'];
		$solicitud_observaciones = $data['solicitud_observaciones'];
		$solicitud_numero_accion_actual = $data['solicitud_numero_accion_actual'];
		$solicitud_nombre_actual = $data['solicitud_nombre_actual'];
		$solicitud_apellidos_actual = $data['solicitud_apellidos_actual'];
		$solicitud_documento_actual = $data['solicitud_documento_actual'];
		$solicitud_telefono_actual = $data['solicitud_telefono_actual'];
		$solicitud_direccion_actual = $data['solicitud_direccion_actual'];
		$solicitud_ciudad_actual = $data['solicitud_ciudad_actual'];
		$solicitud_source = $data['solicitud_source'];
		$solicitud_email_facturacion_actual = $data['solicitud_email_facturacion_actual'];
		$solicitud_email_comunicacion_actual = $data['solicitud_email_comunicacion_actual'];
		$solicitud_foto_actual = $data['solicitud_foto_actual'];
		$solicitud_observaciones_actual = $data['solicitud_observaciones_actual'];
		$solicitud_fecha_ingreso = $data['solicitud_fecha_ingreso'];
		$solicitud_fecha_solicitud = $data['solicitud_fecha_solicitud'];
		$solicitud_acepta_politicas = $data['solicitud_acepta_politicas'];
		$solicitud_estado = $data['solicitud_estado'];
		$solicitud_ip = $data['solicitud_ip'];
		$solicitud_user_agent = $data['solicitud_user_agent'];
		$solicitud_usuario = $data['solicitud_usuario'];
		$solicitud_usuario_ip = $data['solicitud_usuario_ip'];
		$solicitud_usuario_user_agent = $data['solicitud_usuario_user_agent'];
		$solicitud_declara_titular = $data['solicitud_declara_titular'];

		$query = "UPDATE solicitudesimagenes SET  solicitud_numero_accion = '$solicitud_numero_accion', solicitud_nombre = '$solicitud_nombre', solicitud_apellidos = '$solicitud_apellidos', solicitud_documento = '$solicitud_documento', solicitud_telefono = '$solicitud_telefono', solicitud_direccion = '$solicitud_direccion', solicitud_ciudad = '$solicitud_ciudad', solicitud_email_facturacion = '$solicitud_email_facturacion', solicitud_email_comunicacion = '$solicitud_email_comunicacion', solicitud_foto = '$solicitud_foto', solicitud_observaciones = '$solicitud_observaciones', solicitud_numero_accion_actual = '$solicitud_numero_accion_actual', solicitud_nombre_actual = '$solicitud_nombre_actual', solicitud_apellidos_actual = '$solicitud_apellidos_actual', solicitud_documento_actual = '$solicitud_documento_actual', solicitud_telefono_actual = '$solicitud_telefono_actual', solicitud_direccion_actual = '$solicitud_direccion_actual', solicitud_ciudad_actual = '$solicitud_ciudad_actual', solicitud_email_facturacion_actual = '$solicitud_email_facturacion_actual', solicitud_email_comunicacion_actual = '$solicitud_email_comunicacion_actual', solicitud_foto_actual = '$solicitud_foto_actual', solicitud_observaciones_actual = '$solicitud_observaciones_actual', solicitud_fecha_ingreso = '$solicitud_fecha_ingreso', solicitud_fecha_solicitud = '$solicitud_fecha_solicitud', solicitud_acepta_politicas = '$solicitud_acepta_politicas', solicitud_estado = '$solicitud_estado', solicitud_ip = '$solicitud_ip', solicitud_user_agent = '$solicitud_user_agent', solicitud_usuario = '$solicitud_usuario', solicitud_usuario_ip = '$solicitud_usuario_ip', solicitud_usuario_user_agent = '$solicitud_usuario_user_agent', solicitud_declara_titular = '$solicitud_declara_titular', solicitud_source = '$solicitud_source' WHERE solicitud_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	/**
	 * updateExtraFields Actualiza campos adicionales que no se guardan en insert() 
	 * @param  integer $id Identificador de la solicitud
	 * @param  array $fields Array con los campos adicionales a actualizar
	 * @return void
	 */
	public function updateExtraFields($id, $fields)
	{
		$setParts = [];
		foreach ($fields as $field => $value) {
			$escapedValue = mysqli_real_escape_string($this->_conn->getConnection(), $value);
			$setParts[] = "$field = '$escapedValue'";
		}

		if (empty($setParts)) {
			return;
		}

		$query = "UPDATE solicitudesimagenes SET " . implode(', ', $setParts) . " WHERE solicitud_id = '" . $id . "'";
		$this->_conn->query($query);
	}
}
