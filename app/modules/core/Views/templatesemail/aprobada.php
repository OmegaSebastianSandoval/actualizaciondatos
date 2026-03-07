<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top: 20px; padding-bottom: 20px;">
    <div style="width: 100%; max-width: 500px; margin: auto; padding: 20px; background-color: #2E8B57; border-radius: 10px; color: #f4f5f5;">
        <div style="text-align: center; padding: 20px; background-color: #3CB371; border-radius: 10px; margin:0">
            <h1 style="margin:0">Solicitud Aprobada</h1>
        </div>
        <p style="font-size: 17px;">
            <br>
            Estimado/a <?php echo $this->solicitud->solicitud_nombre . " " . $this->solicitud->solicitud_apellidos; ?>,
            <br><br>
            Nos complace informarle que su solicitud de actualización de datos ha sido <strong>aprobada</strong> con éxito.
            <br><br>
            Número de solicitud: <strong>#<?php echo $this->solicitud->solicitud_id; ?></strong>
            <br>
            Fecha de aprobación: <?php echo  $this->solicitud->solicitud_fecha_aprobacion; ?></strong>
            <br><br>
            Si tiene alguna pregunta o necesita asistencia adicional, no dude en contactarnos.
        </p>
      
    </div>
</div>
