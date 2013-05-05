<?php

    class Logbook_model extends CI_Model{

    	public function get_logbook($count, $offset)
    	{
			$this->db->select('logbook.id, logbook.timestamp, logbook.serverid, servers.name AS servername, servers.groups, logbook.serviceid, service.name AS servicename, logbook.status, logbook.message');
			$this->db->from('logbook');
			$this->db->join('servers', 'logbook.serverid = servers.id');
			$this->db->join('service', 'logbook.serviceid = service.id', 'left');
			$this->db->where('logbook.serviceid !=' , '0');
			$this->db->limit($count, $offset);
			$this->db->order_by('timestamp', 'desc');
			
			$query = $this->db->get();
			
			return $query->result_array();
    	}
		
		public function get_total_logitems()
		{
			$count = $this->db->count_all('logbook');
			return $count;
		}
		
		public function save_logitem($serverid, $serviceid, $status, $message)
		{
			$data = array('serverid' => $serverid, 'serviceid' => $serviceid, 'status' => $status, 'message' => $message);
			
			$this->db->insert('logbook', $data);
		}
		
		public function get_lastitem($serverid, $serviceid)
		{
			$this->db->select('logbook.status, logbook.message, logbook.timestamp');
			$this->db->from('logbook');
			$this->db->where('serverid', $serverid);
			$this->db->where('serviceid', $serviceid);
			//$this->db->limit('0', '1');
			$this->db->order_by('timestamp', 'desc');
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
    }