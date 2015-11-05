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
            if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
            {
                redirect('Personas/view'); 
            }
            else 
            {
                $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
                redirect('/', 'refresh');
            }
        }
        else
        {
            redirect('Home/logout','refresh');
        }
    }

    /**
     *  Función que pinta el menú principal de la aplicación (una vez ingreso de usuario).
     */
    public function view()
    {
        if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
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

            $crud->field_type('rol', 'dropdown', array('1' => 'Administrador', '2' => 'Medico Especialista', '3'=>'Asistente Colegio'));

            // Labels de columnas
            $crud->display_as('first_name', 'Primer Nombre');
            $crud->display_as('last_name', 'Primer Apellido');
            $crud->display_as('email', 'Correo Electrónico');
            $crud->display_as('password', 'Contraseña');
            //$crud->display_as('email', 'Correo Electrónico');
            $crud->display_as('phone', 'Teléfono de Contacto');
            $crud->display_as('id_institucion_ed', 'Institución');
            $crud->display_as('rol', 'Perfil');

            $crud->field_type('id_institucion_ed', 'dropdown', $this->momv->instituciones());
            $crud->field_type('password', 'password');

            // Campos obligatorios
            $crud->required_fields('first_name', 'last_name', 'email', 'password', 'phone', 'id_institucion_ed','rol');

            //campos que inserto
            $crud->add_fields('first_name', 'last_name', 'email', 'password', 'phone', 'id_institucion_ed','rol');

            //campos que edito
            $crud->edit_fields('first_name', 'last_name', 'email', 'phone', 'id_institucion_ed');

            // Validación de campos
            //$crud->set_rules('id_number', 'No. Identificación', 'integer');

            //debemos validar que solo el admin pueda eliminar datos
            if (!$this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
            {
                $crud->unset_delete();
            }

                ########################## Importantes  ##############################
                $crud->callback_insert(array($this, 'create_user_callback'));
                $crud->callback_update(array($this, 'edit_user_callback'));
                $crud->callback_delete(array($this, 'delete_user'));
                ######################################################################
            $crud->unset_read();
            $crud->unset_print();
            // Pintado de formulario y creación de vista
            $output = $crud->render();

            $this->load->view('layout/header', $data);
            $this->load->view('layout/navigation', $data);
            $this->load->view('user/personas', $output);
            $this->load->view('layout/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }
    }
    
    function delete_user($primary_key)
    {
        if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
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
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }
    }

    function edit_user_callback($post_array, $primary_key = null)
    {
        if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
        {
            $username = $post_array['username'];
            $email = $post_array['email'];
            $data = array(
                'username' => $username,
                'email' => $email,
                'password' => $post_array['password'],                
                'first_name' => $post_array['first_name'],
                'last_name' => $post_array['last_name'],
                'id_institucion_ed' =>$post_array['id_institucion_ed']
            );

            $this->ion_auth_model->update($primary_key, $data);

            return true;
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }
    }

    function create_user_callback($post_array, $primary_key = null)
    {
        if ($this->ion_auth->is_admin()) // si no es admin condisiono por usuario institucion educativa
        {
            //log_message('ERROR', 'ACR - rol fue ' . $post_array['rol']);
            $username = $post_array['email'];
            $password = $post_array['password'];
            $email = $post_array['email'];
            $data = array(
                'phone' => $post_array['phone'],                
                'first_name' => $post_array['first_name'],
                'last_name' => $post_array['last_name'],
                'id_institucion_ed' => $post_array['id_institucion_ed']
            );
            //$group =  array('2');	//2 es el grupo de los usuarios de entidad
            $group = array($post_array['rol']);
            if($this->ion_auth_model->register($username, $password, $email, $data, $group))
            {
                //antes de retornar el id, envio el correo
                log_message('ERROR', 'AQUI Envio El CORREO al usuario registrado');
                //###########  CORREO  ##############
                $this->mail_newUser($password, $email);
                //###########  CORREO  ##############
                return $this->db->insert_id();
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            $this->session->set_flashdata('message', 'No tiene Permisos para acceder a este lugar');
            redirect('/', 'refresh');
        }
    }
    
    function mail_newUser($password, $email){
                   
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
        $this->email->subject('Bienvenido al Servicio de Orientación Médica Virtual');
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
							<h1>Bienvenido al Servicio de Orientación Médica Virtual</h1>
							<br />
							<p>Al registrarse al Servicio de Orientación Médica Virtual, su institución tiene la tranquilidad de contar con el apoyo de los especialistas de la Fundación Santa Fe de Bogotá para guiar casos y educar en salud a su comunidad.</p>
							<p>Puede saber más del Servicio, ingresando a <a href="#">esta página.</a></p>
							<p>Si tiene más preguntas, puede comunicarse con Servicios Virtuales al correo electrónico <a href="mailto:servicios.virtuales@fsfb.edu.co">servicios.virtuales@fsfb.edu.co</a> o llamando al teléfono (1) 6030303 extensión 5724.</p>
                                                        <p> Sus datos de acceso son los siguientes:<br>
                                                        <label>Usuario: </label>'.$email.'<br>
                                                            <label>Contraseña: </label>'.$password.'</p> 
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

        $this->email->print_debugger();

        $this->email->send();

        if (!$this->email->send())
        {
            //var_dump($this->email->print_debugger());
            log_message('ERROR', ' No Envió correo al registrar a --> ' . $email);
        } 
        else
        {
            log_message('ERROR', 'Envió correo a --> ' . $email);
        }

        //con esto podemos ver el resultado
        //var_dump($this->email->print_debugger());
        //log_message('error', 'error de correo '.$errores );
        //Echo "Correo Enviado Exitosamente";
        return TRUE;    
    }

}
