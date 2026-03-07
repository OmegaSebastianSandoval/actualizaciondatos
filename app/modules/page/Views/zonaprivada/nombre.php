<style>
@import url('https://fonts.googleapis.com/css2?family=Orelega+One&display=swap');
</style> 

<style type="text/css">
body {
  margin-top: 1rem;
  color: #000000;
}
header{
    display: none;
}

.titulo_certificado{
    font-family: 'Orelega One';
    color: #000000;
}

.orelega{
    font-family: 'Orelega One';
    color: #000000;
}

.imagen1{
    max-width: 200px;
    cursor: pointer;
}

.btn-cafe{
    background: #FF7E79;
}


.btn1{
    width:220px;
    height: 60px;
    border-radius: 0px;
    background: #FFFFFF;
    border:2px #000000 solid;
    color: #000000;
}

.btn1:hover{
    background: #FF7E79;
    color: #FFFFFF;
    border:2px #FF7E79 solid;
}

.modal-header {
  background-color: #FF7E79;
}
</style>




<div class="container">
    <div class="row">
		<div class="col-12 text-center">
            <i class="fas fa-user" style="margin-right: 5px; color: #000000;"></i><?php echo $this->socio->socio_nombre; ?> <a href="/page/zonaprivada/logout_nogal" class="btn btn-sm btn-cafe margen_salir" target="_top">Salir</a>
		</div>

    </div>
</div>
