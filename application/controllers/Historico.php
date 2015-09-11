<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Historico extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               

        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            //echo 'Bienvenido a la consulta historica de OMV';
            $data['page'] = 'Histórico';
            $data['historia'] = $this->momv->consulta_historica();
            
            if($data['historia'] != NULL)
            {
                $this->load->view('layout/header',$data);
                $this->load->view('layout/navigation');
                $this->load->view('events/historico', $data);
                $this->load->view('layout/footer');
            }
            else
            {
                echo 'No hay datos';
            }
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }
}