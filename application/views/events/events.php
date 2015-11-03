<div class="container-fluid">
    <h2>Crear Evento</h2><div align="right"><a href="<?php echo site_url('/menu');?>" class="btn btn-info">Menú Principal</a></div>
    <a href="<?php echo site_url('Patients/view/add'); ?>" class="btn btn-sm btn-primary">Agregar Nuevo Paciente</a><hr>
    <div class="col-xs-12 col-sm-11 col-md-11">    
        <!-- Código que inserta la tabla de Grocery CRUD -->
        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

        <?php endforeach; ?>
        <?php foreach ($js_files as $file): ?>

            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <?php echo $output; ?>
    </div>
    <br />
</div>
