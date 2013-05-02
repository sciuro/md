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
        
        private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
                redirect('login_view');
            }
        }
        
    }