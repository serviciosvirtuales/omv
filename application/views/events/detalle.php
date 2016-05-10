<div class="container-fluid">
      
    <h2>Detalle eventos Paciente</h2><div align="right"><a href="<?php echo site_url('/historico/lista');?>" class="btn btn-info">Volver Atrás</a></div><hr>
    <div class="col-xs-12 col-sm-11 col-md-11">    
       <?php
       echo '<table class="table table-striped table-bordered">';
       echo '<tr>';
       echo '<th style="text-align:center;">Descripción</th>';
       echo '<th style="text-align:center;">Fecha</th>';
       echo '<th style="text-align:center;">Respuesta</th>';
       echo '<th style="text-align:center;">Clasificación</th>';
       echo '<th style="text-align:center;">Ver Más</th>';
       echo '</tr>';
        foreach ($historicos->result() as $value)
        {
            echo '<tr>';
            echo '<td>'.word_limiter($value->descripcion,5).'</td>';
            echo '<td style="text-align:center;">'.$value->fecha_evento.'</td>';
            echo '<td>'.word_limiter($value->respuesta,5).'</td>';
            echo '<td>'.$value->clasificacion.'</td>';
            //echo '<td style="text-align:center;"><a href="#/'.$value->id_evento.'" target="_blank" class="btn btn-info">Ver Más</a></td>';
            
            //se comenta la siguiente linea y el uso de modal 
            echo '<td align="center"><button class="btn btn-info" data-toggle="modal" data-target="#myModal'.$value->id_evento.'">ver más</button></td>';
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

                           <strong>Paciente: </strong>'.$value->first_name.' '.$value->middle_name.' '.$value->last_name.'</br>';
                               
                        echo '<strong>Fecha Nacimiento: </strong>'.$value->birth_date.'</br>';
                        /*
                         * calculo edad Inicio
                         */
                        $date2 = date('Y-m-d');//
                        $diff = abs(strtotime($date2) - strtotime($value->birth_date));
                        $years = floor($diff / (365*60*60*24));
                        //$months = floor(($diff - $years * (365*60*60*24)) / (30*60*60*24));
                        //$days = floor(($diff - $years * (365*60*60*24) - $months*(30*60*60*24))/ (60*60*24));
                        /*
                         * calculo edad FIn
                         */
                        echo '<strong>Edad: </strong>'.$years.' Años</br>';
                        //echo '<strong>Edad: </strong>'.$years.' Años, '.$months.' Meses, '.$days.' Días</br>';
                        echo '<strong>Género:</strong> '.$value->gender.'</br></br>';
            
                        echo '    <label>Pregunta: </label>
                            <p>'.$value->descripcion.'</p>';
                                
                            if($value->eadj1 || $value->eadj2 || $value->eadj3 || $value->eadj4 || $value->eadj5)
                            {
                                echo ' 
                                <label>Adjuntos: </label>
                                <p><ul>';if($value->eadj1)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/evento/'.$value->eadj1.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->eadj2)
                                    {
                                    echo '<li><a href="'.base_url().'/assets/uploads/files/evento/'.$value->eadj2.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->eadj3)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/evento/'.$value->eadj3.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->eadj4)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/evento/'.$value->eadj4.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->eadj5)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/evento/'.$value->eadj5.'" target="_blank">Descarga</a></li>';
                                    }
                                echo '</ul></p>';
                            }//if de adjuntos
                            if ($this->ion_auth->is_admin())
                            {
                                echo ' 
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
                            }
                            
                        echo '
                            <label>Respuesta: </label>
                            <p>'.$value->respuesta.'</p>';
                                
                        if($value->radj1 || $value->radj2 || $value->radj3 || $value->radj4 || $value->radj5)
                            {
                                echo ' 
                                <label>Adjuntos Respuesta: </label>
                                <p><ul>';if($value->radj1)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/respuesta/'.$value->radj1.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->radj2)
                                    {
                                    echo '<li><a href="'.base_url().'/assets/uploads/files/respuesta/'.$value->radj2.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->radj3)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/respuesta/'.$value->radj3.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->radj4)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/respuesta/'.$value->radj4.'" target="_blank">Descarga</a></li>';
                                    }
                                    if($value->radj5)
                                    {
                                        echo '<li><a href="'.base_url().'/assets/uploads/files/respuesta/'.$value->radj5.'" target="_blank">Descarga</a></li>';
                                    }
                                echo '</ul></p>';
                            }//if de adjuntos

                        echo ' <div class="modal-footer">
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
    
</div>