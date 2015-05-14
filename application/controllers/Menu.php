<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    /**
    * Constructor para cargar headers, modelos y debug profiler.
    **/
    function __construct() {
       parent::__construct();
       //$this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               
       $this->load->helper('url');
       //$this->load->library('ion_auth');
       //$this->load->model('model');

       /*$this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
       $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
       $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
       $this->output->set_header('Pragma: no-cache');*/
       
       $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
       $this->output->set_header('Pragma: no-cache');
       $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    /**
     *  Función que pinta el menú principal de la aplicación (una vez ingreso de usuario).
     */
    public function index() {
        $data['page'] = 'Inicio';
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('menu/menu_view', $data);
        $this->load->view('layout/footer', $data);
    }
}
