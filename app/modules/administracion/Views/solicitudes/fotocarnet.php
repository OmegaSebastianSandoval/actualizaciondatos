<?php if ($_SESSION['kt_login_level'] == 14): ?>
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

<h1 class="titulo-principal"><i class="fas fa-camera"></i> <?php echo $this->titlesection; ?></h1>

<div class="container-fluid">
  <?php if ($this->error) { ?>
    <div class="alert alert-<?= $this->tipo_error ?? 'danger' ?> text-center">
      <?= $this->error ?>
    </div>
  <?php } ?>

  <?php if (!$this->datos_socio) { ?>
    <div class="content-dashboard search-socio-container">
      <form class="text-start" method="post" action="<?php echo $this->route; ?>/buscar_socio_foto"
        id="form-buscar-socio-foto">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

        <div class="row justify-content-center">
          <div class="col-12 col-lg-8">
            <div class="search-card">
              <div class="search-header">
                <div class="icon-wrapper">
                  <i class="fas fa-id-card"></i>
                </div>
                <h4 class="search-title">Buscar socio para actualizar foto</h4>
                <p class="search-subtitle">Ingrese el numero de carnet y cargue la nueva imagen del carnet.</p>
              </div>

              <div class="search-body">
                <div class="form-group">
                  <label class="control-label">Numero de carnet <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-lg" name="numero_carnet" id="numero_carnet" required
                    placeholder="Ej: 12345" autofocus>
                </div>
              </div>

              <div class="text-center mt-4">
                <button type="submit" class="btn btn-search-primary">
                  <i class="fas fa-search"></i> Buscar socio
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php } else { ?>
    <div class="alert alert-info mb-3">
      <i class="fas fa-info-circle"></i>
      <strong>Socio encontrado:</strong>
      <?= $this->datos_socio->sbe_nomb ?? '' ?>   <?= $this->datos_socio->sbe_apel ?? '' ?>
      - Carnet: <?= $this->datos_socio->numero_carnet ?? '' ?>
      <a href="<?php echo $this->route; ?>/fotocarnet?limpiar=1" class="btn btn-sm btn-warning float-right">
        <i class="fas fa-redo"></i> Nueva busqueda
      </a>
    </div>

    <form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->route; ?>/guardar_foto"
      id="form-foto-carnet">
      <div class="content-dashboard">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

        <div class="row">
          <div class="col-12 col-md-6 border-right">
            <h4 class="text-center">Informacion actual del socio</h4>

            <div class="col-12 form-group">
              <label class="control-label">Numero de accion</label>
              <label class="input-group">
                <span class="input-group-text input-icono"><i class="fas fa-hashtag"></i></span>
                <input type="text" class="form-control" value="<?= $this->datos_socio->numero_carnet ?? '' ?>" readonly>
              </label>
            </div>

            <div class="col-12 form-group">
              <label class="control-label">Nombre</label>
              <label class="input-group">
                <span class="input-group-text input-icono"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" value="<?= $this->datos_socio->sbe_nomb ?? '' ?>" readonly>
              </label>
            </div>

            <div class="col-12 form-group">
              <label class="control-label">Apellidos</label>
              <label class="input-group">
                <span class="input-group-text input-icono"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" value="<?= $this->datos_socio->sbe_apel ?? '' ?>" readonly>
              </label>
            </div>

            <?php
            $fotoActual = generateBase64Image($this->datos_socio->socio_foto ?? '');
            ?>
            <div class="col-12 form-group">
              <label class="control-label">Foto actual</label>
              <div class="content-thumbnail">
                <?php if ($fotoActual) { ?>
                  <img src="<?= $fotoActual ?>" alt="Foto actual" class="img-cambio" />
                <?php } else { ?>
                  <div class="sin-foto">No hay foto registrada</div>
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <h4 class="text-center">Nueva foto de carnet</h4>

            <div class="col-12 form-group">
              <label class="control-label">Subir nueva foto <span class="text-danger">*</span></label>
              <input type="file" class="form-control file-image" name="solicitud_foto_file" id="solicitud_foto_file"
                accept="image/*" required>
              <small class="form-text text-muted">Formatos permitidos: JPG, JPEG, PNG. Tamaño maximo: 5MB.</small>
            </div>

            <div class="col-12 form-group">
              <label class="control-label">Vista previa</label>
              <div class="content-thumbnail">
                <img id="preview-nueva-foto" src="" alt="Vista previa" class="img-cambio d-none" />
                <div id="sin-preview" class="sin-foto">Seleccione una imagen para previsualizar</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="botones-acciones">
        <button type="button" class="btn btn-guardar" data-bs-toggle="modal" data-bs-target="#modalConfirmarFoto">
          <i class="fas fa-save"></i> Guardar foto
        </button>
        <a href="<?php echo $this->route; ?>/fotocarnet?limpiar=1" class="btn btn-warning">
          <i class="fas fa-redo"></i> Nueva busqueda
        </a>
        <a href="<?php echo $this->route; ?>" class="btn btn-cancelar">
          <i class="fas fa-times"></i> Cancelar
        </a>
      </div>

      <div class="modal fade" id="modalConfirmarFoto" tabindex="-1" role="dialog"
        aria-labelledby="modalConfirmarFotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalConfirmarFotoLabel">Confirmar actualizacion de foto</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Esta accion actualizara unicamente la foto de carnet del socio.</p>
              <p class="text-info mb-0"><i class="fas fa-info-circle"></i> No se enviaran correos ni notificaciones.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times"></i> Cancelar
              </button>
              <button type="button" class="btn btn-success" id="btn-confirmar-foto">
                <i class="fas fa-check"></i> Confirmar y actualizar
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  <?php } ?>
</div>

<style>
  .search-socio-container {
    padding: 50px 20px;
    background: #fafbfc;
    border-radius: 8px;
  }

  .search-card {
    background: #fff;
    border-radius: 8px;
    padding: 50px 40px;
    border: 1px solid #e8eaed;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }

  .search-header {
    text-align: center;
    margin-bottom: 35px;
  }

  .icon-wrapper {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    border: 1px solid #e8eaed;
  }

  .icon-wrapper i {
    font-size: 24px;
    color: #5f6368;
  }

  .search-title {
    font-size: 24px;
    font-weight: 400;
    color: #202124;
    margin-bottom: 8px;
  }

  .search-subtitle {
    font-size: 14px;
    color: #5f6368;
    margin-bottom: 0;
  }

  .btn-search-primary {
    background: #1a73e8;
    border: none;
    color: #fff;
    padding: 11px 32px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 4px;
  }

  .btn-search-primary:hover {
    background: #1557b0;
    color: #fff;
  }

  .input-group-text.input-icono {
    background-color: #232222 !important;
  }

  .img-cambio {
    height: 220px;
    width: 100%;
    object-fit: contain;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    background: #fff;
  }

  .sin-foto {
    min-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 1px dashed #ced4da;
    border-radius: 5px;
    background: #f8f9fa;
    text-align: center;
    padding: 20px;
  }

  .border-right {
    border-right: 2px solid #ddd;
  }

  .content-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    max-width: 100%;
    text-align: center;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  @media (max-width: 768px) {
    .border-right {
      border-right: none;
      border-bottom: 2px solid #ddd;
      padding-bottom: 20px;
      margin-bottom: 20px;
    }

    .search-socio-container {
      padding: 30px 15px;
    }

    .search-card {
      padding: 35px 25px;
    }
  }
</style>

<div id="loader-overlay"
  style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center;">
  <div class="loader-content" style="text-align: center; color: white;">
    <div class="spinner"
      style="border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; width: 60px; height: 60px; animation: spin 1s linear infinite; margin: 0 auto 20px;">
    </div>
    <h4>Actualizando foto...</h4>
    <p>Por favor espere</p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var inputFoto = document.getElementById('solicitud_foto_file');
    var preview = document.getElementById('preview-nueva-foto');
    var sinPreview = document.getElementById('sin-preview');
    var btnConfirmar = document.getElementById('btn-confirmar-foto');
    var form = document.getElementById('form-foto-carnet');

    if (inputFoto) {
      inputFoto.addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) {
          preview.classList.add('d-none');
          preview.src = '';
          sinPreview.classList.remove('d-none');
          return;
        }

        var reader = new FileReader();
        reader.onload = function (event) {
          preview.src = event.target.result;
          preview.classList.remove('d-none');
          sinPreview.classList.add('d-none');
        };
        reader.readAsDataURL(file);
      });
    }

    if (btnConfirmar) {
      btnConfirmar.addEventListener('click', function () {
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        $('#modalConfirmarFoto').modal('hide');
        document.getElementById('loader-overlay').style.display = 'flex';
        form.submit();
      });
    }
  });
</script>

<?php
function generateBase64Image(?string $base64String, string $defaultMimeType = 'image/png'): ?string
{
  if (!$base64String) {
    return null;
  }

  $foto = trim($base64String);

  if (strpos($foto, 'data:image') === 0) {
    $partes = explode(',', $foto, 2);
    $foto = isset($partes[1]) ? $partes[1] : '';
  }

  $foto = preg_replace('/\s+/', '', $foto);

  if ($foto !== '' && ctype_xdigit($foto) && strlen($foto) % 2 === 0) {
    $binario = @hex2bin($foto);
    if ($binario !== false) {
      $foto = base64_encode($binario);
    }
  }

  $imageData = base64_decode($foto, true);
  if ($imageData === false) {
    return null;
  }

  $imageInfo = getimagesizefromstring($imageData);
  $mimeType = $imageInfo !== false ? $imageInfo['mime'] : $defaultMimeType;

  return "data:$mimeType;base64," . $foto;
}
?>