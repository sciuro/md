<?php
    class servers extends CI_Controller {
        
        function __construct(){
            parent::__construct();
            $this->check_isvalidated();
        }
        
		public function index()
		{
			redirect('servers/overview/all');
		}
		
        public function overview($filter = 'all')
        {
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "servers";
            $this->load->view('menu_view', $data);
            
			// Model ladel.
			$this->load->model('servers_model');
			$data['groups'] = $this->servers_model->get_groups();
			foreach ($data['groups'] as $group)
			{
				$groupname = $group['name'];
				$data['servers'][$groupname] = $this->servers_model->get_servers($groupname, $filter);
			}
			
			// Pagina laden.
            $this->load->view('servers_view', $data);
            
            // Als laatste de footer laden.
            $this->load->view('footer_view');
        }
        
		public function show($serverid = NULL, $tab = 'overview')
		{
            // Eerst de header laden.
            $this->load->view('header_view');
            
            // Menu laden.
            $data['page'] = "servers";
            $this->load->view('menu_view', $data);
			
			// Model ladel.
			if ($tab == 'overview') {
				$this->load->model('servers_model');
				$this->load->model('services_model');
				$this->load->model('logbook_model');
				if ($this->servers_model->check_serverid($serverid)) {
					$data['server'] = $this->servers_model->get_server($serverid);
					$data['serverinfo'] = $this->servers_model->get_serverinfo($serverid);
					$data['services'] = $this->services_model->get_services($serverid);
					foreach ($data['services'] as $service) {
						$data['logbook'][$service['id']] = $this->logbook_model->get_lastitem($serverid, $service['id']);
					}
				}
			} elseif ($tab = 'statistics') {
				$this->load->model('servers_model');
				$this->load->model('stats_model');
				if ($this->servers_model->check_serverid($serverid)) {
					$data['server'] = $this->servers_model->get_server($serverid);
					$data['stats_cpu'] = $this->stats_model->get_stats_cpu($serverid);
					$data['stats_load'] = $this->stats_model->get_stats_load($serverid);
					$data['stats_memory'] = $this->stats_model->get_stats_memory($serverid);
				}
				
			}
			
			// View options
			$data['tab'] = $tab;
			
			// Pagina laden.
            $this->load->view('servers_show_view', $data);
		
            // Als laatste de footer laden.
            $this->load->view('footer_view');
		}
		
        private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
                redirect('login');
            }
        }
        
    }