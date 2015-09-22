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
                          <li><a href="#">Crear Evento</a></li>
                          <li><a href="#">Ver Consultas Pasadas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Recursos</a>
                    </li>               
                </ul>
                        <?php if ($this->ion_auth->logged_in()) {echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('home/logout').'">Salir</a></li></ul>';} ?>
            </div>
    	</div>
    </nav>
<div class="row">
        <?php echo "<div class='jumbotron' style='background-image:url(" . base_url() . "includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -120px; min-height: 180px;' ></div>"; ?>
    </div>