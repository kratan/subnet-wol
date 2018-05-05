<!DOCTYPE html>
<html>
<head>
	<title>Add/Edit Wakeups</title>

<script type="text/javascript"
        src="jquery.min.js"></script>

<script type="text/javascript" src="jquery-cron.js"></script>

<link type="text/css" href="jquery-cron.css" rel="stylesheet" />


<script type="text/javascript">




function Validate()
{

		var wakeups_name = document.getElementById("wakeups_name").value;
		var wakeups_desc = document.getElementById("wakeups_desc").value;
		var wakeups_code = document.getElementById('wakeups_code').value;
		if(wakeups_name.length<1)
		{
			alert('Wakeups Name is not the proper length.');
			return false;
		}
		if(wakeups_desc.length<1)
		{
			alert('Wakeups Description is not the proper length.');
			return false;
		}
		if(wakeups_code.length<1)
		{
			alert('Wakeups Code is not the proper length.');
			return false;
		}
}

function GotoHome(){
	window.location = 'index.php?';
}

</script>


 <script type="text/javascript">
$(document).ready(function() {
$('#example1').cron({
initial: "42 3 * * 5",
onChange: function() {
$('#example1-val').text($(this).cron("value"));
}
});
$('#example1b').cron({
initial: "42 3 * * 5",
onChange: function() {
$('#example1b-val').text($(this).cron("value"));
},
useGentleSelect: true
});
$('#example2').cron({
initial: "42 3 * * 5",
effectOpts: {
openEffect: "fade",
openSpeed: "slow"
},
useGentleSelect: true
});
$('#example3').cron({
initial: "*/5 * * * *",
onChange: function() {
$('#example3-val').text($(this).cron("value"));
},
customValues: {
"5 Minutes" : "*/5 * * * *",
"2 Hours on Weekends" : "0 */2 * * 5,6"
},
useGentleSelect: true
});
$('#example4').cron({
initial: "42 3 * * 5",
onChange: function() {
$('#example4-val').text($(this).cron("value"));
},
useGentleSelect: true
});
});
</script>
</head>
<body>
<div id="content">
<h1>jQuery plugin: cron</h1>
<h2 id='intro'>Introduction</h2>
<p>
jquery-cron is a <a href='http://jquery.com'>jQuery</a> plugin for
presenting a simplified interface for users to specify cron entries.
</p>
<p>
Instead of having to specify the five elements of a cron entry (minute,
hour, day of month, month, day of week), jquery-cron provides a simpler
interface for users to enter the more common combinations. For example:
</p>
<div class='example'>
<div id='example1'></div>
<p>Generated cron entry: <span class='example-text' id='example1-val'></span></p>
</div>


</head>


<body>

	<img src="cron-job.png" alt="2013 Round Up"
	<div class="wrapper">
		<div class="content" style="width: 1000px !important;">
			<?php //include 'header.php'; ?><br/>
			<div>
			ADD/EDIT Wakeup<br> </br>
			<form id="frmgroups" method="POST" action="index.php"
					onSubmit="return Validate();">
				<input type="hidden" name="wakeup_save"
				value="wakeup_save" />
				<input type="hidden" name="wakeups_id"
				value="<?php

							echo $gresult_wakeups["wakeups_id"];

						?>" />
				<table>
					<tr>
						<td>
							<label for="wakeups_name">Wakeup Name: </label>
						</td>
						<td>
							<input type="text" name="wakeups_name"
							value="<?php
										echo $gresult_wakeups["wakeups_name"];
							?>"
							id="wakeups_name" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="wakeups_desc">Wakeup Description: </label>
						</td>
						<td>
							<input type="text" name="wakeups_desc"
							value="<?php
										echo $gresult_wakeups["wakeups_desc"];
									?>"
							id="wakeups_desc" class="txt-fld"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="wakeups_code">Wakeup Code: </label>
						</td>
						<td>
							<input type="text" name="wakeups_code" placeholder="e.g.: 01 00 * * *"
							value="<?php
							echo $gresult_wakeups["wakeups_code"];
						?>"
						id="wakeups_code" class="txt-fld"/>
						</td>
					</tr>
				</table>
				<input type="hidden" name="action_type" value="<?php
                 if ($gresult_wakeups["wakeups_id"] == "") {
                     echo 'add_wakeup';
                 }
                 else { echo 'edit_wakeup';}
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
