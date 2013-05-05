<?php
    class config extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->check_isvalidated();
        }
        
        public function index()
        {
            redirect('welcome');
        }

        public function options($tab = 'common')
        {
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "config";
            $this->load->view('menu_view', $data);

            // Model laden
            $this->load->model('config_model');
            $data['setting'] = $this->config_model->get_settings();

            // View options.
            $data['tab'] = $tab;
            $this->load->view('config_options_view', $data);

            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }

        public function servers($pagination = '1')
        {
			// Prepare page
			$count = '10';
			$offset = ($count * $pagination) - $count;
			
			// Model ladel.
			$this->load->model('servers_model');
			$data['servers'] = $this->servers_model->get_servers_list($count, $offset);
			
			$data['pagination']['total'] = $this->servers_model->get_total_servers();
			$data['pagination']['current'] = $pagination;
			$data['pagination']['pages'] = ceil($data['pagination']['total'] / $count);
			
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "config";
            $this->load->view('menu_view', $data);
            
			// Pagina laden.
            $this->load->view('config_servers_view', $data);
            
            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }

        public function save($item = NULL) 
        {
            if ($item) {
                if ($item == "proxy") {
                    $this->load->model('config_model');
                    $this->config_model->store_proxy();

                    redirect('config/options/proxy/');
                }
            } else {
                redirect('welcome');
            }
        }

        public function enable($id = NULL)
        {
            if ($id) {
                // Model.
                $this->load->model('servers_model');

                // Check if server exists.
                if ($this->servers_model->check_serverid($id)) {
                    $return = $this->servers_model->enable_server($id);
                }
            }
			
			$this->load->library('user_agent');
			$redirect = $this->agent->referrer();
            redirect($redirect);
        }

        public function disable($id = NULL)
        {
            if ($id) {
                // Model.
                $this->load->model('servers_model');

                // Check if server exists.
                if ($this->servers_model->check_serverid($id)) {
                    $return = $this->servers_model->disable_server($id);
                }
            }
			
			$this->load->library('user_agent');
			$redirect = $this->agent->referrer();
            redirect($redirect);
        }
        
        private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
                redirect('login');
            }
        }
        
    }