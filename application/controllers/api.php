<?php
    class api extends CI_Controller {
        
		public function index()
		{
			redirect('welcome');
		}
		
        public function cron($key = NULL, $option = NULL)
        {
			// Control of key
			if (! is_null($key))
			{
				$this->load->model('api_model');
				$result = $this->api_model->check_key($key);
			
				if (! $result)
				{
					echo "Not authorized!";
				} else {
					$this->update_servers($option);
				}
			} else {
				echo "No key!";
			}
			
        }
        
		private function update_servers($option = NULL)
		{
			// Load settings model
            $this->load->model('config_model');
            $data['setting'] = $this->config_model->get_settings();
			
			// Load server model
			$this->load->model('servers_model');
			$data['servers'] = $this->servers_model->get_servers_cron();
			
			if ($option == 'refresh') {
				echo "<meta http-equiv='refresh' content='60'>";
			}
			
			if ($option == 'debug') {echo "<pre>\n";}
			
			foreach ($data['servers'] as $server)
			{
				if ($option == 'debug') {echo $server['hostname'].": start checking server\n";}
				if ($server['defaultproxy'] == '1') {
					// Override the proxy settings
					if ($option == 'debug') {echo $server['hostname'].": Using default proxy\n";}
					$server['proxyhost'] = $data['setting']['proxyhost'];
					$server['proxyport'] = $data['setting']['proxyport'];
					$server['proxytype'] = $data['setting']['proxytype'];
					$server['proxyuser'] = $data['setting']['proxyuser'];
					$server['proxypassword'] = $data['setting']['proxypassword'];
				}
				
				// Check all the monit servers.
				if ($server['type'] == '1') {
					if ($option == 'debug') {echo $server['hostname'].": Servertype is monit \n";}
					$result = $this->check_server_monit($server['hostname'], $server['port'], $server['username'], $server['password'],$server['proxyhost'] , $server['proxyport'], $server['proxytype'], $server['proxyhost']);
				
					if (! $result) {
						if ($option == 'debug') {echo $server['hostname'].": Connection error\n";}
						// Update server status
						$this->servers_model->update_server_status($server['id'], 'na');
						
						// Update logbook
						$this->save_logitem($server['id'], '', 'na', 'Connection error');
			
					} else {
						if ($option == 'debug') {echo $server['hostname'].": Connection ok \n";}
						$this->parse_server_monit($server, $result, $option);
					}
				} else {
					if ($option == 'debug') {echo $server['hostname'].": Servertype is unknown\n";}
					// Update logbook
					$this->save_logitem($server['id'], '', 'na', 'Servertype is unknown');
					
					// Update server status
					$this->servers_model->update_server_status($server['id'], 'na');
									
				}
			}
			
		}
		
		private function check_server_monit($server, $port, $username = NULL, $password = NULL, $proxyhost = NULL, $proxyport = NULL, $proxytype = NULL, $proxyuser = NULL, $proxypassword = NULL)
		{
			$curl_handle=curl_init();

			curl_setopt($curl_handle,CURLOPT_URL,'http://' . $server . ':' . $port . '/_status?format=xml');
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_TIMEOUT,10);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			if ($username && $password) {
				curl_setopt($curl_handle,CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($curl_handle,CURLOPT_USERPWD, $username . ':' . $password);
			}
			if ($proxyhost && $proxyport && $proxytype) {
				$proxy = $proxyhost.':'.$proxyport;
				curl_setopt($curl_handle,CURLOPT_PROXY, $proxy);
				
				if ($proxytype == 'socks5') {
					curl_setopt($curl_handle,CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
				}
				
				if ($proxyuser && $proxypassword) {
					$proxyauth = $proxyuser.':'.$proxypassword;
					curl_setopt($curl_handle,CURLOPT_PROXYUSERPWD, $proxyauth);
				}
			}
			$buffer = curl_exec($curl_handle);

			if (curl_errno($curl_handle)) {
				return FALSE;
			} else {
				$info = curl_getinfo($curl_handle);
				if ($info['http_code'] != '200') {
					return FALSE;
				} else {
					$return = $buffer;
				}
			}

			curl_close($curl_handle);

			return $return;

		}
		
		private function parse_server_monit($server, $data, $option = NULL)
		{
			if ($option == 'debug') {echo $server['hostname'].": Parsing data\n";}
			$this->load->helper('xml2array');
			$serverdata = xml2array($data);
			
			if ($option == 'showxml') {
				echo "<pre>";
				print_r($serverdata);
				echo "</pre>";
			}

			// In some cases the swapspace is zero, but don't exists in the array.
			if (!isset($serverdata['monit']['platform']['swap'])) {$serverdata['monit']['platform']['swap'] = '0';}
			
			// Update the serverinfo.
			$this->load->model('serverinfo_model');
			$this->serverinfo_model->update($server['id'],
											$serverdata['monit']['platform']['name'],
											$serverdata['monit']['platform']['release'],
											$serverdata['monit']['platform']['machine'],
											$serverdata['monit']['platform']['cpu'],
											$serverdata['monit']['platform']['memory'],
											$serverdata['monit']['platform']['swap']);
			
			// A server is healty at this moment.
			$serverstatus = 'ok';
			
			foreach ($serverdata['monit']['service'] as $service) {
				// Insert new service if not exists.
				$this->load->model('services_model');
				if (!$this->services_model->check_service($server['id'], $service['name'])) {
					$this->services_model->new_service($server['id'], $service['name']);
					if ($option == 'debug') {echo $server['hostname'].": Service ".$service['name']." inserted\n";}
				}
				
				// Get service id number
				$this->load->model('services_model');
				$serviceinfo = $this->services_model->get_serviceid($server['id'], $service['name']);
				
				// check if service is disabled.
				if ($service['monitor'] == '0') {
					if ($option == 'debug') {echo $server['hostname'].": Service ".$service['name']." disabled.\n";}
					$servicestatusmsg = 'Service is set to not monitored';
					$servicestatus = 'na';
				} else {
					// Check if service contains the statistical data.
					if ($service['name'] == $serverdata['monit']['server']['localhostname']) {
						if ($service['system']['cpu']['wait']) {
							$this->save_stats($server['id'],
								$service['system']['load']['avg01'],
								$service['system']['load']['avg05'],
								$service['system']['load']['avg15'],
								$service['system']['cpu']['user'],
								$service['system']['cpu']['system'],
								$service['system']['cpu']['wait'],
								$service['system']['memory']['kilobyte'],
								$service['system']['swap']['kilobyte']);
						} else {
							$this->save_stats($server['id'],
								$service['system']['load']['avg01'],
								$service['system']['load']['avg05'],
								$service['system']['load']['avg15'],
								$service['system']['cpu']['user'],
								$service['system']['cpu']['system'],
								'0',
								$service['system']['memory']['kilobyte'],
								$service['system']['swap']['kilobyte']);
						}
					}

					// If status = 0, then everything is ok.
					if ($service['status'] == '0') {
						if ($option == 'debug') {echo $server['hostname'].": Service ".$service['name']." OK\n";}
						$servicestatus = 'ok';
						$servicestatusmsg = 'Servicestatus changed to ok';
					
					// Warning for special items.
					} elseif ($service['status'] == '2' || $service['status'] == '32768') {
						if ($option == 'debug') {echo $server['hostname'].": Service ".$service['name']." Warning\n";}
						if ($serverstatus != 'error') {$serverstatus = 'warning';}
						$servicestatus = 'warning';
						$servicestatusmsg = $service['status_message'];
						
					// The rest is an error.
					} else {
						if ($option == 'debug') {echo $server['hostname'].": Service ".$service['name']." Error\n";}
						$serverstatus = 'error';
						$servicestatus = 'error';
						$servicestatusmsg = $service['status_message'];
					}
				}
				// Update the servicestatus information
				$this->save_logitem($server['id'], $serviceinfo['id'], $servicestatus, $servicestatusmsg);
				$this->services_model->update_service_status($serviceinfo['id'], $servicestatus);
			}
			
			// Update the server information
			$this->load->model('servers_model');
			
			$this->save_logitem($server['id'], '0', $serverstatus, 'Serverstatus changed to '.$serverstatus);
			$this->servers_model->update_server_status($server['id'], $serverstatus);
			
		}
		
		private function save_logitem($serverid, $serviceid, $status, $message)
		{
			$this->load->model('logbook_model');
			$lastitem = $this->logbook_model->get_lastitem($serverid, $serviceid);

			if ((!$lastitem) || ($lastitem['status'] != $status)) {
				$this->logbook_model->save_logitem($serverid, $serviceid, $status, $message);
			}
		}
		
		private function save_stats($serverid, $avg01, $avg05, $avg15, $user, $system, $wait, $memory, $swap)
		{
			$this->load->model('stats_model');
			$this->stats_model->update_memory($serverid, $memory, $swap);
			$this->stats_model->update_load($serverid, $avg01, $avg05, $avg15);
			$this->stats_model->update_cpu($serverid, $user, $system, $wait);
		}
    }