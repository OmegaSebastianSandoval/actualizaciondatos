<style>
@font-face {
    font-family: 'Orelega One';
    src: url('/skins/page/fuentes/orelegaone-regular-webfont.woff2') format('woff2'),
         url('/skins/page/fuentes/orelegaone-regular-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}
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


<?php 
$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
//print_r($_SESSION['extractos']);

$extractos = (array)$_SESSION['extractos'];
arsort($extractos);


$array_meses=array();
$array_anios=array();
foreach($extractos as $key => $value){
    $aux = explode("_",$value);
    $anio = substr($aux[0],0,4);
    $mes = substr($aux[0],4,2);

    $array_meses[] = intval($mes);
    $array_anios[] = $anio;
}

$array_anios = array_unique($array_anios);
$array_meses = array_unique($array_meses);


?>


<div class="container">
    <div class="row">
        <div class="col-12 titulo-contact text-center">
            <br><h3 class="titulo_certificado">Extractos</h3>
            <div>______________</div>
        </div>
		<div class="col-12 text-center">
            <i class="fas fa-user" style="margin-right: 5px; color: #000000;"></i><?php echo $this->socio->socio_nombre; ?> <a href="/page/zonaprivada/logout_nogal" class="btn btn-sm btn-cafe margen_salir" target="_top">Salir</a>
		</div>
        <div class="col-12 text-center mt-4">

            <div class="row">

                <div class="col-12 mb-4">

                    <div class="row">
                        <div class="col-lg-6">
                            Año del extracto que requiere*
                            <select name="anio" id="anio" onchange="filtrar()">
                                <?php foreach($array_anios as $key => $value){ ?>
                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        <div class="col-lg-6">
                            Mes del extracto que requiere*
                            <select name="mes" id="mes" onchange="filtrar()">
                                <option value=""></option>
                                <?php foreach($array_meses as $key => $value){ ?>
                                    <option value="<?php echo $value; ?>"><?php echo $meses[intval($value)]; ?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                    </div>





                </div>

                <div class="col-lg-12 mb-4">
                    <?php $ruta="/home/delivery.clubelnogal.com/public_html/certificados/extractos/"; ?>


                    

                    <table border="1" width="100%" class="tabla_resultados" style="display: none;">
                        <tr>
                            <th><b>Año</b></th>
                            <th><b>Mes</b></th>
                            <th><b>Extracto</b></th>
                        </tr>

                        <?php foreach($extractos as $key => $value){ ?>
                            <?php
                            $aux = explode("_",$value);
                            $anio = substr($aux[0],0,4);
                            $mes = substr($aux[0],4,2);
                            $fecha = $aux[0];
                            $mes_nombre = $meses[intval($mes)];
                            ?>

                            <?php if(file_exists($ruta.$value)){ ?>
                                <tr class="res<?php echo $anio."-".intval($mes); ?> resultados " style="display: none;">
                                    <td><?php echo $anio; ?></td>
                                    <td><?php echo $mes_nombre; ?></td>
                                    <td><a href="https://delivery.clubelnogal.com/page/zonaprivada/leerpdf/?filename=/home/delivery.clubelnogal.com/public_html/certificados/extractos/<?php echo $value; ?>" target="_blank"><button class="btn btn-cafe btn-sm">Descargar</button></a></td>
                                </tr>
                            <?php } ?>

                        <?php } ?>

                            <tr id="sin_resultados" style="display: none;">
                                <td align="center" colspan="3">Sin resultados</td>
                            </tr>

                    </table>
                </div>


                <br>
                <div class="col-12 text-center"><a href="/page/zonaprivada/certificados" class="btn btn-sm btn-cafe" target="_self">Regresar</a></div>


            </div>

            

            

        </div>

    </div>
</div>


<script>
    function filtrar(){

        var anio = $("#anio").val();
        var mes = $("#mes").val();

        if(anio!="" && mes!=""){
            $(".tabla_resultados").show();
        }

        $(".resultados").hide();
        $(".res"+anio+"-"+mes).show();


        var elements = document.getElementsByClassName("res"+anio+"-"+mes);
        console.log(elements[0]);

        if(typeof elements[0]!=="undefined"){
            $("#sin_resultados").hide();
        }else{
            $("#sin_resultados").show();
        }
    }


</script>