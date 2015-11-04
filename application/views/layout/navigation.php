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
                    <li  class="active">
                        <a href="<?php echo site_url('/');?>">Inicio</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Consultas <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="<?php echo site_url('Events/view/add');?>">Crear Evento</a></li>
                          <li><a href="<?php echo site_url('Historico/lista');?>">Ver Consultas Pasadas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Recursos</a>
                    </li>               
                </ul>
                        <?php if ($this->ion_auth->logged_in()) {
                            
                            echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('home/logout').'">Salir</a></li></ul>';
                            if ($this->ion_auth->is_admin())
                            {
                                echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('ConfigEmail').'">Configurar Correos</a></li></ul>';
                                echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('Aseguradora').'">Aseguradoras</a></li></ul>';
                                
                                
                            }
                                                        
                        } ?>
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
        background-color: rgba(220,220,220,0.2);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        font-size: small;

}
</style>
<div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' ></div>"; ?>
    </div>