<div id="logoacr" >
        <img src="http://104.154.71.126/fsfbedu/img/logo_fsfb_bw.png" width="200"/>
    </div>
<nav class="navbar navbar-default">
    	<div class="container-fluid">
            <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapsed1">
                    <span class="sr-only">Ver navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('/');?>">Orientación Médica Virtual</a>
            </div>
            <div id="navbar-collapsed1" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if($page=='Inicio'){
                    echo '<li  class="active">';
                    }
                    else
                    {
                         echo '<li>';
                    }
                    ?>
                        <a href="<?php echo site_url('/');?>">Inicio</a>
                    </li>
                    <?php
                    if($page=='Eventos'||$page=='Historico de eventos'||$page=='Pacientes'){ //Daniel se quejo por 2 semanas
                    echo '<li class="dropdown active">';
                    }
                    else {
                        echo '<li class="dropdown">';
                    }
                    ?>                        
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Consultas <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        <?php
                            $group = array(1,3);
                            if ($this->ion_auth->in_group($group))
                            {
                                
                                echo '<li><a href="'.site_url("Events/view/add").'">Crear Evento</a></li>';
                                
                            }
                            
                            $group2 = array(1,2,3);
                            if ($this->ion_auth->in_group($group2))
                            {
                                echo '<li><a href="'.site_url("Historico/lista").'">Consultas Pasadas</a></li>';
                            }
                            $group3 = array(1,2);
                            if ($this->ion_auth->in_group($group3))
                            {
                                echo '<li><a href="'.site_url("Events/listado").'">Responder Consultas</a></li>';
                            }
                            if ($this->ion_auth->in_group($group))
                            {
                                echo '<li><a href="'.site_url("patients").'">Pacientes</a></li>';
                            }
                            /*
                            $group4 = 1;
                            if ($this->ion_auth->in_group($group4))
                            {  
                                echo '<li><a href="'.site_url("personas").'">Usuarios</a></li>';
                                echo '<li><a href="'.site_url("institucion").'">Instituciones</a></li>';
                            }
                             * 
                             */
                          ?>
                        </ul>
                    </li>                    
                    <?php
                    /*
                     * A continuacion el dropdown para administrar
                     */
                    
                    if($page=='Aseguradoras'||$page=='Personas'||$page=='Institucion Educativa'||$page=='Correos Especialistas'){ //Daniel se quejo por 2 semanas Correos Especialistas
                    echo '<li class="dropdown active">';
                    }else{
                        echo '<li class="dropdown">';
                    }
                            ?>
                        <?php
                        if ($this->ion_auth->is_admin())
                            {echo ' 
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrar <span class="caret"></span></a>
                            
                        <ul class="dropdown-menu" role="menu">';
                        
                            
                                echo'<li><a href="'. site_url('Aseguradora').'">Aseguradoras</a></li>';
                                echo '<li><a href="'.site_url("personas").'">Usuarios</a></li>';
                                echo '<li><a href="'.site_url("institucion").'">Instituciones</a></li>';
                                echo'<li><a href="'. site_url('ConfigEmail').'">Configurar Correos</a></li>';                                
                            }else
                            {
                                echo '<ul class="dropdown-menu" role="menu">';
                            }?>
                    
                          ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recursos <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        <?php
                        echo '<li><a href="'. site_url("assets/uploads/ManualOMV.pdf").'" target="_blank">Como Usar OMV</a></li>';    
                        ?>
                        </ul>
                    </li>                    
                </ul>
                <?php
                echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('home/logout').'">Salir</a></li></ul>';
                ?>
            </div>
    	</div>
    </nav>
<?php 
/*
 * a continuacion viene la parte del user
*/
?>
<div id="userfsfb">
	<?php

		$usr = $this->ion_auth->user()->row();		
		//$usr = $this->ion_auth->user();
		
		$cod = $usr->id;

		$this->db->select('c.first_name,c.last_name')
			->from('users c')
			->where('c.id',$cod);			
			$rol = $this->db->get();

		foreach($rol->result() as $role)			//local
		{ 
			echo "<h5>Bienvenido - ".$role->first_name." ".$role->last_name;
		}

	?>
</div>
<style>
#userfsfb{
	color: #003399;
	text-align: right;
	vertical-align: middle;
        margin: -15px 3px 3px 3px;
        padding: 5px 15px 5px 5px; 
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        font-size: small;

}
</style>
<div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' ></div>"; ?>
    </div>