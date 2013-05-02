<?php

    class Serverinfo_model extends CI_Model{
                
		public function update($id, $os, $kernel, $cputype, $cpucount, $memory, $swap)
		{
			$serverdata = array('id' => $id,
								'os' => $os,
								'kernel' => $kernel,
								'cputype' => $cputype,
								'cpucount' => $cpucount,
								'memory' => $memory,
								'swap' => $swap
								);

			$this->db->from('serverinfo');
			$this->db->where('timestamp = (select MAX(timestamp) from serverinfo where id = "'.$id.'")', NULL, FALSE);
			$this->db->where($serverdata);

			$query = $this->db->get();
			
			if ($query->num_rows() == 0) {
				$this->db->insert('serverinfo', $serverdata);
			}

			return;

		}
		
    }