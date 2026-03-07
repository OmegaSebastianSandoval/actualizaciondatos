<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title><?= $this->_titlepage ?></title>
	<meta name="description" content="<?= $this->_data['metadescription']; ?>" />
	<meta name="keywords" content="<?= $this->_data['metakeywords']; ?>" />
	<!-- Jquery -->
	<script src="/components/jquery/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="/components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/skins/page/css/global.css?v=1.24">
	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="stylesheet" href="/components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
	<!-- SELECT 2 -->
	<link href="/components/select2/dist/css/select2.min.css" rel="stylesheet" />
	<script src="/components/select2/dist/js/select2.min.js"></script>


	<script type="text/javascript" id="www-widgetapi-script"
		src="https://s.ytimg.com/yts/jsbin/www-widgetapi-vflS50iB-/www-widgetapi.js" async=""></script>
	<?php if (1 == 0) { ?>
		<script src="https://www.youtube.com/player_api"></script>
	<?php } ?>
	<?= $this->_data['info_pagina_scripts']; ?>
	<meta name="viewport" content="width=device-width, user-scalable=no">
</head>

<body>
	<header>
		<?= $this->_data['header']; ?>
	</header>
	<div><?= $this->_content ?></div>
	<footer>
		<?= $this->_data['footer']; ?>
	</footer>

	<script src="/components/bootstrap/js/bootstrap.min.js"></script>

	<script src="/components/bootstrap-validator/dist/validator.min.js"></script>
	<script src="/skins/page/js/main.js?v=1.03"></script>

</body>

</html>