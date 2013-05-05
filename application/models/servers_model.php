<?php

    class Servers_model extends CI_Model{
        
        function __construct(){
            parent::__construct();
        }
        
		public function get_groups()
		{
			$this->db->select('groups AS name');
			$this->db->from('servers');
			$this->db->where('active', '1');
			$this->db->group_by('groups');
			
			$query = $this->db->get();
			
			return $query->result_array();
		}
		
		public function get_total_servers()
		{
			$count = $this->db->count_all('servers');
			return $count;
		}
		
		public function get_servers($group, $status)
		{
			$this->db->select('servers.id, name, status, timestamp, hostname');
			$this->db->from('servers');
			$this->db->where('active', '1');
			$this->db->where('groups', $group);

			if ($status != 'all' && $status != 'problem') {
				$this->db->where('status', $status);
			} elseif ($status == 'problem') {
				$this->db->where('status !=', 'ok');
			}

			$this->db->join('status', 'servers.id = status.id', 'left');
			$this->db->order_by('name');
			
			$query = $this->db->get();
			
			return $query->result_array();
		}
		
		/*
		Historische info:
select name, status, timestamp, hostname
from servers
left join (select MAX(timestamp) AS timestamp, serverid, serviceid, status from logbook where serviceid = '0' and timestamp < '2013-01-21 13:55:00' group by serverid) logbook
on servers.id = logbook.serverid
where active = '1'
and groups = 'Blueview'
order by timestamp desc
		*/
		
		public function get_servers_list($count, $offset)
		{
			$this->db->select('id, name, hostname, groups, active');
			$this->db->from('servers');
			$this->db->limit($count, $offset);
			$this->db->order_by('groups, name');
			
			$query = $this->db->get();
			
			return $query->result_array();
		}
		
		public function get_servers_cron()
		{
			$this->db->select('id, hostname, port, username, password, type, defaultproxy, proxyhost, proxyport, proxytype, proxyuser, proxypassword');
			$this->db->from('servers');
			$this->db->where('active', '1');
			$this->db->order_by('id');
			
			$query = $this->db->get();
			
			return $query->result_array();			
		}

		public function check_serverid($id)
		{
			$this->db->from('servers');
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			
			if ($query->num_rows() == 1)
			{
				return true;
			} else {
				return false;
			}
		}

		public function get_serverstatus($id)
		{
			$this->db->select('status');
			$this->db->from('status');
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function enable_server($id)
		{
			// Change to active
			$data = array('active' => '1');
			$this->db->where('id', $id);
			$this->db->update('servers', $data); 

			return;
		}

		public function disable_server($id)
		{
			// Change to disable.
			$data = array('active' => '0');
			$this->db->where('id', $id);
			$this->db->update('servers', $data); 

			return;
		}
		
		public function update_server_status($id, $status)
		{
			// Check if service exists in status table
			$this->db->from('status');
			$this->db->where('id', $id);
			$query = $this->db->get();
			
			$data = array('id' => $id, 'status' => $status, 'timestamp' => NULL);

			if ($query->num_rows() == 1)
			{
				$this->db->where('id', $id);
				$this->db->update('status', $data);
			} else {
				$this->db->insert('status', $data);
			}

			return;
		}
		
		public function get_server($id)
		{
			$this->db->select('id, hostname, groups, name, active, type, desc');
			$this->db->from('servers');
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function get_serverinfo($id)
		{
			$this->db->select('id, os, kernel, cputype, cpucount, round(memory/1024/1024, 1) as memory, round(swap/1024/1024, 1) as swap, timestamp', FALSE);
			$this->db->from('serverinfo');
			$this->db->where('id', $id);
			$this->db->order_by('timestamp', 'DESC');
			
			$query = $this->db->get();
			return $query->row_array();
		}
		
    }