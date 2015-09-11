<div class="container-fluid">
    <div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' >"; ?>
    </div>

    <h3>Histórico:</h3>
    <div>
        <table class="table table-striped table-bordered table-condensed">
            <tr>
                <th>Descripcion Evento</th>
                <th>Respuesta</th>
                <th style="text-align: center;">Ver Más...</th>
        </tr>
        <?php        
        foreach ($historia->result() as $h)
        {
            echo '<tr><td>'.$h->descripcion.'</td><td>'.$h->respuesta.'</td><td style="text-align: center;"><button class="btn btn-info" data-toggle="modal" data-target="#myModal'.$h->id_evento.'">ver más</button></td></tr>';
                
        
            echo '
            <div>	

            <!-- Modal -->

		<div class="modal fade" id="myModal'.$h->id_evento.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <!-- esta linea pone grande el modal <div class="modal-dialog modal-lg">  -->
                  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Detalle Consulta</h4>
		      </div>
		      <div class="modal-body">';    
                      
                        echo '<h4>Pregunta:</h4>'.$h->descripcion.'<br>';                        
                        if($h->eadj1)
                        {
                            echo '<h4>Adjunto Consulta: </h4>'.anchor('/assets/uploads/files/evento/'.$h->eadj1,'Descarga');
                        }
                        if($h->eadj2)
                        {
                            echo '<h4>Adjunto Consulta: </h4>'.anchor('/assets/uploads/files/evento/'.$h->eadj1,'Descarga');
                        }
                        if($h->eadj3)
                        {
                            echo '<h4>Adjunto Consulta: </h4>'.anchor('/assets/uploads/files/evento/'.$h->eadj1,'Descarga');
                        }
                        if($h->eadj4)
                        {
                            echo '<h4>Adjunto Consulta: </h4>'.anchor('/assets/uploads/files/evento/'.$h->eadj1,'Descarga');
                        }
                        if($h->eadj5)
                        {
                            echo '<h4>Adjunto Consulta: </h4>'.anchor('/assets/uploads/files/evento/'.$h->eadj1,'Descarga');
                        }
                        echo ' <h4>Clasificación CIE10: </h4>'.$h->cie10.'<br>
                            
                        <h4>Respuesta: </h4>'.$h->respuesta.'<br>';
                        if($h->radj1)
                        {
                            echo '<h4>Adjunto Respuesta: </h4>'.anchor('/assets/uploads/files/respuesta/'.$h->radj1,'Descarga');
                        }
                        if($h->radj2)
                        {
                            echo '<h4>Adjunto Respuesta: </h4>'.anchor('/assets/uploads/files/respuesta/'.$h->radj2,'Descarga');
                        }
                        if($h->radj3)
                        {
                            echo '<h4>Adjunto Respuesta: </h4>'.anchor('/assets/uploads/files/respuesta/'.$h->radj3,'Descarga');
                        }
                        if($h->radj4)
                        {                       
                            echo '<h4>Adjunto Respuesta: </h4>'.anchor('/assets/uploads/files/respuesta/'.$h->radj4,'Descarga');
                        }
                        if($h->radj5)
                        {
                            echo '<h4>Adjunto Respuesta: </h4>'.anchor('/assets/uploads/files/respuesta/'.$h->radj5,'Descarga');
                        }                              
                       
                       
                        echo ' 
                        <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>	        
		      </div>
		    </div>
		  </div>
		</div>		
            </div>';
        }
    ?>
    <br />
</div>
    
    
        </table>
    </div>
<style>
    .modal-body{
        margin: 20px;
    }
</style>
