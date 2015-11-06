<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Historico extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               

        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
    }
    
    public function index()
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            redirect('Historico/lista');
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }

    public function lista()
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            $data['page'] = 'Historico de eventos';

            // Inicialización CRUD
            $crud = new grocery_CRUD();
            $user = $this->momv->user_institucion();  
            
            $crud->set_subject('Historico Pacientes');
            $crud->set_table('patients');

            if (!$this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
            {
                $crud->where('institution',$user);
            }
            
            //$crud->set_relation('institution', 'institucion_educativa', 'nombre_institucion');
            
            $crud->columns('type_id', 'id_number', 'first_name', 'middle_name', 'last_name', 'second_last_name', 'contact_phone', 'institution');

            $crud->display_as('type_id', 'Tipo de Identificación');
            $crud->display_as('id_number', 'No. Identificación');
            $crud->display_as('first_name', 'Primer Nombre');
            $crud->display_as('middle_name', 'Segundo Nombre');
            $crud->display_as('last_name', 'Primer Apellido');
            $crud->display_as('second_last_name', 'Segundo Apellido');
            $crud->display_as('birth_date', 'Fecha de Nacimiento');
            $crud->display_as('gender', 'Género');
            $crud->display_as('contact_phone', 'Teléfono de Contacto');

            $user = $this->ion_auth->user()->row();
            $cod_institucion = $user->id_institucion_ed;     

            //$crud->add_action('alt', ruta imagen boton, '/controller/function','class -> opcional');
            $crud->add_action('Ver Eventos', site_url('/includes/img/responder.png'), '/Historico/consulta');

            $crud->unset_delete();

            // Pintado de formulario y creación de vista
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_print();
            $crud->unset_read();

            $output = $crud->render();

            $this->load->view('layout/header', $data);
            $this->load->view('layout/navigation', $data);
            $this->load->view('events/historico', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh'); 
        }
    }
    
    function consulta($id)
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
           //aqui traemos todos los eventos finalizados asociados al id del paciente que se recibe.
            //echo 'se recibe id paciente '.$id;
            $data['historicos']=$this->momv->historia_paciente($id);
            $data['page'] = 'Historico de eventos por paciente';
            
            if(!$data['historicos'])
            {
                $this->session->set_flashdata('message', 'Aún no han respondido la consulta del paciente');
                redirect('/historico/lista', 'refresh');                
            }
            else
            {
                $this->load->view('layout/header', $data);
                $this->load->view('layout/navigation', $data);
                $this->load->view('events/detalle', $data);
                $this->load->view('layout/footer', $data);
            }
        } 
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh'); 
        }        
    }
}