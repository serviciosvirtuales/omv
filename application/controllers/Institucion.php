<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Institucion extends CI_Controller
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
        if($this->ion_auth->logged_in()) //validamos login
        {
            $group = 1;
            if($this->ion_auth->in_group($group))
            {
                redirect('Institucion/view'); 
            }
            else
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/', 'refresh');
            }
        }
        else
        {
            redirect('Home/denied','refresh'); // mostramos mensaje de error
        }
    }
    
    public function view()
    {
        $group = 1;
        if($this->ion_auth->in_group($group))
        {
            $data['page'] = 'Institucion Educativa';

            // Inicialización CRUD
            $crud = new grocery_CRUD();
            $crud->set_subject('Institución Educativa');
            $crud->set_table('institucion_educativa');        
            $crud->columns('id_institucion', 'nombre_institucion', 'poliza_institucion', 'aseguradora', 'fecha_registro', 'estado');

            // Labels de columnas
            $crud->display_as('id_institucion', 'NIT. Institución');
            $crud->display_as('nombre_institucion', 'Nombre Institución');
            $crud->display_as('poliza_institucion', 'Número de Poliza');
            $crud->display_as('aseguradora', 'Aseguradora');
            //$crud->display_as('estado', 'Segundo Nombre');
            $user = $this->ion_auth->user()->row();
            $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 

            $crud->field_type('registrado_por', 'hidden', $admin);
            if(!$this->momv->aseguradoras())
            {
                $this->session->set_flashdata('message', 'No han registrado aseguradoras');
                redirect('/menu'); 
            }else
            {
                $crud->field_type('aseguradora', 'dropdown', $this->momv->aseguradoras());
            }

            // Campos obligatorios
            $crud->required_fields('id_institucion','nombre_institucion','poliza_institucion', 'aseguradora');
            $crud->add_fields('id_institucion','nombre_institucion','poliza_institucion','registrado_por', 'aseguradora'); // con add establecemos los campos para el formulario
            $crud->edit_fields('id_institucion','nombre_institucion','poliza_institucion','registrado_por', 'aseguradora');
            // Validación de campos
            //$crud->set_rules('id_number', 'No. Identificación', 'integer');

            if (!$this->ion_auth->is_admin()) // si no es adminno puede eliminar
            {
                $crud->unset_delete();
            }

            // Pintado de formulario y creación de vista
            $output = $crud->render();

            $this->load->view('layout/header', $data);
            $this->load->view('layout/navigation', $data);
            $this->load->view('Institucion/list', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }        
    }
}