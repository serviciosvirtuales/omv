<div class="container-fluid"> 
    
    <h3>Gestion Aseguradoras</h3>
    <p> Aqui agregamos las aseguradoras para luego asociarlas a una institucion educativa
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