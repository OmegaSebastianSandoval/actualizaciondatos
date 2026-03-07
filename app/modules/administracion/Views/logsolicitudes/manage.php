<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->log_solicitud_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->log_solicitud_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="log_solicitud_usuario" class="control-label">log_solicitud_usuario</label>
					<label class="input-group">

						<span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->log_solicitud_usuario; ?>" name="log_solicitud_usuario"
							id="log_solicitud_usuario" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="log_solicitud_cliente" class="control-label">log_solicitud_cliente</label>
					<label class="input-group">

						<span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
				</div>
				<input type="text" value="<?= $this->content->log_solicitud_cliente; ?>" name="log_solicitud_cliente"
					id="log_solicitud_cliente" class="form-control">
				</label>
				<div class="help-block with-errors"></div>
			</div>
			<div class="col-12 form-group">
				<label for="log_solicitud_solicitud" class="control-label">log_solicitud_solicitud</label>
				<label class="input-group">

					<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
			</div>
			<input type="text" value="<?= $this->content->log_solicitud_solicitud; ?>" name="log_solicitud_solicitud"
				id="log_solicitud_solicitud" class="form-control">
			</label>
			<div class="help-block with-errors"></div>
		</div>
		<div class="col-12 form-group">
			<label for="log_solicitud_fecha_datos_anteriores"
				class="control-label">log_solicitud_fecha_datos_anteriores</label>
			<label class="input-group">

				<span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
		</div>
		<input type="text" value="<?= $this->content->log_solicitud_fecha_datos_anteriores; ?>"
			name="log_solicitud_fecha_datos_anteriores" id="log_solicitud_fecha_datos_anteriores" class="form-control">
		</label>
		<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_datos_completos" class="control-label">log_solicitud_datos_completos</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_datos_completos; ?>" name="log_solicitud_datos_completos"
	id="log_solicitud_datos_completos" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_datos_nuevos" class="control-label">log_solicitud_datos_nuevos</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_datos_nuevos; ?>" name="log_solicitud_datos_nuevos"
	id="log_solicitud_datos_nuevos" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_ip_usuario" class="control-label">log_solicitud_ip_usuario</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_ip_usuario; ?>" name="log_solicitud_ip_usuario"
	id="log_solicitud_ip_usuario" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_user_agent_usuario" class="control-label">log_solicitud_user_agent_usuario</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_user_agent_usuario; ?>"
	name="log_solicitud_user_agent_usuario" id="log_solicitud_user_agent_usuario" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_ip_cliente" class="control-label">log_solicitud_ip_cliente</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_ip_cliente; ?>" name="log_solicitud_ip_cliente"
	id="log_solicitud_ip_cliente" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_user_agent_cliente" class="control-label">log_solicitud_user_agent_cliente</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_user_agent_cliente; ?>"
	name="log_solicitud_user_agent_cliente" id="log_solicitud_user_agent_cliente" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
<div class="col-12 form-group">
	<label for="log_solicitud_fecha_datos_nuevos" class="control-label">log_solicitud_fecha_datos_nuevos</label>
	<label class="input-group">

		<span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
</div>
<input type="text" value="<?= $this->content->log_solicitud_fecha_datos_nuevos; ?>"
	name="log_solicitud_fecha_datos_nuevos" id="log_solicitud_fecha_datos_nuevos" class="form-control">
</label>
<div class="help-block with-errors"></div>
</div>
</div>
</div>
<div class="botones-acciones">
	<button class="btn btn-guardar" type="submit">Guardar</button>
	<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
</div>
</form>
</div>