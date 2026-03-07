<?php

class Administracion_reporteController extends Administracion_mainController
{
	public $botonpanel = 36;

	public function indexAction()
	{
		$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
		$usuariosModel = new Administracion_Model_DbTable_Usuario();
		$logSolicitudModel = new Administracion_Model_DbTable_Logsolicitudes();
		$rawList = $solicitudesModel->getList();

		$reportRows = [];
		$metrics = [
			'total' => 0,
			'pendientes' => 0,
			'aprobados' => 0,
			'rechazados' => 0,
			// tiempos (segundos) desde solicitud -> aprobación
			'times_to_approval' => [],
			'aprobados_por_usuario' => [],
			'creadas_por_usuario' => [],
			// origen: pública vs administrador
			'desde_publica' => 0,
			'desde_admin' => 0,
		];
		$userNameCache = [];

		foreach ($rawList as $item) {
			$metrics['total']++;

			// Cuenta estados
			switch ((int) $item->solicitud_estado) {
				case 1:
					$metrics['pendientes']++;
					break;
				case 2:
					$metrics['aprobados']++;
					$usuarioId = (int) $item->solicitud_usuario;
					if ($usuarioId > 0) {
						if (!isset($userNameCache[$usuarioId])) {
							$user = $usuariosModel->getById($usuarioId);
							$userNameCache[$usuarioId] = ($user && !empty($user->user_names)) ? $user->user_names : ('Usuario #' . $usuarioId);
						}
						$userName = $userNameCache[$usuarioId];
						if (!isset($metrics['aprobados_por_usuario'][$userName])) {
							$metrics['aprobados_por_usuario'][$userName] = 0;
						}
						$metrics['aprobados_por_usuario'][$userName]++;
					}
					break;
				case 3:
					$metrics['rechazados']++;
					break;
			}


			// Cuenta origen (actualizacion_publica -> vía pública, cualquier otro valor -> administrador)
			$source = isset($item->solicitud_source) ? (string) $item->solicitud_source : '';
			if ($source === 'actualizacion_publica') {
				$metrics['desde_publica']++;
				$sourceLabel = 'Actualización pública';
			} else {
				$metrics['desde_admin']++;
				$sourceLabel = 'Administrador';
			}

			// Contar solicitudes creadas por usuario (excluir las creadas desde actualizacion_publica)
			if ($source !== 'actualizacion_publica') {
				$creatorId = 0;
				if (!empty($item->solicitud_solicitado_por)) {
					$creatorId = (int) $item->solicitud_solicitado_por;
				}
				// Si no hay campo solicitud_solicitado_por, buscar en logs
				if ($creatorId <= 0) {
					$logs = $logSolicitudModel->getList("log_solicitud_solicitud = '{$item->solicitud_id}'", "log_solicitud_id ASC");
					if (!empty($logs) && isset($logs[0]->log_solicitud_usuario)) {
						$creatorId = (int) $logs[0]->log_solicitud_usuario;
					}
				}

				if ($creatorId > 0) {
					if (!isset($userNameCache[$creatorId])) {
						$user = $usuariosModel->getById($creatorId);
						$userNameCache[$creatorId] = ($user && !empty($user->user_names)) ? $user->user_names : ('Usuario #' . $creatorId);
					}
					$userName = $userNameCache[$creatorId];
					if (!isset($metrics['creadas_por_usuario'][$userName])) {
						$metrics['creadas_por_usuario'][$userName] = 0;
					}
					$metrics['creadas_por_usuario'][$userName]++;
				}
			}



			// Fila para reporte (sanitizando / enmascarando)
			$reportRows[] = (object) [
				'solicitud_id' => $item->solicitud_id,
				'solicitud_numero_accion' => $item->solicitud_numero_accion,
				'nombre_completo' => trim($item->solicitud_nombre . ' ' . $item->solicitud_apellidos),
				'documento_mask' => ($item->solicitud_documento),
				'telefono_mask' => ($item->solicitud_telefono),
				'email_facturacion' => $item->solicitud_email_facturacion,
				'direccion' => $item->solicitud_direccion,
				'ciudad' => $item->solicitud_ciudad,
				'fecha_ingreso' => $item->solicitud_fecha_ingreso,
				'fecha_solicitud' => $item->solicitud_fecha_solicitud,
				'fecha_aprobacion' => $item->solicitud_fecha_aprobacion,
				'estado' => (int) $item->solicitud_estado,
				'estado_label' => $this->_estadoLabel((int) $item->solicitud_estado),
				'acepta_politicas' => (bool) $item->solicitud_acepta_politicas,
				'ip' => $item->solicitud_ip,
				'user_agent' => $item->solicitud_user_agent,
				'observaciones' => $item->solicitud_observaciones,
				'source' => $source,
				'source_label' => $sourceLabel
			];
		}

		if (!empty($metrics['aprobados_por_usuario'])) {
			arsort($metrics['aprobados_por_usuario']);
		}

		if (!empty($metrics['creadas_por_usuario'])) {
			arsort($metrics['creadas_por_usuario']);
		}

		// Calcular promedio tiempo aprobacin en horas (si aplica)
		$avgApprovalHours = null;
		if (is_countable($metrics['times_to_approval']) && count($metrics['times_to_approval']) > 0) {
			$avgSeconds = array_sum($metrics['times_to_approval']) / count($metrics['times_to_approval']);
			$avgApprovalHours = round($avgSeconds / 3600, 2);
		}

		$metrics['promedio_horas_aprobacion'] = $avgApprovalHours;

		// Preparar vista
		$this->_view->reportRows = $reportRows;
		$this->_view->metrics = $metrics;
		// Compatibilidad: asignamos `$this->data` en la vista para usar `$this->data` directamente
		$this->_view->data = [
			'reportRows' => $reportRows,
			'metrics' => $metrics,
		];

		// Soporta export XLS por query param: ?export=xls
		if (isset($_GET['export']) && $_GET['export'] === 'xls') {
			$this->_exportXls($reportRows);
			exit;
		}

	}

	private function _estadoLabel(int $estado)
	{
		switch ($estado) {
			case 1:
				return 'Pendiente';
			case 2:
				return 'Aprobado';
			case 3:
				return 'Rechazado';
			default:
				return 'Desconocido';
		}
	}

	private function _maskDocument(?string $doc)
	{
		if (empty($doc))
			return '';
		$len = strlen($doc);
		if ($len <= 4)
			return str_repeat('*', max(0, $len - 2)) . substr($doc, -2);
		return substr($doc, 0, 2) . str_repeat('*', max(0, $len - 4)) . substr($doc, -2);
	}

	private function _maskPhone(?string $phone)
	{
		if (empty($phone))
			return '';
		$len = strlen($phone);
		if ($len <= 4)
			return str_repeat('*', $len);
		return substr($phone, 0, $len - 4) . str_repeat('*', 4);
	}

	private function _exportXls(array $rows)
	{
		$filename = 'reporte_solicitudes_' . date('Ymd_His') . '.xls';
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		echo "\xEF\xBB\xBF"; // UTF-8 BOM

		// Cabecera
		echo '<table border="1">';
		echo '<thead><tr>';
		echo '<th>ID</th>';
		echo '<th>Número accin</th>';
		echo '<th>Estado</th>';
		echo '<th>Nombre completo</th>';
		echo '<th>Documento</th>';
		echo '<th>Teléfono</th>';
		echo '<th>Email facturación</th>';
		echo '<th>Dirección</th>';
		echo '<th>Ciudad</th>';
		echo '<th>Fecha ingreso</th>';
		echo '<th>Fecha solicitud</th>';
		echo '<th>Fecha aprobación</th>';
		echo '<th>Acepta políticas</th>';
		echo '<th>IP</th>';
		echo '<th>User agent</th>';
		echo '<th>Fuente</th>';
		echo '<th>Observaciones</th>';
		echo '</tr></thead>';
		echo '<tbody>';

		foreach ($rows as $r) {
			echo '<tr>';
			echo '<td>' . htmlspecialchars($r->solicitud_id) . '</td>';
			echo '<td>' . htmlspecialchars($r->solicitud_numero_accion) . '</td>';
			echo '<td>' . htmlspecialchars($r->estado_label) . '</td>';
			echo '<td>' . htmlspecialchars($r->nombre_completo) . '</td>';
			echo '<td>' . htmlspecialchars($r->documento_mask) . '</td>';
			echo '<td>' . htmlspecialchars($r->telefono_mask) . '</td>';
			echo '<td>' . htmlspecialchars($r->email_facturacion) . '</td>';
			echo '<td>' . htmlspecialchars($r->direccion) . '</td>';
			echo '<td>' . htmlspecialchars($r->ciudad) . '</td>';
			echo '<td>' . htmlspecialchars($r->fecha_ingreso) . '</td>';
			echo '<td>' . htmlspecialchars($r->fecha_solicitud) . '</td>';
			echo '<td>' . htmlspecialchars($r->fecha_aprobacion) . '</td>';
			echo '<td>' . ($r->acepta_politicas ? 'Sí' : 'No') . '</td>';
			echo '<td>' . htmlspecialchars($r->ip) . '</td>';
			echo '<td>' . htmlspecialchars($r->user_agent) . '</td>';
			$srcLabel = '';
			if (isset($r->source_label) && !empty($r->source_label)) {
				$srcLabel = $r->source_label;
			} else {
				$srcLabel = (isset($r->source) && $r->source === 'actualizacion_publica') ? 'Actualización pública' : 'Administrador';
			}
			echo '<td>' . htmlspecialchars($srcLabel) . '</td>';
			echo '<td>' . htmlspecialchars($r->observaciones) . '</td>';
			echo '</tr>';
		}

		echo '</tbody></table>';
	}
}