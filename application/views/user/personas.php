<div class="container-fluid">
    <div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() ."includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' >"; ?>
    </div>
    
    <h3>Usuarios</h3>
    <div class="col-xs-12 col-sm-11 col-md-11">    
        <!-- Código que inserta la tabla de Grocery CRUD -->
        <?php 
            foreach($css_files as $file): ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
             
            <?php endforeach; ?>
            <?php foreach($js_files as $file): ?>
             
                <script src="<?php echo $file; ?>"></script>
            <?php endforeach; ?>
        <?php echo $output; ?>
    </div>
    
    <br /><br /><br />
</div>