<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);


/*crontab Operators

There are multiple ways of specifying several date/time values in a field:

    The comma(,) specifies a list of values, for example: "1,3,4,7,8"
    The dash(-) specifies a range. Example: "1-6", which is equivalent to "1,2,3,4,5,6"
    The asterisk(*) operator specifies all possible values for a field. For example, an asterisk in the hour time field would be the same as 'every hour'.

There is also an operator which some extended versions of cron support, the slash(/) operator, which can be used to skip a given number of values. For example, "*"/3" in the hour time field is equivalent to "0,3,6,9,12,15,18,21". So "*" specifies 'every hour' but the "*"/3" means only those hours divisible by 3.

Example: the following will clear the Apache error log at one minute past midnight each day.

    01 00 * * * echo "" > /www/apache/logs/error_log

Fields

 .---------------- minute (0 - 59)
 |  .------------- hour (0 - 23)
 |  |  .---------- day of month (1 - 31)
 |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
 |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7)  OR sun,mon,tue,wed,thu,fri,sat
 |  |  |  |  |
 *  *  *  *  *  <command to be executed>
 */



require_once ('DBConfig.php');

//ini_set('display_errors', '1');

//for DEbug use

//HOstsKick Escape Chars
if (isset($_POST['hosts_id'])) { $hosts_id = mysqli_real_escape_string($link, strip_tags($_POST['hosts_id'])); }
if (isset($_POST['hosts_name'])) { $hosts_name = mysqli_real_escape_string($link, strip_tags($_POST['hosts_name'])); }
if (isset($_POST['hosts_ip'])) { $hosts_ip = mysqli_real_escape_string($link, strip_tags($_POST['hosts_ip'])); }
if (isset($_POST['hosts_mac'])) { $hosts_mac = mysqli_real_escape_string($link, strip_tags($_POST['hosts_mac'])); }
if (isset($_POST['hosts_wakeups_id'])) { $hosts_wakeups_id = mysqli_real_escape_string($link, strip_tags($_POST['hosts_wakeups_id'])); }
if (isset($_POST['hosts_satellites_id'])) { $hosts_satellites_id = mysqli_real_escape_string($link, strip_tags($_POST['hosts_satellites_id'])); }
if (isset($_POST['hosts_active'])) { $hosts_active = mysqli_real_escape_string($link, strip_tags($_POST['hosts_active'])); }
if (isset($_POST['hosts_groups_id'])) { $hosts_groups_id = mysqli_real_escape_string($link, strip_tags($_POST['hosts_groups_id'])); }
//Groups Kick Escape Chars
if (isset($_POST['groups_id'])) { $groups_id = mysqli_real_escape_string($link, strip_tags($_POST['groups_id'])); }
if (isset($_POST['groups_name'])) { $groups_name = mysqli_real_escape_string($link, strip_tags($_POST['groups_name'])); }
if (isset($_POST['groups_desc'])) { $groups_desc = mysqli_real_escape_string($link, strip_tags($_POST['groups_desc'])); }
if (isset($_POST['groups_wakeups_id'])) { $groups_wakeups_id = mysqli_real_escape_string($link, strip_tags($_POST['groups_wakeups_id'])); }
if (isset($_POST['groups_active'])) { $groups_active = mysqli_real_escape_string($link, strip_tags($_POST['groups_active'])); }
if (isset($_POST['groups_delay'])) { $groups_delay = mysqli_real_escape_string($link, strip_tags($_POST['groups_delay'])); }
//Wakeups Kick Escape Chars
if (isset($_POST['wakeups_id'])) { $wakeups_id = mysqli_real_escape_string($link, strip_tags($_POST['wakeups_id'])); }
if (isset($_POST['wakeups_name'])) { $wakeups_name = mysqli_real_escape_string($link, strip_tags($_POST['wakeups_name'])); }
if (isset($_POST['wakeups_desc'])) { $wakeups_desc = mysqli_real_escape_string($link, strip_tags($_POST['wakeups_desc'])); }
if (isset($_POST['wakeups_code'])) { $wakeups_code = mysqli_real_escape_string($link, strip_tags($_POST['wakeups_code'])); }

//SAtellites Kick ESCApe Chars
if (isset($_POST['satellites_id'])) { $satellites_id = mysqli_real_escape_string($link, strip_tags($_POST['satellites_id'])); }
if (isset($_POST['satellites_name'])) { $satellites_name = mysqli_real_escape_string($link, strip_tags($_POST['satellites_name'])); }
if (isset($_POST['satellites_desc'])) { $satellites_desc = mysqli_real_escape_string($link, strip_tags($_POST['satellites_desc'])); }
if (isset($_POST['satellites_ip'])) { $satellites_ip = mysqli_real_escape_string($link, strip_tags($_POST['satellites_ip'])); }
if (isset($_POST['satellites_submask'])) { $satellites_submask = mysqli_real_escape_string($link, strip_tags($_POST['satellites_submask'])); }
if (isset($_POST['satellites_user'])) { $satellites_user = mysqli_real_escape_string($link, strip_tags($_POST['satellites_user'])); }
if (isset($_POST['satellites_pass'])) { $satellites_pass = mysqli_real_escape_string($link, strip_tags($_POST['satellites_pass'])); }
if (isset($_POST['satellites_port'])) { $satellites_port = mysqli_real_escape_string($link, strip_tags($_POST['satellites_port'])); }



//---------------------------------------------------------------
//Insert or Update Host/Groups/Wakeups(with crontab) information TO SQL
//
if(isset($_POST['action_type']))
{
	if ($_POST['action_type'] == 'add_host'
		or $_POST['action_type'] == 'edit_host'
		or $_POST['action_type'] == 'edit_group'
		or $_POST['action_type'] == 'add_group'
		or $_POST['action_type'] == 'edit_wakeup'
		or $_POST['action_type'] == 'add_wakeup'
		or $_POST['action_type'] == 'edit_satellite'
		or $_POST['action_type'] == 'add_satellite')
	{

		//---------------------------------------------------------------
		//NEWHOST+EDITHOST
		//
		if ($_POST['action_type'] == 'edit_host')
		{
		//transfer Checkbox in bools
		if (isset($hosts_active) and ($hosts_active == 'on')) {$hosts_active = 1;}
		else {$hosts_active = 0;}

			$sql = "UPDATE hosts SET
					hosts_name = '$hosts_name',
					hosts_ip = '$hosts_ip',
					hosts_mac = '$hosts_mac',
					hosts_wakeups_id = '$hosts_wakeups_id',
					hosts_satellites_id = '$hosts_satellites_id',
					hosts_active = '$hosts_active',
					hosts_groups_id = '$hosts_groups_id'
					WHERE hosts_id = '$hosts_id'
					";

		}
		if ($_POST['action_type'] == 'add_host')
		{
			//transfer Checkbox in bools
			if (isset($hosts_active) and ($hosts_active == 'on')) {$hosts_active = 1;}
			else {$hosts_active = 0;}

			$sql = "INSERT INTO hosts SET
					hosts_name = '$hosts_name',
					hosts_ip = '$hosts_ip',
					hosts_mac = '$hosts_mac',
					hosts_wakeups_id = '$hosts_wakeups_id',
					hosts_active = '$hosts_active',
					hosts_satellites_id = '$hosts_satellites_id',
					hosts_groups_id = '$hosts_groups_id'
					";
		}
		//
		//END NewHost+EDITHOST
		//---------------------------------------------------------------


		//---------------------------------------------------------------
		//NewGroup+EDITGROUP
		//
		if ($_POST['action_type'] == 'edit_group')
		{

			//transfer Checkbox in bools
			if (isset($groups_active) and ($groups_active == 'on')) {$groups_active = 1;}
			else {$groups_active = 0;}

			$sql = "UPDATE groups SET
					groups_name = '$groups_name',
					groups_desc = '$groups_desc',
					groups_wakeups_id = '$groups_wakeups_id',
					groups_active = '$groups_active',
					groups_delay = '$groups_delay'
					WHERE groups_id = '$groups_id'
					";

		}
		if ($_POST['action_type'] == 'add_group')
		{

			//transfer Checkbox in bools
			if (isset($groups_active) and ($groups_active == 'on')) {$groups_active = 1;}
			else {$groups_active = 0;}

			$sql = "INSERT INTO groups SET
					groups_name = '$groups_name',
					groups_desc = '$groups_desc',
					groups_wakeups_id = '$groups_wakeups_id',
					groups_delay = '$groups_delay',
					groups_active = '$groups_active'
					";
		}
		//
		//END NewGroup+EDITGROUP
		//---------------------------------------------------------------


		//---------------------------------------------------------------
		//NEWwakeup+Editwakeup SQL
		//
		if ($_POST['action_type'] == 'edit_wakeup')
		{

			$sql = "UPDATE wakeups SET
					wakeups_name = '$wakeups_name',
					wakeups_desc = '$wakeups_desc',
					wakeups_code = '$wakeups_code'
					WHERE wakeups_id = '$wakeups_id'
					";

			//get last wakeup Code from DB
			$sql_read_wakeups_code = "SELECT wakeups_code FROM wakeups WHERE wakeups_id = '$wakeups_id'";
			$result_read_wakeups_code = mysqli_query($link, $sql_read_wakeups_code);
			if(!$result_read_wakeups_code)
			{
				echo mysqli_error($link);
				exit();
			}

			while($rows = mysqli_fetch_array($result_read_wakeups_code))
			{
				$read_wakeups_code = $rows['wakeups_code'];
			}

			//write crontab www-data user
			$output = shell_exec('crontab -l');
			$cron_file = "/tmp/crontab.txt";
			$cron_remove_temp = $read_wakeups_code . ' /usr/bin/php -q /var/www/html/wakeup/start_wakeup.php ' . $wakeups_id . ' >> /var/www/html/wakeup/log_wakeups_auto_start.log';
			//find and replace old line with ""
			$output= str_replace($cron_remove_temp."\n", "", $output);
			//delete empty lines
			$output = preg_replace('/^\h*\v+/m', '', $output);
			//add new line with updated data
			$cron_add = $wakeups_code . ' /usr/bin/php -q /var/www/html/wakeup/start_wakeup.php ' . $wakeups_id . ' >> /var/www/html/wakeup/log_wakeups_auto_start.log';
			file_put_contents($cron_file, $output.$cron_add.PHP_EOL);
			echo exec("crontab $cron_file");

		}


		//CRONJOB WAKEUP edit/delete user wwww-data
		if ($_POST['action_type'] == 'add_wakeup')
		{
			//normal SQL insert
			$sql = "INSERT INTO wakeups SET
					wakeups_name = '$wakeups_name',
					wakeups_desc = '$wakeups_desc',
					wakeups_code = '$wakeups_code'
					";

		}


		//---------------------------------------------------------------
		//NewSatellite+EDITSatellite
		//
		if ($_POST['action_type'] == 'edit_satellite')
		{

			//Check if PW is edited
			//PW was not edited by user if dummypassk is in variable
			if ($satellites_pass == 'dummypasskk')
			{
				$sql =  $sql = "UPDATE satellites SET
                                        satellites_name = '$satellites_name',
                                        satellites_desc = '$satellites_desc',
                                        satellites_ip = '$satellites_ip',
                                        satellites_submask = '$satellites_submask',
                                        satellites_user = '$satellites_user',
                                        satellites_port = '$satellites_port'
                                        WHERE satellites_id = '$satellites_id'
                                        ";
			}
			else
			{

				$sql = "UPDATE satellites SET
					satellites_name = '$satellites_name',
					satellites_desc = '$satellites_desc',
					satellites_ip = '$satellites_ip',
					satellites_submask = '$satellites_submask',
					satellites_user = '$satellites_user',
					satellites_pass = '$satellites_pass',
					satellites_port = '$satellites_port'
					WHERE satellites_id = '$satellites_id'
					";
			}
		}
		if ($_POST['action_type'] == 'add_satellite')
		{

			$sql = "INSERT INTO satellites SET
					satellites_name = '$satellites_name',
					satellites_desc = '$satellites_desc',
					satellites_ip = '$satellites_ip',
					satellites_submask = '$satellites_submask',
					satellites_user = '$satellites_user',
					satellites_pass = '$satellites_pass',
					satellites_port = '$satellites_port'
					";
		}


		//
		//END NewSatellite+EDITSatellite
		//---------------------------------------------------------------


	if (!mysqli_query($link, $sql))
	{
		echo 'Error Saving Data. ' . mysqli_error($link);
		exit();
	}

	//Wakeup again for LAST_ID
	if ($_POST['action_type'] == 'add_wakeup')
		{

			$last_id = mysqli_insert_id($link);

			//write crontab www-data user
			$output = shell_exec('crontab -l');
			//delete empty lines
			$output = preg_replace('/^\h*\v+/m', '', $output);
			$cron_file = "/tmp/crontab.txt";
			$wakeups_code_temp = $wakeups_code . ' /usr/bin/php -q /var/www/html/wakeup/start_wakeup.php ' . $last_id . ' >> /var/www/html/wakeup/log_wakeups_auto_start.log';

			file_put_contents($cron_file, $output.$wakeups_code_temp.PHP_EOL);
			echo exec("crontab $cron_file");
		}
		//
		//END Newwakeup+Editwakeup SQL
		//--------------------------------------------------------------
	}
}
//
//End Insert or Update host information
//---------------------------------------------------------------


//---------------------------------------------------------------
//Start of edit/newhost  for update.php Entry read
//
//DEclare GlobalVars
$gresult_hosts = '';
if (isset($_POST["action_host"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	if ($_POST["action_host"] == 'edit_host')
	{
		//Get Info for Special Host ID from DB in EDIT MODE
		$sql = "SELECT hosts_id, hosts_name, hosts_ip, hosts_mac, hosts_wakeups_id, hosts_satellites_id, hosts_active, hosts_groups_id, groups_id, groups_name, wakeups_id, wakeups_name
				FROM hosts,groups,wakeups,satellites
				WHERE hosts_groups_id = groups_id
				AND hosts_wakeups_id = wakeups_id
				AND hosts_satellites_id = satellites_id
				AND hosts_id = " . $id . "
				";

		$result = mysqli_query($link, $sql);

		if(!$result)
		{
			echo mysqli_error($link);
			exit();
		}

	$gresult_hosts = mysqli_fetch_array($result);
	}

	//$gresult_hosts fill with '' for new hosts add
	if ($_POST["action_host"] == 'add_host')
	{
		$gresult_hosts["hosts_name"] = '';
		$gresult_hosts["hosts_ip"] = '';
		$gresult_hosts["hosts_mac"] = '';
		$gresult_hosts["hosts_groups_id"] = '';
		$gresult_hosts["hosts_wakeups_id"] = '';
		$gresult_hosts["hosts_satellites_id"] = '';
		$gresult_hosts["hosts_active"] = '0';
	}

	//read table groups for EDIT
	$sql = "SELECT groups_id, groups_name, groups_wakeups_id FROM groups";

	$gresult_groups = mysqli_query($link, $sql);

	if(!$gresult_groups)
	{
		echo mysqli_error($link);
		exit();
	}

	//read table wakeups for EDIT
	$sql = "SELECT wakeups_id, wakeups_name,wakeups_desc,wakeups_code FROM wakeups";

	$gresult_wakeups = mysqli_query($link, $sql);

	if(!$gresult_wakeups)
	{
		echo mysqli_error($link);
		exit();
	}

	//read table satellites for EDIT
	$sql = "SELECT satellites_id, satellites_name FROM satellites";

	$gresult_satellites = mysqli_query($link, $sql);

	if(!$gresult_satellites)
	{
		echo mysqli_error($link);
		exit();
	}

	include ('update_host.php');
	exit();
}


//
//ADD-EDIT GROUPS PAGE LIST
//
//declare Global groups
$gresult_groups = '';
if (isset($_POST["action_group"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	if ($_POST["action_group"] == 'edit_group')
	{
		//Get Info for Special Host ID from DB in EDIT MODE
		$sql = "SELECT groups_id, groups_name,groups_desc,groups_wakeups_id, groups_active, groups_delay ,wakeups_id,wakeups_name
				FROM groups
				INNER JOIN wakeups
				ON groups_wakeups_id = wakeups_id
				WHERE groups_id = " . $id . "
				";

		$result = mysqli_query($link, $sql);

		if(!$result)
		{
			echo mysqli_error($link);
			exit();
		}

		//Fetch for Edit Group here
		while($row = mysqli_fetch_array($result))
		{
			$gresult_groups["groups_id"] = $row["groups_id"];
			$gresult_groups["groups_name"] = $row["groups_name"];
			$gresult_groups["groups_desc"] = $row["groups_desc"];
			$gresult_groups["groups_wakeups_id"] = $row["groups_wakeups_id"];
			$gresult_groups["groups_active"] = $row["groups_active"];
			$gresult_groups["groups_delay"] = $row["groups_delay"];
		}
	}

	//if not edit_group, must be add group, but check
	else
	{
		//$gresult_groups fill with '' for new groups add
		if ($_POST["action_group"] == 'add_group')
		{
			$gresult_groups["groups_name"] = '';
			$gresult_groups["groups_desc"] = '';
			$gresult_groups["groups_wakeups_id"] = '';
			$gresult_groups["groups_active"] = '';
			$gresult_groups["groups_delay"] = '';
		}
	}

	//read table wakeups for EDIT group
	$sql = "SELECT wakeups_id, wakeups_name,wakeups_desc,wakeups_code FROM wakeups";
	$gresult_wakeups = mysqli_query($link, $sql);
	if(!$gresult_wakeups)
	{
		echo mysqli_error($link);
		exit();
	}

	include ('update_group.php');
	exit();
}

//
//end of read
//---------------------------------------------------------------



//
//ADD-EDIT WAKEUPS PAGE LIST
//
//declare Global groups
$gresult_wakeups = '';
if (isset($_POST["action_wakeup"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	if ($_POST["action_wakeup"] == 'edit_wakeup')
	{
		//Get Info for Special Host ID from DB in EDIT MODE
		$sql = "SELECT wakeups_id, wakeups_name, wakeups_desc, wakeups_code
				FROM wakeups
				WHERE wakeups_id = " . $id . "
				";

		$result = mysqli_query($link, $sql);

		if(!$result)
		{
			echo mysqli_error($link);
			exit();
		}

		//Fetch for Edit Group here
		while($row = mysqli_fetch_array($result))
		{
			$gresult_wakeups["wakeups_id"] = $row["wakeups_id"];
			$gresult_wakeups["wakeups_name"] = $row["wakeups_name"];
			$gresult_wakeups["wakeups_desc"] = $row["wakeups_desc"];
			$gresult_wakeups["wakeups_code"] = $row["wakeups_code"];
		}
	}

	//if not edit_group, must be add group, but check
	else
	{
		//$gresult_groups fill with '' for new groups add
		if ($_POST["action_wakeup"] == 'add_wakeup')
		{
			$gresult_wakeups["wakeups_id"] = '';
			$gresult_wakeups["wakeups_name"] = '';
			$gresult_wakeups["wakeups_desc"] = '';
			$gresult_wakeups["wakeups_code"] = '';
		}
	}
include_once('update_wakeup.php');
exit();
}
//end of read
//---------------------------------------------------------------


//
//ADD-EDIT SATELLITE PAGE LIST
//
$gresult_satellites = '';
if (isset($_POST["action_satellite"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	if ($_POST["action_satellite"] == 'edit_satellite')
	{
		//Get Info for Special Host ID from DB in EDIT MODE
		$sql = "SELECT satellites_id, satellites_name, satellites_desc, satellites_ip, satellites_submask, satellites_user, satellites_pass, satellites_port
				FROM satellites
				WHERE satellites_id = " . $id . "
				";

		$result = mysqli_query($link, $sql);

		if(!$result)
		{
			echo mysqli_error($link);
			exit();
		}

		//Fetch for Edit Group here
		while($row = mysqli_fetch_array($result))
		{
			$gresult_satellites["satellites_id"] = $row["satellites_id"];
			$gresult_satellites["satellites_name"] = $row["satellites_name"];
			$gresult_satellites["satellites_desc"] = $row["satellites_desc"];
			$gresult_satellites["satellites_ip"] = $row["satellites_ip"];
			$gresult_satellites["satellites_submask"] = $row["satellites_submask"];
			$gresult_satellites["satellites_user"] = $row["satellites_user"];
			$gresult_satellites["satellites_pass"] = $row["satellites_pass"];
			$gresult_satellites["satellites_port"] = $row["satellites_port"];
		}
	}
	//if not edit_group, must be add group, but check
	else
	{
		//$gresult_groups fill with '' for new groups add
		if ($_POST["action_satellite"] == 'add_satellite')
		{
			$gresult_satellites["satellites_id"] = '';
			$gresult_satellites["satellites_name"] = '';
			$gresult_satellites["satellites_desc"] = '';
			$gresult_satellites["satellites_ip"] = '';
			$gresult_satellites["satellites_submask"] = '';
			$gresult_satellites["satellites_user"] = '';
                        $gresult_satellites["satellites_pass"] = '';
                        $gresult_satellites["satellites_port"] = '';

		}
	}

	//read table wakeups for EDIT group

	include ('update_satellite.php');
	exit();
}

//
//end of read
//---------------------------------------------------------------





//---------------------------------------------------------------
//HOST delete in Hostlist START

if(isset($_POST["delete_host"]) and $_POST["delete_host"]=="delete_host"){
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	$sql = "DELETE FROM hosts
			WHERE hosts_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

}
//
//HOST delete in Hostlist END
//---------------------------------------------------------------

//---------------------------------------------------------------
//GROUP delete in Grouplist START
if(isset($_POST["delete_group"]) and $_POST["delete_group"]=="delete_group")
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	//check ob noch Hosts in dieser Gruppe sind
	//!!!!!!!!active check noch!!!!?????????
	$sql = "SELECT hosts_id, hosts_name, hosts_ip
			FROM groups, hosts
			WHERE hosts_groups_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	while($rows = mysqli_fetch_array($result))
	{
		$delete_group_list[] = array(
						'hosts_id' => $rows['hosts_id'],
						'hosts_name' => $rows['hosts_name'],
						'hosts_ip' => $rows['hosts_ip']
						);
	}




	if (isset($delete_group_list[0]["hosts_id"]))
	{

		echo "There are Hosts in Group-ID " . $id . ".<br> Please delete/edit the following Hosts first, before deleting the Group: <br><br>";
		foreach ($delete_group_list as $deleti)
		{
			echo "Host: " . $deleti["hosts_id"] . " " . $deleti["hosts_name"] . " " . $deleti["hosts_ip"];
			echo "<br>";
		}
		exit();
	}



	$sql = "DELETE FROM groups
			WHERE groups_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

}
//
//GROUP delete in GroupList END
//-------------


//---------------------------------------------------------------
//WAKEUP delete in Wakeuplist START
if(isset($_POST["delete_wakeup"]) and $_POST["delete_wakeup"]=="delete_wakeup")
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	//check if hosts in this Wakeup

	$sql = "SELECT groups_id, groups_name, wakeups_id, wakeups_code, wakeups_name
			FROM groups, wakeups
			WHERE groups_wakeups_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	while($rows = mysqli_fetch_array($result))
	{
		$delete_wakeup_list[] = array(
						'groups_id' => $rows['groups_id'],
						'groups_name' => $rows['groups_name'],
						'wakeups_id' => $rows['wakeups_id'],
						'wakeups_code' => $rows['wakeups_code'],
						'wakeups_name' => $rows['wakeups_name']
						);
	}
	//var_dump($delete_wakeup_list);
	//exit();

	if (isset($delete_wakeup_list[0]["groups_id"]))
	{

		echo "There are Groups in Wakeup-ID " . $id . ".<br> Please delete/edit the following Groups first, before deleting the Wakeup: <br><br>";
		foreach ($delete_wakeup_list as $deleti)
		{
			echo "Group: " . $deleti["groups_id"] . " " . $deleti["groups_name"];
			echo "<br>";
		}
		exit();
	}

	//Get Wakeups infos for deleting
	$sql = "SELECT wakeups_id, wakeups_code, wakeups_name
			FROM wakeups
			WHERE wakeups_id = " . $id . "
			";


	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//clear array
	$delete_wakeup_list = '';

	while($rows = mysqli_fetch_array($result))
	{
		$delete_wakeup_list[] = array(
						'wakeups_code' => $rows['wakeups_code'],
						'wakeups_name' => $rows['wakeups_name']
						);
	}

	//delete crontab www-data user
	$output = shell_exec('crontab -l');
	$cron_file = "/tmp/crontab.txt";
	$wakeups_code_temp = $delete_wakeup_list[0]["wakeups_code"] . ' /usr/bin/php -q /var/www/html/wakeup/start_wakeup.php ' . $id . ' >> /var/www/html/wakeup/log_wakeups_auto_start.log'; // . $delete_wakeup_list[0]["wakeups_name"];
	$remove_cron = str_replace($wakeups_code_temp."\n", "", $output);
	//delete empty rows
	$remove_cron = preg_replace('/^\h*\v+/m', '', $remove_cron);
	file_put_contents($cron_file, $remove_cron.PHP_EOL);
	echo exec("crontab $cron_file");

	//delete wakeup from DB
	$sql = "DELETE FROM wakeups
			WHERE wakeups_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}
}
//
//WAKEUP delete in Wakeuplist END
//-------------
//------------------------------------------------------------



//---------------------------------------------------------------
//SATELLITE delete in Satellitelist START
if(isset($_POST["delete_satellite"]) and $_POST["delete_satellite"]=="delete_satellite")
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');

	//check if hosts in Satellite
	$sql = "SELECT hosts_id, hosts_name, hosts_ip
			FROM satellites, hosts
			WHERE hosts_satellites_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	while($rows = mysqli_fetch_array($result))
	{
		$delete_satellite_list[] = array(
						'hosts_id' => $rows['hosts_id'],
						'hosts_name' => $rows['hosts_name'],
						'hosts_ip' => $rows['hosts_ip']
						);
	}

	if (isset($delete_satellite_list[0]["hosts_id"]))
	{

		echo "There are Hosts in Satellite-ID " . $id . ".<br> Please delete the following Hosts first, before deleting the Satellite: <br><br>";
		foreach ($delete_satellite_list as $deleti)
		{
			echo "Host: " . $deleti["hosts_id"] . " " . $deleti["hosts_name"] . " " . $deleti["hosts_ip"];
			echo "<br>";
		}
		exit();
	}

	$sql = "DELETE FROM satellites
			WHERE satellites_id = " . $id . "
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

}
//
//SATELLITE delete in SatelliteList END
//--------------------------------------------



//---------------------------------------------------------------
//Read hosts information from database for hostlist.php
//
$sql = "SELECT
		hosts_id, hosts_name, hosts_ip, hosts_mac, hosts_wakeups_id, hosts_satellites_id, hosts_active, hosts_groups_id, groups_id, groups_name, wakeups_id, wakeups_name, satellites_id, satellites_name 
		FROM
		hosts, groups, wakeups, satellites
		WHERE
		hosts_groups_id = groups_id
		AND
		hosts_wakeups_id = wakeups_id
		AND
		hosts_satellites_id = satellites_id
		ORDER by hosts_name";

$result = mysqli_query($link, $sql);
if(!$result)
{
	echo mysqli_error($link);
	exit();
}

//Loop through each row on array and store the data to $hosts_list[]
while($rows = mysqli_fetch_array($result))
{
	$hosts_list[] = array(
						'hosts_id' => $rows['hosts_id'],
						'hosts_name' => $rows['hosts_name'],
						'hosts_ip' => $rows['hosts_ip'],
						'hosts_mac' => $rows['hosts_mac'],
						'hosts_wakeups_id' => $rows['hosts_wakeups_id'],
						'hosts_active' => $rows['hosts_active'],
						'hosts_groups_id' => $rows['hosts_groups_id'],
						'hosts_satellites_id' => $rows['hosts_satellites_id'],
						'groups_id' => $rows['groups_id'],
						'groups_name' => $rows['groups_name'],
						'wakeups_id' => $rows['wakeups_id'],
						'wakeups_name' => $rows['wakeups_name'],
						'satellites_id' => $rows['satellites_id'],
						'satellites_name' => $rows['satellites_name']
						);
}


//read Groups information from DB
//declare global

$sql = "SELECT groups_id, groups_name, groups_desc, groups_wakeups_id,groups_active,groups_delay,wakeups_id,wakeups_name
		FROM groups, wakeups
		WHERE
		groups_wakeups_id = wakeups_id
		";

$result = mysqli_query($link, $sql);

if(!$result)
{
	echo mysqli_error($link);
	exit();
}

while($rows = mysqli_fetch_array($result))
{
	$groups_list[] = array(
							'groups_id' => $rows['groups_id'],
							'groups_name' => $rows['groups_name'],
							'groups_desc' => $rows['groups_desc'],
							'groups_wakeups_id' => $rows['groups_wakeups_id'],
							'groups_delay' => $rows['groups_delay'],
							'groups_active' => $rows['groups_active'],
							'wakeups_id' => $rows['wakeups_id'],
							'wakeups_name' => $rows['wakeups_name']
							);

}

//read Wakeups information from DB
//declare Global
$sql = "SELECT wakeups_id, wakeups_name,wakeups_desc,wakeups_code FROM wakeups";

$result = mysqli_query($link, $sql);

if(!$result)
{
	echo mysqli_error($link);
	exit();
}

//Loop through each row on array and store the data to $groups_list[]
while($rows = mysqli_fetch_array($result))
{
	$wakeups_list[] = array('wakeups_id' => $rows['wakeups_id'],
							'wakeups_name' => $rows['wakeups_name'],
							'wakeups_desc' => $rows['wakeups_desc'],
							'wakeups_code' => $rows['wakeups_code']
							);

}

//read Satelittes info from DB

$sql = "SELECT satellites_id, satellites_name, satellites_desc, satellites_ip, satellites_submask, satellites_user, satellites_pass, satellites_port
		FROM satellites
		";

$result = mysqli_query($link, $sql);

if(!$result)
{
	echo mysqli_error($link);
	exit();
}

while($rows = mysqli_fetch_array($result))
{
	$satellites_list[] = array(
							'satellites_id' => $rows['satellites_id'],
							'satellites_name' => $rows['satellites_name'],
							'satellites_desc' => $rows['satellites_desc'],
							'satellites_ip' => $rows['satellites_ip'],
							'satellites_submask' => $rows['satellites_submask'],
							'satellites_user' => $rows['satellites_user'],
                                                        'satellites_pass' => $rows['satellites_pass'],
                                                        'satellites_port' => $rows['satellites_port']

							);
}
//
//Read information from database
//---------------------------------------------------------------


//Start HOST STUFF
//declare Global
$ssh_result = '';
$start_host = '';
function start_host($id_start_host = NULL)
{

	global $link, $start_host, $ssh_result; // $ssh_port, $ssh_user, $ssh_pass;

	if ($id_start_host == NULL) {
		echo "Iidi";
		exit();
	}

	$sql = "SELECT DISTINCT satellites_id, satellites_name, satellites_desc, satellites_ip, satellites_submask, satellites_user, satellites_pass, satellites_port, hosts_name, hosts_mac, hosts_id, hosts_ip, hosts_satellites_id
			FROM satellites, hosts
			WHERE hosts_satellites_id = satellites_id
			AND hosts_id = $id_start_host;
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$start_host = '';

	while($rows = mysqli_fetch_array($result))
	{
		$start_host[] = array(
							'satellites_id' => $rows['satellites_id'],
							'satellites_name' => $rows['satellites_name'],
							'satellites_desc' => $rows['satellites_desc'],
							'satellites_ip' => $rows['satellites_ip'],
							'satellites_submask' => $rows['satellites_submask'],
							'satellites_user' => $rows['satellites_user'],
                                                        'satellites_pass' => $rows['satellites_pass'],
                                                        'satellites_port' => $rows['satellites_port'],
							'hosts_id' => $rows['hosts_id'],
							'hosts_name' => $rows['hosts_name'],
							'hosts_ip' => $rows['hosts_ip'],
							'hosts_mac' => $rows['hosts_mac'],
							'hosts_satellites_id' => $rows['hosts_satellites_id']
							);
	}

	if (!isset($start_host[0]["satellites_ip"]))
	{
		echo "No Entries in Hosts Starts";
		exit();
	}

	if($ssh = ssh2_connect($start_host[0]["satellites_ip"], $start_host[0]["satellites_port"]))
	{
		if(ssh2_auth_password($ssh, $start_host[0]["satellites_user"], $start_host[0]["satellites_pass"]))
		{

			$stream = ssh2_exec($ssh, 'wakeonlan '. $start_host[0]['hosts_mac']);
			stream_set_blocking($stream, true);
			$data = '';
			while($buffer = fread($stream, 4096))
			{
				$ssh_result .= $buffer;
			}
		fclose($stream);
		}
	}
}

//START HOST
if (isset($_POST["start_host"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');
	start_host($id);
}

//START GROUPE
if (isset($_POST["start_group"]))
{
	$id_start_group = (isset($_POST["ci"])? $_POST["ci"] : '');

	global $link, $start_host, $ssh_result;// $ssh_port, $ssh_user, $ssh_pass;

	$sql = "SELECT hosts_id,groups_delay
			FROM hosts,groups
			WHERE hosts_groups_id = $id_start_group
			AND hosts_groups_id = groups_id
			;
			";


	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$start_group = '';

	while($rows = mysqli_fetch_array($result))
	{
		$start_group[] = array(
					'hosts_id' => $rows['hosts_id'],
					'groups_delay' => $rows['groups_delay']
					);
	}


	if (!isset($start_group[0]["hosts_id"]))
	{
		echo "No Entries in Groups Starts";
		exit();
	}


	//var_dump($start_group);
	//exit();



	//Get Hosts_ID/Groups Delay FROM ARRAY
	foreach ($start_group as $hosts_id_groups_delay)
	{
			start_host($hosts_id_groups_delay["hosts_id"]);
			sleep($hosts_id_groups_delay["groups_delay"]);

	}
}


//Check ONLINE
$ssh_result_check = '';
$check_host = '';
function check_host($id_check_host = NULL)
{

	global $link, $check_host, $ssh_result_check;// $ssh_port, $ssh_user, $ssh_pass;

	if ($id_check_host == NULL) {
		echo "Iidi";
		exit();
	}

	$sql = "SELECT DISTINCT satellites_id, satellites_name, satellites_desc, satellites_ip, satellites_submask, satellites_user, satellites_pass, satellites_port, hosts_name, hosts_mac, hosts_id, hosts_ip, hosts_satellites_id
			FROM satellites, hosts
			WHERE hosts_satellites_id = satellites_id
			AND hosts_id = $id_check_host;
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$check_host = '';

	while($rows = mysqli_fetch_array($result))
	{
		$check_host[] = array(
							'satellites_id' => $rows['satellites_id'],
							'satellites_name' => $rows['satellites_name'],
							'satellites_desc' => $rows['satellites_desc'],
							'satellites_ip' => $rows['satellites_ip'],
							'satellites_submask' => $rows['satellites_submask'],
							'satellites_user' => $rows['satellites_user'],
                                                        'satellites_pass' => $rows['satellites_pass'],
                                                        'satellites_port' => $rows['satellites_port'],
							'hosts_id' => $rows['hosts_id'],
							'hosts_name' => $rows['hosts_name'],
							'hosts_ip' => $rows['hosts_ip'],
							'hosts_mac' => $rows['hosts_mac'],
							'hosts_satellites_id' => $rows['hosts_satellites_id']
							);
	}
	if (!isset($check_host[0]["satellites_ip"]))
	{
		echo "No Entries in Hosts Starts";
		exit();
	}

	//var_dump($check_host);
	if($ssh = ssh2_connect($check_host[0]["satellites_ip"], $check_host[0]["satellites_port"]))
	{

		if(ssh2_auth_password($ssh, $check_host[0]["satellites_user"], $check_host[0]["satellites_pass"]))
		{
			$ssh_result_check_temp = '';

			$stream = ssh2_exec($ssh, 'ping -w1 -c1 '. $check_host[0]['hosts_ip']);
			stream_set_blocking($stream, true);
			$data = '';
			while($buffer = fread($stream, 4096))
			{
				$ssh_result_check_temp .= $buffer;
			}
			fclose($stream);

			if (strpos($ssh_result_check_temp, '100% packet loss') !== false)
			{
                $ssh_result_check .= $check_host[0]['hosts_ip'] . ' --> ' .  $check_host[0]['hosts_name'] . ' --> <FONT COLOR="#FF0000">OFFLINE</FONT><BR>';
            }
            else
            {
                $ssh_result_check .= $check_host[0]['hosts_ip'] . ' --> ' .  $check_host[0]['hosts_name'] . ' -->  <FONT COLOR="#009900">ONLINE</FONT><BR>';
            }
		}
	}
}


//check host online via ping
if (isset($_POST["check_host"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');
	check_host($id);
}

//check all Group-Members online via ping(inactive included)
if (isset($_POST["check_group"]))
{
	$id_check_group = (isset($_POST["ci"])? $_POST["ci"] : '');

	global $link, $start_host, $ssh_result, $ssh_port, $ssh_user, $ssh_pass;

	$sql = "SELECT hosts_id
			FROM hosts
			WHERE $id_check_group = hosts_groups_id;
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$check_group = '';

	while($rows = mysqli_fetch_array($result))
	{
		$check_group[] = array(
								'hosts_id' => $rows['hosts_id']
								);
	}


	if (!isset($check_group[0]["hosts_id"]))
	{
		echo "No Entries in Group Checks";
		exit();
	}

	//Get Hosts_ID FROM ARRAY
	foreach ($check_group as $v1)
	{
		foreach ($v1 as $v2)
		{
			check_host($v2);
			//sleep(1);
		}
	}
}


//---------------------------------------
//SHUTDOWN
$result_shutdown = '';
$shutdown_host = '';
function shutdown_host($id_shutdown_host = NULL)
{

	global $link, $shutdown_host, $result_shutdown, $shutdown_user, $shutdown_pass;// $ssh_port, $ssh_user, $ssh_pass;

	if ($id_shutdown_host == NULL) {
		echo "Iidi";
		exit();
	}

	$sql = "SELECT DISTINCT hosts_id, hosts_name, hosts_ip
			FROM hosts
			WHERE hosts_id = $id_shutdown_host;
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$shutdown_host = '';

	while($rows = mysqli_fetch_array($result))
	{
		$shutdown_host[] = array(
						'hosts_id' => $rows['hosts_id'],
						'hosts_name' => $rows['hosts_name'],
						'hosts_ip' => $rows['hosts_ip']
					);
	}

	if (!isset($shutdown_host[0]["hosts_id"]))
	{
		echo "No Entries in Hosts Starts";
		exit();
	}

	//var_dump($check_host);
	$command = 'net rpc shutdown -t 1 -f -I '. $shutdown_host[0]['hosts_ip'] . ' -U ' . $shutdown_user . '%' . $shutdown_pass;
	$escaped_command = escapeshellcmd($command);
	$result_shutdown_temp = shell_exec($escaped_command);

	if (strpos($result_shutdown_temp, 'machine succeeded') !== false)
 	{
		$result_shutdown .= $shutdown_host[0]['hosts_ip'] . ' --> ' .  $shutdown_host[0]['hosts_name'] . ' --> <FONT COLOR="#009900">Successfully Shutdown</FONT><BR>';
	}
	else
	{
		 $result_shutdown .= $shutdown_host[0]['hosts_ip'] . ' --> ' .  $shutdown_host[0]['hosts_name'] . ' --> <FONT COLOR="#FF0000">Error! Maybe Offline or No Shutdown User on Remote</FONT><BR>';
	}
}

//Shutdown host
if (isset($_POST["shutdown_host"]))
{
	$id = (isset($_POST["ci"])? $_POST["ci"] : '');
	shutdown_host($id);
}

//shutdown all group members
if (isset($_POST["shutdown_group"]))
{
	$id_shutdown_group = (isset($_POST["ci"])? $_POST["ci"] : '');

	global $link, $shutdown_host;// $ssh_port, $ssh_user, $ssh_pass;

	$sql = "SELECT hosts_id
			FROM hosts
			WHERE $id_shutdown_group = hosts_groups_id;
			";

	$result = mysqli_query($link, $sql);

	if(!$result)
	{
		echo mysqli_error($link);
		exit();
	}

	//empty Array
	$shutdown_group = '';

	while($rows = mysqli_fetch_array($result))
	{
		$shutdown_group[] = array(
						'hosts_id' => $rows['hosts_id']
					);
	}


	if (!isset($shutdown_group[0]["hosts_id"]))
	{
		echo "No Entries in Group Shutdowns";
		exit();
	}


	//Get Hosts_ID FROM ARRAY
	foreach ($shutdown_group as $v1)
	{
		foreach ($v1 as $v2)
		{
			shutdown_host($v2);
			sleep(1);
		}
	}
}
//SHUTDOWN END
//---------------------------------------------


//----------------------------------------------
//RESTART

$result_restart = '';
$restart_host = '';
function restart_host($id_restart_host = NULL)
{

        global $link, $shutdown_host, $result_restart, $shutdown_user, $shutdown_pass;// $ssh_port, $ssh_user, $ssh_pass;

        if ($id_restart_host == NULL) {
                echo "Iidi";
                exit();
        }

        $sql = "SELECT DISTINCT hosts_id, hosts_name, hosts_ip
                        FROM hosts
                        WHERE hosts_id = $id_restart_host;
                        ";

        $result = mysqli_query($link, $sql);

        if(!$result)
        {
                echo mysqli_error($link);
                exit();
        }

        //empty Array
        $restart_host = '';

        while($rows = mysqli_fetch_array($result))
        {
                $restart_host[] = array(
                                                        'hosts_id' => $rows['hosts_id'],
                                                        'hosts_name' => $rows['hosts_name'],
                                                        'hosts_ip' => $rows['hosts_ip']
                                        );
        }

        if (!isset($restart_host[0]["hosts_id"]))
        {
                echo "No Entries in Hosts Starts";
                exit();
        }

        //var_dump($check_host);
        $command = 'net rpc shutdown -r -t 1 -f -I '. $restart_host[0]['hosts_ip'] . ' -U ' . $shutdown_user . '%' . $shutdown_pass;
        $escaped_command = escapeshellcmd($command);
        $result_restart_temp = shell_exec($escaped_command);

        if (strpos($result_restart_temp, 'machine succeeded') !== false)
        {
                $result_restart .= $restart_host[0]['hosts_ip'] . ' --> ' .  $restart_host[0]['hosts_name'] . ' --> <FONT COLOR="#009900">Successfully Restarted</FONT><BR>';
        }
        else
        {
                 $result_restart .= $restart_host[0]['hosts_ip'] . ' --> ' .  $restart_host[0]['hosts_name'] . ' --> <FONT COLOR="#FF0000">Error! Maybe Offline or No Restart User on Remote</FONT><BR>';
        }
}

//Restart host
if (isset($_POST["restart_host"]))
{
        $id = (isset($_POST["ci"])? $_POST["ci"] : '');
        restart_host($id);
}


//Restart Group
if (isset($_POST["restart_group"]))
{
        $id_restart_group = (isset($_POST["ci"])? $_POST["ci"] : '');

        global $link, $restart_host;// $ssh_port, $ssh_user, $ssh_pass;

        $sql = "SELECT hosts_id
                        FROM hosts
                        WHERE $id_restart_group = hosts_groups_id;
                        ";

        $result = mysqli_query($link, $sql);

        if(!$result)
        {
                echo mysqli_error($link);
                exit();
        }

        //empty Array
        $restart_group = '';

        while($rows = mysqli_fetch_array($result))
        {
                $restart_group[] = array(
                                                'hosts_id' => $rows['hosts_id']
                                        );
        }


        if (!isset($restart_group[0]["hosts_id"]))
        {
                echo "No Entries in Group Shutdowns";
                exit();
        }


        //Get Hosts_ID FROM ARRAY
	//var_dump($restart_group);
        foreach ($restart_group as $v1)
        {
	var_dump($v1);
                foreach ($v1 as $v2)
                {
		var_dump($v2);
                        restart_host($v2);
                        sleep(1);
                }
        }
}

//RESTART END
//---------------------------------------------------


//Check if Group action or Hostaction or Wakeup or Satellite action or ERROR

if (isset($_POST["action_grouplist"]) or (isset($_POST["group_save"]) or (isset($_POST["delete_group"]))))
{
	include("grouplist.php");
}
elseif (isset($_POST["action_wakeuplist"]) or (isset($_POST["wakeup_save"]) or (isset($_POST["delete_wakeup"]))))
{
	include("wakeuplist.php");
}
elseif (isset($_POST["action_satellitelist"]) or (isset($_POST["satellite_save"]) or (isset($_POST["delete_satellite"]))))
{
	include("satellitelist.php");
}
elseif (isset($_POST["start_host"]))
{
	include("start_host.php");
}
elseif (isset($_POST["start_group"]))
{
	include("start_group.php");
}
elseif (isset($_POST["check_host"]))
{
	include("check_host.php");
}
elseif (isset($_POST["check_group"]))
{
	include("check_group.php");
}
elseif (isset($_POST["shutdown_group"]))
{
        include("shutdown_group.php");
}
elseif (isset($_POST["shutdown_host"]))
{
        include("shutdown_host.php");
}
elseif (isset($_POST["restart_group"]))
{
        include("restart_group.php");
}
elseif (isset($_POST["restart_host"]))
{
        include("restart_host.php");
}

else
{
	include("hostlist.php");
}

exit();

?>
