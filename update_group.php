<!DOCTYPE html>
<html>
<head>
	<title>Add/Edit Groups</title>

<script type="text/javascript">

function Validate(){
	var valid = true;
	var message = '';
	var groups_name = document.getElementById("groups_name");
	var groups_ip = document.getElementById("groups_ip");
	var groups_mac = document.getElementById("groups_mac");
	if(groups_name.value.trim() == ''){
		valid = false;
		message = message + '*groups Name is required' + '\n';
	}
	if(groups_ip.value.trim() == ''){
		valid = false;
		message = message + '*groups IP is required';
	}



	if (valid == false){
		alert(message);
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
			ADD/EDIT GROUP<br> </br>
			<form id="frmgroups" method="POST" action="index.php"
					onSubmit="return Validate();">
				<input type="hidden" name="group_save"
				value="group_save" />
				<input type="hidden" name="groups_id"
				value="<?php
                        echo $gresult_groups["groups_id"];
                       ?>" />
 
				<table>
					<tr>
						<td>
							<label for="groups_name">Groups Name: </label>
						</td>
						<td>
							<input type="text" name="groups_name" 
							value="<?php
                                    echo $gresult_groups["groups_name"];

                            ?>"
							id="groups_name" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="groups_ip">Groups Description: </label>
						</td>
						<td>
							<input type="text" name="groups_desc" 
							value="<?php

                                    echo $gresult_groups["groups_desc"];
                                   ?>" 
							id="groups_ip" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="groups_wakeups_id">Wakeup Name: </label>
						</td>
						<td>

						<?php
						//select box
						$selectBoxClose =  "</select>";
						// select box open tag
						$selectBoxOpen =  "<select name='groups_wakeups_id'>"; 
						// select box option tag
						$selectBoxOption = ''; 
						// play with return result array 
						if (isset($gresult_wakeups)) 
						{
						while($row = mysqli_fetch_array($gresult_wakeups))
							{
							//find current wakeup and set active in combobox
							if ($gresult_groups["groups_wakeups_id"] == $row['wakeups_id']) 
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
                                                        <label for="groups_ip">Groups Delay(default 5): </label>
                                                </td>
                                                <td>
                                                        <input type="text" name="groups_delay"
                                                        value="<?php

                                    echo $gresult_groups["groups_delay"];
                                   ?>"
                                                        id="groups_ip" class="txt-fld"/>
                                                </td>
                                        </tr>


					<tr>
						<td>
							<label for="groups_active">Active: </label>
						</td>
						<td>
							<input type="checkbox" name="groups_active" 
							<?php
								if ($gresult_groups["groups_active"] == 1 )echo ' checked ';
							?>
                            id="groups_active" class="txt-fld"/>
						</td>
					</tr>
				</table>
				<input type="hidden" name="action_type" value="<?php echo (isset($gresult_groups["groups_id"]) ? 'edit_group' : 'add_group');?>"/>
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
