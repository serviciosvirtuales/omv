<div class="container-fluid">
    
    <h2>Consulta</h2>
    <div>
        <?php
        foreach ($evento->result() as $consulta)
        {
            echo '<strong>Paciente: </strong>'.$consulta->first_name.' '.$consulta->middle_name.' '.$consulta->last_name.'</br>';
            echo '<br><strong>Consulta:</strong> '.$consulta->descripcion.'<br>';
            
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
        
    </div>
    <br />
</div>