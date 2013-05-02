<?php
    class welcome extends CI_Controller {
      
      function __construct(){
            parent::__construct();
        //$this->check_isvalidated();
        }
        
        public function index()
        {
            if(! $this->session->userdata('validated')){
                // Eerst de header laden.
                $this->load->view('header_view');
            
                // Menu laden.
                $data['page'] = "home";
                $this->load->view('menu_view', $data);
            
                $this->load->view('welcome_view');
            
                // Als laatste de footer laden.
                $this->load->view('footer_view');
            } else {
                redirect('home');
            }
        }
        
    }