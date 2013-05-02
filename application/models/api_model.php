<?php

    class Api_model extends CI_Model{
                
		public function check_key($key)
		{
			$this->db->count_all();
			$this->db->from('api_key');
			$this->db->where('key', $key);
			$query = $this->db->get('');
			
			if ($query->num_rows() == 1)
			{
				return true;
			} else {
				return false;
			}

		}
		
    }