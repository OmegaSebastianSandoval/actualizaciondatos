<div class="text-center">
	Por favor ingrese su dirección de correo electrónico y
	recibirás un enlace para crear una nueva contraseña.
</div>
<br>
<form  autocomplete="off" action="/administracion/loginuser/forgotpassword" method="post" >
    <div class="form-group " >
        <label class="control-label sr-only">Correo</label> 
        <div class="input-group">
            <i class="fa-solid fa-envelope icon-input-left"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ej: usuario@dominio.com" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <?php if($this->error_olvido){ ?>
        <div class="error_login"><?php echo $this->error_olvido; ?></div>
    <?php } ?>
    <?php if($this->mensaje_olvido){ ?>
        <div class="mensaje_login"><?php echo $this->mensaje_olvido; ?></div>
    <?php } ?>
    <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
    <div class="text-center"><a href="/administracion" class="olvido">Volver al Login</a></div>
    <div class="text-center"><button  class="btn-azul-login" type="submit">Enviar</button></div>
</form>