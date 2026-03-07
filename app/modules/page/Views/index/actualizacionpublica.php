<script src="https://www.google.com/recaptcha/api.js" async defer></script>




<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  * {
    box-sizing: border-box;
  }

  header {
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #FFF;
  }

  header img {
    width: 100%;
    max-width: 150px;
  }

  footer {
    position: fixed;
    bottom: 0;
    text-align: center;
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 10px 0;
    border-top: 1px solid #e2e8f0;
    background-color: #FFF;
  }

  footer span {
    color: #262626;
  }


  a {
    color: #2C5483;
    text-decoration: none;
  }

  body {
    display: block;
    justify-content: center;
    align-items: center;
    margin: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
    min-height: 100vh;
  }

  .g-recaptcha {
    display: block !important;
    position: relative !important;
    transform: none !important;
  }

  iframe[src*="recaptcha"] {
    position: static !important;
  }

  .contenedor-formulario {
    margin: 0 auto;
    max-width: 680px;
  }

  body>div {
    width: 100%;
  }

  :root {
    --primary: #2C5483;
    --primary-hover: #23466d;
    --primary-light: #e8eff7;
    --success: #51cf66;
    --danger: #2C5483;
    --warning: #ffd43b;
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --border-color: #e2e8f0;
    --bg-input: #ffffff;
  }

  .form {
    position: relative;
    display: flex;
    flex-direction: column;
    border-radius: 16px;
    background-color: #fff;
    color: var(--text-primary);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    width: 100%;
    background-clip: border-box;
    overflow: hidden;
  }

  .btn-rosa {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    color: white;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 14px;
    cursor: pointer;
    border-radius: 0 8px 8px 0;
    transition: all 0.2s ease;
  }

  .btn-rosa:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(44, 84, 131, 0.3);
  }

  .header {
    position: relative;
    background: linear-gradient(135deg, #2C5483 0%, #3f6795 50%, #5b82ad 100%);
    padding: 20px;
    color: #fff;
    text-align: center;
    letter-spacing: -0.02em;
    font-weight: 700;
    font-size: 24px;
    position: relative;
    overflow: hidden;
  }

  .header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.4;
  }

  .header span {
    position: relative;
    z-index: 1;
  }

  .inputs {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 13px;
  }

  .field-group {
    display: flex;
    flex-direction: column;
  }

  .field-group label {
    margin-top: 0;
  }

  .field-full {
    grid-column: 1 / -1;
  }

  label {
    margin: 0;
    color: var(--text-primary);
    margin-top: 16px;
    margin-bottom: 6px;
    font-weight: 500;
    font-size: 14px;
    display: block;
  }

  label span[style*="color:red"] {
    color: var(--danger);
  }

  label.error {
    color: var(--danger);
    font-size: 13px;
    margin-top: 4px;
  }

  .input-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    min-width: 200px;
    width: 100%;
    height: 2.75rem;
    position: relative;
  }

  .input {
    border: 2px solid var(--border-color);
    outline: 0;
    color: var(--text-primary);
    font-weight: 400;
    font-size: 15px;
    line-height: 1.5;
    padding: 12px 16px;
    background-color: var(--bg-input);
    border-radius: 10px;
    width: 100%;
    height: 100%;
    transition: all 0.2s ease;
    font-family: inherit;
  }

  .input::placeholder {
    color: #a0aec0;
  }

  .select2-container {
    margin-bottom: 0;
  }

  .input:hover {
    border-color: #cbd5e0;
  }

  .input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
  }

  .input:read-only {
    background-color: #f7fafc;
    border-color: #e2e8f0;
    color: var(--text-secondary);
  }

  .input:disabled {
    background-color: #f7fafc;
    border-color: #e2e8f0;
    cursor: not-allowed;
    color: #a0aec0;
  }

  select.input {
    background-color: var(--bg-input) !important;
    cursor: pointer;
  }

  .input-error {
    border-color: var(--danger) !important;
    box-shadow: 0 0 0 3px rgba(44, 84, 131, 0.1) !important;
  }

  .checkbox-container {
    margin-left: 0;
    /* margin-top: 16px; */
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }

  .checkbox-text {
    cursor: pointer;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
  }

  .checkbox-text input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--primary);
  }

  .sigin-btn {
    /* margin-top: 24px; */
    font-weight: 600;
    font-size: 15px;
    line-height: 1;
    text-align: center;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    border-radius: 10px;
    width: 100%;
    outline: 0;
    border: 0;
    color: #fff;
    transition: all 0.2s ease;
    cursor: pointer;
    text-transform: none;
    letter-spacing: 0.02em;
  }

  .sigin-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(44, 84, 131, 0.3);
  }

  .sigin-btn:active:not(:disabled) {
    transform: translateY(0);
  }

  .sigin-btn:disabled {
    background: #e2e8f0;
    color: #a0aec0;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
  }

  .select2.select2-container {
    width: 100% !important;
  }

  .select2-container .select2-selection--single {
    height: 48px;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    transition: all 0.2s ease;
  }

  .select2-container--default .select2-selection--single:hover {
    border-color: #cbd5e0;
  }

  .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 44px;
    padding-left: 16px;
    color: var(--text-primary);
    font-size: 15px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px;
    right: 8px;
  }

  .content-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: contain;
  }

  .content-thumbnail {
    padding: 16px;
    background-color: #f7fafc;
    border: 2px dashed var(--border-color);
    border-radius: 10px;
    max-width: 100%;
    height: auto;
    margin-top: 12px;
  }

  .content-thumbnail span {
    display: block;
    text-align: center;
    font-size: 13px;
    margin-top: 12px;
    color: var(--text-secondary);
    font-weight: 500;
  }

  .file-drop-disabled {
    display: grid;
  }

  .carnet-status {
    position: absolute;
    right: 14px;
    top: 55%;
    transform: translateY(-50%);
    font-size: 18px;
  }

  .input-with-status {
    position: relative;
  }

  .input-with-status .input {
    padding-right: 40px;
  }

  #loader-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(4px);
    z-index: 9999;
    justify-content: center;
    align-items: center;
  }

  .loader-content {
    text-align: center;
    color: white;
  }

  .loader-content h4 {
    font-weight: 600;
    font-size: 20px;
    margin-bottom: 8px;
  }

  .loader-content p {
    color: #cbd5e0;
    font-size: 14px;
  }

  .spinner {
    border: 4px solid rgba(255, 255, 255, 0.1);
    border-top: 4px solid #2C5483;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 24px;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .alert {
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 0;
    border: 1px solid transparent;
    font-size: 14px;
    line-height: 1.6;
  }

  .alert-danger {
    background-color: #fff5f5;
    border-color: #feb2b2;
    color: #c53030;
  }

  .alert-success {
    background-color: #f0fff4;
    border-color: #9ae6b4;
    color: #22543d;
  }

  .alert-warning {
    background-color: #fffaf0;
    border-color: #fbd38d;
    color: #744210;
    font-weight: 500;
  }

  #mensaje-verificacion .alert {
    animation: slideDown 0.3s ease;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  #detalle-form {
    animation: fadeIn 0.4s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  .d-none {
    display: none !important;
  }

  .mb-2 {
    margin-bottom: 12px;
  }

  .mt-1 {
    margin-top: 8px;
  }

  .mt-2 {
    margin-top: 12px;
  }

  .mt-3 {
    margin-top: 16px;
  }

  .p-3 {
    padding: 16px;
  }

  .w-100 {
    width: 100%;
  }

  .mx-auto {
    margin-left: auto;
    margin-right: auto;
  }

  .ml-1 {
    margin-left: 8px;
  }

  @media (max-width: 768px) {
    body {
      /* padding: 15px 10px; */
    }

    .contenedor-formulario {
      padding: 0 15px;
    }

    .inputs {
      padding: 24px 20px;
    }

    .header {
      font-size: 20px;
      padding: 24px 20px;
    }

    label {
      font-size: 13px;
    }

    .input {
      font-size: 14px;
      padding: 11px 14px;
    }

    .contenedor-formulario {
      max-width: 100%;
    }

    .form-grid {
      grid-template-columns: 1fr;
    }

    .field-full {
      grid-column: auto;
    }
  }

  @media (max-width: 480px) {
    .inputs {
      padding: 20px 16px;
    }

    .header {
      font-size: 18px;
      padding: 20px 16px;
    }
  }

  .text-titulo {
    color: #262626;
    text-align: center;
    width: 100%;
    display: block;
    padding: 10px 0 0 0;
    font-size: 0.8rem;
  }
</style>


<div class="contenedor-formulario pt-4 pb-5">

  <form class="form" method="POST" action="/page/index/guardar_actualizacion" enctype="multipart/form-data"
    id="form-actualizacion-publica">
    <div class="header">
      <span>Actualiza tus datos y mantente conectado con El Nogal</span>
    </div>

    <div class="inputs">
      <div class="form-grid">
        <?php if ($this->error && $this->tipo) { ?>
          <div class="alert text-center alert-<?= $this->tipo ?> field-full" role="alert">
            <?= $this->error ?>
          </div>
        <?php } ?>

        <div class="field-group">
          <label for="numero_carnet">N&uacute;mero de carnet <span style="color:red">*</span></label>
          <div class="input-with-status">
            <input placeholder="Ingrese su n&uacute;mero de carnet" class="input" type="text" name="numero_carnet"
              id="numero_carnet" onkeypress="return soloNumeros(event)" pattern="^\d+$" required autocomplete="off">
            <span class="carnet-status" id="carnet-status">
              <i class="fas fa-circle" style="color: #ccc;"></i>
            </span>
          </div>
        </div>

        <div class="field-group">
          <label for="numero_documento">Documento de identidad <span style="color:red">*</span></label>
          <div class="input-with-status">
            <input placeholder="Ingrese su documento" class="input" type="text" name="numero_documento"
              id="numero_documento" required autocomplete="off">
            <span class="carnet-status" id="documento-status">
              <i class="fas fa-circle" style="color: #ccc;"></i>
            </span>
          </div>
        </div>

        <div id="mensaje-verificacion" class="field-full d-none"></div>

        <button class="sigin-btn field-full" type="button" id="btn-validar">Validar</button>

        <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
        <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">

        <input type="text" name="solicitud_fecha"
          style="position: absolute; left: -9999px; width: 1px; height: 1px; opacity: 0;" tabindex="-1"
          autocomplete="off" aria-hidden="true">

        <div id="detalle-form" class="d-none field-full">
          <div class="form-grid">
            <div class="field-group">
              <label for="solicitud_numero_accion">N&uacute;mero de carnet</label>
              <input placeholder="N&uacute;mero de carnet" class="input" type="text" name="solicitud_numero_accion"
                id="solicitud_numero_accion" readonly>
            </div>

            <div class="field-group">
              <label for="solicitud_documento">Documento de identidad</label>
              <input placeholder="Documento" class="input" type="text" name="solicitud_documento"
                id="solicitud_documento" readonly>
            </div>

            <div class="field-group">
              <label for="solicitud_nombre">Nombres <span style="color:red">*</span></label>
              <input placeholder="Nombres" class="input" type="text" name="solicitud_nombre" id="solicitud_nombre"
                minlength="3" maxlength="25" disabled required>
            </div>

            <div class="field-group">
              <label for="solicitud_apellidos">Apellidos <span style="color:red">*</span></label>
              <input placeholder="Apellidos" class="input" type="text" name="solicitud_apellidos"
                id="solicitud_apellidos" minlength="3" maxlength="25" disabled required>
            </div>

            <div class="field-group">
              <label for="solicitud_telefono">Tel&eacute;fono <span style="color:red">*</span></label>
              <input placeholder="Tel&eacute;fono" class="input" type="text" name="solicitud_telefono"
                id="solicitud_telefono" onkeypress="return soloNumeros(event)" maxlength="10" minlength="10"
                pattern="^\d+$" disabled required>
            </div>

            <div class="field-group">
              <label for="solicitud_direccion">Direcci&oacute;n <span style="color:red">*</span></label>
              <input placeholder="Direcci&oacute;n" class="input" type="text" name="solicitud_direccion"
                id="solicitud_direccion" minlength="3" maxlength="75" disabled required>
            </div>

            <input type="hidden" name="solicitud_departamento" id="solicitud_departamento">
            <input type="hidden" name="solicitud_pais" id="solicitud_pais">
            <input type="hidden" name="solicitud_region" id="solicitud_region">

            <div class="field-group field-full">
              <label for="solicitud_ciudad">Ciudad de Residencia <span style="color:red">*</span></label>
              <select class="input" name="solicitud_ciudad" id="solicitud_ciudad" required>
                <option value="" disabled>Seleccione una ciudad</option>
                <?php if ($this->ciudades): ?>
                  <?php foreach ($this->ciudades as $ciudad): ?>
                    <option value="<?= $ciudad->mun_codi ?>" data-pais="<?= $ciudad->pai_codi ?>"
                      data-departamento="<?= $ciudad->dep_codi ?>" data-region="<?= $ciudad->reg_codi ?>">
                      <?= $ciudad->dep_nomb . ", " . $ciudad->mun_nomb ?>
                    </option>
                  <?php endforeach ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="field-group">
              <label for="solicitud_email_facturacion">Email facturaci&oacute;n <span style="color:red">*</span></label>
              <input placeholder="Email facturaci&oacute;n" class="input" type="email"
                name="solicitud_email_facturacion" id="solicitud_email_facturacion" pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45" disabled required>
            </div>

            <div class="field-group">
              <label for="solicitud_email_facturacion_confirm">Confirmar email facturaci&oacute;n <span
                  style="color:red">*</span></label>
              <input placeholder="Confirmar email facturaci&oacute;n" class="input" type="email"
                name="solicitud_email_facturacion_confirm" id="solicitud_email_facturacion_confirm"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+" minlength="7" maxlength="45" disabled required>
            </div>

            <div class="field-group">
              <label for="solicitud_email_comunicacion">Email para recibir comunicaciones</label>
              <input placeholder="Email para recibir comunicaciones" class="input" type="email"
                name="solicitud_email_comunicacion" id="solicitud_email_comunicacion" pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45" disabled>
            </div>

            <div class="field-group">
              <label for="solicitud_email_comunicacion_confirm">Confirmar email para recibir comunicaciones</label>
              <input placeholder="Confirmar email para recibir comunicaciones" class="input" type="email"
                name="solicitud_email_comunicacion_confirm" id="solicitud_email_comunicacion_confirm"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+" minlength="7" maxlength="45" disabled>
            </div>

            <div class="field-group field-full mb-2">
              <label class="w-100" for="solicitud_foto">Foto</label>
              <div class="alert-warning p-3 mt-1 mb-2">
                <strong>Nota:</strong> La foto debe ser en formato JPG o PNG y no debe superar los 4MB.
              </div>
              <input class="file-image" type="file" name="solicitud_foto" id="solicitud_foto" disabled
                accept="image/jpeg, image/png">
              <input type="hidden" name="solicitud_foto_base64" id="solicitud_foto_base64">
              <?php if ($fotoActual): ?>
                <?php
                // Decodificar temporalmente la cadena base64 para detectar el tipo MIME
                $imageData = base64_decode($fotoActual);
                $imageInfo = @getimagesizefromstring($imageData);

                if ($imageInfo !== false) {
                  $mimeType = $imageInfo['mime'];
                } else {
                  $mimeType = 'image/png';
                }

                $base64Image = "data:$mimeType;base64," . $fotoActual;
                ?>
                <div id="current-image-container" class="content-thumbnail" style="margin-top: 10px;">
                  <img id="current-image" src="<?= $base64Image ?>" alt="Imagen actual" />
                  <span>Imagen Actual</span>
                </div>
              <?php else: ?>
                <div id="current-image-container" class="content-thumbnail d-none"
                  style="display: none; margin-top: 10px;">
                  <img id="current-image" src="" alt="Imagen actual" />
                  <span>Imagen Actual</span>
                </div>
              <?php endif; ?>
              <div id="image-preview-container" class="content-thumbnail d-none"
                style="display: none; margin-top: 10px;">
                <img id="image-preview" src="" alt="Vista previa de imagen" />
                <span>Vista previa de imagen</span>
              </div>
            </div>

            <div class="field-group field-full">
              <label for="solicitud_observaciones">Observaciones</label>
              <textarea placeholder="Observaciones" class="input" name="solicitud_observaciones"
                id="solicitud_observaciones" rows="3" style="height: auto;" disabled></textarea>
            </div>

            <div class="field-full">
              <div class="g-recaptcha mx-auto mt-3" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"
                data-callback="enableSubmit"></div>
            </div>
            <div id="recaptchaAlert" class="alert alert-danger mt-2 d-none field-full" role="alert">
              Por favor, completa el captcha para continuar.
            </div>

            <div class="checkbox-container field-full">
              <label class="checkbox-text">
                <input type="checkbox" name="solicitud_acepta_politicas" id="solicitud_acepta_politicas" value="1"
                  disabled>
                <span>Acepto las <a href="https://www.clubelnogal.com/tratamiento-de-datos-personales-1/"
                    target="_blank">pol&iacute;ticas de tratamiento de datos</a></span>
              </label>
            </div>

            <div class="checkbox-container field-full">
              <label class="checkbox-text">
                <input type="checkbox" name="solicitud_declara_titular" id="solicitud_declara_titular" value="1"
                  disabled required>
                <span>Declaro que soy el titular de la informaci&oacute;n suministrada</span>
              </label>
            </div>

            <input type="hidden" name="solicitud_source" value="actualizacion_publica">

            <button class="sigin-btn field-full" type="submit" id="submitBtn" disabled>Enviar solicitud</button>
          </div>
        </div>
      </div>
    </div>
</div>
</form>
</div>

<div id="loader-overlay">
  <div class="loader-content">
    <div class="spinner"></div>
    <h4>Procesando solicitud...</h4>
    <p>Por favor espere</p>
  </div>
</div>

<script src="/components/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/components/bootstrap-fileinput/js/locales/es.js"></script>
<script src="/components/bootstrap/dist/js/bootstrap.min.js"></script>

<script>

  function soloNumeros (event) {
    const charCode = event.keyCode ? event.keyCode : event.which;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      event.preventDefault();
      return false;
    }
    return true;
  }



  let socioVerificado = false;
  let emailFacturacion;
  let emailFacturacionConfirm;
  let emailComunicacion;
  let emailComunicacionConfirm;
  let submitButton;

  const detalleForm = document.getElementById('detalle-form');
  const validarButton = document.getElementById('btn-validar');
  const mensajeVerificacion = document.getElementById('mensaje-verificacion');
  const carnetStatus = document.getElementById('carnet-status');
  const documentoStatus = document.getElementById('documento-status');
  const currentImageContainer = document.getElementById('current-image-container');
  const currentImage = document.getElementById('current-image');

  $(".file-image").fileinput({
    maxFileSize: 10048,
    previewFileType: "image",
    allowedFileExtensions: ["jpg", "png", "jpeg"],
    browseClass: "btn-rosa",
    showUpload: false,
    showRemove: false,
    browseIcon: "<i class=\"fas fa-image\"></i> ",
    browseLabel: "Imagen",
    language: "es",
    dropZoneEnabled: false
  });

  $('#solicitud_ciudad').select2();

  const selectCiudad = document.getElementById('solicitud_ciudad');
  const departamentoInput = document.getElementById('solicitud_departamento');
  const paisInput = document.getElementById('solicitud_pais');
  const regionInput = document.getElementById('solicitud_region');

  $('#solicitud_ciudad').on('change', function () {
    const selectedOption = $(this).find(':selected');
    const departamento = selectedOption.data('departamento');
    const pais = selectedOption.data('pais');
    const region = selectedOption.data('region');

    departamentoInput.value = departamento || '';
    paisInput.value = pais || '';
    regionInput.value = region || '';
  });

  emailFacturacion = document.getElementById('solicitud_email_facturacion');
  emailFacturacionConfirm = document.getElementById('solicitud_email_facturacion_confirm');
  emailComunicacion = document.getElementById('solicitud_email_comunicacion');
  emailComunicacionConfirm = document.getElementById('solicitud_email_comunicacion_confirm');
  submitButton = document.getElementById('submitBtn');

  function validatePair (email, emailConfirm) {
    if (email.value !== emailConfirm.value) {
      emailConfirm.classList.add('input-error');
    } else {
      emailConfirm.classList.remove('input-error');
    }
  }

  function validateEmails () {
    validatePair(emailFacturacion, emailFacturacionConfirm);
    validatePair(emailComunicacion, emailComunicacionConfirm);

    const isEmailFacturacionValid = emailFacturacion.value === emailFacturacionConfirm.value && emailFacturacion.value !== '';
    const isEmailComunicacionValid = emailComunicacion.value === emailComunicacionConfirm.value ||
      (emailComunicacion.value === '' && emailComunicacionConfirm.value === '');
    const recaptchaValid = window.grecaptcha && grecaptcha.getResponse().length > 0;

    submitButton.disabled = !(isEmailFacturacionValid && isEmailComunicacionValid && recaptchaValid && socioVerificado);
  }

  emailFacturacion.addEventListener('input', validateEmails);
  emailFacturacionConfirm.addEventListener('input', validateEmails);
  emailComunicacion.addEventListener('input', validateEmails);
  emailComunicacionConfirm.addEventListener('input', validateEmails);

  document.getElementById('solicitud_foto').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        const base64String = event.target.result.split(',')[1];
        document.getElementById('solicitud_foto_base64').value = base64String;

        const previewImg = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        previewImg.src = event.target.result;
        previewContainer.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });

  function setStatus (iconEl, html) {
    iconEl.innerHTML = html;
  }

  function construirDataUrlImagen (valorImagen) {
    if (!valorImagen) {
      return '';
    }

    const valor = String(valorImagen).trim();
    if (!valor) {
      return '';
    }

    if (valor.startsWith('data:image')) {
      return valor;
    }

    if (valor.startsWith('http://') || valor.startsWith('https://') || valor.startsWith('/')) {
      return valor;
    }

    function esHexadecimal (texto) {
      return /^[0-9a-fA-F]+$/.test(texto) && texto.length % 2 === 0;
    }

    function hexABase64 (hex) {
      let binario = '';
      for (let i = 0; i < hex.length; i += 2) {
        binario += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
      }
      return btoa(binario);
    }

    const valorNormalizado = valor
      .replace(/^['"]+|['"]+$/g, '')
      .replace(/\\\//g, '/')
      .replace(/^0x/i, '')
      .trim();

    const base64OriginalOHex = esHexadecimal(valorNormalizado)
      ? hexABase64(valorNormalizado)
      : valorNormalizado;

    const base64Limpio = base64OriginalOHex
      .replace(/\s/g, '')
      .replace(/-/g, '+')
      .replace(/_/g, '/');

    const padding = base64Limpio.length % 4;
    const base64Normalizado = padding ? base64Limpio + '='.repeat(4 - padding) : base64Limpio;
    let mimeType = 'image/png';

    if (base64Normalizado.startsWith('/9j/')) {
      mimeType = 'image/jpeg';
    } else if (base64Normalizado.startsWith('iVBORw0KGgo')) {
      mimeType = 'image/png';
    }

    return `data:${mimeType};base64,${base64Normalizado}`;
  }

  function mostrarImagenActual (valorImagen) {
    const dataUrl = construirDataUrlImagen(valorImagen);

    if (!dataUrl) {
      currentImage.src = '';
      currentImageContainer.classList.add('d-none');
      currentImageContainer.style.display = 'none';
      return;
    }

    currentImage.src = dataUrl;
    currentImageContainer.classList.remove('d-none');
    currentImageContainer.style.display = 'block';
  }

  function habilitarCampos () {

    const nombre = document.getElementById('solicitud_nombre');
    const apellidos = document.getElementById('solicitud_apellidos');
    nombre.disabled = false;
    apellidos.disabled = false;
    nombre.readOnly = true;
    apellidos.readOnly = true;

    document.getElementById('solicitud_telefono').disabled = false;
    document.getElementById('solicitud_direccion').disabled = false;
    // document.getElementById('solicitud_ciudad').disabled = false;
    document.getElementById('solicitud_email_facturacion').disabled = false;
    document.getElementById('solicitud_email_facturacion_confirm').disabled = false;
    document.getElementById('solicitud_email_comunicacion').disabled = false;
    document.getElementById('solicitud_email_comunicacion_confirm').disabled = false;
    document.getElementById('solicitud_foto').disabled = false;
    document.getElementById('solicitud_observaciones').disabled = false;
    document.getElementById('solicitud_acepta_politicas').disabled = false;
    document.getElementById('solicitud_declara_titular').disabled = false;

    detalleForm.classList.remove('d-none');


  }

  function deshabilitarCampos () {
    const campos = [
      'solicitud_nombre',
      'solicitud_apellidos',
      'solicitud_telefono',
      'solicitud_direccion',
      // 'solicitud_ciudad',
      'solicitud_email_facturacion',
      'solicitud_email_facturacion_confirm',
      'solicitud_email_comunicacion',
      'solicitud_email_comunicacion_confirm',
      'solicitud_foto',
      'solicitud_observaciones'
    ];

    campos.forEach(function (id) {
      const el = document.getElementById(id);
      el.disabled = true;
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        el.value = '';
      }
    });

    document.getElementById('solicitud_acepta_politicas').disabled = true;
    document.getElementById('solicitud_acepta_politicas').checked = false;
    document.getElementById('solicitud_declara_titular').disabled = true;
    document.getElementById('solicitud_declara_titular').checked = false;
    document.getElementById('submitBtn').disabled = true;
    detalleForm.classList.add('d-none');
  }

  validarButton.addEventListener('click', function () {

    const carnet = document.getElementById('numero_carnet').value.trim();
    const documento = document.getElementById('numero_documento').value.trim();

    socioVerificado = false;
    mensajeVerificacion.innerHTML = '';
    mensajeVerificacion.classList.remove('d-none');
    setStatus(carnetStatus, '<i class="fas fa-circle" style="color: #ccc;"></i>');
    setStatus(documentoStatus, '<i class="fas fa-circle" style="color: #ccc;"></i>');
    deshabilitarCampos();

    if (carnet.length < 3 || documento.length < 3) {
      mensajeVerificacion.innerHTML = '<div class="alert alert-danger">Debe ingresar carnet y documento v&aacute;lidos.</div>';
      return;
    }

    validarButton.disabled = true;
    validarButton.textContent = 'Validando...';
    setStatus(carnetStatus, '<i class="fas fa-spinner fa-spin" style="color: #1e88e5;"></i>');
    setStatus(documentoStatus, '<i class="fas fa-spinner fa-spin" style="color: #1e88e5;"></i>');

    fetch('/page/index/verificar_carnet', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'carnet=' + encodeURIComponent(carnet) + '&documento=' + encodeURIComponent(documento)
    })
      .then(response => response.json())
      .then(response => {
        validarButton.disabled = false;
        validarButton.textContent = 'Validar';

        if (!response.success || !response.carnet_verificado) {
          setStatus(carnetStatus, '<i class="fas fa-times-circle" style="color: #dc3545;"></i>');
          setStatus(documentoStatus, '<i class="fas fa-times-circle" style="color: #dc3545;"></i>');
          mensajeVerificacion.innerHTML = '<div class="alert alert-danger mt-3">' +
            (response.message || 'No se encontr&oacute; el socio con el carnet ingresado') + '</div>';
          return;
        }

        if (response.carnet_verificado && !response.documento_verificado) {
          setStatus(carnetStatus, '<i class="fas fa-check-circle" style="color: #28a745;"></i>');
          setStatus(documentoStatus, '<i class="fas fa-times-circle" style="color: #dc3545;"></i>');
          mensajeVerificacion.innerHTML = '<div class="alert alert-danger mt-3">' +
            (response.message || 'El documento no coincide con el carnet ingresado') + '</div>';


          return;
        }

        if (response.success && response.documento_verificado) {
          setStatus(carnetStatus, '<i class="fas fa-check-circle" style="color: #28a745;"></i>');
          setStatus(documentoStatus, '<i class="fas fa-check-circle" style="color: #28a745;"></i>');

          socioVerificado = true;
          document.getElementById('btn-validar').disabled = true;
          document.getElementById('btn-validar').classList.add('d-none')
          const datos = response.socio || {};

          console.log(datos);


          document.getElementById('numero_carnet').value = datos.numero_carnet || carnet;
          document.getElementById('numero_documento').value = datos.SBE_CODI || documento;

          document.getElementById('solicitud_numero_accion').value = datos.numero_carnet || carnet;
          document.getElementById('solicitud_documento').value = datos.SBE_CODI || documento;

          document.getElementById('solicitud_nombre').value = datos.sbe_nomb || '';
          document.getElementById('solicitud_apellidos').value = datos.sbe_apel || '';
          document.getElementById('solicitud_telefono').value = datos.sbe_tele || '';
          document.getElementById('solicitud_direccion').value = datos.sbe_dire || '';
          document.getElementById('solicitud_email_facturacion').value = datos.sbe_mail || '';
          document.getElementById('solicitud_email_facturacion_confirm').value = datos.sbe_mail || '';
          document.getElementById('solicitud_email_comunicacion').value = datos.con_mail || '';
          document.getElementById('solicitud_email_comunicacion_confirm').value = datos.con_mail || '';
          // No establecer el value directamente: añadiremos la opción (si aplica)
          // y actualizaremos los campos ocultos de departamento/pais/región.
          mostrarImagenActual(datos.soc_foto || '');

          document.getElementById('solicitud_observaciones').disabled = false;
          habilitarCampos();

          if (datos.ciu_codi) {
            // Buscar la opción existente para obtener el texto correcto
            var opcionExistente = $('#solicitud_ciudad option[value="' + datos.ciu_codi + '"][data-departamento="' + (datos.dep_codi || '') + '"]');
            var textoOpcion = opcionExistente.length > 0 ? opcionExistente.text().trim() : (datos.ciu_nomb || '');

            var option = new Option(
              textoOpcion,
              datos.ciu_codi,
              true,
              true
            );

            $(option)
              .attr('data-pais', datos.pai_codi || '')
              .attr('data-departamento', datos.dep_codi || '')
              .attr('data-region', datos.reg_codi || '');

            // Añadir y disparar cambio para que select2 actualice la UI
            $('#solicitud_ciudad').append(option).trigger('change');

            // Asegurar que los inputs ocultos queden con los valores correctos
            if (typeof departamentoInput !== 'undefined' && departamentoInput) {
              departamentoInput.value = datos.dep_codi || '';
            }
            if (typeof paisInput !== 'undefined' && paisInput) {
              paisInput.value = datos.pai_codi || '';
            }
            if (typeof regionInput !== 'undefined' && regionInput) {
              regionInput.value = datos.reg_codi || '';
            }
          } else {
            // Si no hay ciudad, limpiar o preservar valores según convenga
            if (typeof departamentoInput !== 'undefined' && departamentoInput) {
              departamentoInput.value = departamentoInput.value || '';
            }
            if (typeof paisInput !== 'undefined' && paisInput) {
              paisInput.value = paisInput.value || '';
            }
            if (typeof regionInput !== 'undefined' && regionInput) {
              regionInput.value = regionInput.value || '';
            }
          }

          validateEmails();
        }
      })
      .catch(error => {
        console.log('Error:', error);
        validarButton.disabled = false;
        validarButton.textContent = 'Validar';
        setStatus(carnetStatus, '<i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>');
        setStatus(documentoStatus, '<i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>');
        mensajeVerificacion.innerHTML = '<div class="alert alert-danger mt-3">Error al verificar. Por favor intente nuevamente.</div>';
      });
  });

  document.getElementById('form-actualizacion-publica').addEventListener('submit', function (e) {
    if (!socioVerificado) {
      e.preventDefault();
      alert('Debe validar el número de carnet y documento antes de enviar.');
      return false;
    }

    const response = grecaptcha.getResponse();
    if (response.length === 0) {
      e.preventDefault();
      document.getElementById('recaptchaAlert').classList.remove('d-none');
      return false;
    }

    document.getElementById('solicitud_ciudad').disabled = false;

    document.getElementById('recaptchaAlert').classList.add('d-none');
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').textContent = 'Enviando...';
    document.getElementById('loader-overlay').style.display = 'flex';
  });

  window.enableSubmit = function () {
    const recaptchaAlert = document.getElementById('recaptchaAlert');
    if (recaptchaAlert) {
      recaptchaAlert.classList.add('d-none');
    }
    validateEmails();
  };

</script>