<div class="container-fluid">
      
    <h2>Detalle eventos Paciente:</h2>
    <div class="col-xs-12 col-sm-11 col-md-11">    
       <?php
       echo '<table class="table table-striped table-bordered">';
       echo '<tr>';
       echo '<th style="text-align:center;">Descripción</th>';
       echo '<th style="text-align:center;">Fecha</th>';
       echo '<th style="text-align:center;">Respuesta</th>';
       echo '<th style="text-align:center;">Ver Más</th>';
       echo '</tr>';
        foreach ($historicos->result() as $value)
        {
            echo '<tr>';
            echo '<td>'.word_limiter($value->descripcion,5).'</td>';
            echo '<td style="text-align:center;">'.$value->fecha_evento.'</td>';
            echo '<td>'.word_limiter($value->respuesta,5).'</td>';
            echo '<td style="text-align:center;"><a href="#/'.$value->id_evento.'" target="_blank" class="btn btn-info">Ver Más</a></td>';
            echo '</tr>';
        }    
        echo '</table>';
        ?>
        
    </div>
    <br />
</div>