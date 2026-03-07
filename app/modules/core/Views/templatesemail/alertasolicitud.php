<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top: 20px; padding-bottom: 20px;">
    <div style="width: 100%; max-width: 500px; margin: auto; padding: 20px; background-color: slategray; border-radius: 10px; color: #f4f5f5;">
        <div style="text-align: center; padding: 20px; background-color: darkgray; border-radius: 10px; margin:0">
            <h1 style="margin:0">Nueva Solicitud Recibida</h1>
        </div>
        <p style="font-size: 17px;">
        <br>

            Estimado/a administrador/a,
            <br><br>
            Se ha recibido una nueva solicitud de actualización de datos con los siguientes detalles:
            <br><br>
            Nombre del socio: <strong><?php echo $this->solicitud->solicitud_nombre_actual; ?> <?php echo $this->solicitud->solicitud_apellidos_actual; ?></strong>
            <br>
            Número de solicitud: <strong>#<?php echo $this->solicitud->solicitud_id; ?></strong>
            <br>
            Fecha de recepción: <strong><?php echo date('d-m-Y H:i:s'); ?></strong>
            <br><br>
            Por favor, acceda al panel de administración para revisar y procesar la solicitud.
        </p>
        <div style="">
            <a href="<?php echo $this->url_panel; ?>" style="display:block;margin:0 auto; text-align: center; padding: 20px; background-color: #FF7E79; border-radius: 10px; margin-top: 20px; color: #f4f5f5; text-decoration: none; font-weight: bold;font-size: 17px;">Ir al Panel de Administración</a>
        </div>
    </div>
</div>
