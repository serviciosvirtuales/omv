<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller
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
        if($this->ion_auth->logged_in()) //validamos login
        {
             redirect('Events/view'); 
        }
        else
        {
            redirect('Home/denied','refresh');
        }
    }
    
    public function view()
    {
        $data['page'] = 'Eventos';

        // Inicialización CRUD
        $crud = new grocery_CRUD();
        $crud->set_subject('Eventos');
        $crud->set_table('evento');        
        $crud->columns('id_evento', 'descripcion', 'fecha_evento', 'estado', 'registrado_por');

        // Labels de columnas
        //$crud->display_as('id_evento', 'Tipo de Identificación');
        $crud->display_as('descripcion', 'Descripción del evento');
        //$crud->display_as('fecha_evento', 'Primer Nombre');
        //$crud->display_as('estado', 'Segundo Nombre');
        $user = $this->ion_auth->user()->row();
        $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 
        
        $crud->field_type('registrado_por', 'hidden', $admin);

        // Campos obligatorios
        $crud->required_fields('descripcion');
        $crud->add_fields('descripcion','registrado_por'); // con add establecemos los campos para el formulario
        $crud->edit_fields('descripcion','registrado_por');
        
        $crud->unset_delete();
        
        
        // Validación de campos
        //$crud->set_rules('id_number', 'No. Identificación', 'integer');

        // Dropdowns (Quemados)
        /*
        $crud->field_type('type_id', 'dropdown', array(
            'TI' => 'Tarjeta de Identidad',
            'CC' => 'Cédula de Ciudadanía',
            'NUIP' => 'NUIP',
            'Pasaporte' => 'Pasaporte',
            'CE' => 'Cédula de Extranjería'
        ));
        $crud->field_type('gender', 'dropdown', array(
            'Femenino' => 'Femenino',
            'Masculino' => 'Masculino',
            'Otro' => 'Otro'
        ));
        */
        // Pintado de formulario y creación de vista
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('events/events', $output);
        $this->load->view('layout/footer', $data);
    }
}