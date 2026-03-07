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

  header {
    display: none;
  }

  .titulo_certificado {
    font-family: 'Orelega One';
    color: #000000;
  }

  .orelega {
    font-family: 'Orelega One';
    color: #000000;
  }

  .imagen1 {
    max-width: 200px;
    cursor: pointer;
  }

  .btn-cafe {
    background: #FF7E79;
  }


  .btn1 {
    width: 220px;
    height: 60px;
    border-radius: 0px;
    background: #FFFFFF;
    border: 2px #000000 solid;
    color: #000000;
  }

  .btn1:hover {
    background: #FF7E79;
    color: #FFFFFF;
    border: 2px #FF7E79 solid;
  }

  .modal-header {
    background-color: #FF7E79;
  }
</style>



<?php if ($_GET["prueba"] == "1") {
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}
?>
<div class="container">
  <div class="row">
    <div class="col-12 titulo-contact text-center">
      <br>
      <h3 class="titulo_certificado">Certificados</h3>
      <div>______________</div>
    </div>
    <div class="col-12 text-center">
      <i class="fas fa-user" style="margin-right: 5px; color: #000000;"></i><?php echo $this->socio->socio_nombre; ?> <a
        href="/page/zonaprivada/logout_nogal" class="btn btn-sm btn-cafe margen_salir" target="_top">Salir</a>
    </div>
    <div class="col-12 text-center mt-4">

      <div class="row">
        <div class="col-lg-4 mb-4">
          <?php if ($this->existe != "") { ?>
              <a href="/page/zonaprivada/certificadopdf/?cert=int" target="_blank"><img src="/corte/intrinseco.jpg"
                  class="imagen1" /><br><button class="btn btn-cafe  btn1">Certificado intrínseco</button></a>
          <?php } else { ?>
              <a data-bs-toggle="modal" data-target="#exampleModal2"><img src="/corte/intrinseco.jpg"
                  class="imagen1" /><br><button class="btn btn-cafe btn1">Certificado intrínseco</button></a>
          <?php } ?>
        </div>
        <div class="col-lg-4 mb-4">
          <?php $ruta = "/home/delivery.clubelnogal.com/public_html/certificados/fundacion/" . substr($_SESSION['kt_accion'], 0, 4) . "_" . $_SESSION['kt_cedula'] . ".pdf"; ?>
          <?php if (file_exists($ruta)) { ?>

              <a href="/page/zonaprivada/leerpdf/?filename=<?php echo $ruta; ?>&cert=donacionnogal" target="_blank"><img
                  src="/corte/fundacion.jpg" class="imagen1" /><br><button class="btn btn-cafe btn1">Certificado de donacin
                  Fundación El Nogal</button></a>
          <?php } else { ?>
              <a data-bs-toggle="modal" data-target="#exampleModal3"><img src="/corte/fundacion.jpg"
                  class="imagen1" /><br><button class="btn btn-cafe btn1">Certificado de donación Fundación El
                  Nogal</button></a>
          <?php } ?>
        </div>
        <div class="col-lg-4 mb-4">
          <?php $ruta = "/home/delivery.clubelnogal.com/public_html/certificados/fonnogal/" . substr($_SESSION['kt_accion'], 0, 4) . "_" . $_SESSION['kt_cedula'] . ".pdf"; ?>
          <?php if (file_exists($ruta)) { ?>
              <a href="/page/zonaprivada/leerpdf/?filename=<?php echo $ruta; ?>&cert=donacionfonnogal" target="_blank"><img
                  src="/corte/fonnogal.jpg" class="imagen1" /><br><button class="btn btn-cafe btn1">Certificado de donación
                  Fonnogal</button></a>
          <?php } else { ?>
              <a data-bs-toggle="modal" data-target="#exampleModal"><img src="/corte/fonnogal.jpg"
                  class="imagen1" /><br><button class="btn btn-cafe btn1">Certificado de donación Fonnogal</button></a>
          <?php } ?>
        </div>

        <?php if (1 == 0) { ?>
            <div class="col-lg-4 mb-4">
              <?php if (count((array) $_SESSION['extractos']) > 0) { ?>
                  <a href="/page/zonaprivada/extractos/"><img src="/corte/extractos.jpg" class="imagen1" /><br><button
                      class="btn btn-cafe btn1">Extractos</button></a>
              <?php } else { ?>
                  <a data-bs-toggle="modal" data-target="#exampleModal_extractos"><img src="/corte/extractos.jpg"
                      class="imagen1" /><br><button class="btn btn-cafe btn1">Extractos</button></a>
              <?php } ?>
            </div>
        <?php } ?>

      </div>







      <?php if (1 == 0) { ?>
          <a href="/certificados/consumos/<?php echo $_SESSION['kt_cedula']; ?>-<?php echo $_SESSION['kt_accion']; ?>.pdf"
            target="_blank"><button class="btn btn-cafe">Certificado de consumos</button></a>
      <?php } ?>

    </div>

  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4 class="titulo_certificado">El certificado intrínseco no está disponible</h4>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4 class="titulo_certificado">Este certificado está disponible nicamente para socios del Club que realizan
          aportes a la Fundación El Nogal</h4>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4 class="titulo_certificado">Este certificado está disponible únicamente para socios del Club que realizan
          aportes al Fondo de Empleados (Fonnogal)</h4>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal_extractos" tabindex="-1" role="dialog"
  aria-labelledby="exampleModal_extractosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4 class="titulo_certificado">Los extractos no estan disponibles</h4>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>