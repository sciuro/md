<?php

    class Services_model extends CI_Model{
                
		public function new_service($serverid, $name)
		{
			$data = array('serverid' => $serverid, 'active' => '1', 'name' => $name);
			$this->db->insert('service', $data);
			return;
		}
		
		public function check_service($serverid, $name)
		{
			$this->db->from('service');
			$this->db->where('serverid', $serverid);
			$this->db->where('name', $name);
			
			$query = $this->db->get();
			
			if ($query->num_rows() == 1)
			{
				return true;
			} else {
				return false;
			}
		}
		
		public function get_serviceid($serverid, $name)
		{
			$this->db->select('id');
			$this->db->from('service');
			$this->db->where('serverid', $serverid);
			$this->db->where('name', $name);
			
			$query = $this->db->get();
			return $query->row_array();

		}
		
		public function get_servicestatus($id)
		{
			$this->db->select('status');
			$this->db->from('status_services');
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function update_service_status($id, $status)
		{
			// Check if service exists in status table
			$this->db->from('status_services');
			$this->db->where('id', $id);
			$query = $this->db->get();
			
			$data = array('id' => $id, 'status' => $status, 'timestamp' => NULL);

			if ($query->num_rows() == 1)
			{
				$this->db->where('id', $id);
				$this->db->update('status_services', $data);
			} else {
				$this->db->insert('status_services', $data);
			}

			return;
		}
		
		public function get_services($serverid)
		{
			$this->db->select('service.id, service.active, status_services.status, service.name, status_services.timestamp');
			$this->db->from('service');
			$this->db->where('serverid', $serverid);
			$this->db->join('status_services', 'service.id=status_services.id', 'left');
			
			$query = $this->db->get();
			return $query->result_array();
		}
    }