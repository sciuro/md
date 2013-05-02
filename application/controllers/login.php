<?php
    class login extends CI_Controller {
        
        function __construct(){
            parent::__construct();
        }
        
        public function index($msg = NULL)
        {
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menuoptie.
            $data['page'] = "login";

			// Eventueel errorbericht laden.
            $data['msg'] = $msg;
			
			// Menu laden.
            $this->load->view('menu_view', $data);			
			
			// Loginscherm laden.
            $this->load->view('login_view', $data);
            
            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }
        
        public function process(){
            // Load the model
            $this->load->model('login_model');
            
            // Validate the user can login
            $result = $this->login_model->validate();
            
            // Now we verify the result
            if(! $result){
                // If user did not validate, then show them login page again
                $msg = '<font color=red>Invalid username and/or password.</font><br />';
                $this->index($msg);
            }else{
                // If user did validate,
                // Send them to members area
                redirect('home');
            }
        }
		
		public function logout(){
            $this->session->sess_destroy();
            redirect('welcome');
        }
        
    }