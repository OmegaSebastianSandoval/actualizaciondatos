<?php if ($_SESSION['kt_login_level'] == 10): ?>
	<style>
		#panel-botones {
			display: none;
			transition: all 0.5s;
		}

		#contenido_panel {
			max-width: 100% !important;
			flex: 0 0 100%;
		}
	</style>
<?php endif; ?>
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid  m-0 p-0">
	<form action="<?php echo $this->route; ?>" method="post">
		<div class="content-dashboard  m-0 p-2">
			<div class="row">
				<div class="col-6 col-md-3 ">
					<label>Numero acci&oacute;n</label>
					<label class="input-group">

						<span class="input-group-text input-icono fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>

						<input type="text" class="form-control" name="solicitud_numero_accion"
							value="<?php echo $this->getObjectVariable($this->filters, 'solicitud_numero_accion') ?>"></input>
					</label>
				</div>
				<div class="col-6 col-md-3 ">
					<label>Nombre</label>
					<label class="input-group">

						<span class="input-group-text input-icono fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
						<input type="text" class="form-control" name="solicitud_nombre"
							value="<?php echo $this->getObjectVariable($this->filters, 'solicitud_nombre') ?>"></input>
					</label>
				</div>
				<div class="col-6 col-md-3 ">
					<label>Apellidos</label>
					<label class="input-group">

						<span class="input-group-text input-icono fondo-azul "><i class="fas fa-pencil-alt"></i></span>

						<input type="text" class="form-control" name="solicitud_apellidos"
							value="<?php echo $this->getObjectVariable($this->filters, 'solicitud_apellidos') ?>"></input>
					</label>
				</div>
				<div class="col-6 col-md-3 ">
					<label>Fecha de solicitud</label>
					<label class="input-group">

						<span class="input-group-text input-icono fondo-cafe "><i class="fas fa-pencil-alt"></i></span>

						<input type="date" class="form-control" name="solicitud_fecha_solicitud"
							value="<?php echo $this->getObjectVariable($this->filters, 'solicitud_fecha_solicitud') ?>"></input>
					</label>
				</div>
				<div class="col-6 col-md-6">
					<label>Estado</label>
					<label class="input-group">

						<span class="input-group-text input-icono fondo-verde "><i class="far fa-list-alt"></i></span>

						<select class="form-control" name="solicitud_estado">
							<option value="">Todas</option>
							<?php foreach ($this->list_solicitud_estado as $key => $value): ?>
								<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'solicitud_estado') == $key) {
										echo "selected";
									} ?>><?= $value; ?></option>
							<?php endforeach ?>
						</select>
					</label>
				</div>
				<div class="col-6 col-md-3 d-flex align-items-end ">

					<button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
				</div>
				<div class="col-6 col-md-3 d-flex align-items-end">

					<a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1"> <i
							class="fas fa-eraser"></i> Limpiar Filtro</a>
				</div>
			</div>
		</div>
	</form>

	<!-- Paginación inferior -->
	<?php if ($this->totalpages > 1): ?>
		<div class="mt-4 mb-5 ">
			<nav aria-label="Paginación">
				<ul class="pagination justify-content-center">
					<?php
					$url = $this->route;
					$maxSide = 5; // mostrar hasta 5 páginas a cada lado
					$start = max(1, $this->page - $maxSide);
					$end = min($this->totalpages, $this->page + $maxSide);

					if ($this->page != 1) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page - 1) . '">&laquo; Anterior</a></li>';
					}

					// Mostrar primera página y puntos si es necesario
					if ($start > 1) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=1">1</a></li>';
						if ($start > 2) {
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
						}
					}

					for ($i = $start; $i <= $end; $i++) {
						if ($this->page == $i) {
							echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
						} else {
							echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
						}
					}

					// Mostrar puntos y última página si es necesario
					if ($end < $this->totalpages) {
						if ($end < $this->totalpages - 1) {
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
						}
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $this->totalpages . '">' . $this->totalpages . '</a></li>';
					}

					if ($this->page != $this->totalpages) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
					}
					?>
				</ul>
			</nav>
		</div>
	<?php endif; ?>
	<?php if ($this->error && $this->tipo_error) { ?>
		<div class="alert alert-<?= $this->tipo_error ?> text-center">
			<?= $this->error ?>
		</div>
	<?php } ?>
	<?php if ($this->response && 1 == 0) { ?>

		<div class="alert alert-<?= $this->response->status == 'success' ? $this->response->status : 'danger' ?>">
			<p> <?= $this->response->message ?></p>

			<?php if ($this->response->detalles && 1 == 0) { ?>
				<ul>
					<?php foreach ($this->response->detalles as $detalle) { ?>
						<li><?= $detalle ?></li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>

	<?php } ?>


	<div class="content-dashboard m-0 p-2">
		<div class="franja-paginas">
			<div class="row align-items-center">
				<div class="col-3">
					<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
				</div>
				<div class="col-4 text-end">
					<div class="texto-paginas">Registros por pagina:</div>
				</div>
				<div class="col-2">
					<select class="form-control form-control-sm selectpagination">
						<option value="20" <?php if ($this->pages == 20) {
							echo 'selected';
						} ?>>20</option>
						<option value="30" <?php if ($this->pages == 30) {
							echo 'selected';
						} ?>>30</option>
						<option value="50" <?php if ($this->pages == 50) {
							echo 'selected';
						} ?>>50</option>
						<option value="100" <?php if ($this->pages == 100) {
							echo 'selected';
						} ?>>100</option>
					</select>
				</div>
				<div class="col-3">
					<?php if ($_SESSION['kt_login_level'] != 10 && $_SESSION['kt_login_level'] != 15): ?>

						<div class="text-end d-flex justify-content-end" style="gap:6px;">
							<a class="btn btn-sm btn-info" href="<?php echo $this->route . "/fotocarnet?limpiar=1"; ?>">
								<i class="fas fa-camera"></i> Actualizar foto
							</a>
							<a class="btn btn-sm btn-success" href="<?php echo $this->route . "\crear?limpiar=1"; ?>"> <i
									class="fas fa-plus-square"></i> Actualizar
								socio </a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<!-- Scroll horizontal superior sincronizado -->
		<div class="scroll-wrapper-top" style="overflow-x: auto; overflow-y: hidden; margin-bottom: 10px;">
			<div class="scroll-content-top" style="height: 1px;"></div>
		</div>
		<div class="content-table  m-0 p-0 border-0 overflow-auto w-100" id="table-wrapper">
			<table class=" table  text-start">
				<thead>
					<tr>
						<td>N&uacute;mero acci&oacute;n</td>
						<td>Nombre</td>
						<td>Apellidos</td>
						<td>Documento</td>
						<td>Teléfono</td>
						<td width="300">Dirección</td>
						<td>Ciudad</td>
						<td>Email de facturación</td>
						<td>Email de comunicación </td>
						<td>Foto</td>

						<td width="150">Fecha de la solicitud</td>
						<td>Estado</td>
						<td width="200"></td>
					</tr>
				</thead>
				<tbody>
					<?php
					function colorTexto($estado)
					{
						$colorTexto = "";
						if ($estado == 1) {
							$colorTexto = "text-primary";
						}
						if ($estado == 2) {
							$colorTexto = "text-success";
						}
						if ($estado == 3) {
							$colorTexto = "text-danger";
						}
						return $colorTexto;
					}
					function colorBadge($estado)
					{
						$colorTexto = "";
						if ($estado == 1) {
							$colorTexto = "badge text-bg-warning";
						}
						if ($estado == 2) {
							$colorTexto = "badge text-bg-success";
						}
						if ($estado == 3) {
							$colorTexto = "badge text-bg-danger";
						}
						return $colorTexto;
					}
					?>
					<?php foreach ($this->lists as $key => $content) { ?>
						<?php $id = $content->solicitud_id;
						$fotoActual = generateBase64Image($content->solicitud_foto_actual);
						$fotoNueva = generateBase64Image($content->solicitud_foto);

						?>
						<?php

						$bgColor = $key % 2 == 0 ? 'background-color:#dedede;' : 'background-color:#FFF;';
						?>
						<tr class="bg-primary  bg-opacity-50 text-white">
							<td colspan="10" class="bg-primary bg-opacity-50 text-white p-1">
								<p class="text-start font-weight-bold my-0">
									<?= $content->solicitud_estado == 1
										? 'Información actual'
										: 'Información anterior'; ?>
								</p>
							</td>
							<td style="<?= $bgColor ?> color:initial !important" rowspan="4"><?= $content->solicitud_fecha_solicitud; ?>
							</td>
							<td style="<?= $bgColor ?> color:initial !important" rowspan="4"
								class=" <?= colorTexto($content->solicitud_estado) ?> fw-bold" style="font-weight:bold;">
								<span class="<?= colorBadge($content->solicitud_estado) ?>">
									<?= $this->list_solicitud_estado[$content->solicitud_estado]; ?>
								</span>
							<td style="<?= $bgColor ?> color:initial !important" rowspan="4" class="text-end">
								<div class="d-flex justify-content-center " style="gap:3px;">
									<?php if ($content->solicitud_estado == 1) { ?>
										<?php if ($_SESSION['kt_login_level'] != 10 && $_SESSION['kt_login_level'] != 15): ?>

											<button class="btn btn-verde btn-sm" data-bs-toggle="modal" data-bs-target="#modalAprobar<?= $id ?>"
												title="Aprobar"><i class="fas fa-check"></i></button>

											<button class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modalRechazar<?= $id ?>"
												title="Rechazar"><i class="fas fa-window-close"></i></button>

											<a class="btn btn-azul btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>"
												data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
										<?php else: ?>
											<a class="btn btn-verde btn-sm" href="<?php echo $this->route; ?>/manage?id=<?= $id ?>"
												data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></a>
										<?php endif; ?>
									<?php } ?>
									<?php if ($content->solicitud_estado != 1) { ?>
										<a class="btn btn-verde btn-sm" href="<?php echo $this->route; ?>/info?id=<?= $id ?>"
											data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></a>
									<?php } ?>
									<!-- <span data-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt"></i></a></span> -->
								</div>

							</td>
						</tr>
						<tr style="<?= $bgColor ?>">
							<td><?= $content->solicitud_numero_accion; ?></td>
							<td><?= $content->solicitud_nombre_actual; ?></td>
							<td><?= $content->solicitud_apellidos_actual; ?></td>
							<td><?= $content->solicitud_documento_actual; ?></td>
							<td><?= $content->solicitud_telefono_actual; ?></td>
							<td><?= $content->solicitud_direccion_actual; ?></td>
							<td><?= $this->ciudades[$content->solicitud_departamento_actual][$content->solicitud_ciudad_actual]; ?></td>
							<td><?= $content->solicitud_email_facturacion_actual; ?></td>
							<td><?= $content->solicitud_email_comunicacion_actual; ?></td>
							<td class="text-center">
								<?php if ($fotoActual) { ?>
									<img src="<?= $fotoActual ?>" alt="Imagen" class="img-cambio">
									<!-- Campo oculto con la misma imagen en Base64 -->
								<?php } else { ?>
									-
								<?php } ?>
							</td>

						</tr>
						<tr style="<?= $bgColor ?>" class="<?= $content->solicitud_estado == 1
								? 'bg-primary-pastel'
								: ($content->solicitud_estado == 2
									? 'bg-success-pastel'
									: 'bg-danger-pastel') ?>">
							<td colspan="10" class="bg-primary text-white bg-opacity-50">
								<p class="text-start font-weight-bold my-0 text-white
								">
									<?= $content->solicitud_estado == 1
										? 'Información pendiente a aprobar'
										: ($content->solicitud_estado == 2
											? 'Información aprobada'
											: 'Información rechazada') ?>
								</p>
							</td>
						</tr>
						</td>
						<tr class="mb-4" style="<?= $key % 2 == 0 ? 'background-color:#d4cfcfb5;' : 'background-color:#FFF;'; ?>">

							<td><?= $content->solicitud_numero_accion; ?></td>
							<td><?= $content->solicitud_nombre; ?></td>
							<td><?= $content->solicitud_apellidos; ?></td>
							<td><?= $content->solicitud_documento; ?></td>
							<td><?= $content->solicitud_telefono; ?></td>
							<td><?= $content->solicitud_direccion; ?></td>
							<td><?= $this->ciudades[$content->solicitud_departamento][$content->solicitud_ciudad]; ?></td>
							<td><?= $content->solicitud_email_facturacion; ?></td>
							<td><?= $content->solicitud_email_comunicacion; ?></td>
							<td class="text-center">

								<?php if ($fotoNueva) { ?>
									<img src="<?= $fotoNueva ?>" alt="Imagen" class="img-cambio">
									<!-- Campo oculto con la misma imagen en Base64 -->
								<?php } else { ?>
									-
								<?php } ?>

							</td>


						</tr>
						<tr>
							<td colspan="13" class="p-3">
							</td>
						</tr>

						<!-- Modal Aprobar -->
						<div class="modal fade" id="modalAprobar<?= $id ?>" tabindex="-1" role="dialog"
							aria-labelledby="modalAprobarLabel<?= $id ?>" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header bg-success text-white">
										<h5 class="modal-title" id="modalAprobarLabel<?= $id ?>">
											<i class="fas fa-check-circle"></i> Confirmar Aprobación
										</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
											style="filter: invert(1);"></button>
									</div>
									<div class="modal-body">
										<p class="mb-3">¿Está seguro que desea <strong>aprobar</strong> la solicitud de:</p>
										<div class="alert alert-info">
											<strong><?= $content->solicitud_nombre ?> 	<?= $content->solicitud_apellidos ?></strong><br>
											<small>Número de acción: <?= $content->solicitud_numero_accion ?></small>
										</div>
										<p class="text-muted small">Esta acción actualizará el estado de la solicitud a "Aprobada".</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
											<i class="fas fa-times"></i> Cancelar
										</button>
										<a href="<?php echo $this->route; ?>/aprobar?id=<?= $id ?>&update=1&solicitud_estado_home=2&csrf=<?= $this->csrf; ?>"
											class="btn btn-success btn-action-confirm">
											<i class="fas fa-check"></i> Sí, Aprobar
										</a>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal Rechazar -->
						<div class="modal fade" id="modalRechazar<?= $id ?>" tabindex="-1" role="dialog"
							aria-labelledby="modalRechazarLabel<?= $id ?>" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger text-white">
										<h5 class="modal-title" id="modalRechazarLabel<?= $id ?>">
											<i class="fas fa-times-circle"></i> Confirmar Rechazo
										</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
											style="filter: invert(1);"></button>
									</div>
									<div class="modal-body">
										<p class="mb-3">¿Está seguro que desea <strong>rechazar</strong> la solicitud de:</p>
										<div class="alert alert-warning">
											<strong><?= $content->solicitud_nombre ?> 	<?= $content->solicitud_apellidos ?></strong><br>
											<small>Número de acción: <?= $content->solicitud_numero_accion ?></small>
										</div>
										<p class="text-muted small">Esta acción actualizará el estado de la solicitud a "Rechazada".</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
											<i class="fas fa-times"></i> Cancelar
										</button>
										<a href="<?php echo $this->route; ?>/aprobar?id=<?= $id ?>&update=1&solicitud_estado_home=3&csrf=<?= $this->csrf; ?>"
											class="btn btn-danger btn-action-confirm">
											<i class="fas fa-window-close"></i> Sí, Rechazar
										</a>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>
				</tbody>
			</table>
		</div>
		<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route"
			value="<?php echo $this->route; ?>/changepage">
	</div>

	<!-- Paginación inferior -->
	<?php if ($this->totalpages > 1): ?>
		<div class="mt-4 mb-5 ">
			<nav aria-label="Paginación">
				<ul class="pagination justify-content-center">
					<?php
					$url = $this->route;
					$maxSide = 5; // mostrar hasta 5 páginas a cada lado
					$start = max(1, $this->page - $maxSide);
					$end = min($this->totalpages, $this->page + $maxSide);

					if ($this->page != 1) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page - 1) . '">&laquo; Anterior</a></li>';
					}

					// Mostrar primera página y puntos si es necesario
					if ($start > 1) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=1">1</a></li>';
						if ($start > 2) {
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
						}
					}

					for ($i = $start; $i <= $end; $i++) {
						if ($this->page == $i) {
							echo '<li class="active page-item"><a class="page-link">' . $this->page . '</a></li>';
						} else {
							echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
						}
					}

					// Mostrar puntos y última página si es necesario
					if ($end < $this->totalpages) {
						if ($end < $this->totalpages - 1) {
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
						}
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . $this->totalpages . '">' . $this->totalpages . '</a></li>';
					}

					if ($this->page != $this->totalpages) {
						echo '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($this->page + 1) . '">Siguiente &raquo;</a></li>';
					}
					?>
				</ul>
			</nav>
		</div>
	<?php endif; ?>
</div>
<style>
	.badge {
		font-size: 12px !important;
	}

	.table td,
	.table th {
		vertical-align: middle;
		padding: 0;
		font-size: 11px;
		background-color: unset;
	}

	table {

		width: 100%;

	}

	.content-table .table thead td {
		color: #FFF;
		font-weight: 500;
		padding: 5px;
		font-size: 0.7rem;
	}

	.content-table .table tbody td {
		font-size: 0.7rem;
	}

	table img {
		max-width: 70px;
		/* width: 100%; */
		height: 70px;
		object-fit: contain;
	}

	.bg-primary-pastel {
		background-color: #84b6f4 !important;
	}

	.bg-success-pastel {
		background-color: #59c589 !important;
	}

	.bg-danger-pastel {
		background-color: #f48484 !important;
	}

	/* Loader Overlay */
	#loader-overlay {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.7);
		z-index: 9999;
		justify-content: center;
		align-items: center;
		overflow: hidden;
	}

	#loader-overlay.active {
		display: flex;
	}

	body.loader-active {
		overflow: hidden;
	}

	.loader-content {
		text-align: center;
		color: white;
	}

	.spinner {
		border: 5px solid #f3f3f3;
		border-top: 5px solid #3498db;
		border-radius: 50%;
		width: 60px;
		height: 60px;
		animation: spin 1s linear infinite;
		margin: 0 auto 20px;
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}
</style>

<!-- Loader Overlay -->
<div id="loader-overlay">
	<div class="loader-content">
		<div class="spinner"></div>
		<h4>Procesando solicitud...</h4>
		<p>Por favor espere</p>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const actionButtons = document.querySelectorAll('.btn-action-confirm');
		const loaderOverlay = document.getElementById('loader-overlay');

		actionButtons.forEach(button => {
			button.addEventListener('click', function (e) {
				// Cerrar el modal
				$(this).closest('.modal').modal('hide');

				// Mostrar el loader
				loaderOverlay.classList.add('active');
				document.body.classList.add('loader-active');

				// El navegador seguirá el enlace normalmente
				// El loader se quedará visible hasta que la página se recargue
			});
		});

		// Sincronización del scroll horizontal
		const scrollWrapperTop = document.querySelector('.scroll-wrapper-top');
		const scrollContentTop = document.querySelector('.scroll-content-top');
		const tableWrapper = document.getElementById('table-wrapper');
		const table = tableWrapper.querySelector('table');

		// Ajustar el ancho del contenido superior al ancho de la tabla
		function adjustScrollWidth () {
			if (table) {
				scrollContentTop.style.width = table.offsetWidth + 'px';
			}
		}

		// Sincronizar scroll superior con la tabla
		scrollWrapperTop.addEventListener('scroll', function () {
			tableWrapper.scrollLeft = scrollWrapperTop.scrollLeft;
		});

		// Sincronizar scroll de la tabla con el superior
		tableWrapper.addEventListener('scroll', function () {
			scrollWrapperTop.scrollLeft = tableWrapper.scrollLeft;
		});

		// Ajustar ancho inicial y al redimensionar
		adjustScrollWidth();
		window.addEventListener('resize', adjustScrollWidth);
	});
</script>
<?php
/**
 * Genera una imagen en formato base64 con el prefijo MIME adecuado.
 * Detecta automáticamente si la entrada es hexadecimal o base64.
 *
 * @param string|null $base64String Cadena en formato hexadecimal o base64 sin prefijo MIME.
 * @param string $defaultMimeType Tipo MIME predeterminado si no se puede detectar.
 * @return string|null Imagen base64 con prefijo MIME o null si no se proporciona una cadena válida.
 */
function generateBase64Image(?string $base64String, string $defaultMimeType = 'image/png'): ?string
{
	if (!$base64String) {
		return null;
	}

	// Detectar si es hexadecimal (solo contiene 0-9 y a-f)
	if (ctype_xdigit($base64String)) {
		// Es hexadecimal, convertir a binario y luego a base64
		$binary = hex2bin($base64String);
		$base64String = base64_encode($binary);
	}

	// Decodificar para detectar el tipo MIME
	$imageData = base64_decode($base64String);
	$imageInfo = getimagesizefromstring($imageData);

	// Detecta el tipo MIME o usa el valor predeterminado
	$mimeType = $imageInfo !== false ? $imageInfo['mime'] : $defaultMimeType;

	// Vuelve a codificar en base64 con el prefijo MIME adecuado
	return "data:$mimeType;base64," . $base64String;
}

?>

<!-- 170X154 -->