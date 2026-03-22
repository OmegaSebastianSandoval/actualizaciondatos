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
  <style>
    .meta-container {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 12px;
      border: 1px solid #e9ecef;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .meta-progress-wrapper {
      position: relative;
      width: 300px;
      cursor: pointer;
      margin: 0 15px;
    }

    .meta-label {
      font-size: 14px;
      font-weight: 700;
      color: #202124;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .progress-custom {
      height: 18px;
      background-color: #e8eaed;
      border-radius: 9px;
      overflow: hidden;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
      border: 1px solid #dadce0;
    }

    .progress-bar-custom {
      height: 100%;
      background: linear-gradient(90deg, #3498db, #2ecc71);
      transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .meta-tooltip {
      visibility: hidden;
      position: absolute;
      bottom: 140%;
      left: 50%;
      transform: translateX(-50%);
      background-color: #202124;
      color: #fff;
      text-align: center;
      padding: 10px 15px;
      border-radius: 8px;
      z-index: 100;
      opacity: 0;
      transition: all 0.3s;
      width: 220px;
      font-size: 13px;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .meta-tooltip::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -6px;
      border-width: 6px;
      border-style: solid;
      border-color: #202124 transparent transparent transparent;
    }

    .meta-progress-wrapper:hover .meta-tooltip {
      visibility: visible;
      opacity: 1;
      bottom: 155%;
    }

    .meta-stats {
      font-weight: 800;
      color: #fff;
    }

    .meta-numbers {
      font-size: 15px;
      font-weight: 700;
      color: #1a73e8;
      background: #e8f0fe;
      padding: 4px 12px;
      border-radius: 20px;
      min-width: 85px;
      text-align: center;
    }

    .meta-percentage-tag {
      font-size: 12px;
      font-weight: 700;
      color: #fff;
      background: rgba(0, 0, 0, 0.1);
      padding: 0 8px;
      border-radius: 10px;
      line-height: 16px;
    }

    .header-top-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      position: sticky;
      top: 0;
      background: white;
      z-index: 1000;
      padding: 10px 15px;
      border-bottom: 2px solid #e8eaed;

    }

    .header-top-container .meta-container {
      margin-bottom: 0;
    }

    .header-top-container .titulo-principal {
      margin-bottom: 0 !important;
    }
  </style>
<?php endif; ?>


<div class="header-top-container">
  <h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
  <?php if ($_SESSION['kt_login_level'] == 14): ?>

    <a href="<?php echo $this->route; ?>/fotocarnet?limpiar=1" class="btn btn-info me-2">
      <i class="fas fa-camera"></i> Solo actualizar foto
    </a>

    <div class="meta-container">
      <?php
      $porcentaje = ($this->meta > 0) ? min(100, round(($this->solicitudesHoyUsuario / $this->meta) * 100)) : 0;
      $faltantes = max(0, $this->meta - $this->solicitudesHoyUsuario);
      $barColor = $porcentaje >= 100 ? '#2ecc71' : ($porcentaje >= 75 ? '#3498db' : '#f39c12');
      ?>
      <span class="meta-label"> Meta</span>

      <div class="meta-progress-wrapper">
        <div class="progress-custom">
          <div class="progress-bar-custom" style="width: <?= $porcentaje ?>%; background: <?= $barColor ?>;">
            <?php if ($porcentaje > 15): ?>
              <span class="meta-percentage-tag"><?= $porcentaje ?>%</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="meta-tooltip">
          <div class="mb-1">Progreso Actual: <span class="meta-stats"><?= $porcentaje ?>%</span></div>
          <div>Solicitudes: <span class="meta-stats"><?= $this->solicitudesHoyUsuario ?> de <?= $this->meta ?></span>
          </div>
          <hr style="margin: 8px 0; border-top: 1px solid rgba(255,255,255,0.1);">
          <?php if ($faltantes > 0): ?>
            <div class="text-info">Te faltan <strong><?= $faltantes ?></strong> para el objetivo.</div>
          <?php else: ?>
            <div class="text-success"><i class="fas fa-star"></i> Meta alcanzada.</div>
          <?php endif; ?>
        </div>
      </div>

      <div class="meta-numbers">
        <span class="text-dark"><?= $this->solicitudesHoyUsuario ?></span> / <?= $this->meta ?>
      </div>
    </div>
  <?php endif; ?>

</div>
<!-- SELECT 2 -->
<link href="/components/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="/components/select2/dist/js/select2.min.js"></script>

<div class="container-fluid">

  <?php if ($this->error) { ?>
    <div class="alert alert-<?= $this->tipo_error ?? 'danger' ?> text-center">
      <?= $this->error ?>
    </div>
  <?php } ?>

  <?php if (!$this->datos_socio) { ?>
    <!-- Formulario para buscar socio -->
    <div class="content-dashboard search-socio-container">
      <form class="text-start" method="post" action="<?php echo $this->route; ?>/buscar_socio" id="form-buscar-socio">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

        <div class="row justify-content-center">
          <div class="col-12 col-lg-8">
            <div class="search-card">
              <div class="search-header">
                <div class="icon-wrapper">
                  <i class="fas fa-search"></i>
                </div>
                <h4 class="search-title">Buscar Socio</h4>
                <p class="search-subtitle">Ingrese el número de carnet para buscar al socio en el sistema</p>
              </div>

              <div class="search-body">
                <div class="form-group">
                  <label class="control-label">Número de carnet <span class="text-danger">*</span></label>

                  <input type="text" class="form-control form-control-lg" name="numero_carnet" id="numero_carnet" required
                    placeholder="Ej: 12345" autofocus>
                </div>
              </div>

              <div class="text-center mt-4">
                <button type="submit" class="btn btn-search-primary">
                  <i class="fas fa-search"></i> Buscar Socio
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>
    </form>
  </div>
<?php } else { ?>
  <div class="alert alert-info mb-3">
    <i class="fas fa-info-circle"></i> <strong>Socio encontrado:</strong> <?= $this->datos_socio->sbe_nomb ?? '' ?>
    <?= $this->datos_socio->sbe_apel ?? '' ?> - Carnet: <?= $this->datos_socio->numero_carnet ?? '' ?>
    <a href="<?php echo $this->route; ?>/crear?limpiar=1" class="btn btn-sm btn-warning float-right">
      <i class="fas fa-redo"></i> Nueva Búsqueda
    </a>
  </div>
  <!-- Formulario con los datos del socio encontrado -->
  <form class="text-start" enctype="multipart/form-data" method="post"
    action="<?php echo $this->route; ?>/guardar_solicitud" data-toggle="validator" id="form-solicitudes">
    <div class="content-dashboard">
      <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
      <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

      <input type="hidden" name="solicitud_sbe_codi" id="solicitud_sbe_codi"
        value="<?= $this->datos_socio->SBE_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_sbe_cont" id="solicitud_sbe_cont"
        value="<?= $this->datos_socio->SBE_CONT ?? '' ?>" />
      <input type="hidden" name="solicitud_soc_codi" id="solicitud_soc_codi"
        value="<?= $this->datos_socio->SOC_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_soc_cont" id="solicitud_soc_cont"
        value="<?= $this->datos_socio->SOC_CONT ?? '' ?>" />
      <input type="hidden" name="solicitud_mac_nume" id="solicitud_mac_nume"
        value="<?= $this->datos_socio->MAC_NUME ?? '' ?>" />
      <input type="hidden" name="solicitud_ncon" id="solicitud_ncon" value="<?= $this->datos_socio->SBE_NCON ?? '' ?>" />
      <input type="hidden" name="solicitud_sbe_idio" id="solicitud_sbe_idio"
        value="<?= $this->datos_socio->SBE_IDIO ?? '' ?>" />

      <!-- Datos actuales (hidden) -->
      <input type="hidden" name="solicitud_numero_accion_actual" value="<?= $this->datos_socio->numero_carnet ?? '' ?>" />
      <input type="hidden" name="solicitud_nombre_actual" value="<?= $this->datos_socio->sbe_nomb ?? '' ?>" />
      <input type="hidden" name="solicitud_apellidos_actual" value="<?= $this->datos_socio->sbe_apel ?? '' ?>" />
      <input type="hidden" name="solicitud_documento_actual" value="<?= $this->datos_socio->SBE_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_telefono_actual" value="<?= $this->datos_socio->sbe_ncel ?? '' ?>" />
      <input type="hidden" name="solicitud_direccion_actual" value="<?= $this->datos_socio->sbe_dire ?? '' ?>" />
      <input type="hidden" name="solicitud_ciudad_actual" value="<?= $this->datos_socio->MUN_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_departamento_actual" value="<?= $this->datos_socio->DEP_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_pais_actual" value="<?= $this->datos_socio->PAI_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_region_actual" value="<?= $this->datos_socio->REG_CODI ?? '' ?>" />
      <input type="hidden" name="solicitud_email_facturacion_actual" value="<?= $this->datos_socio->con_mail ?? '' ?>" />
      <input type="hidden" name="solicitud_email_comunicacion_actual" value="<?= $this->datos_socio->sbe_mail ?? '' ?>" />
      <input type="hidden" name="solicitud_foto_actual" value="<?= $this->datos_socio->socio_foto ?? '' ?>" />

      <div class="row">
        <div class="col-12 col-md-6 border-right">
          <h4 class="text-center">Información Actual</h4>

          <div class="col-12 form-group">
            <label class="control-label">Número de acción</label>
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

          <div class="col-12 form-group">
            <label class="control-label">Documento</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-id-card"></i></span>
              <input type="text" class="form-control" value="<?= $this->datos_socio->SBE_CODI ?? '' ?>" readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Teléfono</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-phone"></i></span>
              <input type="text" class="form-control" value="<?= $this->datos_socio->sbe_ncel ?? '' ?>" readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Dirección</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" value="<?= $this->datos_socio->sbe_dire ?? '' ?>" readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Ciudad</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-city"></i></span>
              <?php
              // Buscar el nombre de la ciudad actual
              $ciudadActual = '';
              if (isset($this->datos_socio->DEP_CODI) && isset($this->datos_socio->MUN_CODI)) {
                foreach ($this->ciudadesList as $ciudad) {
                  if ($ciudad->dep_codi == $this->datos_socio->DEP_CODI && $ciudad->mun_codi == $this->datos_socio->MUN_CODI) {
                    $ciudadActual = $ciudad->mun_nomb . ' - ' . $ciudad->dep_nomb;
                    break;
                  }
                }
              }
              ?>
              <input type="text" class="form-control" value="<?= $ciudadActual ?: ($this->datos_socio->mun_nomb ?? '') ?>"
                readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Email de facturación</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-envelope"></i></span>
              <input type="text" class="form-control" value="<?= $this->datos_socio->con_mail ?? '' ?>" readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Email de comunicación</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-envelope"></i></span>
              <input type="text" class="form-control" value="<?= $this->datos_socio->sbe_mail ?? '' ?>" readonly>
            </label>
          </div>

          <?php
          $fotoActual = generateBase64Image($this->datos_socio->socio_foto ?? '');
          if ($fotoActual) {
            ?>
            <div class="col-12 form-group">
              <label class="control-label">Foto actual</label>
              <div class="content-thumbnail">
                <img src="<?= $fotoActual ?>" alt="Foto actual" class="img-cambio" />
                <span>Imagen Actual</span>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="col-12 col-md-6">
          <h4 class="text-center">Nuevos Datos a Actualizar</h4>

          <div class="col-12 form-group">
            <label class="control-label">Número de acción</label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-hashtag"></i></span>
              <input type="text" class="form-control" name="solicitud_numero_accion" id="solicitud_numero_accion"
                value="<?= $this->datos_socio->numero_carnet ?? '' ?>" readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Nombre <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" name="solicitud_nombre" id="solicitud_nombre"
                value="<?= $this->datos_socio->sbe_nomb ?? '' ?>" required readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Apellidos <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" name="solicitud_apellidos" id="solicitud_apellidos"
                value="<?= $this->datos_socio->sbe_apel ?? '' ?>" required >
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Documento <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-id-card"></i></span>
              <input type="text" class="form-control" name="solicitud_documento" id="solicitud_documento"
                value="<?= $this->datos_socio->SBE_CODI ?? '' ?>" required readonly>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Teléfono <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-phone"></i></span>
              <input type="text" class="form-control" name="solicitud_telefono" id="solicitud_telefono"
                value="<?= $this->datos_socio->sbe_ncel ?? '' ?>" required>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Dirección <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" name="solicitud_direccion" id="solicitud_direccion"
                value="<?= $this->datos_socio->sbe_dire ?? '' ?>" required>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Ciudad <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-city"></i></span>
              <select class="form-control" name="solicitud_ciudad" id="solicitud_ciudad" required>
                <option value="">Seleccione una ciudad</option>
                <?php foreach ($this->ciudadesList as $ciudad) { ?>
                  <option value="<?= $ciudad->mun_codi ?>" data-departamento="<?= $ciudad->dep_codi ?>"
                    data-pais="<?= $ciudad->pai_codi ?>" data-region="<?= $ciudad->reg_codi ?>"
                    <?= (isset($this->datos_socio->MUN_CODI) && $this->datos_socio->MUN_CODI == $ciudad->mun_codi && $this->datos_socio->DEP_CODI == $ciudad->dep_codi) ? 'selected' : '' ?>>
                    <?= $ciudad->mun_nomb ?> - <?= $ciudad->dep_nomb ?>
                  </option>
                <?php } ?>
              </select>
            </label>
          </div>

          <input type="hidden" name="solicitud_departamento" id="solicitud_departamento"
            value="<?= $this->datos_socio->DEP_CODI ?? '' ?>" />
          <input type="hidden" name="solicitud_pais" id="solicitud_pais"
            value="<?= $this->datos_socio->PAI_CODI ?? '' ?>" />
          <input type="hidden" name="solicitud_region" id="solicitud_region"
            value="<?= $this->datos_socio->REG_CODI ?? '' ?>" />

          <div class="col-12 form-group">
            <label class="control-label">Email de facturación <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" name="solicitud_email_facturacion" id="solicitud_email_facturacion"
                value="<?= $this->datos_socio->con_mail ?? '' ?>" required>
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Email de comunicación <span class="text-danger">*</span></label>
            <label class="input-group">

              <span class="input-group-text input-icono"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" name="solicitud_email_comunicacion"
                id="solicitud_email_comunicacion" value="<?= $this->datos_socio->sbe_mail ?? '' ?>">
            </label>
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Foto</label>
            <input type="file" class="form-control file-image" name="solicitud_foto_file" id="solicitud_foto_file"
              accept="image/*">
            <input type="hidden" name="solicitud_foto" id="solicitud_foto"
              value="<?= $this->datos_socio->socio_foto ?? '' ?>">
          </div>

          <div class="col-12 form-group">
            <label class="control-label">Observaciones</label>
            <textarea class="form-control" name="solicitud_observaciones" id="solicitud_observaciones"
              rows="3"></textarea>
          </div>
          <div class="col-12 form-group">

            <label class="checkbox-text">
              <input type="checkbox" name="solicitud_acepta_politicas" id="solicitud_acepta_politicas" value="1">
              <span>Acepto las <a href="https://www.clubelnogal.com/tratamiento-de-datos-personales-1/"
                  target="_blank">pol&iacute;ticas de tratamiento de datos</a></span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="botones-acciones">
      <button type="button" class="btn btn-guardar" data-bs-toggle="modal" data-bs-target="#modalConfirmarActualizacion">
        <i class="fas fa-save"></i> Guardar y Enviar
      </button>
      <a href="<?php echo $this->route; ?>/crear?limpiar=1" class="btn btn-warning">
        <i class="fas fa-redo"></i> Nueva Búsqueda
      </a>
      <a href="<?php echo $this->route; ?>/crear?limpiar=1" class="btn btn-cancelar">
        <i class="fas fa-times"></i> Cancelar
      </a>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="modalConfirmarActualizacion" tabindex="-1" role="dialog"
      aria-labelledby="modalConfirmarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmarLabel">Confirmar solicitud</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          </div>
          <div class="modal-body">
            <p>¿Está seguro que desea guardar y enviar esta solicitud de actualización de datos?</p>
            <p class="text-info"><i class="fas fa-info-circle"></i> Los datos se enviarán automáticamente al sistema
              para su respectiva validación.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn btn-success" id="btn-confirmar-actualizacion">
              <i class="fas fa-check"></i> Confirmar y enviar
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php } ?>
</div>

<style>
  input[readonly] {
    background-color: #ebebeb !important;
  }
  /* Estilos para el formulario de búsqueda - Minimalista */
  .search-socio-container {
    padding: 50px 20px;
    background: #fafbfc;
    border-radius: 8px;
  }

  .search-card {
    background: white;
    border-radius: 8px;
    padding: 50px 40px;
    border: 1px solid #e8eaed;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.2s ease;
  }

  .search-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .search-header {
    text-align: center;
    margin-bottom: 40px;
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
    letter-spacing: -0.5px;
  }

  .search-subtitle {
    font-size: 14px;
    color: #5f6368;
    margin-bottom: 0;
    font-weight: 400;
  }

  .search-body {
    padding: 0 20px;
  }

  .input-group-modern .input-group-text {
    background: #ffffff;
    border: 1px solid #dadce0;
    border-right: none;
    color: #5f6368;
    font-size: 16px;
    padding: 0 15px;
  }

  .input-group-modern .form-control-lg {
    border-left: none;
    padding: 12px 15px;
    font-size: 15px;
    border: 1px solid #dadce0;
    transition: all 0.2s ease;
    color: #202124;
  }

  .input-group-modern .form-control-lg:focus {
    border-color: #1a73e8;
    box-shadow: none;
    outline: none;
  }

  .input-group-modern .form-control-lg:focus+.input-group-prepend .input-group-text,
  .input-group-modern .input-group-prepend .input-group-text:has(+ .form-control-lg:focus) {
    border-color: #1a73e8;
  }

  .btn-search-primary {
    background: #1a73e8;
    border: none;
    color: white;
    padding: 11px 32px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 4px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    letter-spacing: 0.25px;
  }

  .btn-search-primary:hover {
    background: #1557b0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    color: white;
  }

  .btn-search-primary:active {
    background: #0d47a1;
  }

  /* Estilos existentes */
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
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
  }

  .border-right {
    border-right: 2px solid #ddd;
  }

  .content-thumbnail {
    padding: .25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    max-width: 100%;
    text-align: center;
  }

  .content-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    margin-bottom: 10px;
  }

  .content-thumbnail span {
    display: block;
    font-size: 13px;
    color: #6c757d;
    font-weight: 500;
  }

  .select2-container .select2-selection--single {
    height: 42px;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 41px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px;
  }

  .input-group .select2-container {
    flex: 1 1 auto;
    width: 1% !important;
  }

  .input-group .select2-container .select2-selection--single {
    height: 42px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .input-group .select2-container--default .select2-selection--single {
    border-left: 0;
  }


  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .select2-container .select2-selection--single .select2-selection__rendered {

    font-weight: 500;
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

    .search-title {
      font-size: 21px;
    }

    .search-subtitle {
      font-size: 13px;
    }

    .search-body {
      padding: 0;
    }

    .icon-wrapper {
      width: 55px;
      height: 55px;
    }

    .icon-wrapper i {
      font-size: 22px;
    }
  }
</style>

<!-- Loader Overlay -->
<div id="loader-overlay"
  style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center;">
  <div class="loader-content" style="text-align: center; color: white;">
    <div class="spinner"
      style="border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; width: 60px; height: 60px; animation: spin 1s linear infinite; margin: 0 auto 20px;">
    </div>
    <h4>Procesando actualización...</h4>
    <p>Por favor espere</p>
  </div>
</div>

<script src="/components/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/components/bootstrap-fileinput/js/locales/es.js"></script>

<script>
  $(document).ready(function () {
    const $formSolicitudes = $('#form-solicitudes');

    function validarCamposEmail () {
      let emailsValidos = true;

      $formSolicitudes.find('input[type="email"]').each(function () {
        const valor = $(this).val().trim();

        if (valor !== '' && !this.checkValidity()) {
          this.setCustomValidity('Ingrese un correo electronico valido.');
          emailsValidos = false;
        } else {
          this.setCustomValidity('');
        }
      });

      return emailsValidos;
    }

    // Inicializar Select2
    $('#solicitud_ciudad').select2({
      width: '100%'
    });

    // Estado inicial del botón de confirmación
    $('#btn-confirmar-actualizacion').prop('disabled', false).html('<i class="fas fa-check"></i> Confirmar y enviar');

    // Actualizar campos ocultos cuando cambia la ciudad
    $('#solicitud_ciudad').on('change', function () {
      const selectedOption = $(this).find(':selected');
      const departamento = selectedOption.data('departamento');
      const pais = selectedOption.data('pais');
      const region = selectedOption.data('region');

      $('#solicitud_departamento').val(departamento);
      $('#solicitud_pais').val(pais);
      $('#solicitud_region').val(region);
    });

    // Inicializar file input
    $(".file-image").fileinput({
      maxFileSize: 5048,
      previewFileType: "image",
      allowedFileExtensions: ["jpg", "png", "jpeg"],
      browseClass: "btn btn-primary",
      showUpload: false,
      showRemove: true,
      browseIcon: "<i class='fas fa-image'></i> ",
      browseLabel: "Seleccionar Imagen",
      language: "es",
      dropZoneEnabled: false
    });

    // Convertir imagen a base64 cuando se selecciona
    $('#solicitud_foto_file').on('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
          const base64String = event.target.result.split(',')[1];
          $('#solicitud_foto').val(base64String);
        };
        reader.readAsDataURL(file);
      }
    });

    // Limpiar mensajes custom al editar correos
    $formSolicitudes.find('input[type="email"]').on('input blur', function () {
      this.setCustomValidity('');
    });

    // Bloquear cualquier envio directo del formulario si hay emails invalidos
    $formSolicitudes.on('submit', function (e) {
      if (!validarCamposEmail() || !this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        this.reportValidity();
        return false;
      }
    });

    // Confirmar y enviar formulario
    $('#btn-confirmar-actualizacion').on('click', function (e) {
      e.preventDefault();

      const form = document.getElementById('form-solicitudes');

      if (!validarCamposEmail() || !form.checkValidity()) {
        $('#modalConfirmarActualizacion').modal('hide');
        form.reportValidity();
        return;
      }

      $('#modalConfirmarActualizacion').modal('hide');
      $('#loader-overlay').css('display', 'flex');
      $('#btn-confirmar-actualizacion').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');

      form.submit();
    });
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

  $foto = trim($base64String);

  // Si viene como data URL, extrae solo el payload base64
  if (strpos($foto, 'data:image') === 0) {
    $partes = explode(',', $foto, 2);
    $foto = isset($partes[1]) ? $partes[1] : '';
  }

  $foto = preg_replace('/\s+/', '', $foto);

  // Si viene hexadecimal (ejemplo: ffd8ffe0...), convertir a base64.
  if ($foto !== '' && ctype_xdigit($foto) && strlen($foto) % 2 === 0) {
    $binario = @hex2bin($foto);
    if ($binario !== false) {
      $foto = base64_encode($binario);
    }
  }

  // Decodifica temporalmente la cadena normalizada para detectar el tipo MIME
  $imageData = base64_decode($foto, true);
  if ($imageData === false) {
    return null;
  }

  $imageInfo = getimagesizefromstring($imageData);

  // Detecta el tipo MIME o usa el valor predeterminado
  $mimeType = $imageInfo !== false ? $imageInfo['mime'] : $defaultMimeType;

  // Vuelve a codificar en base64 con el prefijo MIME adecuado
  return "data:$mimeType;base64," . $foto;
}
?>