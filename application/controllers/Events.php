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
            $group = array(1,3);
            if ($this->ion_auth->in_group($group))
            {
                redirect('Events/view/add');
            }
            else
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/', 'refresh');
            }
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }

    public function view()
    {
        $group = array(1,3);
        if ($this->ion_auth->in_group($group))
        {
            $data['page'] = 'Eventos';
            $estado = 'Recibido';
            // Inicialización CRUD
            $crud = new grocery_CRUD();
            $this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png|doc|docx|pdf');
            $crud->set_subject('Eventos');
            $crud->where('estado',$estado);
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

            //$crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento());

            $id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa

            $crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);

            $crud->field_type('registrado_por', 'hidden', $admin);

            // Campos obligatorios
            $crud->required_fields('descripcion', 'paciente_id');

            $crud->add_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5'); // con add establecemos los campos para el formulario
            $crud->edit_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5');

            if (!$this->ion_auth->is_admin()) // si no es admin no puede eliminar y consulta sus pacientes
            {
                $crud->unset_delete();
                $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento());
            }
            else // es admin consulta todos los pacientes
            {
                $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento_admin());
            }
                //a continuacion dejo los callbacks para las funciones del crud
                //########################## Importantes  ##############################
                //$crud->callback_insert(array($this, 'create_event_callback'));
                //$crud->callback_update(array($this, 'edit_event_callback'));
                //$crud->callback_delete(array($this, 'delete_event_callback'));
                //$crud->callback_after_insert(array($this, 'adjuntos_evento')); // no se requiere ya que se daña la carga si los adjuntos estan en tablas separadas
                //######################################################################
                
            
            //###########  CORREO  ##############
            $crud->callback_after_insert(array($this, 'mail_newEvento'));
            //###########  CORREO  ##############
            
            $crud->unset_back_to_list();
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
            $this->load->view('events/events', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }
    }
    
    function mail_newEvento($post_array, $primary_key = null){
    
        //consultar el correo con el id de la pregunta
        //$registrado_por = $post_array['registrado_por'];
        //$email = $this->momv->email_evento($registrado_por); //necesito enviar el correo a todos los especialistas
        
        $email = $this->momv->emailEspecialistas();
               
        
        if(!$email){
            log_message('ERROR', ' No se encontro correo electronico para enviar a los especialistas');
            return TRUE;
        }
        
        foreach ($email->result() as $correo)
        {
            //cargamos la libreria email de ci
            $this->load->library("email");
            //$email = $post_array['registrado_por'];
            //$email = 'dt@fsfb.edu.co';
            //$respuesta_e = $post_array['respuesta'];
            //configuracion para gmail
            /*
            $configGmail = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'desarrollos@fsfb.edu.co',
                'smtp_pass' => 'admfsfb2008',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n");
             */
            $configGmail = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.mailgun.org',
                'smtp_port' => 465,
                'smtp_user' => 'postmaster@sandbox224cc937f61d42948cc7e944f56c4694.mailgun.org',
                'smtp_pass' => '1c0e062dbc4ffaea11496eca3c905ccf',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n");

            //cargamos la configuración para enviar con gmail
            $this->email->initialize($configGmail);

            $this->email->from('OMV');
            $this->email->to($correo->email);
            $this->email->subject('Alerta - Evento en Servicio de Orientación Médica Virtual');
            $this->email->message('<body style="margin:0; padding: 0; border:0;">
                <table class="wrapper" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 90%; color: #555;">
                    <tr>
                            <td align="center">
                                    <table class="content" cellpadding="0" cellspacing="0" border="0" width="600">
                                            <tr><td width="100%" bgcolor="#042473">
                                                    <table cellpadding="20">
                                                            <tr>
                                                                    <td width="100%" bgcolor="#042473">
                                                                            <img src="http://104.154.71.126/fsfbedu/img/logo_fsfb_bw.png" width="200" style="display:block;">
                                                                    </td>
                                                            </tr>
                                                    </table>
                                            </td></tr>
                                            <tr>
                                                    <td>
                                                            <img src="http://173.192.217.154/omv/includes/img/banner3.jpg" style="display:block;">
                                                    </td>
                                            </tr>
                                            <tr>
                                                    <td>
                                                            <h1>Se ha registrado un nuevo evento en el Servicio de Orientación Médica Virtual</h1>
                                                            <br />
                                                            <p><strong>Importante</strong> - Se ha registrado un nuevo evento en el Sistema de Orientación Médica Virtual. Para acceder al sistema y contestar este evento, puede dirigirse a <a href="#">https://fsfb.edu.co/omv/</a>. Debe recordar que el tiempo de contacto con la institución remisora no debe superar los 15 minutos desde la recepción de este correo.</p>
                                                            <p>Puede saber más del Servicio, ingresando a <a href="#">esta página.</a></p>
                                                            <p>Si tiene más preguntas, puede comunicarse con Servicios Virtuales al correo electrónico <a href="mailto:servicios.virtuales@fsfb.edu.co">servicios.virtuales@fsfb.edu.co</a> o llamando al teléfono (1) 6030303 extensión 5724.</p>
                                                            <br />
                                                            <p><strong>El Equipo de Servicios Virtuales</strong><br />Fundación Santa Fe de Bogotá</p><br />
                                                    </td>
                                            </tr>
                                            <tr>
                                                    <td style="font-size:70%">Todos los derechos reservados, Fundación Santa Fe de Bogotá. 
                                                            Evite imprimir, piense en su compromiso con el medio ambiente.</td>
                                            </tr>
                                    </table>
                            </td>
                    </tr>
                </table>
            </body>');

            //$this->email->print_debugger();

            $this->email->send();

            if (!$this->email->send())
            {
                //var_dump($this->email->print_debugger());
                log_message('ERROR', ' No Envió correo con respuesta a --> ' .$correo->email);
            } 
            else
            {
                log_message('ERROR', 'Envió correo a --> ' .$correo->email);
            }

            //con esto podemos ver el resultado
            //var_dump($this->email->print_debugger());
            //log_message('error', 'error de correo '.$errores );
            //Echo "Correo Enviado Exitosamente";
              
        }//foreach email
        return TRUE;
    }
    
    public function listado()
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            $group3 = array(1,2);
            if ($this->ion_auth->in_group($group3))
            {
                redirect('Events/lista');
            }
            else
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/', 'refresh');
            }
        } 
        else
        {
            redirect('Home/denied', 'refresh');
        }
    }

    public function lista()
    {
        $group3 = array(1,2);
        if ($this->ion_auth->in_group($group3))
        {
            $data['page'] = 'Eventos';
            $estado = 'Recibido';
            // Inicialización CRUD
            $crud = new grocery_CRUD();
            $crud->set_subject('Eventos');
            $crud->where('estado',$estado);
            $crud->set_table('evento');

            $crud->set_field_upload('adjunto1','assets/uploads/files/evento');      
            $crud->set_field_upload('adjunto2','assets/uploads/files/evento');      
            $crud->set_field_upload('adjunto3','assets/uploads/files/evento');      
            $crud->set_field_upload('adjunto4','assets/uploads/files/evento');      
            $crud->set_field_upload('adjunto5','assets/uploads/files/evento');

            $crud->columns('paciente_id', 'descripcion', 'fecha_evento', 'registrado_por', 'institucion_edu_id', 'estado');

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

            $crud->field_type('paciente_id', 'dropdown', $this->momv->paciente_evento_responde());

            $id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa

            $crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);

            $crud->field_type('registrado_por', 'hidden', $admin);

            // Campos obligatorios
            $crud->required_fields('descripcion', 'paciente_id');

            $crud->add_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5'); // con add establecemos los campos para el formulario
            $crud->edit_fields('paciente_id', 'descripcion', 'registrado_por', 'institucion_edu_id', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5');

            if (!$this->ion_auth->is_admin()) // si no es adminno puede eliminar
            {
                //$crud->unset_delete();
                //$crud->unset_add();
            }
                //a continuacion dejo los callbacks para las funciones del crud
                //########################## Importantes  ##############################
                //$crud->callback_insert(array($this, 'create_event_callback'));
                //$crud->callback_update(array($this, 'edit_event_callback'));
                //$crud->callback_delete(array($this, 'delete_event_callback'));
                //$crud->callback_after_insert(array($this, 'adjuntos_evento'));
                //######################################################################

            // Pintado de formulario y creación de vista
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_add();
            $crud->unset_print();
            //$crud->unset_read();

            $output = $crud->render();

            $this->load->view('layout/header', $data);
            $this->load->view('layout/navigation', $data);
            $this->load->view('events/responde_evento', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh'); 
        }
    }
    
    function responder($id)
    {
        if ($this->ion_auth->logged_in()) //validamos login
        {
            $group3 = array(1,2);
            if ($this->ion_auth->in_group($group3))
            {
                redirect('Events/responde_evento/'.$id.'/add');
            }
            else
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/', 'refresh'); 
            }
            
        //$id es el id del evento a responder
        // codigo para el multiselect del cie10:
        //$crud->field_type('cie10', 'multiselect', $this->momv->cie10());
        } 
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh'); 
        }
        
    }
    
    function responde_evento($id)
    {
        $group3 = array(1,2);
        if ($this->ion_auth->in_group($group3))
        {
            //echo 'respondes evento con id ' . $id;
            $data['evento'] = $this->momv->detalle_evento($id);
            $data['page'] = 'Responde - Evento';

            $crud = new grocery_CRUD();
            $crud->set_subject('Responder');
            $crud->set_table('respuesta');


            $crud->set_field_upload('adjunto1','assets/uploads/files/respuesta');      
            $crud->set_field_upload('adjunto2','assets/uploads/files/respuesta');      
            $crud->set_field_upload('adjunto3','assets/uploads/files/respuesta');      
            $crud->set_field_upload('adjunto4','assets/uploads/files/respuesta');      
            $crud->set_field_upload('adjunto5','assets/uploads/files/respuesta');

            $crud->columns('id_evento', 'respuesta', 'fecha_respuesta', 'registrado_por');

            //$crud->add_action('alt', ruta imagen boton, '/controller/function','class -> opcional');
            //$crud->add_action('Responder', site_url('/includes/img/responder.png'), '/events/responder');

            // Labels de columnas
            //$crud->display_as('id_evento', 'Cod. Evento');
            $crud->display_as('respuesta', 'Ingrese su respuesta');
            //$crud->display_as('fecha_respuesta', 'Se Respondió el');
            $crud->display_as('cie10', 'Código CIE10');
            $crud->display_as('adjunto1', 'Archivo Adjunto');
            $crud->display_as('adjunto2', 'Archivo Adjunto');
            $crud->display_as('adjunto3', 'Archivo Adjunto');
            $crud->display_as('adjunto4', 'Archivo Adjunto');
            $crud->display_as('adjunto5', 'Archivo Adjunto');

            //$crud->display_as('estado', 'Segundo Nombre');
            $user = $this->ion_auth->user()->row();
            $admin = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 

            $crud->field_type('cie10', 'multiselect', $this->momv->cie10());

            //$id_edu_ins = $user->id_institucion_ed; //seleccionamos el id de la institucion educativa

            //$crud->field_type('institucion_edu_id', 'hidden', $id_edu_ins);

            $crud->field_type('id_evento', 'hidden', $id);
            $crud->field_type('registrado_por', 'hidden', $admin);

            // Campos obligatorios
            $crud->required_fields('respuesta');

            $crud->add_fields('id_evento', 'respuesta', 'registrado_por', 'cie10', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5'); // con add establecemos los campos para el formulario
            $crud->edit_fields('respuesta', 'registrado_por', 'cie10', 'adjunto1', 'adjunto2', 'adjunto3', 'adjunto4', 'adjunto5');

            if (!$this->ion_auth->is_admin()) // si no es adminno puede eliminar
            {
                $crud->unset_delete();
            }
                //a continuacion dejo los callbacks para las funciones del crud
                //########################## Importantes  ##############################
                //$crud->callback_insert(array($this, 'create_event_callback'));
                //$crud->callback_update(array($this, 'edit_event_callback'));
                //$crud->callback_delete(array($this, 'delete_event_callback'));
                $crud->callback_after_insert(array($this, 'actualizo_evento'));
                //######################################################################

            // Pintado de formulario y creación de vista

            $crud->unset_print();
            //$crud->unset_read();
            $crud->unset_back_to_list();

            $crud->set_lang_string('insert_success_message','Gracias por su respuesta<br/>
             <script type="text/javascript">
              window.location = "'.site_url(strtolower('home').'/'.strtolower('index')).'";
             </script>
             <div style="display:none">
             '
             );


            $output = $crud->render();


            $this->load->view('layout/header', $data);
            $this->load->view('layout/navigation', $data);

            $this->load->view('events/consulta', $data); //agrego una vista para mostrar la consulta realizada
            $this->load->view('events/responde_evento', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh'); 
        }
    }
    
    function actualizo_evento($post_array)
    {
        //log_message('ERROR', 'actualizo evento id '.$post_array['id_evento']);
        $id = $post_array['id_evento'];
        
        if($this->momv->actualizo_evento($id))
            {
                //antes de retornar, envio el correo
                log_message('ERROR', 'AQUI Envio El CORREO respuesta a evento');
                //###########  CORREO  ##############
                $this->mail_newRespuesta($id); //envio ID del evento
                return TRUE;
            }
            else
            {
                return FALSE;
            }
    }
    
    function mail_newRespuesta($id){ //Recibimos el id del evento que se responde
                   
        //debemos consultar el correo de la persona que realizo la consulta para enviar el correo de respuesta
        $email = $this->momv->email_evento_id($id);
        //cargamos la libreria email de ci
        $this->load->library("email");
        
        /*
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'desarrollos@fsfb.edu.co',
            'smtp_pass' => 'admfsfb2008',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n");
         */
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.mailgun.org',
            'smtp_port' => 465,
            'smtp_user' => 'postmaster@sandbox224cc937f61d42948cc7e944f56c4694.mailgun.org',
            'smtp_pass' => '1c0e062dbc4ffaea11496eca3c905ccf',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n");
        
        //cargamos la configuración para enviar con gmail
        $this->email->initialize($configGmail);

        $this->email->from('OMV');
        $this->email->to($email);
        $this->email->subject('Respuesta del Servicio de Orientación Médica Virtual');
        $this->email->message('<body style="margin:0; padding: 0; border:0;">
	<table class="wrapper" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 90%; color: #555;">
		<tr>
			<td align="center">
				<table class="content" cellpadding="0" cellspacing="0" border="0" width="600">
					<tr><td width="100%" bgcolor="#042473">
						<table cellpadding="20">
							<tr>
								<td width="100%" bgcolor="#042473">
									<img src="http://104.154.71.126/fsfbedu/img/logo_fsfb_bw.png" width="200" style="display:block;">
								</td>
							</tr>
						</table>
					</td></tr>
					<tr>
						<td>
							<img src="http://173.192.217.154/omv/includes/img/banner3.jpg" style="display:block;">
						</td>
					</tr>
					<tr>
						<td>
							<h1>Ya puede acceder a la respuesta del Servicio de Orientación Médica Virtual</h1>
							<br />
							<p><strong>Importante</strong> - Ya puede acceder para ver la respuesta a su consulta en el Servicio de Orientación Médica Virtual. Para acceder al sistema y ver la respuesta a este evento, puede dirigirse a <a href="#">https://fsfb.edu.co/omv/</a>. Puede acceder con su usuario y contraseña registrada y seleccionar "Ver consultas pasadas" en el menú principal.</p>
							<p>Puede saber más del Servicio, ingresando a <a href="#">esta página.</a></p>
							<p>Si tiene más preguntas, puede comunicarse con Servicios Virtuales al correo electrónico <a href="mailto:servicios.virtuales@fsfb.edu.co">servicios.virtuales@fsfb.edu.co</a> o llamando al teléfono (1) 6030303 extensión 5724.</p>
							<br />
							<p><strong>El Equipo de Servicios Virtuales</strong><br />Fundación Santa Fe de Bogotá</p><br />
						</td>
					</tr>
					<tr>
						<td style="font-size:70%">Todos los derechos reservados, Fundación Santa Fe de Bogotá. 
							Evite imprimir, piense en su compromiso con el medio ambiente.</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>');

        //$this->email->print_debugger();

        $this->email->send();

        if (!$this->email->send())
        {
            //var_dump($this->email->print_debugger());
            log_message('ERROR', ' No Envió correo con respuesta a --> ' . $email);
        } 
        else
        {
            log_message('ERROR', 'Envió correo a --> ' . $email);
            return TRUE; 
        }

        //con esto podemos ver el resultado
        //var_dump($this->email->print_debugger());
        //log_message('error', 'error de correo '.$errores );
        //Echo "Correo Enviado Exitosamente";
        return TRUE;    
    }
    
}
