<ul>

  <?php if ($_SESSION['kt_login_level'] == "1") { ?>
    <!-- <li <?php if ($this->botonpanel == 1) { ?>class="activo" <?php } ?>><a href="/administracion/panel"><i
          class="fas fa-info-circle"></i> Información Página</a></li> -->
    <!-- <li <?php if ($this->botonpanel == 2) { ?>class="activo" <?php } ?>><a href="/administracion/publicidad"><i
          class="far fa-images"></i> Administrar Banner</a></li>
    <li <?php if ($this->botonpanel == 3) { ?>class="activo" <?php } ?>><a href="/administracion/contenido"><i
          class="fas fa-file-invoice"></i> Administrar Contenidos</a></li> -->

    <li <?php if ($this->botonpanel == 4) { ?>class="activo" <?php } ?>><a href="/administracion/usuario"><i
          class="fas fa-users"></i> Administrar Usuarios</a></li>

    <li <?php if ($this->botonpanel == 17) { ?>class="activo" <?php } ?>><a href="/administracion/solicitudes"><i
          class="fas  fa-file"></i> Solicitudes</a></li>

    <li <?php if ($this->botonpanel == 36) { ?>class="activo" <?php } ?>><a href="/administracion/reporte"><i
          class="fas fa-file-invoice"></i> Reporte</a></li>
  <?php } ?>
  <?php if ($_SESSION['kt_login_level'] == "10") { ?>
    <li <?php if ($this->botonpanel == 17) { ?>class="activo" <?php } ?>><a href="/administracion/solicitudes"><i
          class="fas  fa-file"></i> Solicitudes</a></li>
  <?php } ?>


  <?php if ($_SESSION['kt_login_level'] == "13") { ?>
    <li <?php if ($this->botonpanel == 17) { ?>class="activo" <?php } ?>><a href="/administracion/solicitudes"><i
          class="fas  fa-file"></i> Solicitudes</a></li>
    <li <?php if ($this->botonpanel == 4) { ?>class="activo" <?php } ?>><a href="/administracion/usuario"><i
          class="fas fa-users"></i> Administrar Usuarios</a></li>
    <li <?php if ($this->botonpanel == 36) { ?>class="activo" <?php } ?>><a href="/administracion/reporte"><i
          class="fas fa-file-invoice"></i> Reporte</a></li>
  <?php } ?>
  <?php if ($_SESSION['kt_login_level'] == "14") { ?>
    <li <?php if ($this->botonpanel == 17) { ?>class="activo" <?php } ?>><a href="/administracion/solicitudes/crear"><i
          class="fas  fa-file"></i> Solicitudes</a></li>
  <?php } ?>

  <?php if ($_SESSION['kt_login_level'] == "15") { ?>
    <li <?php if ($this->botonpanel == 17) { ?>class="activo" <?php } ?>><a href="/administracion/solicitudes"><i
          class="fas  fa-file"></i> Solicitudes</a></li>
    <li <?php if ($this->botonpanel == 36) { ?>class="activo" <?php } ?>><a href="/administracion/reporte"><i
          class="fas fa-file-invoice"></i> Reporte</a></li>


  <?php } ?>


</ul>