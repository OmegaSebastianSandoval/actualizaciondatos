<style type="text/css">
	body {}

	.enviar {
		background: #69E4A7;
		border: 1px solid #000000;
		border-radius: 15px;
		min-width: 200px;
	}

	.btn-cafe {
		background: #69E4A7;
	}

	.campo_login {
		border: 1px solid #000000;
		margin-bottom: 10px;
		border-radius: 15px;
		text-indent: 20px;
		height: 45px;
	}

	.caja-items {
		visibility: hidden;
	}



	.titulo-contact {
		color: #000000;
	}

	footer .derechos {
		background: #69E4A7;
	}

	.modal-header {
		background-color: #69E4A7;
	}
</style>


<div class="container div_login">
	<div class="row">
		<div class="col-12 text-center">
			<img src="/corte/banner_delivery.png" style="width: 100%;">
		</div>
	</div>
</div>

<div class="container div_login">
	<div class="row">
		<div class="col-10 offset-lg-1 titulo-contact" style="margin-top: 20px;">
			<b style="font-weight: 600; font-size: 20px;">Nuevo sistema de autenticación</b>
			<p style="margin-top: 20px;">Queremos que tus compras más seguras, por eso a partir de este <b>mes de octubre</b>
				actualizaremos nuestro método de ingreso al servicio de delivery Club El Nogal y ahora podrás asignar una
				contraseña personal.</p>
		</div>
	</div>
</div>

<div class="div_login">
	<div class="row">
		<div class="col-12 text-center">
			<a href="/page/login/index"><button class="btn btn-cafe">Socio</button></a>
			<a href="/page/login/invitado"><button class="btn btn-outline-secondary">Invitado</button></a>
		</div>
	</div>
	<form method="post" action="/page/login/login" class="col-md-8 offset-md-2 " style="margin-top: 20px;">
		<?php if ($_GET['registro'] == 1) { ?>
				<div class="alert alert-warning">Apreciado socio, su registro se realizó de forma exitosa. por favor ingrese su
					información de acceso:</div>
		<?php } ?>
		<div align="center" class="caja_registro alto-login">
			<div class="col-md-12 col-lg-6 form-group">
				<div class="col-sm-12 col-md-12 margen_icono">
					<div class="row">
						<div class="col-md-12"><input type="text" name="cedula" required
								class="form-control texto_normal campo_login" value="<?php echo $_GET['cedula']; ?>"
								placeholder="Identificación"></div>

					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<div class="row">
						<div class="col-md-12"><input type="password" name="clave" required
								class="form-control texto_normal campo_login" value="" placeholder="No. de Acción o Contraseña"></div>
					</div>
				</div>


				<div class="col-md-12 text-center d-none1"><br><a href="/page/registro" class="enlace d-none">Crear cuenta</a>
					<span class="azul d-none">|</span> <a href="/page/login/recordarsocio/" class="enlace">Recordar contraseña</a>
				</div>

				<div class="col-md-12">
					<br>
					<button class="btn btn-primary enviar" type="submit">Ingresar</button>
				</div>
			</div>
		</div>


		<?php if ($_GET['error'] == "1"): ?>
				<div class="col-md-12"><br></div>
				<div class="alert alert-danger col-md-12 text-center">La identificación no es válida o la contraseña es incorrecta
				</div>
		<?php endif ?>
		<?php if ($_GET['error'] == "2"): ?>
				<div class="col-md-12"><br></div>
				<div class="alert alert-danger col-md-12 text-center">Usuario inactivo</div>
		<?php endif ?>
		<?php if ($_GET['error'] == "3"): ?>
				<div class="col-md-12"><br></div>
				<div class="alert alert-danger col-md-12 text-center">Usted ya tiene una contraseña segura asignada. Por favor no
					utilice su número de acción para ingresar</div>
		<?php endif ?>

		<input type="hidden" name="taberna_express" value="<?= $_GET['taberna_express'] ?>">
		<input type="hidden" name="anchor" value="<?= $_GET['anchor'] ?>">

	</form>
</div>


<?php if ($_GET['mensaje'] != "") { ?>

		<script src="/components/jquery/dist/jquery.min.js"></script>

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary d-none" id="boton_modal_mensaje" data-bs-toggle="modal"
			data-target="#exampleModal_mensaje">
			Launch demo modal
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal_mensaje" tabindex="-1" role="dialog"
			aria-labelledby="exampleModal_mensajeLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModal_expressLabel"></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<?php if ($_GET['mensaje'] == "1") { ?>
								Estimado socio,<br><br>
						<?php } ?>
						<?php if ($_GET['mensaje'] == "2") { ?>
								Estimado invitado,<br><br>
						<?php } ?>

						Hemos actualizado nuestro método de ingreso para hacer sus compras<br>más seguras.<br><br>

						<span style="font-weight: 600;">Le hemos enviado un mensaje a su correo electrónico registrado en el
							Club,<br>por favor ingrese y asigne una nueva contraseña a su cuenta.</span> <br><br>

						Si no recibe nuestro mensaje o su correo electrónico no se encuentra actualizado en nuestras bases de datos lo
						invitamos a comunicarse con la oficina de atención al socio:
						601 3267700 ext. 3954 en nuestros horarios de lunes a viernes de 8 a.m. a <br>6 p.m.


					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			function f1 () {
				$("#boton_modal_mensaje").click();
			}
			setTimeout("f1()", 1000);
		</script>

<?php } ?>