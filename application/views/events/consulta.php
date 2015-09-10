<div class="container-fluid">
    <div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' >"; ?>
    </div>

    <h3>Consulta:</h3>
    <div>
        <?php
        foreach ($evento->result() as $consulta)
        {
            echo $consulta->descripcion;
        }
        ?>
    </div>
    <br />
</div>