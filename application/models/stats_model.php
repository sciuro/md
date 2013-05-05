<?php

    class Stats_model extends CI_Model{
                
		public function update_memory($serverid, $memory, $swap)
		{
			$data = array('id' => $serverid,
							'used' => $memory,
							'swap' => $swap);
			$this->db->insert('stat-memory', $data);
			
			return;
		}
		
		public function update_load($serverid, $avg01, $avg05, $avg15)
		{
			$data = array('id' => $serverid,
							'avg01' => $avg01,
							'avg05' => $avg05,
							'avg15' => $avg15);
			$this->db->insert('stat-load', $data);
			
			return;
		}
		
		public function update_cpu($serverid, $user, $system, $wait)
		{
			$data = array('id' => $serverid,
							'user' => $user,
							'system' => $system,
							'wait' => $wait);
			$this->db->insert('stat-cpu', $data);
			
			return;
		}
		
		public function get_stats_cpu($serverid)
		{
			$this->db->select('unix_timestamp(timestamp)*1000 AS time, user, system, wait');
			$this->db->from('stat-cpu');
			$this->db->where('id', $serverid);
			$this->db->where('timestamp >=', '(NOW() - interval 2 day)', FALSE);
			$this->db->order_by('timestamp', 'ASC');
			
			$query = $this->db->get();
			return $query->result_array();
		}

		public function get_stats_load($serverid)
		{
			$this->db->select('unix_timestamp(timestamp)*1000 AS time, avg01, avg05, avg15');
			$this->db->from('stat-load');
			$this->db->where('id', $serverid);
			$this->db->where('timestamp >=', '(NOW() - interval 2 day)', FALSE);
			$this->db->order_by('timestamp', 'ASC');
			
			$query = $this->db->get();
			return $query->result_array();
		}

		public function get_stats_memory($serverid)
		{
			$this->db->select('unix_timestamp(timestamp)*1000 AS time, round(used/1024,1) as used, round(swap/1024,1) as swap', FALSE);
			$this->db->from('stat-memory');
			$this->db->where('id', $serverid);
			$this->db->where('timestamp >=', '(NOW() - interval 2 day)', FALSE);
			$this->db->order_by('timestamp', 'ASC');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
    }