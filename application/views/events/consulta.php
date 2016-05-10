<div class="container-fluid">
    
    <h2>Consulta</h2>
    <div>
        <?php
        foreach ($evento->result() as $consulta)
        {
            echo '<strong>Paciente: </strong>'.$consulta->first_name.' '.$consulta->middle_name.' '.$consulta->last_name.'</br>';
            echo '<strong>Fecha Nacimiento: </strong>'.$consulta->birth_date.'</br>';
            /*
             * calculo edad Inicio
             */
            $date2 = date('Y-m-d');//
            $diff = abs(strtotime($date2) - strtotime($consulta->birth_date));
            $years = floor($diff / (365*60*60*24));
            //$months = floor(($diff - $years * (365*60*60*24)) / (30*60*60*24));
            //$days = floor(($diff - $years * (365*60*60*24) - $months*(30*60*60*24))/ (60*60*24));
            /*
             * calculo edad FIn
             */
            echo '<strong>Edad: </strong>'.$years.' Años</br>';
            //echo '<strong>Edad: </strong>'.$years.' Años, '.$months.' Meses, '.$days.' Días</br>';
            echo '<strong>Género:</strong> '.$consulta->gender.'</br>';
            echo '<strong>Consulta:</strong> '.$consulta->descripcion.'</br>';
            echo '<strong>Quién Pregunta:</strong> '.$consulta->registrado_por.'</br>';
            
            if($consulta->adjunto1){
            echo '<a href="'.site_url('assets/uploads/files/evento').'/'.$consulta->adjunto1.'" target ="_blank">adjunto 1</a> ';
            }
            if($consulta->adjunto2){
            echo '<a href="'.site_url('assets/uploads/files/evento').'/'.$consulta->adjunto2.'" target ="_blank">adjunto 2</a> ';
            }
            if($consulta->adjunto3){
            echo '<a href="'.site_url('assets/uploads/files/evento').'/'.$consulta->adjunto3.'" target ="_blank">adjunto 3</a> ';
            }
            if($consulta->adjunto4){
            echo '<a href="'.site_url('assets/uploads/files/evento').'/'.$consulta->adjunto4.'" target ="_blank">adjunto 4</a> ';
            }
            if($consulta->adjunto5){
            echo '<a href="'.site_url('assets/uploads/files/evento').'/'.$consulta->adjunto5.'" target ="_blank">adjunto 5</a> ';
            }
        }
        ?>
        
    </div><br><br>    
    <div class="col-xs-12 col-sm-11 col-md-11"><a href="https://appear.in/omvfsfb/<?php echo $this->uri->segment(3);?>" target="_blank" class="btn btn-danger btn-large" onclick="vc()">Iniciar video-conferencia</a><br><br>
    </div>
</div>
<script type= 'text/javascript'>

  
    function vc(){
        <?php
        //log_message('ERROR', 'aqui se supone que envio el correo de la VC');
        //$link = 'https://appear.in/omvfsfb/'.$this->uri->segment(3);
        $id = $this->uri->segment(3);        
        //log_message('ERROR', 'link ->'.$link.' id ->'.$id);  
        ?>
    $.ajax({        
        url:'<?php echo site_url('Events/sendmail_vc/'.$id);?>',
        complete: function (response) {
          $('#output').html(response.true);
      }
    }); 
    }

</script>