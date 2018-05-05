<?php

require_once ('/var/www/html/wakeup/DBConfig.php');




function logging($msg = "Error Logging")
{
	// open file
	$fd = fopen("/var/www/html/wakeup/log_wakeups_auto_start.log", "a");
	// append date/time to message
	$str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg;
	// write string
	fwrite($fd, $str . "\n");
	// close file
	fclose($fd);
}

if (isset($argv[1]))
{
	$id = (isset($argv[1])? $argv[1] : '');
	if ($id == '')
	{
		logging('NO Wakeups_ID in crontab file!!');
		exit();
	}

	//Get Info for Special Host ID from DB in EDIT MODE
	$sql = "SELECT DISTINCT hosts_id, hosts_name, hosts_ip, hosts_mac, hosts_groups_id, hosts_wakeups_id, hosts_active, hosts_satellites_id, wakeups_id, wakeups_name, satellites_id, satellites_name, satellites_ip, satellites_user, satellites_pass, satellites_port, groups_active, groups_delay
   		FROM hosts INNER JOIN groups ON hosts_groups_id=groups_id
  		LEFT JOIN wakeups ON wakeups_id=hosts_wakeups_id
		LEFT JOIN satellites ON hosts_satellites_id=satellites_id
		WHERE groups_active = 1
		AND hosts_active = 1
		AND hosts_wakeups_id = $id
		";

	logging($sql);

	$result = mysqli_query($link, $sql);
	if(!$result)
	{
		logging(mysqli_error($link));

		exit();
	}

	//empty hosts List
	$starts_list = '';
	//Loop through each row on array and store the data to $starts_list[]
	while($rows = mysqli_fetch_array($result))
	{
		$starts_list[] = array(
						'hosts_id' => $rows['hosts_id'],
						'hosts_name' => $rows['hosts_name'],
						'hosts_ip' => $rows['hosts_ip'],
						'hosts_mac' => $rows['hosts_mac'],
						'hosts_wakeups_id' => $rows['hosts_wakeups_id'],
						'hosts_active' => $rows['hosts_active'],
						'hosts_groups_id' => $rows['hosts_groups_id'],
						'hosts_satellites_id' => $rows['hosts_satellites_id'],
						'wakeups_id' => $rows['wakeups_id'],
						'wakeups_name' => $rows['wakeups_name'],
						'satellites_id' => $rows['satellites_id'],
						'satellites_name' => $rows['satellites_name'],
						'satellites_ip' => $rows['satellites_ip'],
						'satellites_user' => $rows['satellites_user'],
						'satellites_pass' => $rows['satellites_pass'],
						'satellites_port' => $rows['satellites_port'],
						'groups_delay' => $rows['groups_delay']
						);
	}



	if (!isset($starts_list))
	{
		logging("No active Hosts for Wakeup ID " .$id);
		exit();
	}
	else
	{
		foreach($starts_list as $host)
		{

			if($ssh = ssh2_connect($host["satellites_ip"], $host["satellites_port"]))
			{
				if(ssh2_auth_password($ssh, $host["satellites_user"], $host["satellites_pass"]))
				{
					$stream = ssh2_exec($ssh, 'wakeonlan '. $host['hosts_mac']);
					logging($stream);
					stream_set_blocking($stream, true);
					$data = '';
					while($buffer = fread($stream, 4096))
					{
						$ssh_result = $buffer;

					}
				fclose($stream);
				logging($host["hosts_name"] . '->Satellite: ' . $host["satellites_ip"] . " " . $ssh_result);
				}
				else { logging("Error connecting to satellite Server! " . $host["satellites_ip"] . " Host: " . $host['hosts_ip']); }
			}
			else { logging("Error connecting to satellite Server! " . $host["satellites_ip"] . " Host: " . $host['hosts_ip']); }
			sleep($host["groups_delay"]);
		}
	}
}

?>
