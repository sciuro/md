<?php
    class logbook extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->check_isvalidated();
        }
        
        public function view($pagination = '1')
        {
			// Prepare page
			$count = '20';
			$offset = ($count * $pagination) - $count;
			
			// Model ladel.
			$this->load->model('logbook_model');
			$data['logbook'] = $this->logbook_model->get_logbook($count, $offset);
			
			$data['pagination']['total'] = $this->logbook_model->get_total_logitems();
			$data['pagination']['current'] = $pagination;
			$data['pagination']['pages'] = ceil($data['pagination']['total'] / $count);
			if ($data['pagination']['pages'] >= 15) {
				$data['pagination']['pages'] = 15;
			}

            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "logbook";
            $this->load->view('menu_view', $data);
			
			// Pagina laden.
            $this->load->view('logbook_view', $data);
            
            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }
        
        private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
                redirect('login_view');
            }
        }
        
    }