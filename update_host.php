<!DOCTYPE html>
<html>
<head>
	<title>Add/Edit Host</title>

<script type="text/javascript">

function Validate()
{

		var hosts_name = document.getElementById("hosts_name").value;
		var hosts_ip = document.getElementById("hosts_ip").value;
		var hosts_mac=document.getElementById('hosts_mac').value;
		var macAddressRegExp=/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i;

		if(hosts_name.length<1)
		{
			alert('Host Name is not the proper length.');
			return false;
		}


		if (!(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(hosts_ip)))
		{
			alert("You have entered an invalid IP address!");
			return false;
		}


		if(hosts_mac.length!=17) {
			alert('Mac Address is not the proper length.');
			return false;
		}

		if (macAddressRegExp.test(hosts_mac)==false) {
			alert("Please enter a valid MAC Address.");
			return false;
		}

}

function GotoHome(){
	window.location = 'index.php?';
}

</script>
</head>
<body>
	<div class="wrapper">
		<div class="content" style="width: 1000px !important;">
			<?php //include 'header.php'; ?><br/>
			<div>
			ADD/EDIT HOST<br> </br>
			<form id="frmHosts" method="POST" action="index.php"
					onSubmit="javascript:return Validate();">
				<input type="hidden" name="hosts_id"
				value="<?php
				echo (isset($gresult_hosts) ? $gresult_hosts["hosts_id"] : '');
				?>" />
				<table>
					<tr>
						<td>
							<label for="hosts_id">Hosts Name: </label>
						</td>
						<td>
							<input type="text" name="hosts_name"
							value="<?php echo (isset($gresult_hosts) ? $gresult_hosts["hosts_name"] :  ''); ?>"
							id="hosts_name" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="hosts_ip">Hosts IP: </label>
						</td>
						<td>
							<input type="text" name="hosts_ip"
							value="<?php echo (isset($gresult_hosts) ? $gresult_hosts["hosts_ip"] :  ''); ?>"
							id="hosts_ip" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="hosts_mac">MAC: </label>
						</td>
						<td>
							<input type="text" name="hosts_mac"
							value="<?php echo (isset($gresult_hosts) ? $gresult_hosts["hosts_mac"] :  ''); ?>"
							class="txt-fld" id="hosts_mac" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="hosts_groups_id">Group Name: </label>
						</td>
						<td>
						<?php
						//define defaults
						// select box open tag
						$selectBoxOpen =  "<select name='hosts_groups_id'>";
						// select box close tag
						$selectBoxClose =  "</select>";
						// select box option tag
						$selectBoxOption = '';
						if (isset($gresult_groups))
						{
						// play with return result array
						while($row = mysqli_fetch_array($gresult_groups))
							{
						//find current group and set active in combobox
							if ($gresult_hosts["hosts_groups_id"] == $row['groups_id'])
								{
								$select_current_group = ' selected';
								}
							else
								{
								$select_current_group = '';
								}
							$selectBoxOption .="<option " . $select_current_group . " value = '".$row['groups_id']."'>".$row['groups_id']. "." .$row['groups_name']."</option>";
							}
							// create select box tag with mysql result
							echo  $selectBoxOpen.$selectBoxOption.$selectBoxClose;
						}
						else
						{
						// play with return result array
						while($row = mysqli_fetch_array($gresult_groups))
							{
							$selectBoxOption .="<option value = '".$row['groups_id']."'>".$row['groups_id']. "." .$row['groups_name']."</option>";
							}
						// create select box tag with mysql result
						echo  $selectBoxOpen.$selectBoxOption.$selectBoxClose;
						}
						?>

						<tr>
						<td>
							<label for="hosts_wakeups_id">Wakeup Name: </label>
						</td>
						<td>

						<?php
						// select box open tag
						$selectBoxOpen =  "<select name='hosts_wakeups_id'>";
						// select box option tag
						$selectBoxOption = '';
						// play with return result array

						if (isset($gresult_wakeups))
						{
						while($row = mysqli_fetch_array($gresult_wakeups))
							{
							//find current wakeup and set active in combobox
							if ($gresult_hosts["hosts_wakeups_id"] == $row['wakeups_id'])
								{
								$select_current_wakeup = ' selected';
								}
							else
								{
								$select_current_wakeup = '';
								}
							$selectBoxOption .="<option " . $select_current_wakeup . " value = '".$row['wakeups_id']."'>". $row['wakeups_id'] . "." .$row['wakeups_name']."</option>";
							}
						}
						else
						{
							// play with return result array
							while($row = mysqli_fetch_array($gresult_wakeups))
								{
									$selectBoxOption .="<option value = '".$row['wakeups_id']."'>". $row['wakeups_id'] . "." .$row['wakeups_name']."</option>"; 
								}
						// create select box tag with mysql result
						}
						echo  $selectBoxOpen.$selectBoxOption.$selectBoxClose;

						?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="hosts_satellites_id">Satellite Name: </label>
						</td>
						<td>

						<?php

						// select box open tag
						$selectBoxOpen =  "<select name='hosts_satellites_id'>";
						// select box option tag
						$selectBoxOption = '';
						// play with return result array

						if (isset($gresult_satellites))
						{
						while($row = mysqli_fetch_array($gresult_satellites))
							{
							//find current wakeup and set active in combobox
							if ($gresult_hosts["hosts_satellites_id"] == $row['satellites_id'])
								{
								$select_current_satellite = ' selected';
								}
							else
								{
								$select_current_satellite = '';
								}
							$selectBoxOption .="<option " . $select_current_satellite . " value = '".$row['satellites_id']."'>". $row['satellites_id'] . "." .$row['satellites_name']."</option>";
							}
						}
						else
						{
							// play with return result array
							while($row = mysqli_fetch_array($gresult_satellites))
								{
									$selectBoxOption .="<option value = '".$row['satellites_id']."'>". $row['satellites_id'] . "." .$row['satellites_name']."</option>";
								}
						// create select box tag with mysql result
						}
						echo  $selectBoxOpen.$selectBoxOption.$selectBoxClose;

						?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="hosts_active">Active: </label>
						</td>
						<td>
							<input type="checkbox" name="hosts_active"
							<?php
								if ($gresult_hosts["hosts_active"] == 1 )echo ' checked';
							?>

							class="txt-fld"/>
						</td>
					</tr>

				</table>
				<input type="hidden" name="action_type" value="<?php echo (isset($gresult_hosts["hosts_id"]) ? 'edit_host' : 'add_host');?>"/>
				<div style="text-align: center; padding-top: 30px;">
					<input class="btn" type="submit" name="save" id="save" value="Save" />
					<input class="btn" type="submit" name="save" id="cancel" value="Cancel"
					onclick=" return GotoHome();"/>
				</div>
			</form>
			</div>
		</div>
	</div>
</body>
</html>
