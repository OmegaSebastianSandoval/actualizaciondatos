<script src="/components/jquery/dist/jquery.min.js"></script>
<link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
<!-- SELECT 2 -->
<link href="/components/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="/components/select2/dist/js/select2.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>




<style>
    @import url('https://fonts.googleapis.com/css2?family=Orelega+One&display=swap');

    * {
        /* border: 1px solid red; */
    }

    header {
        display: none;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
        /* height: 100vh; */
        margin: 0;
        font-family: 'Orelega One';
        background-color: #fff;
    }
  body>div {
    width: 100%;
  }
    :root {
        --primary: #FF7E79;
    }

    .form {
        position: relative;
        display: flex;
        flex-direction: column;
        border-radius: 0.75rem;
        background-color: #fff;
        color: rgb(97 97 97);
        /*box-shadow: 20px 20px 30px rgba(0, 0, 0, .05);*/
        width: 100%;
        /* max-width: 600px; */
        background-clip: border-box;
    }

    .btn-rosa {
        background-color: #FF7E79;
        color: white;
        border: none;
        /* padding: 10px 20px; */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 5px;
        /* margin: 4px 2px; */
        cursor: pointer;
        border-top-right-radius: .375rem;
        border-bottom-right-radius: .375rem;
        cursor: pointer;


    }

    .header {
        position: relative;
        background-clip: border-box;
        background-color: #1e88e5;
        background-image: linear-gradient(to top right, #1e88e5, #42a5f5);
        margin: 10px;
        border-radius: 0.75rem;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 0 #0000, 0 0 #0000, 0 0 #0000, 0 0 #0000, rgba(33, 150, 243, .4);
        height: 7rem;
        letter-spacing: 0;
        line-height: 1.375;
        font-weight: 600;
        font-size: 1.9rem;
        font-family: Roboto, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .inputs {
        padding: 1.5rem;
        /* gap: 1rem; */
        display: flex;
        flex-direction: column;
    }

    label {
        margin: 0;
        color: #848484;
    }

    label.error {
        color: red;
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
        border: 1px solid rgba(128, 128, 128, 0.61);
        outline: 0;
        color: rgb(69 90 100);
        font-weight: 400;
        font-size: .9rem;
        line-height: 1.25rem;
        padding: 0.75rem;
        background-color: transparent;
        border-radius: .375rem;
        width: 100%;
        height: 100%;
        margin-bottom: 15px;
    }

    .select2-container {
        margin-bottom: 15px;

    }

    .input:focus {
        border: 1px solid var(--primary);
    }

    .input:read-only {
        background-color: #d2d2d2;
    }

    select.input {
        background-color: transparent !important;

    }

    .input-error {
        border-color: red;
        box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.25);
    }

    .checkbox-container {
        margin-left: -0.625rem;
        display: inline-flex;
        align-items: center;
    }

    .checkbox {
        position: relative;
        overflow: hidden;
        padding: .55rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        cursor: pointer;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.027);
        height: 35px;
        width: 35px;
    }

    .checkbox input {
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .checkbox-text {
        cursor: pointer;
    }

    .sigin-btn {
        text-transform: uppercase;
        font-weight: 700;
        font-size: .75rem;
        line-height: 1rem;
        text-align: center;
        padding: .75rem 1.5rem;
        background-color: var(--primary);
        border-radius: 0;
        width: 100%;
        outline: 0;
        border: 0;
        color: #fff;
        transition: all 0.3s ease;
    }

    .sigin-btn:hover {
        background-color: #61CE70;
    }

    .sigin-btn:disabled {
        background-color: #ccc;
        color: #000;
    }

    .signup-link {
        line-height: 1.5;
        font-weight: 300;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .signup-link a,
    .forget {
        line-height: 1.5;
        font-weight: 700;
        font-size: .875rem;
        margin-left: .25rem;
        color: #1e88e5;
    }

    .forget {
        text-align: right;
        font-weight: 600;
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

    .content-thumbnail img {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }

    .content-thumbnail {
        padding: .25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        max-width: 100%;
        height: auto;
    }

    .content-thumbnail span {
        display: block;
        text-align: center;
        font-size: 13px;
        margin-top: 10px;
        color: #6c757d;
    }

    .file-drop-disabled {
        display: grid;
    }

    @media (max-width: 768px) {
        body {
            padding: 5px;
        }

        .inputs {
            padding: 5px;
        }
    }
</style>

<!-- TODO : Traer ciudad -->



<div class="contenedor-formulario">



    <form class="form" method="POST" action="/page/zonaprivada/solicitud?debug=" enctype="multipart/form-data" id="form-update">


        <div class="inputs">

            <?php if ($this->error && $this->tipo) { ?>
                <div class="alert  text-center alert-<?= $this->tipo ?>" role="alert">
                    <?= $this->error ?>
                </div>
            <?php } ?>

            <input type="hidden" name="solicitud_fecha_ingreso" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" name="solicitud_fecha">
            <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
            <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">

            <input type="hidden" name="solicitud_numero_accion_actual" value="<?= Session::getInstance()->get("kt_accion") ?>">
            <input type="hidden" name="solicitud_nombre_actual" value="<?= Session::getInstance()->get("kt_login_name") ?>">
            <input type="hidden" name="solicitud_apellidos_actual" value="<?= Session::getInstance()->get("socio_apellido") ?>">
            <input type="hidden" name="solicitud_documento_actual" value="<?= Session::getInstance()->get("kt_cedula") ?>">
            <input type="hidden" name="solicitud_telefono_actual" value="<?= Session::getInstance()->get("socio_telefono") ?>">
            <input type="hidden" name="solicitud_direccion_actual" value="<?= Session::getInstance()->get("socio_direccion") ?>">

            <input type="hidden" name="solicitud_ciudad_actual" value="<?= Session::getInstance()->get("socio_municipio") ?>">
            <input type="hidden" name="solicitud_departamento_actual" value="<?= Session::getInstance()->get("socio_departamento") ?>">
            <input type="hidden" name="solicitud_pais_actual" value="<?= Session::getInstance()->get("socio_pais") ?>">
            <input type="hidden" name="solicitud_region_actual" value="<?= Session::getInstance()->get("socio_region") ?>">

            <input type="hidden" name="solicitud_email_facturacion_actual" value="<?= Session::getInstance()->get("socio_correo_facturacion") ?>">
            <input type="hidden" name="solicitud_email_comunicacion_actual" value="<?= Session::getInstance()->get("kt_correo") ?>">
            <input type="hidden" name="solicitud_foto_actual" value="<?= Session::getInstance()->get("socio_foto") ?>">
            <input type="hidden" name="solicitud_observaciones_actual" value="<?= Session::getInstance()->get("socio_observacion") ?>">


            <input type="hidden" name="solicitud_sbe_codi" value="<?= Session::getInstance()->get("socio_sbe_codi") ?>">
            <input type="hidden" name="solicitud_sbe_cont" value="<?= Session::getInstance()->get("socio_sbe_cont") ?>">
            <input type="hidden" name="solicitud_soc_codi" value="<?= Session::getInstance()->get("socio_soc_codi") ?>">
            <input type="hidden" name="solicitud_soc_cont" value="<?= Session::getInstance()->get("socio_soc_cont") ?>">
            <input type="hidden" name="solicitud_mac_nume" value="<?= Session::getInstance()->get("socio_mac_nume") ?>">
            <input type="hidden" name="solicitud_ncon" value="<?= Session::getInstance()->get("socio_sbe_ncon") ?>">
            <input type="hidden" name="solicitud_sbe_idio" value="<?= Session::getInstance()->get("socio_sbe_idio") ?>">


            <label for="solicitud_numero_accion">Número de accin</label>
            <input
                placeholder="Número de acción"
                class="input" type="text"
                name="solicitud_numero_accion"
                id="solicitud_numero_accion"
                value="<?= Session::getInstance()->get("kt_accion") ?>"
                required readonly>

            <label for="solicitud_nombre">Nombre</label>
            <input
                placeholder="Nombre"
                class="input" type="text"
                name="solicitud_nombre"
                id="solicitud_nombre"
                value="<?= Session::getInstance()->get("kt_login_name") ?>"
                minlength="3" maxlength="25"
                required>

            <label for="solicitud_apellidos">Apellidos</label>
            <input
                placeholder="Apellidos"
                class="input" type="text"
                name="solicitud_apellidos"
                id="solicitud_apellidos"
                minlength="3" maxlength="25"
                value="<?= Session::getInstance()->get("socio_apellido") ?>"
                required>

            <label for="solicitud_documento">Documento</label>
            <input
                placeholder="Documento"
                class="input"
                type="text"
                name="solicitud_documento"
                id="solicitud_documento"
                value="<?= Session::getInstance()->get("kt_cedula") ?>"
                required
                readonly>

            <label for="solicitud_telefono">Telefono</label>
            <input
                placeholder="Telefono"
                class="input"
                type="text"
                name="solicitud_telefono"
                id="solicitud_telefono"
                onkeypress="return soloNumeros(event)"
                maxlength="10"
                minlength="10"
                pattern="^\d+$"
                value="<?= Session::getInstance()->get("socio_telefono") ?>"
                required>

            <label for="solicitud_direccion">Dirección</label>
            <input
                placeholder="Direccion"
                class="input"
                type="text"
                name="solicitud_direccion"
                id="solicitud_direccion"
                minlength="3" maxlength="75"

                value="<?= Session::getInstance()->get("socio_direccion") ?>"
                required>


            <input type="hidden" name="solicitud_departamento" id="solicitud_departamento" value="<?= Session::getInstance()->get("socio_departamento") ?>">
            <input type="hidden" name="solicitud_pais" id="solicitud_pais" value="<?= Session::getInstance()->get("socio_pais") ?>">
            <input type="hidden" name="solicitud_region" id="solicitud_region" value="<?= Session::getInstance()->get("solicitud_region") ?>">



            <label for="solicitud_ciudad">Ciudad de residencia</label>
            <select class="input" name="solicitud_ciudad" id="solicitud_ciudad">
                <option value="" selected disabled>Seleccione una ciudad</option>
                <?php foreach ($this->ciudades as $ciudad) : ?>
                    <option
                        value="<?= $ciudad->mun_codi ?>" <?php if ($ciudad->mun_codi ==  Session::getInstance()->get("socio_municipio")) {
                                                                echo "selected";
                                                            } ?>
                        data-pais="<?= $ciudad->pai_codi ?>"
                        data-departamento="<?= $ciudad->dep_codi ?>"
                        data-region="<?= $ciudad->reg_codi ?>"><?= $ciudad->dep_nomb . ", " . $ciudad->mun_nomb ?></option>
                <?php endforeach ?>
            </select>

            <label for="solicitud_email_facturacion">Email facturación</label>
            <input
                placeholder="Email Facturacion"
                class="input"
                type="email"
                name="solicitud_email_facturacion"
                id="solicitud_email_facturacion"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45"


                value="<?= Session::getInstance()->get("socio_correo_facturacion") ?>"
                required>

            <label for="solicitud_email_comunicacion">Confirmar email facturación</label>
            <input
                placeholder="Confirmar Email Facturacion"
                class="input"
                type="email"
                name="solicitud_email_facturacion_confirm"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45"

                id="solicitud_email_facturacion_confirm" required>

            <label for="solicitud_email_comunicacion">Email para recibir comunicaciones</label>
            <input
                placeholder="Email para recibir comunicaciones"
                class="input"
                type="email"
                name="solicitud_email_comunicacion"
                id="solicitud_email_comunicacion"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45"

                value="<?= Session::getInstance()->get("kt_correo") ?>"

                required>

            <label for="solicitud_email_comunicacion_confirm">Confirmar email para recibir comunicaciones</label>
            <input
                placeholder="Confirmar Email para recibir comunicaciones"
                class="input"
                type="email"
                name="solicitud_email_comunicacion_confirm"
                id="solicitud_email_comunicacion_confirm"
                pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                minlength="7" maxlength="45"

                required>
            <div class="mb-2">

                <label for="solicitud_foto">Foto</label>
                <div class="alert-warning p-3 mt-1 mb-2">
          <strong>Nota:</strong> La foto debe ser en formato JPG o PNG y no debe superar los 4MB.
        </div>
                <input
                    placeholder="Foto"
                    class=" input  file-image"
                    data-buttonName="btn-rosa"
                    type="file"
                    name="solicitud_foto"
                    id="solicitud_foto"
                    accept="image/jpeg, image/png">
                <?php
                // Supongamos que $this->content->solicitud_foto contiene la cadena base64 sin el prefijo.
                $base64String = Session::getInstance()->get("socio_foto");

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
                <?php if (Session::getInstance()->get("socio_foto")) { ?>
                    <div class="content-thumbnail">
                        <img src="<?= $base64Image ?>" alt="Imagen actual" />
                        <span>Imagen Actual</span>
                    </div>
                <?php } ?>

            </div>

            <label for="solicitud_observaciones">Observaciones</label>
            <textarea
                placeholder=""
                class="input"
                name="solicitud_observaciones"
                id="solicitud_observaciones"></textarea>

            <div class="g-recaptcha" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr" data-callback="enableSubmit"></div>
            <div id="recaptchaAlert" class="alert alert-danger mt-2 d-none" role="alert">
                Por favor verifica que no eres un robot.
            </div>

            <div class="checkbox-container">
                <label class="checkbox">
                    <input type="checkbox" name="solicitud_acepta_politicas" id="checkbox" required>
                </label>
                <label for="checkbox" class="checkbox-text">Acepto política de tratamiento de datos personales</label>
            </div>
            <div class="checkbox-container">
                <label class="checkbox">
                    <input type="checkbox" name="solicitud_acepta_politicas" id="checkbox" required>
                </label>
                <label for="checkbox" class="checkbox-text">Declaro que soy el titular de la información suministrada</label>
            </div>
            <button class="sigin-btn" id="submitBtn">Enviar</button>
        </div>
    </form>
</div>
<script src="/components/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="/components/bootstrap-fileinput/js/locales/es.js"></script>
<script src="/components/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailFacturacion = document.getElementById('solicitud_email_facturacion');
        const emailFacturacionConfirm = document.getElementById('solicitud_email_facturacion_confirm');
        const emailComunicacion = document.getElementById('solicitud_email_comunicacion');
        const emailComunicacionConfirm = document.getElementById('solicitud_email_comunicacion_confirm');
        const submitButton = document.querySelector('.sigin-btn');

        function validateEmails() {
            validatePair(emailFacturacion, emailFacturacionConfirm);
            validatePair(emailComunicacion, emailComunicacionConfirm);

            // Habilita el botón solo si ambos pares de correos son válidos
            const isEmailFacturacionValid = emailFacturacion.value === emailFacturacionConfirm.value;
            const isEmailComunicacionValid = emailComunicacion.value === emailComunicacionConfirm.value;
            const recaptchaValid = grecaptcha && grecaptcha.getResponse().length > 0;

            submitButton.disabled = !(isEmailFacturacionValid && isEmailComunicacionValid && recaptchaValid);
        }

        function validatePair(email, emailConfirm) {
            if (email.value !== emailConfirm.value) {
                emailConfirm.classList.add('input-error');
            } else {
                emailConfirm.classList.remove('input-error');
            }
        }

        // Valida al cargar la página
        // validateEmails();

        // Añade validaciones en tiempo real
        emailFacturacion.addEventListener('input', validateEmails);
        emailFacturacionConfirm.addEventListener('input', validateEmails);
        emailComunicacion.addEventListener('input', validateEmails);
        emailComunicacionConfirm.addEventListener('input', validateEmails);

        // Validacin también cuando el recaptcha se activa
        window.enableSubmit = function() {
            const recaptchaAlert = document.getElementById('recaptchaAlert');
            recaptchaAlert.classList.add('d-none');
            validateEmails();
        };

    });

    document.addEventListener("DOMContentLoaded", function() {



        const formUpdate = document.getElementById('form-update');
        const submitBtn = document.getElementById('submitBtn');
        const recaptchaAlert = document.getElementById('recaptchaAlert');

        formUpdate.addEventListener('submit', function(event) {
            event.preventDefault();
            const response = grecaptcha.getResponse();
            // console.log(response);

            if (response.length === 0) {
                // alert('Por favor verifica que no eres un robot');  
                recaptchaAlert.classList.remove('d-none');
                recaptchaAlert.classList.add('show');
                submitBtn.disabled = true
                return;
            }
            recaptchaAlert.classList.add('d-none');
            const submitButton = document.querySelector('.sigin-btn');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Enviando...';
            formUpdate.submit();


        });
    })

    function enableSubmit() {
        const submitBtn = document.getElementById('submitBtn');
        const recaptchaAlert = document.getElementById('recaptchaAlert');
        recaptchaAlert.classList.add('d-none');

        submitBtn.disabled = false;
    }
    $(".file-image").fileinput({
        maxFileSize: 5048,
        previewFileType: "image",
        allowedFileExtensions: ["jpg", "png"],
        browseClass: "btn-rosa",
        showUpload: false,
        showRemove: false,
        browseIcon: "<i class=\"fas fa-image\"></i> ",
        browseLabel: "Imagen",
        language: "es",
        dropZoneEnabled: false
    });

    // In your Javascript (external .js resource or <script> tag)

    $('#solicitud_ciudad').select2();

    const selectCiudad = document.getElementById('solicitud_ciudad');
    const departamentoInput = document.getElementById('solicitud_departamento');
    const paisInput = document.getElementById('solicitud_pais');
    const regionInput = document.getElementById('solicitud_region');
    selectCiudad.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        console.log(selectedOption);
        selectDepartamento.value = selectedOption.getAttribute('data-departamento');
        selectPais.value = selectedOption.getAttribute('data-pais');
    });
    // Manejar el evento change
    $('#solicitud_ciudad').on('change', function() {
        // Obtener la opción seleccionada
        const selectedOption = $(this).find(':selected');

        // Obtener los atributos personalizados
        const departamento = selectedOption.data('departamento');
        const pais = selectedOption.data('pais');
        const region = selectedOption.data('region');

        // Mostrar los valores en consola o usarlos según tu necesidad
        // console.log('Departamento:', departamento);
        departamentoInput.value = departamento;
        // console.log('País:', pais);
        paisInput.value = pais;
        // console.log('Region:', region);
        regionInput.value = region;
    });
</script>
<script>
    function soloNumeros(event) {
        const charCode = event.keyCode ? event.keyCode : event.which;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>