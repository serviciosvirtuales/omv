<div class="container-fluid">
      
    <h3>Histórico:</h3>
    <?php if($this->session->flashdata('message')){echo "<div class='alert alert-danger' role='alert'>".$this->session->flashdata('message')."</div>";}?>  
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
