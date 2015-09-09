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
        if ($this->ion_auth->logged_in()) //validamos login
        {
            redirect('Events/view/add');
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }

    public function view()
    {
        $data['page'] = 'Eventos';

        // Inicialización CRUD
        $crud = new grocery_CRUD();
        $this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png|doc|docx|pdf');
        $crud->set_subject('Eventos');
        $crud->set_table('evento');
        
        $crud->set_field_upload('adjunto1','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto2','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto3','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto4','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto5','assets/uploads/files/evento');
        
        $crud->columns('paciente_id', 'descripcion', 'fecha_evento', 'registrado_por', 'institucion_edu_id', 'estado','adjunto1');

        //$crud->add_action('alt', ruta imagen boton, '/controller/function','class -> opcional');
        $crud->add_action('Responder', site_url('/includes/img/responder.png'), '/events/responder');

        // Labels de columnas
        $crud->display_as('fecha_evento', 'Registrado el');
        $crud->display_as('paciente_id', 'Paciente');
        $crud->display_as('descripcion', 'Descripción del evento');
        $crud->display_as('institucion_edu_id', 'Código Institución Educativa');
        $crud->display_as('adjunto1', 'Archivo Adjunto');
        $crud->display_as('adjunto2', 'Archivo Adjunto');
        $crud->display_as('adjunto3', 'Archivo Adjunto');
        $crud->display_as('adjunto4', 'Archivo Adjunto');
        $crud->display_as('adjunto5', 'Archivo Adjunto');
        
        //$crud->display_as('estado', 'Segundo Nombre');
        $user = $this->ion_auth->user()->row();
        $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 

        $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento());

        $id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa

        $crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);

        $crud->field_type('registrado_por', 'hidden', $admin);

        // Campos obligatorios
        $crud->required_fields('descripcion', 'paciente_id','adjunto1');

        $crud->add_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5'); // con add establecemos los campos para el formulario
        $crud->edit_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5');

        if (!$this->ion_auth->is_admin()) // si no es adminno puede eliminar
        {
            $crud->unset_delete();
        }
            //a continuacion dejo los callbacks para las funciones del crud
            //########################## Importantes  ##############################
            //$crud->callback_insert(array($this, 'create_event_callback'));
            //$crud->callback_update(array($this, 'edit_event_callback'));
            //$crud->callback_delete(array($this, 'delete_event_callback'));
            //$crud->callback_after_insert(array($this, 'adjuntos_evento')); // no se requiere ya que se daña la carga si los adjuntos estan en tablas separadas
            //######################################################################
        
        // Pintado de formulario y creación de vista
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('events/events', $output);
        $this->load->view('layout/footer', $data);
    }
    /*
    function adjuntos_evento($post_array,$primary_key)
    {
        log_message('ERROR', 'ACR - adjuntos_evento ' .$primary_key);
        return TRUE;
    }
    */
    /*
    function delete_event_callback($primary_key)
    {
        if ($this->ion_auth_model->delete_user($primary_key))
        {
            return true;
        } 
        else
        {
            return false;
        }
    }
    */
    
    /*
    function edit_event_callback($post_array, $primary_key = null)
    {
        $username = $post_array['username'];
        $email = $post_array['email'];
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $post_array['password'],
            'id_especialidad' => $post_array['id_especialidad'],
            'first_name' => $post_array['first_name'],
            'last_name' => $post_array['last_name'],
            'id_institucion_ed' =>$post_array['id_institucion_ed']
        );

        $this->ion_auth_model->update($primary_key, $data);

        return true;
    }
    */
    
    /*
    function create_event_callback($post_array, $primary_key = null)
    {
        //log_message('ERROR', 'ACR - rol fue ' . $post_array['rol']);
        $username = $post_array['email'];
        $password = $post_array['password'];
        $email = $post_array['email'];
        $data = array(
            'phone' => $post_array['phone'],
            'id_especialidad' => $post_array['id_especialidad'],
            'first_name' => $post_array['first_name'],
            'last_name' => $post_array['last_name'],
            'id_institucion_ed' => $post_array['id_institucion_ed']
        );
        //$group =  array('2');	//2 es el grupo de los usuarios de entidad
        $group = array($post_array['rol']);
        $this->ion_auth_model->register($username, $password, $email, $data, $group);

        return $this->db->insert_id();
    }
    */
    
     public function listado()
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            redirect('Events/lista');
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }

    public function lista()
    {
        $data['page'] = 'Eventos';

        // Inicialización CRUD
        $crud = new grocery_CRUD();
        $crud->set_subject('Eventos');
        $crud->set_table('evento');
        
        $crud->set_field_upload('adjunto1','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto2','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto3','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto4','assets/uploads/files/evento');      
        $crud->set_field_upload('adjunto5','assets/uploads/files/evento');
        
        $crud->columns('paciente_id', 'descripcion', 'fecha_evento', 'registrado_por', 'institucion_edu_id', 'estado','adjunto1');

        //$crud->add_action('alt', ruta imagen boton, '/controller/function','class -> opcional');
        $crud->add_action('Responder', site_url('/includes/img/responder.png'), '/events/responder');

        // Labels de columnas
        $crud->display_as('fecha_evento', 'Registrado el');
        $crud->display_as('paciente_id', 'Paciente');
        $crud->display_as('descripcion', 'Descripción del evento');
        $crud->display_as('institucion_edu_id', 'Código Institución Educativa');
        $crud->display_as('adjunto1', 'Archivo Adjunto');
        $crud->display_as('adjunto2', 'Archivo Adjunto');
        $crud->display_as('adjunto3', 'Archivo Adjunto');
        $crud->display_as('adjunto4', 'Archivo Adjunto');
        $crud->display_as('adjunto5', 'Archivo Adjunto');
        
        //$crud->display_as('estado', 'Segundo Nombre');
        $user = $this->ion_auth->user()->row();
        $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 

        $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento());

        $id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa

        $crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);

        $crud->field_type('registrado_por', 'hidden', $admin);

        // Campos obligatorios
        $crud->required_fields('descripcion', 'paciente_id','adjunto1');

        $crud->add_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5'); // con add establecemos los campos para el formulario
        $crud->edit_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5');

        if (!$this->ion_auth->is_admin()) // si no es adminno puede eliminar
        {
            $crud->unset_delete();
        }
            //a continuacion dejo los callbacks para las funciones del crud
            //########################## Importantes  ##############################
            //$crud->callback_insert(array($this, 'create_event_callback'));
            //$crud->callback_update(array($this, 'edit_event_callback'));
            //$crud->callback_delete(array($this, 'delete_event_callback'));
            //$crud->callback_after_insert(array($this, 'adjuntos_evento'));
            //######################################################################
        
        // Pintado de formulario y creación de vista
        
        $crud->unset_print();
        //$crud->unset_read();
                
        $output = $crud->render();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/navigation', $data);
        $this->load->view('events/events', $output);
        $this->load->view('layout/footer', $data);
    }
    
    function responder($id)
    {
        echo 'respondes evento ' . $id;
        //$id es el id del evento a responder
        // codigo para el multiselect del cie10:
        //$crud->field_type('cie10', 'multiselect', $this->momv->cie10());
    }
}
