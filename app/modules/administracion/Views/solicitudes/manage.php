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

		input,
		textarea,
		select {
			background-color: #e9ecef !important;
			pointer-events: none;
		}
	</style>
<?php endif; ?>
<!-- SELECT 2 -->
<link href="/components/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="/components/select2/dist/js/select2.min.js"></script>

<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<?php if ($_SESSION['kt_login_level'] == 10 || $_SESSION['kt_login_level'] == 15): ?>
		<form class="text-start">
		<?php else: ?>
			<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
				data-toggle="validator" id="form-solicitudes">
			<?php endif; ?>
			<div class="content-dashboard">
				<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
				<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
				<?php if ($this->content->solicitud_id) { ?>
					<input type="hidden" name="id" id="id" value="<?= $this->content->solicitud_id; ?>" />
				<?php } ?>

				<input type="hidden" name="solicitud_sbe_codi" id="solicitud_sbe_codi"
					value="<?= $this->content->solicitud_sbe_codi; ?>" />
				<input type="hidden" name="solicitud_sbe_cont" id="solicitud_sbe_cont"
					value="<?= $this->content->solicitud_sbe_cont; ?>" />

				<input type="hidden" name="solicitud_soc_codi" id="solicitud_soc_codi"
					value="<?= $this->content->solicitud_soc_codi; ?>" />
				<input type="hidden" name="solicitud_soc_cont" id="solicitud_soc_cont"
					value="<?= $this->content->solicitud_soc_cont; ?>" />
				<input type="hidden" name="solicitud_mac_nume" id="solicitud_mac_nume"
					value="<?= $this->content->solicitud_mac_nume; ?>" />
				<input type="hidden" name="solicitud_ncon" id="solicitud_ncon" value="<?= $this->content->solicitud_ncon; ?>" />
				<input type="hidden" name="solicitud_sbe_idio" id="solicitud_sbe_idio"
					value="<?= $this->content->solicitud_sbe_idio; ?>" />
				<input type="hidden" name="solicitud_source" id="solicitud_source"
					value="<?= $this->content->solicitud_source; ?>" />

				<?php if ($this->content->solicitud_estado == 1) { ?>

					<div class="row">
						<div class="col-12 col-md-6 border-right">
							<h4 class="text-center">Informaci&oacute;n actual</h4>
							<div class="col-12 form-group">
								<label for="solicitud_numero_accion_actual" class="control-label">N&uacute;mero acci&oacute;n
									actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_numero_accion_actual; ?>"
										name="solicitud_numero_accion_actual" id="solicitud_numero_accion_actual" class="form-control"
										readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_nombre_actual" class="control-label">Nombre actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>

									<input type="text" value="<?= $this->content->solicitud_nombre_actual; ?>"
										name="solicitud_nombre_actual" id="solicitud_nombre_actual" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_apellidos_actual" class="control-label">Apellidos actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>

									<input type="text" value="<?= $this->content->solicitud_apellidos_actual; ?>"
										name="solicitud_apellidos_actual" id="solicitud_apellidos_actual" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_documento_actual" class="control-label">Documento actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_documento_actual; ?>"
										name="solicitud_documento_actual" id="solicitud_documento_actual" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_telefono_actual" class="control-label">Tel&eacute;fono actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_telefono_actual; ?>"
										name="solicitud_telefono_actual" id="solicitud_telefono_actual" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_direccion_actual" class="control-label">Direcci&oacute;n actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_direccion_actual; ?>"
										name="solicitud_direccion_actual" id="solicitud_direccion_actual" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<input type="hidden" name="solicitud_ciudad_actual" id="solicitud_ciudad_actual"
								value="<?= $this->content->solicitud_ciudad_actual; ?>" />

							<input type="hidden" name="solicitud_departamento_actual" id="solicitud_departamento_actual"
								value="<?= $this->content->solicitud_departamento_actual; ?>" />

							<input type="hidden" name="solicitud_pais_actual" id="solicitud_pais_actual"
								value="<?= $this->content->solicitud_pais_actual; ?>" />





							<div class="col-12 form-group">
								<label for="solicitud_ciudad_actual" class="control-label">Ciudad actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>

									<input type="text"
										value="<?= $this->ciudades[$this->content->solicitud_departamento_actual][$this->content->solicitud_ciudad_actual]; ?>"
										name="solicitud_ciudad_actual_select" id="solicitud_ciudad_actual_select" class="form-control"
										readonly>
								</label>
								<div class="help-block with-errors"></div>
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
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_email_comunicacion_actual" class="control-label">Email de comunicaci&oacute;n
									actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_email_comunicacion_actual; ?>"
										name="solicitud_email_comunicacion_actual" id="solicitud_email_comunicacion_actual"
										class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<?php
							$base64ImageAct = null;

							if ($this->content->solicitud_foto_actual) {
								$rawData = $this->content->solicitud_foto_actual;

								// Detectar si es hexadecimal (solo contiene 0-9 y a-f)
								if (ctype_xdigit($rawData)) {
									// Es hexadecimal, convertir a binario y luego a base64
									$binary = hex2bin($rawData);
									$base64StringAct = base64_encode($binary);
								} else {
									// Asumir que ya es base64
									$base64StringAct = $rawData;
								}

								// Decodificar para detectar el tipo MIME
								$imageDataAct = base64_decode($base64StringAct);
								$imageInfoAct = getimagesizefromstring($imageDataAct);

								if ($imageInfoAct !== false) {
									$mimeTypeAct = $imageInfoAct['mime'];
								} else {
									$mimeTypeAct = 'image/png'; // Valor predeterminado
								}

								// Generar imagen con prefijo MIME
								$base64ImageAct = "data:$mimeTypeAct;base64," . $base64StringAct;
							}
							?>
							<?php if ($base64ImageAct && $this->content->solicitud_foto_actual) { ?>
								<div style="height:200px; display:grid; place-items:center">
									<img src="<?= $base64ImageAct ?>" alt="Imagen Actual" class="img-cambio">
								</div>
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
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_observaciones_actual" class="control-label">Observaciones actual</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
									<!-- <input type="text" value="<?= $this->content->solicitud_observaciones_actual; ?>" name="solicitud_observaciones_actual" id="solicitud_observaciones_actual" class="form-control" readonly> -->
									<textarea name="solicitud_observaciones_actual" id="solicitud_observaciones_actual" class="form-control"
										rows="2" readonly><?= $this->content->solicitud_observaciones_actual; ?></textarea>
								</label>
								<div class="help-block with-errors"></div>
							</div>
						</div>

						<div class="col-12 col-md-6">
							<h4 class="text-center">Informaci&oacute;n pendiente por actualizar</h4>

							<div class="col-12 form-group">
								<label for="solicitud_numero_accion" class="control-label">N&uacute;mero acci&oacute;n</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_numero_accion; ?>"
										name="solicitud_numero_accion" id="solicitud_numero_accion" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>


							<div class="col-12 form-group">
								<label for="solicitud_nombre" class="control-label">Nombre</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" minlength="3" maxlength="25" value="<?= $this->content->solicitud_nombre; ?>"
										name="solicitud_nombre" id="solicitud_nombre" class="form-control">
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_apellidos" class="control-label">Apellidos</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" minlength="3" maxlength="25" value="<?= $this->content->solicitud_apellidos; ?>"
										name="solicitud_apellidos" id="solicitud_apellidos" class="form-control">
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_documento" class="control-label">Documento</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_documento; ?>" name="solicitud_documento"
										id="solicitud_documento" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_telefono" class="control-label">Tel&eacute;fono</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" maxlength="10" minlength="10" pattern="^\d+$" onkeypress="return soloNumeros(event)"
										value="<?= $this->content->solicitud_telefono; ?>" name="solicitud_telefono" id="solicitud_telefono"
										class="form-control">
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_direccion" class="control-label">Direcci&oacute;n</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
									<input type="text" value="<?= $this->content->solicitud_direccion; ?>" name="solicitud_direccion"
										id="solicitud_direccion" class="form-control">
								</label>
								<div class="help-block with-errors"></div>
							</div>

							<input type="hidden" name="solicitud_departamento" id="solicitud_departamento"
								value="<?= $this->content->solicitud_departamento; ?>" />
							<input type="hidden" name="solicitud_pais" id="solicitud_pais"
								value="<?= $this->content->solicitud_pais; ?>" />
							<input type="hidden" name="solicitud_region" id="solicitud_region"
								value="<?= $this->content->solicitud_region; ?>" />


							<div class="col-12 form-group">
								<label for="solicitud_ciudad" class="control-label">Ciudad</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
									<!-- <input type="text" value="<?= $this->ciudades[$this->content->solicitud_departamento][$this->content->solicitud_ciudad]; ?>" name="solicitud_ciudad" id="solicitud_ciudad" class="form-control" > -->
									<select class="form-control" name="solicitud_ciudad" id="solicitud_ciudad">
										<option value="" selected disabled>Seleccione una ciudad</option>
										<?php foreach ($this->ciudadesList as $ciudad): ?>
											<option value="<?= $ciudad->mun_codi ?>" <?php if ($ciudad->mun_codi == $this->content->solicitud_ciudad && $ciudad->dep_codi == $this->content->solicitud_departamento) {
													echo "selected";
												} ?>
												data-pais="<?= $ciudad->pai_codi ?>" data-departamento="<?= $ciudad->dep_codi ?>"
												data-region="<?= $ciudad->reg_codi ?>"><?= $ciudad->dep_nomb . ", " . $ciudad->mun_nomb ?></option>
										<?php endforeach ?>
									</select>

								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_email_facturacion" class="control-label">Email de facturaci&oacute;n</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
									<input type="email" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" minlength="7" maxlength="45"
										value="<?= $this->content->solicitud_email_facturacion; ?>" name="solicitud_email_facturacion"
										id="solicitud_email_facturacion" class="form-control">
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_email_comunicacion" class="control-label">Email de comunicaci&oacute;n</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
									<input type="email" pattern="[^\s@]+@[^\s@]+\.[^\s@]+" minlength="7" maxlength="45"
										value="<?= $this->content->solicitud_email_comunicacion; ?>" name="solicitud_email_comunicacion"
										id="solicitud_email_comunicacion" class="form-control">
								</label>
								<div class="help-block with-errors"></div>
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
								<img src="<?= $base64Image ?>" alt="Imagen" class="img-cambio">
								<!-- Campo oculto con la misma imagen en Base64 -->


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

									<input type="text" value="<?= $this->content->solicitud_foto; ?>" name="solicitud_foto"
										id="solicitud_foto" class="form-control" readonly>
								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group">
								<label for="solicitud_observaciones" class="control-label">Observaciones</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
									<!-- <input type="text" value="<?= $this->content->solicitud_observaciones; ?>" name="solicitud_observaciones" id="solicitud_observaciones" class="form-control" readonly> -->
									<textarea name="solicitud_observaciones" id="solicitud_observaciones" class="form-control" rows="2"
										readonly><?= $this->content->solicitud_observaciones; ?></textarea>
								</label>
								<div class="help-block with-errors"></div>
							</div>


						</div>


						<div class="row p-4 mt-4">
							<div class="col-4 form-group">
								<label class="control-label">Estado</label>
								<label class="input-group">

									<span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
									<select class="form-control" name="solicitud_estado" id="solicitud_estado">
										<option value="" disabled>Seleccione...</option>
										<?php foreach ($this->list_solicitud_estado as $key => $value) { ?>
											<option <?php if ($this->getObjectVariable($this->content, "solicitud_estado") == $key) {
												echo "selected";
											} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="estado_actual" id="estado_actual"
										value="<?= $this->content->solicitud_estado; ?>" />
								</label>
								<div class="help-block with-errors"></div>
							</div>

							<div class="col-12 form-group info">
								<label for="solicitud_fecha_ingreso" class="control-label">Fecha de ingreso al formulario</label>
								<label class="input-group">

									<!-- <input type="text" value="<?= $this->content->solicitud_fecha_ingreso; ?>" name="solicitud_fecha_ingreso" id="solicitud_fecha_ingreso" class="form-control" readonly> -->
									<?= $this->content->solicitud_fecha_ingreso; ?>
								</label>
								<div class="help-block with-errors"></div>
							</div>

							<div class="col-12 form-group info">
								<label for="solicitud_acepta_politicas" class="control-label">Acepta polticas</label>
								<label class="input-group">

									<!-- <input type="text" value="<?= $this->content->solicitud_acepta_politicas == 'on' ? 'Sí' : 'No'; ?>" name="solicitud_acepta_politicas" id="solicitud_acepta_politicas" class="form-control" readonly> -->
									<?= ($this->content->solicitud_acepta_politicas == 'on' || $this->content->solicitud_acepta_politicas == '1') ? 'Sí' : 'No'; ?>

								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 form-group info">
								<label for="solicitud_declara_titular" class="control-label">Declara titular</label>
								<label class="input-group">

									<!-- <input type="text" value="<?= $this->content->solicitud_declara_titular == 'on' ? 'Sí' : 'No'; ?>" name="solicitud_declara_titular" id="solicitud_declara_titular" class="form-control" readonly> -->
									<?= ($this->content->solicitud_declara_titular == 'on' || $this->content->solicitud_declara_titular == '1') ? 'Sí' : 'No'; ?>

								</label>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-12 mt-4 mb-3 ">
								<span class="font-weight-bolder">Informaci&oacute;n desde donde se envi&oacute; el formulario</span>
							</div>
							<div class="col-12 form-group info">
								<label for="solicitud_fecha_solicitud" class="control-label">Fecha de env&iacute;o de la
									solicitud:</label>
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


							<?php if ($this->content->solicitud_usuario) { ?>
								<div class="col-12 mt-4 mb-3">
									<span class="font-weight-bolder">Informaci&oacute;n de aprobación o rechazo</span>
								</div>
								<div class="col-12 form-group info">
									<label for="solicitud_usuario" class="control-label">Usuario que aprobó o rechazó la solicitud:</label>
									<label class="input-group">

										<!-- 	<input type="text" value="<?= $this->content->solicitud_usuario; ?>" name="solicitud_usuario" id="solicitud_usuario" class="form-control" readonly> -->
										<?= $this->content->solicitud_usuario; ?>
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
				<?php } else { ?>
					<div class="alert alert-info">
						Esta solicitud ya ha sido aprobada o rechazada, no es posible realizar modificaciones.
					</div>
				<?php } ?>

			</div>
			<?php


			if (
				$_SESSION['kt_login_level'] != 15 ||
				$_SESSION['kt_login_level'] != 14
			): ?>
				<div class="botones-acciones">
					<?php if ($this->content->solicitud_estado == 1) { ?>
						<span class="btn btn-guardar" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Guardar</span>
					<?php } ?>


					<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>

					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Confirmar actualizacin</h5>
									<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body text-center">
									¿Desea actualizar la solicitud?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" id="btn-cancelar-form"
										data-bs-dismiss="modal">Cancelar</button>
									<button class="btn btn-guardar" id="btn-guardar-form" type="submit">Actualizar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</form>
</div>

<style>
	select *:read-only {
		background-color: transparent !important;
	}

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

<script>
	const selectCiudad = document.getElementById('solicitud_ciudad');
	const departamentoInput = document.getElementById('solicitud_departamento');
	const paisInput = document.getElementById('solicitud_pais');
	const regionInput = document.getElementById('solicitud_region');
	/*   selectCiudad.addEventListener('change', function() {
				const selectedOption = this.options[this.selectedIndex];
				console.log(selectedOption);
				selectDepartamento.value = selectedOption.getAttribute('data-departamento');
				selectPais.value = selectedOption.getAttribute('data-pais');
		}); */
	// Manejar el evento change
	$('#solicitud_ciudad').on('change', function () {
		// Obtener la opción seleccionada
		var selectedOption = $(this).find(':selected');

		// Obtener los atributos personalizados
		var departamento = selectedOption.data('departamento');
		var pais = selectedOption.data('pais');
		var region = selectedOption.data('region');

		// Mostrar los valores en consola o usarlos según tu necesidad
		console.log('Departamento:', departamento);
		departamentoInput.value = departamento;
		console.log('País:', pais);
		paisInput.value = pais;
		console.log('Región:', region);
		regionInput.value = region;
	});

	document.getElementById('form-solicitudes').addEventListener('submit', function (e) {

		const estadoActual = document.getElementById('estado_actual').value;
		const estadoNuevo = document.getElementById('solicitud_estado').value;

		if (estadoActual == estadoNuevo) {
			alert('El estado actual y el estado nuevo no pueden ser iguales');
			e.preventDefault();
			return;
		}

		const btnForm = document.getElementById('btn-guardar-form');
		const cancelBtn = document.getElementById('btn-cancelar-form');

		btnForm.innerHTML = 'Guardando...';
		btnForm.disabled = true;

		cancelBtn.disabled = true;



	});
</script>


<?php
/**
 * Genera una imagen en formato base64 con el prefijo MIME adecuado.
 *
 * @param string|null $base64String Cadena base64 sin prefijo MIME.
 * @param string $defaultMimeType Tipo MIME predeterminado si no se puede detectar.
 * @return string|null Imagen base64 con prefijo MIME o null si no se proporciona una cadena válida.
 */
function generateBase64Image(?string $base64String, string $defaultMimeType = 'image/png'): ?string
{
	if (!$base64String) {
		return null;
	}

	// Decodifica temporalmente la cadena base64 para detectar el tipo MIME
	$imageData = base64_decode($base64String);
	$imageInfo = getimagesizefromstring($imageData);

	// Detecta el tipo MIME o usa el valor predeterminado
	$mimeType = $imageInfo !== false ? $imageInfo['mime'] : $defaultMimeType;

	// Vuelve a codificar en base64 con el prefijo MIME adecuado
	return "data:$mimeType;base64," . $base64String;
}

// Uso de la función

?>