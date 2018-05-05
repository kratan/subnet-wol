<!DOCTYPE html>
<html>
<head>
	<title>Add/Edit Satellite</title>

<script type="text/javascript">

function Validate()
{

		var satellites_name = document.getElementById("satellites_name").value;
		var satellites_desc = document.getElementById("satellites_desc").value;
		var satellites_ip = document.getElementById("satellites_ip").value;
		var satellites_submask = document.getElementById("satellites_submask").value;
		var satellites_user = document.getElementById("satellites_user").value;
                var satellites_pass = document.getElementById("satellites_pass").value;
		var satellites_port = document.getElementById("satellites_port").value;


		if(satellites_name.length<1)
		{
			alert('Satellites Name is not the proper length.');
			return false;
		}
		if(satellites_desc.length<1)
		{
			alert('Satellites Description is not the proper length.');
			return false;
		}
		if(satellites_ip.length<1)
		{
			alert('Satellites IP is not the proper length.');
			return false;
		}
		if(satellites_submask.length<1)
		{
			alert('Satellites Submask is not the proper length.');
			return false;
		}
		if(satellites_user.length<1)
                {
                        alert('Satellites User is not the proper length.');
                        return false;
                }
                if(satellites_pass.length<8)
                {
                        alert('Satellites Pass is not the proper length (8 Chars).');
                        return false;
                }
                if(satellites_port.length<1)
                {
                        alert('Satellites Port is not the proper length.');
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
			ADD/EDIT Satellite<br> </br>
			<form id="frmgroups" method="POST" action="index.php"
					onSubmit="return Validate();">
				<input type="hidden" name="satellite_save"
				value="satellite_save" />
				<input type="hidden" name="satellites_id"
				value="<?php

							echo $gresult_satellites["satellites_id"];

						?>" />
				<table>
					<tr>
						<td>
							<label for="satellites_name">Name(16): </label>
						</td>
						<td>
							<input type="text" name="satellites_name"
							value="<?php
										echo $gresult_satellites["satellites_name"];
							?>"
							id="satellites_name" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="satellites_desc">Description(40): </label>
						</td>
						<td>
							<input type="text" name="satellites_desc"
							value="<?php
										echo $gresult_satellites["satellites_desc"];
									?>"
							id="satellites_desc" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="satellites_ip">IP: </label>
						</td>
						<td>
							<input type="text" name="satellites_ip"
							value="<?php
							echo $gresult_satellites["satellites_ip"];
						?>"
						id="satellites_ip" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="satellites_submask">Submask: </label>
						</td>
						<td>
							<input type="text" name="satellites_submask"
							value="<?php
							echo $gresult_satellites["satellites_submask"];
						?>"
						id="satellites_submask" class="txt-fld"/>
						</td>
					</tr>
					 <tr>
                                                <td>
                                                        <label for="satellites_user">User: </label>
                                                </td>
                                                <td>
                                                        <input type="text" name="satellites_user"
                                                        value="<?php
                                                        echo $gresult_satellites["satellites_user"];
                                                ?>"
                                                id="satellites_user" class="txt-fld"/>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <label for="satellites_pass">Password: </label>
                                                </td>
                                                <td>
                                                        <input type="password" name="satellites_pass"
                                                        value="<?php
                                                        //check if PW is set
                                                        if ($gresult_satellites["satellites_pass"] == '')
							{
								echo $gresult_satellites["satellites_pass"];

							}
							else
							{
							 	$gresult_satellites["satellites_pass"] = 'dummypasskk';
								echo $gresult_satellites["satellites_pass"];

							}
                                                ?>"
                                                id="satellites_pass" class="txt-fld"/>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <label for="satellites_port">Port: </label>
                                                </td>
                                                <td>
                                                        <input type="text" name="satellites_port"
                                                        value="<?php
                                                        echo $gresult_satellites["satellites_port"];
                                                ?>"
                                                id="satellites_port" class="txt-fld"/>
                                                </td>
                                        </tr>


				</table>
				<input type="hidden" name="action_type" value="<?php
				if ($gresult_satellites["satellites_id"] == "") {
					echo 'add_satellite';
				}
				else { echo 'edit_satellite';}
				//echo (isset($gresult_wakeups["wakeups_id"]) ? 'edit_wakeup' : 'add_wakeup');

				?>"/>
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
