<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid pb-5">
	<div class="d-flex justify-content-start align-items-center py-3">
		<a href="<?php echo $this->route; ?>" class="btn btn-secondary">Volver</a>
	</div>
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-toggle="validator">
		<div class="content-dashboard mt-0">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->solicitud_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->solicitud_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-12 col-md-6 border-right">
					<h4 class="text-center">Informaci&oacute;n anterior</h4>
					<div class="col-12 form-group">
						<label for="solicitud_numero_accion_actual" class="control-label">N&uacute;mero acci&oacute;n actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>

							<input type="text" value="<?= $this->content->solicitud_numero_accion_actual; ?>"
								name="solicitud_numero_accion_actual" id="solicitud_numero_accion_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_nombre_actual" class="control-label">Nombre actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_nombre_actual; ?>" name="solicitud_nombre_actual"
								id="solicitud_nombre_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_apellidos_actual" class="control-label">Apellidos actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_apellidos_actual; ?>"
								name="solicitud_apellidos_actual" id="solicitud_apellidos_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_documento_actual" class="control-label">Documento actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_documento_actual; ?>"
								name="solicitud_documento_actual" id="solicitud_documento_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_telefono_actual" class="control-label">Tel&eacute;fono actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_telefono_actual; ?>"
								name="solicitud_telefono_actual" id="solicitud_telefono_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_direccion_actual" class="control-label">Direcci&oacute;n actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_direccion_actual; ?>"
								name="solicitud_direccion_actual" id="solicitud_direccion_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_ciudad_actual" class="control-label">Ciudad actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text"
								value="<?= $this->ciudades[$this->content->solicitud_departamento_actual][$this->content->solicitud_ciudad_actual]; ?>"
								name="solicitud_ciudad_actual" id="solicitud_ciudad_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_email_facturacion_actual" class="control-label">Email de facturaci&oacute;n
							actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_email_facturacion_actual; ?>"
								name="solicitud_email_facturacion_actual" id="solicitud_email_facturacion_actual" class="form-control"
								readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_email_comunicacion_actual" class="control-label">Email de comunicaci&oacute;n
							actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_email_comunicacion_actual; ?>"
								name="solicitud_email_comunicacion_actual" id="solicitud_email_comunicacion_actual" class="form-control"
								readonly>
						</label>

					</div>
					<?php
					// Supongamos que $this->content->solicitud_foto contiene la cadena base64 sin el prefijo.
					$base64StringAct = $this->content->solicitud_foto_actual;

					// Decodifica temporalmente la cadena base64 para detectar el tipo MIME
					$imageDataAct = base64_decode($base64StringAct);
					$imageInfoAct = getimagesizefromstring($imageDataAct);

					if ($imageInfoAct !== false) {
						$mimeTypeAct = $imageInfoAct['mime']; // Obtiene el tipo MIME, por ejemplo, "image/png" o "image/jpeg"
					} else {
						$mimeTypeAct = 'image/png'; // Valor predeterminado si falla la detección
					}

					// Vuelve a codificar en base64 con el prefijo MIME adecuado
					$base64ImageAct = "data:$mimeTypeAct;base64," . $base64StringAct;
					?>
					<?php if ($base64ImageAct && $this->content->solicitud_foto_actual) { ?>
						<img src="<?= $base64ImageAct ?>" alt="Imagen Actual" class="img-cambio">
					<?php } else { ?>
						<div style="width:100%; height: 200px; display:grid; place-items:center;">
							<div class="alert alert-warning">
								No se ha cargado una imagen
							</div>
						</div>
					<?php } ?>

					<div class="col-12 form-group">
						<label for="solicitud_foto_actual" class="control-label">Foto actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_foto_actual; ?>" name="solicitud_foto_actual"
								id="solicitud_foto_actual" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_observaciones_actual" class="control-label">Observaciones actual</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
							<!-- 	<input type="text" value="<?= $this->content->solicitud_observaciones_actual; ?>" name="solicitud_observaciones_actual" id="solicitud_observaciones_actual" class="form-control" readonly> -->
							<textarea name="solicitud_observaciones_actual" id="solicitud_observaciones_actual" class="form-control"
								rows="2" readonly><?= $this->content->solicitud_observaciones_actual; ?></textarea>
						</label>

					</div>
				</div>
				<div class="col-12 col-md-6">
					<h4 class="text-center">Informaci&oacute;n
						<?= $this->content->solicitud_estado == 2 ? 'aceptada' : 'rechazada' ?>
					</h4>

					<div class="col-12 form-group">
						<label for="solicitud_numero_accion" class="control-label">N&uacute;mero acci&oacute;n</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_numero_accion; ?>" name="solicitud_numero_accion"
								id="solicitud_numero_accion" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_nombre" class="control-label">Nombre</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_nombre; ?>" name="solicitud_nombre"
								id="solicitud_nombre" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_apellidos" class="control-label">Apellidos</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_apellidos; ?>" name="solicitud_apellidos"
								id="solicitud_apellidos" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_documento" class="control-label">Documento</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_documento; ?>" name="solicitud_documento"
								id="solicitud_documento" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_telefono" class="control-label">Tel&eacute;fono</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_telefono; ?>" name="solicitud_telefono"
								id="solicitud_telefono" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_direccion" class="control-label">Direcci&oacute;n</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_direccion; ?>" name="solicitud_direccion"
								id="solicitud_direccion" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_ciudad" class="control-label">Ciudad</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text"
								value="<?= $this->ciudades[$this->content->solicitud_departamento][$this->content->solicitud_ciudad]; ?>"
								name="solicitud_ciudad" id="solicitud_ciudad" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_email_facturacion" class="control-label">Email de facturaci&oacute;n</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_email_facturacion; ?>"
								name="solicitud_email_facturacion" id="solicitud_email_facturacion" class="form-control" readonly>
						</label>

					</div>
					<div class="col-12 form-group">
						<label for="solicitud_email_comunicacion" class="control-label">Email de comunicaci&oacute;n</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->content->solicitud_email_comunicacion; ?>"
								name="solicitud_email_comunicacion" id="solicitud_email_comunicacion" class="form-control" readonly>
						</label>

					</div>
					<?php
					// Supongamos que $this->content->solicitud_foto contiene la cadena base64 sin el prefijo.
					$base64String = $this->content->solicitud_foto;

					// Decodifica temporalmente la cadena base64 para detectar el tipo MIME
					$imageData = base64_decode($base64String);
					$imageInfo = getimagesizefromstring($imageData);

					if ($imageInfo !== false) {
						$mimeType = $imageInfo['mime']; // Obtiene el tipo MIME, por ejemplo, "image/png" o "image/jpeg"
					} else {
						$mimeType = 'image/png'; // Valor predeterminado si falla la detección
					}

					// Vuelve a codificar en base64 con el prefijo MIME adecuado
					$base64Image = "data:$mimeType;base64," . $base64String;
					?>


					<?php if ($base64Image && $this->content->solicitud_foto) { ?>
						<img src="<?= $base64Image ?>" alt="Imagen Actual" class="img-cambio">
					<?php } else { ?>
						<div style="width:100%; height: 200px; display:grid; place-items:center;">
							<div class="alert alert-warning">
								No se ha cargado una imagen
							</div>
						</div>
					<?php } ?>


					<div class="col-12 form-group">
						<label for="solicitud_foto" class="control-label">Foto</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>

					<input type="text" value="<?= $this->content->solicitud_foto; ?>" name="solicitud_foto" id="solicitud_foto"
						class="form-control" readonly>
					</label>

				</div>
				<div class="col-12 form-group">
					<label for="solicitud_observaciones" class="control-label">Observaciones</label>
					<label class="input-group">

						<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
				<!-- <input type="text" value="<?= $this->content->solicitud_observaciones; ?>" name="solicitud_observaciones" id="solicitud_observaciones" class="form-control" readonly> -->
				<textarea name="solicitud_observaciones" id="solicitud_observaciones" class="form-control" rows="2"
					readonly><?= $this->content->solicitud_observaciones; ?></textarea>
				</label>

			</div>


		</div>

		<hr>
		<div class="row p-4 mt-4">
			<div class="col-12 form-group info">
				<label for="solicitud_fecha_ingreso" class="control-label">Fecha de ingreso al formulario:</label>
				<label class="input-group">
					<?= $this->content->solicitud_fecha_ingreso; ?>
					<!-- 	<input type="text" value="<?= $this->content->solicitud_fecha_ingreso; ?>" name="solicitud_fecha_ingreso" id="solicitud_fecha_ingreso" class="form-control" readonly> -->
				</label>

			</div>

			<div class="col-12 form-group info">
				<label for="solicitud_acepta_politicas" class="control-label">Acepta políticas:</label>
				<label class="input-group">

					<?= $this->content->solicitud_acepta_politicas == 'on' ? 'Sí' : 'Sí'; ?>

				</label>

			</div>
			<div class="col-12 form-group info">
				<label class="control-label">Estado:</label>
				<label class="input-group">
					<?php echo $this->list_solicitud_estado[$this->content->solicitud_estado]; ?>
					<!-- <select class="form-control" name="solicitud_estado" readonly>
								<option value="" disabled>Seleccione...</option>
								<?php foreach ($this->list_solicitud_estado as $key => $value) { ?>
									<option <?php if ($this->getObjectVariable($this->content, "solicitud_estado") == $key) {
										echo "selected";
									} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
								<?php } ?>
							</select> -->
				</label>

			</div>

			<div class="col-12 mt-4 mb-3 ">
				<span class="font-weight-bolder">Informaci&oacute;n desde donde se envi&oacute; el formulario</span>
			</div>
			<div class="col-12 form-group info">
				<label for="solicitud_fecha_solicitud" class="control-label">Fecha de env&iacute;o de la solicitud:</label>
				<label class="input-group">

					<!-- <input type="text" value="<?= $this->content->solicitud_fecha_solicitud; ?>" name="solicitud_fecha_solicitud" id="solicitud_fecha_solicitud" class="form-control" readonly> -->
					<?= $this->content->solicitud_fecha_solicitud; ?>
				</label>

			</div>

			<div class="col-12 form-group info">
				<label for="solicitud_ip" class="control-label">Ip:</label>
				<label class="input-group">

					<!-- 	<input type="text" value="<?= $this->content->solicitud_ip; ?>" name="solicitud_ip" id="solicitud_ip" class="form-control" readonly> -->
					<?= $this->content->solicitud_ip; ?>
				</label>

			</div>
			<div class="col-12 form-group info  d-grid">
				<label for="solicitud_user_agent" class="form-label">User agent:</label>
				<!-- <textarea name="solicitud_user_agent" id="solicitud_user_agent" class="form-control" rows="2" readonly><?= $this->content->solicitud_user_agent; ?></textarea> -->
				<?= $this->content->solicitud_user_agent; ?>

			</div>

			<div class="col-12 mt-4 mb-3">
				<span class="font-weight-bolder">Informaci&oacute;n de aprobación o rechazo</span>
			</div>
			<?php if ($this->content->solicitud_usuario) { ?>
				<div class="col-12 form-group info">
					<label for="solicitud_usuario" class="control-label">Usuario que aprobó o rechazó la solicitud:</label>
					<label class="input-group">

						<!-- 	<input type="text" value="<?= $this->content->solicitud_usuario; ?>" name="solicitud_usuario" id="solicitud_usuario" class="form-control" readonly> -->
						<?= $this->usuario_aprobacion->user_names; ?>
					</label>


				</div>
			<?php } ?>
			<?php if ($this->content->solicitud_usuario_ip) { ?>

				<div class="col-12 form-group info">
					<label for="solicitud_usuario_ip" class="control-label">Usuario ip:</label>
					<label class="input-group">

						<!-- 	<input type="text" value="<?= $this->content->solicitud_usuario_ip; ?>" name="solicitud_usuario_ip" id="solicitud_usuario_ip" class="form-control" readonly> -->
						<?= $this->content->solicitud_usuario_ip; ?>
					</label>

				</div>
			<?php } ?>
			<?php if ($this->content->solicitud_usuario_user_agent) { ?>

				<div class="col-12 form-group info d-grid">
					<label for="solicitud_usuario_user_agent" class="form-label">Usuario user agent:</label>
					<!-- <textarea name="solicitud_usuario_user_agent" id="solicitud_usuario_user_agent" class="form-control" rows="2" readonly><?= $this->content->solicitud_usuario_user_agent; ?></textarea> 
						-->

					<?= $this->content->solicitud_usuario_user_agent; ?>
				</div>
			<?php } ?>

		</div>

</div>
</div>

<div class="botones-acciones">
	<a href="<?php echo $this->route; ?>" class="btn btn-secondary">Volver</a>
</div>
</form>
<?php if ($_GET["log"] == 1) { ?>
	<div class="accordion" id="accordionExample">

		<div class="card">
			<div class="card-header" id="headingTwo">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse"
						data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Detalle de la solicitud (LOGS)
					</button>
				</h2>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				<div class="card-body">
					<div class="row">
						<div class="col-3 form-group">
							<label for="log_solicitud_usuario" class="control-label">Usuario</label>
							<label class="input-group">

								<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->logs->log_solicitud_usuario; ?>" name="log_solicitud_usuario"
							id="log_solicitud_usuario" class="form-control" readonly>
						</label>

					</div>
					<div class="col-3 form-group">
						<label for="log_solicitud_cliente" class="control-label">Asociado</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>

							<input type="text" value="<?= $this->logs->log_solicitud_cliente; ?>" name="log_solicitud_cliente"
								id="log_solicitud_cliente" class="form-control " readonly>
						</label>

					</div>
					<div class="col-3 form-group">
						<label for="log_solicitud_solicitud" class="control-label">ID solicitud</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
							<input type="text" value="<?= $this->logs->log_solicitud_solicitud; ?>" name="log_solicitud_solicitud"
								id="log_solicitud_solicitud" class="form-control" readonly>
						</label>

					</div>
					<div class="col-3 form-group">
						<label for="log_solicitud_fecha_datos_anteriores" class="control-label">Fecha de envío</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt" </i></span>
							<input type="text" value="<?= $this->logs->log_solicitud_fecha_datos_anteriores; ?>"
								name="log_solicitud_fecha_datos_anteriores" id="log_solicitud_fecha_datos_anteriores" class="form-control"
								readonly>
						</label>

					</div>
					<div class="col-3 form-group">
						<label for="log_solicitud_ip_usuario" class="control-label"> Ip usuario</label>
						<label class="input-group">

							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
					</div>
					<input type="text" value="<?= $this->logs->log_solicitud_ip_usuario; ?>" name="log_solicitud_ip_usuario"
						id="log_solicitud_ip_usuario" class="form-control" readonly>
					</label>

				</div>

				<div class="col-3 form-group">
					<label for="log_solicitud_user_agent_usuario" class="control-label">User Agent usuario</label>
					<label class="input-group">

						<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
				</div>
				<input type="text" value="<?= $this->logs->log_solicitud_user_agent_usuario; ?>"
					name="log_solicitud_user_agent_usuario" id="log_solicitud_user_agent_usuario" class="form-control" readonly>
				</label>

			</div>
			<div class="col-3 form-group">
				<label for="log_solicitud_ip_cliente" class="control-label">IP asociado</label>
				<label class="input-group">

					<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
			</div>
			<input type="text" value="<?= $this->logs->log_solicitud_ip_cliente; ?>" name="log_solicitud_ip_cliente"
				id="log_solicitud_ip_cliente" class="form-control" readonly>
			</label>

		</div>
		<div class="col-3 form-group">
			<label for="log_solicitud_user_agent_cliente" class="control-label">USer Agent Asociado</label>
			<label class="input-group">

				<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
		</div>
		<input type="text" value="<?= $this->logs->log_solicitud_user_agent_cliente; ?>"
			name="log_solicitud_user_agent_cliente" id="log_solicitud_user_agent_cliente" class="form-control" readonly>
		</label>

	</div>
	<div class="col-3 form-group">
		<label for="log_solicitud_fecha_datos_nuevos" class="control-label">Fecha de respuesta</label>
		<label class="input-group">

			<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
	</div>
	<input type="text" value="<?= $this->logs->log_solicitud_fecha_datos_nuevos; ?>" name="log_solicitud_fecha_datos_nuevos"
		id="log_solicitud_fecha_datos_nuevos" class="form-control" readonly>
	</label>

	</div>




	</div>
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab"
				aria-controls="nav-home" aria-selected="true">Información Inicial</button>
			<button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab"
				aria-controls="nav-profile" aria-selected="false">Solicitud Completa Inicial</button>
			<button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab"
				aria-controls="nav-contact" aria-selected="false">Información Nueva</button>
			<button class="nav-link" id="nav-contact-fin" data-toggle="tab" data-target="#nav-fin" type="button" role="tab"
				aria-controls="nav-fin" aria-selected="false">Solicitud Completa Final</button>
		</div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			<?php
			echo "<pre>";
			print_r($this->logs->log_solicitud_datos_actuales);
			echo "</pre>";
			?>
		</div>
		<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
			<?php
			echo "<pre>";
			print_r($this->logs->log_solicitud_datos_completos);
			echo "</pre>";
			?>
		</div>
		<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
			<?php
			echo "<pre>";

			print_r($this->logs->log_solicitud_datos_nuevos);
			echo "</pre>";
			?>
		</div>

		<div class="tab-pane fade" id="nav-fin" role="tabpanel" aria-labelledby="nav-contact-fin">
			<?php
			echo "<pre>";

			print_r($this->logs->log_solicitud_datos_completos_fin);
			echo "</pre>";
			?>
		</div>
	</div>

	</div>
	</div>
	</div>

	</div>
<?php } ?>
</div>

<style>
	.input-group-text.input-icono {
		background-color: #232222 !important;
	}

	.img-cambio {
		height: 200px;
		width: 100%;
		object-fit: contain;
	}

	.form-group.info {
		display: flex;
		align-items: center;
		justify-content: start;
		gap: 10px;
	}

	.form-group.info .control-label {
		font-size: 16px;
		font-weight: 700;
		text-wrap: nowrap;
		margin: 0;
		color: #2b5486;

	}

	.form-group.info .form-label {
		font-size: 16px;
		font-weight: 700;
		text-wrap: nowrap;
		margin: 0;
		color: #2b5486;
	}

	.form-group.info .input-group {
		margin: 0;
		font-size: 15px;
		font-weight: 600;
		color: #727272;

	}

	.d-grid {
		display: grid !important;
	}

	.font-weight-bolder {
		font-size: 19px;
		color: #727272;

	}
</style>