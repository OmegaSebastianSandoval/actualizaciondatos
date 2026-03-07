<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top: 20px; padding-bottom: 20px;">
    <div style="width: 100%; max-width: 500px; margin: auto; padding: 20px; background-color: #B22222; border-radius: 10px; color: #f4f5f5;">
        <div style="text-align: center; padding: 20px; background-color: #DC143C; border-radius: 10px; margin:0">
            <h1 style="margin:0">Solicitud Rechazada</h1>
        </div>
        <p style="font-size: 17px;">
            <br>
            Estimado/a <?php echo $this->solicitud->solicitud_nombre_actual . " " . $this->solicitud->solicitud_apellidos_actual; ?>,
            <br><br>
            Lamentamos informarle que su solicitud de actualización de datos ha sido <strong>rechazada.</strong>
            <br><br>
            Número de solicitud: <strong>#<?php echo  $this->solicitud->solicitud_id; ?></strong>
            <br>
            Fecha de rechazo: <strong><?php echo  $this->solicitud->solicitud_fecha_aprobacion; ?></strong>
            <br><br>
            Si tiene alguna duda o desea obtener más información sobre el motivo del rechazo, por favor, comuníquese con nuestro equipo de soporte.
        </p>

    </div>
</div>