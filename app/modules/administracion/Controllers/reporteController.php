<?php

class Administracion_reporteController extends Administracion_mainController
{
	public $botonpanel = 36;

	public function indexAction()
	{
		ini_set('memory_limit', '512M');

		$solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
		$db = App::getDbConnection();
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
			'total_fotos_subidas' => 0,
		];
		$approvedUserIds = [];
		$creatorBySolicitud = [];
		$missingCreatorSolicitudIds = [];

		foreach ($rawList as $item) {
			$metrics['total']++;

			$estado = (int) $item->solicitud_estado;
			switch ($estado) {
				case 1:
					$metrics['pendientes']++;
					break;
				case 2:
					$metrics['aprobados']++;
					$usuarioId = isset($item->solicitud_usuario) ? (int) $item->solicitud_usuario : 0;
					if ($usuarioId > 0) {
						$approvedUserIds[$usuarioId] = true;
					}
					break;
				case 3:
					$metrics['rechazados']++;
					break;
			}

			$source = isset($item->solicitud_source) ? (string) $item->solicitud_source : '';
			if ($source === 'actualizacion_publica') {
				$metrics['desde_publica']++;
			} else {
				$metrics['desde_admin']++;
				$solicitudId = (int) $item->solicitud_id;
				$creatorId = isset($item->solicitud_solicitado_por) ? (int) $item->solicitud_solicitado_por : 0;
				if ($creatorId > 0) {
					$creatorBySolicitud[$solicitudId] = $creatorId;
				} else {
					$missingCreatorSolicitudIds[$solicitudId] = true;
				}
			}

			// Tiempo solicitud -> aprobación para solicitudes aprobadas.
			if ($estado === 2 && !empty($item->solicitud_fecha_solicitud) && !empty($item->solicitud_fecha_aprobacion)) {
				$createdAt = strtotime($item->solicitud_fecha_solicitud);
				$approvedAt = strtotime($item->solicitud_fecha_aprobacion);
				if ($createdAt !== false && $approvedAt !== false && $approvedAt >= $createdAt) {
					$metrics['times_to_approval'][] = ($approvedAt - $createdAt);
				}
			}

			if ($item->solicitud_foto != $item->solicitud_foto_actual) {
				$metrics['total_fotos_subidas1']++;

				$actual = $item->solicitud_foto_actual;

				if (preg_match('/^[0-9a-fA-F]+$/', $actual) && strlen($actual) % 2 == 0) {
					$actual = hex2bin($actual);
				} else {
					$decoded = base64_decode($actual, true);
					if ($decoded !== false) {
						$actual = $decoded;
					}
				}

				$nueva = $item->solicitud_foto;
				$decodedNueva = base64_decode($nueva, true);
				if ($decodedNueva !== false) {
					$nueva = $decodedNueva;
				}

				if ($nueva !== $actual) {
					$metrics['total_fotos_subidas']++;
					if ($_GET['test'] == 1) {
						print_r([
							'solicitud_id' => $item->solicitud_id,
						]);
						echo '<br>';
					}
				}
			}
		}

		if (!empty($missingCreatorSolicitudIds)) {
			$solicitudIds = array_keys($missingCreatorSolicitudIds);
			$solicitudIds = array_map('intval', $solicitudIds);
			$solicitudIds = array_filter($solicitudIds, function ($id) {
				return $id > 0;
			});

			if (!empty($solicitudIds)) {
				$inClause = implode(',', $solicitudIds);
				$sqlFirstLogs = "
					SELECT l.log_solicitud_solicitud, l.log_solicitud_usuario
					FROM log_solicitudes l
					INNER JOIN (
						SELECT log_solicitud_solicitud, MIN(log_solicitud_id) AS first_log_id
						FROM log_solicitudes
						WHERE log_solicitud_solicitud IN ($inClause)
						GROUP BY log_solicitud_solicitud
					) first_logs ON first_logs.first_log_id = l.log_solicitud_id
				";
				$firstLogs = $db->query($sqlFirstLogs)->fetchAsObject();
				if (!empty($firstLogs)) {
					foreach ($firstLogs as $logRow) {
						$sid = isset($logRow->log_solicitud_solicitud) ? (int) $logRow->log_solicitud_solicitud : 0;
						$uid = isset($logRow->log_solicitud_usuario) ? (int) $logRow->log_solicitud_usuario : 0;
						if ($sid > 0 && $uid > 0) {
							$creatorBySolicitud[$sid] = $uid;
						}
					}
				}
			}
		}

		$allUserIdsMap = $approvedUserIds;
		foreach ($creatorBySolicitud as $creatorId) {
			$creatorId = (int) $creatorId;
			if ($creatorId > 0) {
				$allUserIdsMap[$creatorId] = true;
			}
		}

		$userNameCache = [];
		if (!empty($allUserIdsMap)) {
			$userIds = array_keys($allUserIdsMap);
			$userIds = array_map('intval', $userIds);
			$userIds = array_filter($userIds, function ($id) {
				return $id > 0;
			});

			if (!empty($userIds)) {
				$userInClause = implode(',', $userIds);
				$sqlUsers = "SELECT user_id, user_names FROM user WHERE user_id IN ($userInClause)";
				$users = $db->query($sqlUsers)->fetchAsObject();
				if (!empty($users)) {
					foreach ($users as $user) {
						$uid = isset($user->user_id) ? (int) $user->user_id : 0;
						if ($uid > 0) {
							$userNameCache[$uid] = !empty($user->user_names) ? $user->user_names : ('Usuario #' . $uid);
						}
					}
				}
			}
		}

		foreach ($rawList as $item) {
			$estado = (int) $item->solicitud_estado;
			$source = isset($item->solicitud_source) ? (string) $item->solicitud_source : '';
			$sourceLabel = ($source === 'actualizacion_publica') ? 'Actualización pública' : 'Administrador';

			if ($estado === 2) {
				$usuarioId = isset($item->solicitud_usuario) ? (int) $item->solicitud_usuario : 0;
				if ($usuarioId > 0) {
					$userName = isset($userNameCache[$usuarioId]) ? $userNameCache[$usuarioId] : ('Usuario #' . $usuarioId);
					if (!isset($metrics['aprobados_por_usuario'][$userName])) {
						$metrics['aprobados_por_usuario'][$userName] = 0;
					}
					$metrics['aprobados_por_usuario'][$userName]++;
				}
			}

			if ($source !== 'actualizacion_publica') {
				$sid = (int) $item->solicitud_id;
				$creatorId = isset($creatorBySolicitud[$sid]) ? (int) $creatorBySolicitud[$sid] : 0;
				if ($creatorId > 0) {
					$userName = isset($userNameCache[$creatorId]) ? $userNameCache[$creatorId] : ('Usuario #' . $creatorId);
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
				'estado' => $estado,
				'estado_label' => $this->_estadoLabel($estado),
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

		// Calcular promedio tiempo aprobación en horas (si aplica)
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
		echo '<th>Número acción</th>';
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