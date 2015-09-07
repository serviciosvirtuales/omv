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
        $crud->columns('paciente_id', 'descripcion', 'fecha_evento', 'registrado_por', 'institucion_edu_id', 'estado');

        // Labels de columnas
        //$crud->display_as('id_evento', 'Tipo de Identificación');
        $crud->display_as('descripcion', 'Descripción del evento');
        $crud->display_as('paciente_id', 'Paciente');
        //$crud->display_as('fecha_evento', 'Primer Nombre');
        //$crud->display_as('estado', 'Segundo Nombre');
        $user = $this->ion_auth->user()->row();
        $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 
        
        $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento());
        
        $id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa
        
        $crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);
        
        $crud->field_type('registrado_por', 'hidden', $admin);

        // Campos obligatorios
        $crud->required_fields('descripcion','paciente_id');
        
        $crud->add_fields('descripcion','registrado_por','paciente_id','institucion_edu_id'); // con add establecemos los campos para el formulario
        $crud->edit_fields('descripcion','registrado_por','paciente_id','institucion_edu_id');
        
        $crud->unset_delete();
                
        
        // Pintado de formulario y creación de vista
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('events/events', $output);
        $this->load->view('layout/footer', $data);
    }
}