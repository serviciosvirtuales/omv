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
            //echo '<td style="text-align:center;"><a href="#/'.$value->id_evento.'" target="_blank" class="btn btn-info">Ver Más</a></td>';
            
            //se comenta la siguiente linea y el uso de modal 
            echo '<td><button class="btn btn-info" data-toggle="modal" data-target="#myModal'.$value->id_evento.'">ver más</button></td>';
            echo '</tr>';
            // seccion para el modal
            echo '
                <div>	
                    <!-- Modal -->

                    <div class="modal fade" id="myModal'.$value->id_evento.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <!-- esta linea pone grande el modal <div class="modal-dialog modal-lg">  -->
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Detalle Consulta</h4>
                          </div>
                          <div class="modal-body">        


                            <label>Pregunta: </label>
                            <p>'.$value->descripcion.'</p>

                            <label>Clasificación: CIE10</label>';
                            /*
                            //$data = str_replace(',','","',$value->cie10);
                            //log_message('ERROR', 'reemplazando ACR '.$data);
                            $query=$this->db->select("cie10_descripcion")->from('cie10')->where_in('cie10_cie2',$value->cie10)->get();
                            
                            foreach ($query->result() as $cie10)
                            {
                                echo '<p>'.$cie10->cie10_descripcion.'</p>';
                            }
                            */
                             echo '<p>'.$value->cie10.'</p>';
                            
                        echo '
                            <label>Respuesta: </label>
                            <p>'.$value->respuesta.'</p>


                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>	        


                          </div>
                        </div>
                      </div>
                    </div>		
                </div>';
            // seccion para el modal
        }    
        echo '</table>';
        ?>
        
    </div>
    <br />
</div>