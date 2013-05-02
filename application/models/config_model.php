<?php

    class Config_model extends CI_Model{

    	public function get_settings()
    	{
    		$this->db->select('name, value');
    		$this->db->from('settings');

    		$query = $this->db->get();

    		foreach ($query->result_array() as $row) {
    			$return[$row['name']] = $row['value'];
    		}

    		return $return;
    	}

		public function store_proxy()
		{
			$data = array('value' => $this->input->post('proxyhost'));
			$this->db->where('name','proxyhost');
			$this->db->update('settings', $data);

			$data = array('value' => $this->input->post('proxyport'));
			$this->db->where('name','proxyport');
			$this->db->update('settings', $data);

			$data = array('value' => $this->input->post('proxytype'));
			$this->db->where('name','proxytype');
			$this->db->update('settings', $data);

			$data = array('value' => $this->input->post('proxyuser'));
			$this->db->where('name','proxyuser');
			$this->db->update('settings', $data);

			$data = array('value' => $this->input->post('proxypassword'));
			$this->db->where('name','proxypassword');
			$this->db->update('settings', $data);

			return;
		}
		
    }