<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aseguradora extends CI_Controller
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
            if ($this->ion_auth->is_admin()) // si no es adminno puede eliminar
            {
                //muestro el crud de correos
                redirect('Aseguradora/agregar');
            }
            else
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/menu', 'refresh');  
            }
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/menu', 'refresh');
        }
    }
    
    function agregar()
    {
        if ($this->ion_auth->is_admin()) // si no es adminno puede eliminar
        {
            $data['page'] = 'Aseguradoras';
        
            // Inicialización CRUD
            $crud = new grocery_CRUD();       
            $crud->set_subject('Aseguradoras');        
            $crud->set_table('aseguradora');

            $crud->columns('id_aseguradora', 'aseguradora');

            // Labels de columnas
            $crud->display_as('aseguradora', 'Nombre Aseguradora');

            // Campos obligatorios
            $crud->required_fields('aseguradora');

            $crud->add_fields('aseguradora'); // con add establecemos los campos para el formulario
            $crud->edit_fields('aseguradora');

            if (!$this->ion_auth->is_admin()) // si no es admin no puede eliminar etc
            {
                $crud->unset_delete();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_print();
            }

            //a continuacion dejo los callbacks para las funciones del crud
            //########################## Importantes  ##############################
                //$crud->callback_insert(array($this, 'create_event_callback'));
                //$crud->callback_update(array($this, 'edit_event_callback'));
                //$crud->callback_delete(array($this, 'delete_event_callback'));
                //$crud->callback_after_insert(array($this, 'adjuntos_evento')); // no se requiere ya que se daña la carga si los adjuntos estan en tablas separadas
            //######################################################################

            //###########  CORREO  ##############
            //$crud->callback_after_insert(array($this, 'mail_newEvento'));
            //###########  CORREO  ##############

            //$crud->unset_back_to_list();

            $crud->set_lang_string('insert_success_message', 'Gracias por usar nuestros servicios' . '<br/>
                                        <script type="text/javascript">
                                        window.location = "' . site_url(strtolower('home') . '/' . strtolower('index')) . '";
                                        </script>
                                        <div style="display:none">
                                        '
                    );


                // Pintado de formulario y creación de vista
                $output = $crud->render();

                $this->load->view('layout/header', $data);
                $this->load->view('layout/navigation', $data);
                $this->load->view('config/aseguradora', $output);
                $this->load->view('layout/footer', $data);
        }else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/menu', 'refresh');
        }
    }
}