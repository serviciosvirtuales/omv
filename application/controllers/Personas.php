<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personas extends CI_Controller
{

    /**
     * Constructor para cargar headers, modelos y debug profiler.
     * */
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
            if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
            {
                redirect('Personas/view'); 
            }
            else 
            {
                redirect('Home/denied',refresh);
            }
        }
        else
        {
            redirect('Home/denied',refresh);
        }
    }

    /**
     *  Función que pinta el menú principal de la aplicación (una vez ingreso de usuario).
     */
    public function view()
    {
        $data['page'] = 'Personas';

        // Inicialización CRUD
        $crud = new grocery_CRUD();
        /*        
        if (!$this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
	{
            $crud->where('institution',$user);
	}
	*/           
        $crud->set_subject('Personas');
        $crud->set_table('users');
        $crud->columns('first_name', 'last_name', 'phone', 'id_institucion_ed');

        // Labels de columnas
        $crud->display_as('first_name', 'Primer Nombre');
        $crud->display_as('last_name', 'Primer Apellido');
        $crud->display_as('email', 'Correo Electrónico');
        $crud->display_as('password', 'Contraseña');
        //$crud->display_as('email', 'Correo Electrónico');
        $crud->display_as('phone', 'Teléfono de Contacto');
        $crud->display_as('id_institucion_ed', 'Institución');
        
        $crud->field_type('id_institucion_ed', 'dropdown', $this->momv->instituciones());
        
        // Campos obligatorios
        $crud->required_fields('first_name', 'last_name', 'email', 'password', 'phone', 'id_institucion_ed');
        
        //campos que inserto
        $crud->add_fields('first_name', 'last_name', 'email', 'password', 'phone', 'id_institucion_ed');
        
        //campos que edito
        $crud->edit_fields('first_name', 'last_name', 'email', 'phone', 'id_institucion_ed');

        // Validación de campos
        //$crud->set_rules('id_number', 'No. Identificación', 'integer');
        
        //debemos validar que solo el admin pueda eliminar datos
        if (!$this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
	{
            $crud->unset_delete();
        }
        

        // Pintado de formulario y creación de vista
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('user/personas', $output);
        $this->load->view('layout/footer', $data);
    }

}