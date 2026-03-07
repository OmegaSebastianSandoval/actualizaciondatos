<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?= $this->_titlepage ?>
    </title>
    <!-- Jquery -->
    <script src="/components/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWYVxdF4VwIPfmB65X2kMt342GbUXApwQ&sensor=true">
    </script>
    <link rel="stylesheet" href="/components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
    <link rel="stylesheet" href="/components/Font-Awesome/css/all.min.css">
    <link href="/components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="/components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link rel="stylesheet" href="/skins/administracion/css/global.css">
    
</head>

<body>
    <header>
        <?= $this->_data['panel_header']; ?>
    </header>
    <div class="container-fluid panel p-0">
        <div class="d-flex justify-content-start">
            <nav id="panel-botones">
                <?= $this->_data['panel_botones']; ?>
            </nav>
            <article id="contenido_panel" class="w-100
      ">
                <section id="contenido_general">
                    <div class="panel-titulo"><b>Dashboard</b> Versión 6.0</div>
                    <?= $this->_content ?>
                </section>
            </article>
        </div>
    </div>
    <footer class="panel-derechos col-md-12">&copy;Todos los Derechos Reservados <?php echo date('Y'); ?> - Diseñado por
        Omega Soluciones Web
    </footer>

    <script src="/components/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="/components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="/components/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/components/bootstrap-fileinput/js/locales/es.js"></script>
    <script src="/components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
    <script src="/skins/administracion/js/main.js?v=1.01"></script>
    <!-- Charts -->
    <script src="/components/chart/chart.min.js"></script>
    <script src="/components/chart/chartjs-plugin-datalabels@2.js"></script>

</body>

</html>