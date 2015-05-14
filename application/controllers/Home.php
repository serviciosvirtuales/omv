<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    /**
    * Constructor para cargar headers, modelos y debug profiler.
    **/
    function __construct() {
        parent::__construct();
        $this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->library('session');
        
        $this->load->database();
        
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    /**
     * Pintar el home básico del sistema (login).
     */
    public function index() {
        
        $this->load->view('home');
        $this->load->view('layout/footer');
    }
}
