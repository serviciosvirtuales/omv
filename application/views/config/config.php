<div class="container-fluid"> 
    
    <h2>Correos Especialistas</h2><div align="right"><a href="<?php echo site_url('/menu');?>" class="btn btn-info">Menú Principal</a></div>
    <p> Los siguientes correos son los que reciben una alerta cuando se crea un evento nuevo en el sistema</p><hr>
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