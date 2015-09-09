<!--
        AGREGAMOS FUNCION PARA ADJUNTOS
-->
<script>
    var numClicks = 0;
    $(document).on('ready', function () {
        $('#adjuntos').on('click', function (e) {
            numClicks++;
            //alert('clicks '+numClicks);
            if (numClicks == 1)
            {
                $('#adjunto2_field_box').css('display', 'block');
            }
            if (numClicks == 2)
            {
                $('#adjunto3_field_box').css('display', 'block');
            }
            if (numClicks == 3)
            {
                $('#adjunto4_field_box').css('display', 'block');
            }
            if (numClicks == 4)
            {
                $('#adjunto5_field_box').css('display', 'block');

                $('#adjuntos').css('display', 'none');
            }
        })
    });
</script>
<div class="container-fluid">
    <div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' >"; ?>
    </div>

    <h3>Eventos</h3>
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
    <!-- <input type='button' id='adjuntos' value='Agregar otro adjunto'></input> -->
    <br /><br /><br />
</div>
<?php
/*
<style>
    #adjunto2_field_box {
	display: none;
    }
    #adjunto3_field_box {
    	display: none;
    }
    #adjunto4_field_box {
	display: none;
    }
    #adjunto5_field_box {
	display: none;
    }
</style>
*/
?>