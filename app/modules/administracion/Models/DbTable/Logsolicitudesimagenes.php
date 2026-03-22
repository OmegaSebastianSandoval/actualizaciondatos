<?php

/**
 * clase que genera la insercion y edicion  de logsolicitud en la base de datos
 */
class Administracion_Model_DbTable_Logsolicitudesimagenes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'log_solicitudesimagenes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'log_solicitud_id';

	/**
	 * insert recibe la informacion de un logsolicitud y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$log_solicitud_usuario = $data['log_solicitud_usuario'];
		$log_solicitud_cliente = $data['log_solicitud_cliente'];
		$log_solicitud_solicitud = $data['log_solicitud_solicitud'];
		$log_solicitud_fecha_datos_anteriores = $data['log_solicitud_fecha_datos_anteriores'];
		$log_solicitud_datos_completos = $data['log_solicitud_datos_completos'];
		$log_solicitud_datos_nuevos = $data['log_solicitud_datos_nuevos'];
		$log_solicitud_ip_usuario = $data['log_solicitud_ip_usuario'];
		$log_solicitud_user_agent_usuario = $data['log_solicitud_user_agent_usuario'];
		$log_solicitud_ip_cliente = $data['log_solicitud_ip_cliente'];
		$log_solicitud_user_agent_cliente = $data['log_solicitud_user_agent_cliente'];
		$log_solicitud_fecha_datos_nuevos = $data['log_solicitud_fecha_datos_nuevos'];
		$query = "INSERT INTO log_solicitudesimagenes( log_solicitud_usuario, log_solicitud_cliente, log_solicitud_solicitud, log_solicitud_fecha_datos_anteriores, log_solicitud_datos_completos, log_solicitud_datos_nuevos, log_solicitud_ip_usuario, log_solicitud_user_agent_usuario, log_solicitud_ip_cliente, log_solicitud_user_agent_cliente, log_solicitud_fecha_datos_nuevos) VALUES ( '$log_solicitud_usuario', '$log_solicitud_cliente', '$log_solicitud_solicitud', '$log_solicitud_fecha_datos_anteriores', '$log_solicitud_datos_completos', '$log_solicitud_datos_nuevos', '$log_solicitud_ip_usuario', '$log_solicitud_user_agent_usuario', '$log_solicitud_ip_cliente', '$log_solicitud_user_agent_cliente', '$log_solicitud_fecha_datos_nuevos')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un logsolicitud  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$log_solicitud_usuario = $data['log_solicitud_usuario'];
		$log_solicitud_cliente = $data['log_solicitud_cliente'];
		$log_solicitud_solicitud = $data['log_solicitud_solicitud'];
		$log_solicitud_fecha_datos_anteriores = $data['log_solicitud_fecha_datos_anteriores'];
		$log_solicitud_datos_completos = $data['log_solicitud_datos_completos'];
		$log_solicitud_datos_nuevos = $data['log_solicitud_datos_nuevos'];
		$log_solicitud_ip_usuario = $data['log_solicitud_ip_usuario'];
		$log_solicitud_user_agent_usuario = $data['log_solicitud_user_agent_usuario'];
		$log_solicitud_ip_cliente = $data['log_solicitud_ip_cliente'];
		$log_solicitud_user_agent_cliente = $data['log_solicitud_user_agent_cliente'];
		$log_solicitud_fecha_datos_nuevos = $data['log_solicitud_fecha_datos_nuevos'];
		$query = "UPDATE log_solicitudesimagenes SET  log_solicitud_usuario = '$log_solicitud_usuario', log_solicitud_cliente = '$log_solicitud_cliente', log_solicitud_solicitud = '$log_solicitud_solicitud', log_solicitud_fecha_datos_anteriores = '$log_solicitud_fecha_datos_anteriores', log_solicitud_datos_completos = '$log_solicitud_datos_completos', log_solicitud_datos_nuevos = '$log_solicitud_datos_nuevos', log_solicitud_ip_usuario = '$log_solicitud_ip_usuario', log_solicitud_user_agent_usuario = '$log_solicitud_user_agent_usuario', log_solicitud_ip_cliente = '$log_solicitud_ip_cliente', log_solicitud_user_agent_cliente = '$log_solicitud_user_agent_cliente', log_solicitud_fecha_datos_nuevos = '$log_solicitud_fecha_datos_nuevos' WHERE log_solicitud_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
}
