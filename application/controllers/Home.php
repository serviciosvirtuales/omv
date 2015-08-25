<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    /**
     * Constructor para cargar headers, modelos y debug profiler.
     * */
    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE); //profiler para el seguimiento del performance                               
        /*
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        */
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
    }

    /**
     * Pintar el home básico del sistema (login).
     */
    public function index()
    {
        log_message('ERROR','ACR Home/index OK');	
        $this->load->view('home');
        $this->load->view('layout/footer');
    }
    
    //version login andres
    /*
    public function login()
    {
        
        $this->form_validation->set_rules('identity', 'identity', 'trim|required|');                       //valido identity
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|callback_check_database');      //valido contraseña
        
        if ($this->form_validation->run() == FALSE)
        {
            log_message('ERROR','ACR Home/login validacion FALSE');
            //si falla la validacion, redirecciona a la pag de login
            redirect('home/denied', 'refresh');
        } else
        {
            log_message('ERROR','ACR Home/login validacion TRUE');
            //si  no falla pasa a un area privada
            //redirect('home', 'refresh');
            redirect('menu', 'refresh');
        }
    }
    */
    //version ion_auth
    
    function login()
	{
		$this->data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('menu', 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('/', $this->data);
		}
	}
        
        
    /* function to log out o para salir xD */
    public function logout()
    {
        $this->ion_auth->logout();
        redirect('home', 'refresh');
    }
    /*
    function check_database($password)
    {
        //si la validacion de campos es exitosa, pasa a validar contra la base de datos
        $identidad = $this->input->post('identity');
        log_message('ERROR','ACR Home/validando identidad '.$identidad);
        log_message('ERROR','ACR Home/validando password '.$password);

        //consultamos la base de datos
        //$result = $this->user->login($username, $password); //aqui usabamos el modelo anterior para el login
        $result = $this->ion_auth->login($identidad, $password);
        
        log_message('ERROR','ACR result --> '.$result);
        
        if ($result)
        {
            return TRUE;
        } else
        {            
            $this->form_validation->set_message('password', 'Error Message');
            return FALSE;
        }
    }
    */
    
    function denied()
    {
        echo 'Error';
    }

}
