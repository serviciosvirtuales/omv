<div class="container-fluid">
    <h2>Responder Consultas</h2><div align="right"><input type="button" class="btn btn-info"value="Volver atrás" name="volver atrás2" onclick="history.back()" /></div><hr>
    
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
