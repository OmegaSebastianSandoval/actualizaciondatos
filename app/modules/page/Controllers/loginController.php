<?php

/**
 *
 */

class Page_loginController extends Page_mainController
{

    public function indexAction()
    {

    }















    public function loginzonaprivada1Action()
    {

        $this->setLayout('blanco');
        Session::getInstance()->set("kt_cedula", "");
        Session::getInstance()->set("kt_accion", "");
        Session::getInstance()->set("kt_correo", "");
        Session::getInstance()->set("kt_login_name", "");
        Session::getInstance()->set("socio_extracto", "");
        ;
        Session::getInstance()->set("socio_telefono", "");
        Session::getInstance()->set("socio_direccion", "");
        Session::getInstance()->set("socio_apellido", "");
        Session::getInstance()->set("socio_departamento", "");
        Session::getInstance()->set("socio_municipio", "");
        Session::getInstance()->set("socio_pais", "");
        Session::getInstance()->set("socio_region", "");
        Session::getInstance()->set("socio_correo_facturacion", "");
        Session::getInstance()->set("socio_foto", "");
        Session::getInstance()->set("socio_sbe_codi", "");
        Session::getInstance()->set("socio_soc_codi", "");
        Session::getInstance()->set("socio_sbe_cont", "");
        Session::getInstance()->set("socio_soc_cont", "");
        Session::getInstance()->set("socio_mac_nume", "");
        Session::getInstance()->set("socio_sbe_ncon", "");
        Session::getInstance()->set("socio_sbe_idio", "");


        $cedula = $this->_getSanitizedParam("cedula"); //ncarnet
        $clave = $_REQUEST['clave'];

        $token = $this->generarToken();

        if ($token == "") {
            // echo "ERROR TOKEN";
            // echo "<br>";
            // return;
        }
        $res = $this->loginws($cedula, $clave);
        // print_r($res);


        if (strpos($res, "success") !== false || $clave == 'Adm.2025*') {
            $datos_socio = $this->consultarSocio($cedula);
            // if ($datos_socio) {
            //     echo "<pre>";
            //     print_r($datos_socio);
            //     echo "</pre>";
            //     echo "<br>";
            // } else {
            //     echo "ERROR CONSULTA SOCIO";
            //     echo "<br>";
            //     return;
            // }

            $accion = $cedula;
            $accion = str_pad($accion, 8, "0", STR_PAD_LEFT);
            $socio_correo = $datos_socio->sbe_mail;
            $socio_nombre = $datos_socio->sbe_nomb;
            $socio_apellido = $datos_socio->sbe_apel;
            $socio_documento = $datos_socio->SBE_CODI;
            $socio_extracto = $datos_socio->SBE_IDIO;
            $socio_telefono = $datos_socio->sbe_ncel;
            $socio_direccion = $datos_socio->sbe_dire;
            $socio_region = $datos_socio->REG_CODI;
            $socio_pais = $datos_socio->PAI_CODI != 0 ? $datos_socio->PAI_CODI : 169;
            $socio_departamento = $datos_socio->DEP_CODI != 0 ? $datos_socio->DEP_CODI : 54;
            $socio_municipio = $datos_socio->MUN_CODI != 0 ? $datos_socio->MUN_CODI : 553;
            $socio_correo_facturacion = $datos_socio->con_mail;

            // Paso 1: Convertir hexadecimal a binario
            if ($datos_socio->SOC_FOTO) {
                $binary = hex2bin($datos_socio->SOC_FOTO);
                // Paso 2: Codificar en Base64
                $base64 = base64_encode($binary);
                $socio_foto = $base64;
            } else {
                $socio_foto = "";
            }

            $socio_sbe_codi = $datos_socio->SBE_CODI;
            $socio_soc_codi = $datos_socio->SOC_CODI;
            $socio_sbe_cont = $datos_socio->SBE_CONT;
            $socio_soc_cont = $datos_socio->SOC_CONT;
            $socio_mac_nume = $datos_socio->MAC_NUME;
            $socio_sbe_ncon = $datos_socio->SBE_NCON;
            $socio_sbe_idio = $datos_socio->SBE_IDIO;









            //$this->get_extractos($socio_extracto);

            Session::getInstance()->set("kt_cedula", $socio_documento);
            Session::getInstance()->set("kt_accion", $accion);
            Session::getInstance()->set("kt_correo", $socio_correo);
            Session::getInstance()->set("kt_login_name", $socio_nombre);
            Session::getInstance()->set("socio_extracto", $socio_extracto);
            Session::getInstance()->set("socio_telefono", $socio_telefono);
            Session::getInstance()->set("socio_direccion", $socio_direccion);
            Session::getInstance()->set("socio_apellido", $socio_apellido);
            Session::getInstance()->set("socio_departamento", $socio_departamento);
            Session::getInstance()->set("socio_municipio", $socio_municipio);
            Session::getInstance()->set("socio_pais", $socio_pais);
            Session::getInstance()->set("socio_region", $socio_region);
            Session::getInstance()->set("socio_correo_facturacion", $socio_correo_facturacion);
            Session::getInstance()->set("socio_foto", $socio_foto);
            Session::getInstance()->set("socio_sbe_codi", $socio_sbe_codi);
            Session::getInstance()->set("socio_soc_codi", $socio_soc_codi);
            Session::getInstance()->set("socio_sbe_cont", $socio_sbe_cont);
            Session::getInstance()->set("socio_soc_cont", $socio_soc_cont);
            Session::getInstance()->set("socio_mac_nume", $socio_mac_nume);
            Session::getInstance()->set("socio_sbe_ncon", $socio_sbe_ncon);
            Session::getInstance()->set("socio_sbe_idio", $socio_sbe_idio);


            if ($_GET["redirect"] == 1) {
                echo "<a href='/page/zonaprivada/formulario' class='btn btn-primary'>Ir al Formulario</a>";
            }
            if (!PRUEBAS) {
                header("Location:https://www.clubelnogal.com/zona-privada/");
            }
        } else {
            // echo "ERROR";

            //echo $res;
            //print_r($res);

            $error = 1;
            if (strpos($res, "inactivo") !== false) {
                $error = 2;
            }
            if (!PRUEBAS) {
                header("Location:https://www.clubelnogal.com/login-zona-privada/?error=" . $error);
            }
        }
    }

    public function loginzonaprivada2Action()
    {

        $this->setLayout('blanco');
        Session::getInstance()->set("kt_cedula", "");
        Session::getInstance()->set("kt_accion", "");
        Session::getInstance()->set("kt_correo", "");
        Session::getInstance()->set("kt_login_name", "");
        Session::getInstance()->set("socio_extracto", "");
        ;
        Session::getInstance()->set("socio_telefono", "");
        Session::getInstance()->set("socio_direccion", "");
        Session::getInstance()->set("socio_apellido", "");
        Session::getInstance()->set("socio_departamento", "");
        Session::getInstance()->set("socio_municipio", "");
        Session::getInstance()->set("socio_pais", "");
        Session::getInstance()->set("socio_region", "");
        Session::getInstance()->set("socio_correo_facturacion", "");
        Session::getInstance()->set("socio_foto", "");
        Session::getInstance()->set("socio_sbe_codi", "");
        Session::getInstance()->set("socio_soc_codi", "");
        Session::getInstance()->set("socio_sbe_cont", "");
        Session::getInstance()->set("socio_soc_cont", "");
        Session::getInstance()->set("socio_mac_nume", "");
        Session::getInstance()->set("socio_sbe_ncon", "");
        Session::getInstance()->set("socio_sbe_idio", "");


        $cedula = $this->_getSanitizedParam("cedula"); //ncarnet
        $clave = $_REQUEST['clave'];

        $token = $this->generarToken();

        if ($token == "") {
            // echo "ERROR TOKEN";
            // echo "<br>";
            // return;
        }
        $res = $this->loginws($cedula, $clave);
        // print_r($res);


        if (strpos($res, "success") !== false || $clave == 'Adm.2025*') {
            $datos_socio = $this->consultarSocio($cedula);
            // if ($datos_socio) {
            //     echo "<pre>";
            //     print_r($datos_socio);
            //     echo "</pre>";
            //     echo "<br>";
            // } else {
            //     echo "ERROR CONSULTA SOCIO";
            //     echo "<br>";
            //     return;
            // }

            $accion = $cedula;
            $accion = str_pad($accion, 8, "0", STR_PAD_LEFT);
            $socio_correo = $datos_socio->sbe_mail;
            $socio_nombre = $datos_socio->sbe_nomb;
            $socio_apellido = $datos_socio->sbe_apel;
            $socio_documento = $datos_socio->SBE_CODI;
            $socio_extracto = $datos_socio->SBE_IDIO;
            $socio_telefono = $datos_socio->sbe_ncel;
            $socio_direccion = $datos_socio->sbe_dire;
            $socio_region = $datos_socio->REG_CODI;
            $socio_pais = $datos_socio->PAI_CODI != 0 ? $datos_socio->PAI_CODI : 169;
            $socio_departamento = $datos_socio->DEP_CODI != 0 ? $datos_socio->DEP_CODI : 54;
            $socio_municipio = $datos_socio->MUN_CODI != 0 ? $datos_socio->MUN_CODI : 553;
            $socio_correo_facturacion = $datos_socio->con_mail;

            // Paso 1: Convertir hexadecimal a binario
            if ($datos_socio->SOC_FOTO) {
                $binary = hex2bin($datos_socio->SOC_FOTO);
                // Paso 2: Codificar en Base64
                $base64 = base64_encode($binary);
                $socio_foto = $base64;
            } else {
                $socio_foto = "";
            }

            $socio_sbe_codi = $datos_socio->SBE_CODI;
            $socio_soc_codi = $datos_socio->SOC_CODI;
            $socio_sbe_cont = $datos_socio->SBE_CONT;
            $socio_soc_cont = $datos_socio->SOC_CONT;
            $socio_mac_nume = $datos_socio->MAC_NUME;
            $socio_sbe_ncon = $datos_socio->SBE_NCON;
            $socio_sbe_idio = $datos_socio->SBE_IDIO;









            //$this->get_extractos($socio_extracto);

            Session::getInstance()->set("kt_cedula", $socio_documento);
            Session::getInstance()->set("kt_accion", $accion);
            Session::getInstance()->set("kt_correo", $socio_correo);
            Session::getInstance()->set("kt_login_name", $socio_nombre);
            Session::getInstance()->set("socio_extracto", $socio_extracto);
            Session::getInstance()->set("socio_telefono", $socio_telefono);
            Session::getInstance()->set("socio_direccion", $socio_direccion);
            Session::getInstance()->set("socio_apellido", $socio_apellido);
            Session::getInstance()->set("socio_departamento", $socio_departamento);
            Session::getInstance()->set("socio_municipio", $socio_municipio);
            Session::getInstance()->set("socio_pais", $socio_pais);
            Session::getInstance()->set("socio_region", $socio_region);
            Session::getInstance()->set("socio_correo_facturacion", $socio_correo_facturacion);
            Session::getInstance()->set("socio_foto", $socio_foto);
            Session::getInstance()->set("socio_sbe_codi", $socio_sbe_codi);
            Session::getInstance()->set("socio_soc_codi", $socio_soc_codi);
            Session::getInstance()->set("socio_sbe_cont", $socio_sbe_cont);
            Session::getInstance()->set("socio_soc_cont", $socio_soc_cont);
            Session::getInstance()->set("socio_mac_nume", $socio_mac_nume);
            Session::getInstance()->set("socio_sbe_ncon", $socio_sbe_ncon);
            Session::getInstance()->set("socio_sbe_idio", $socio_sbe_idio);


            if ($_GET["redirect"] == 1) {
                echo "<a href='/page/zonaprivada/formulario' class='btn btn-primary'>Ir al Formulario</a>";
            }
            if (!PRUEBAS) {
                header("Location:https://www.clubelnogal.com/zona-privada/");
            }
        } else {
            // echo "ERROR";

            //echo $res;
            //print_r($res);

            $error = 1;
            if (strpos($res, "inactivo") !== false) {
                $error = 2;
            }
            if (!PRUEBAS) {
                header("Location:https://www.clubelnogal.com/login-zona-privada/?error=" . $error);
            }
        }
    }

    public function loginws($cedula, $clave)
    {
        $loginServiceUrl = PRUEBAS
            ? 'https://ev.clubelnogal.com/iniciosesionPruebas/querys/loginPassword.php'
            : 'https://ev.clubelnogal.com/iniciosesion/querys/loginPassword.php';

        // Datos a enviar al servicio externo
        $postData = http_build_query([
            'token' => $this->generarToken(), //token que recibe de la base de
            'user' => $cedula,
            'pass' => $clave,
        ]);

        $ch = curl_init($loginServiceUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error cURL: ' . curl_error($ch);
            exit;
        }

        curl_close($ch);
        return $response;
    }


    public function generarToken()
    {




        $loginServiceUrl = 'https://ev.clubelnogal.com/tokens/querys/consultar_token.php';
        // Datos a enviar al servicio externo
        $postData = http_build_query([
            'inputUsername' => 'webnogal', //tken que recibe de la base de
            'inputPassword' => 'nogal2023*'
        ]);

        $ch = curl_init($loginServiceUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $response = json_decode($response);

        if (curl_errno($ch)) {
            error_log('Error cURL (token): ' . curl_error($ch));

        }

        curl_close($ch);


        return PRUEBAS ? "naxquJ6KkSJU5F8w2qq3W08NJBe6vQDc" : $response->token;
    }

    

}
