<?php
    class home extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->check_isvalidated();
        }
        
        public function index()
        {
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "home";
            $this->load->view('menu_view', $data);
            
            $this->load->view('home_view');
            
            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }
        
        private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
                redirect('welcome');
            }
        }
        
    }