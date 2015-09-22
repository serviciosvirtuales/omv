<div class="container-fluid">
    
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