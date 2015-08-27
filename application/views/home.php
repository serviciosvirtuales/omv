<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orientación Médica Virtual FSFB</title>
        <link href="<?php echo base_url() ?>/includes/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/includes/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/includes/css/basic.css" rel="stylesheet">
    </head>
    <body>
        <script src="<?php echo base_url() ?>/includes/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>/includes/js/bootstrap.min.js"></script>
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapsed1">
                            <span class="sr-only">Ver navegación</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Orientación Médica Virtual</a>
                    </div>
                    <div id="navbar-collapsed1" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            /*
                            <li  class="active">
                                <a href="#">Inicio</a>
                            </li>                             
                            */
                            ?>
                        </ul>
                        <?php if ($this->ion_auth->logged_in()) {echo'<ul class="nav navbar-nav navbar-right"><li><a href="'. site_url('home/logout').'">Salir</a></li></ul>';} ?>
                    </div>
                </div>
            </nav>
            
            <div class="row">
                <div class="jumbotron" style="background-image:url(<?php echo base_url() ?>includes/img/banner1.png); no-repeat fixed; background-size:cover; background-position: right 0px top -60px;">
                    <h1 style="color: white; font-size: xx-large; text-shadow: black 0.05em 0.05em 0.05em;">Orientación Médica Virtual
                    <br />
                    <small style="color: white;">Fundación Santa Fe de Bogotá</small></h1>
                    <div class="row" style="background-color: rgba(255,255,255,0.5); padding: 10px; border-radius: 5px;">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                        <p style="color: black; font-size: medium; text-shadow: black 0.01em 0.01em 0.01em;">El Servicio de Orientación Médica Virtual permite a las instituciones
                    educativas solicitar orientación y asistencia ante casos dudosos o difíciles.</p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6" >
			    <?php 
                            if (!$this->ion_auth->logged_in()){ //validamos que esl usuario este logeado
			    
                                echo form_open("home/login");
			    /*
				if ($message) {
				  echo "<div id='infoMessage' class='alert alert-danger alert-dismissible' role='alert'>";
				  echo "<button type='button' class='close' data-dismiss='alert'>";
				  echo "<span aria-hidden='true'>&times;</span>";
				  echo "<span class='sr-only'>Close</span>";
				  echo "</button>";
				  echo $message;
				  echo "</div>";
				}*/
				?>
				<input type="text" id="identity" name="identity" class="form-control" placeholder="Correo electrónico" required autofocus><br />
				<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required><br />
				
				<div class="text-right"><button type="submit" class="btn btn-lg btn-primary">Ingresar</button></div>
			    <?php echo form_close();
                            }
                            else 
                            {   
                                $usr = $this->ion_auth->user()->row();	// capturamos los datos del user			 
                                echo'Bienvenido '.$usr->first_name; // mostramos el nombre
                                
                                /*
                                $this->load->view('menu/menu_view');
                                
                                 * $this->load->view('layout/footer');
                                
                                */
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
echo "<h2>".$this->session->flashdata('message')."</h2>";
?>