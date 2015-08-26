<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller
{

    /**
     * Constructor para cargar headers, modelos y debug profiler.
     * */
    function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               
        //$this->load->library('ion_auth');
        //$this->load->model('model');
        //$this->load->library('grocery_CRUD');

        /* $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
          $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
          $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
          $this->output->set_header('Pragma: no-cache'); */

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
    {
        if($this->ion_auth->logged_in())
        {
             redirect('patients/view'); 
        }
        else
        {
            redirect('home/denied',refresh);
        }
    }

    /**
     *  Función que pinta el menú principal de la aplicación (una vez ingreso de usuario).
     */
    public function view()
    {
        $data['page'] = 'Pacientes';

        // Inicialización CRUD
        $crud = new grocery_CRUD();
        $crud->set_subject('Pacientes');
        $crud->set_table('patients');
        $crud->columns('type_id', 'id_number', 'first_name', 'middle_name', 'last_name', 'contact_phone', 'institution');

        // Labels de columnas
        $crud->display_as('type_id', 'Tipo de Identificación');
        $crud->display_as('id_number', 'No. Identificación');
        $crud->display_as('first_name', 'Primer Nombre');
        $crud->display_as('middle_name', 'Segundo Nombre');
        $crud->display_as('last_name', 'Primer Apellido');
        $crud->display_as('second_last_name', 'Segundo Apellido');
        $crud->display_as('birth_date', 'Fecha de Nacimiento');
        $crud->display_as('gender', 'Género');
        $crud->display_as('contact_phone', 'Teléfono de Contacto');
        $crud->display_as('institution', 'Institución');

        // Campos obligatorios
        $crud->required_fields('type_id', 'id_number', 'first_name', 'last_name', 'birth_date', 'gender', 'contact_phone', 'institution');

        // Validación de campos
        $crud->set_rules('id_number', 'No. Identificación', 'integer');

        // Dropdowns (Quemados)
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

        // Pintado de formulario y creación de vista
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('patients/list', $output);
        $this->load->view('layout/footer', $data);
    }

}
