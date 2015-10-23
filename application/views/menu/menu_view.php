<?php echo "<h2 style='color:#990000;'>".$this->session->flashdata('message')."</h2>";?>  
<div class="container-fluid">
    
  
    <div class="row">
        
        <div class="col-xs-12 col-sm-6 col-md-6">
            
            <?php
            // 1 admin 2 medico 3 colegio 4 generalUser
            $group = array(1,3);
            if ($this->ion_auth->in_group($group))
            {
               ?> 
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="<?php echo site_url('Events');?>">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_evento.png" style="width: 60px; height: 60px" />
                        <h5>Crear Evento</h5>
                        
                    </div>
                </a>
            </div>
            <?php
            }
            // 1 admin 2 medico 3 colegio 4 generalUser
            $group2 = array(1,2,3);
            if ($this->ion_auth->in_group($group2))
            {                
               ?> 
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="historico">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_historico.png" style="width: 60px; height: 60px" />
                        <h5>Ver Consultas Pasadas</h5>
                    </div>
                </a>
            </div>
            <?php
            }
            // 1 admin 2 medico 3 colegio 4 generalUser
            $group3 = array(1,2);
            if ($this->ion_auth->in_group($group3))
            {                
               ?> 
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="events/listado">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_responder.png" style="width: 60px; height: 60px" />
                        <h5>Responder Consultas</h5>
                    </div>
                </a>
            </div>
            <?php
            }
            // 1 admin 2 medico 3 colegio 4 generalUser
            //$group = array(1,3);
            if ($this->ion_auth->in_group($group))
            {                
               ?>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="<?php echo site_url('patients') ?>">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_pacientes.png" style="width: 60px; height: 60px" />
                        <h5>Ver Pacientes</h5>
                    </div>
                </a>
            </div>
            <?php
            }
            // 1 admin 2 medico 3 colegio 4 generalUser
            $group4 = 1;
            if ($this->ion_auth->in_group($group4))
            {                
               ?> 
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="<?php echo site_url('personas') ?>">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_usuarios.png" style="width: 60px; height: 60px" />
                        <h5>Administrar Usuarios</h5>
                    </div>
                </a>
            </div>
            <?php
            }
            // 1 admin 2 medico 3 colegio 4 generalUser
            //$group4 = 1;
            if ($this->ion_auth->in_group($group4))
            {                
               ?>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <a href="<?php echo site_url('institucion') ?>">
                    <div class="mini-container">
                        <img src="<?php echo base_url() ?>includes/img/logo_colegios.png" style="width: 60px; height: 60px" />
                        <h5>Administrar Instituciones</h5>
                    </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="mini-container">
                <h5>El Servicio de Orientación Médica Virtual
                    <br />Fundación Santa Fe de Bogotá</h5>
                <div class="text-left">
                    <br />
                    <p>El Servicio de Orientación Médica Virtual permite a las instituciones
                        educativas solicitar orientación y asistencia ante casos dudosos o difíciles.
                        Se encuentra enmarcado dentro de la póliza Clase Feliz y cubre a cualquier
                        persona al interior de la institución durante los horarios establecidos.
                        <br />Se debe recordar que por medio de este servicio no se realiza diagnóstico ni tratamiento
                        y aquellos casos que se consideren de urgencia no pueden ser atendidos por este medio.
                        En su lugar se debe consultar a la Red #322. <br /><br />
                        Más información en el correo: <a href="mailto:telemedicina@fsfb.edu.co">telemedicina@fsfb.edu.co</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

