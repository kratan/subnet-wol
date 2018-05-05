<?php
include_once 'index.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Wakeup Overview</title>
<script type="text/javascript">
function ConfirmDelete(){
	var d = confirm('Do you really want to delete data?');
	if(d == false){
		return false;
	}
}
</script>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
 	.hoverTable{
		width:80%;
		border-collapse:collapse;
	}
	.hoverTable td{
		padding:0px; border:#4e95f4 1px solid;
	}
	/* Define the default color for all the table rows */
	.hoverTable tr{
		background: #b8d1f3;
	}
	/* Define the hover highlight color for the table row */
    .hoverTable tr:hover {
          background-color: #ffff99;
    }
</style>






</head>
<body>
	<div class="wrapper">
		<div class="content" >
			<br/>
			1. Wake Up on LAN Zeit erstellen <br/>
			2. Satelliten Server erstellen, falls noch nicht vorhanden<br/>
			3. Group erstellen mit zuvor erstellter Wake Up on LAN Zeit<br/>
			4. Host erstellen und Group zuweisen + Satelliten Server zuweisen
			<?php //include 'header.php'; ?><br/> <br/>
			<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_host" value="add_host" />
				<input type="submit" value="New Host" />
			</form>
			<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_grouplist" value="grouplist" />
				<input type="submit" value="Check/Add/Edit/Start Groups" />
			</form>
				<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_wakeuplist" value="wakeuplist" />
				<input type="submit" value="Add/Edit Wakeups" />
			</form>
				<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_satellitelist" value="satellitelist" />
				<input type="submit" value="Add/Edit Satellites" />
			</form>
			<form method="post" action="import_hosts.php">
				<input type="hidden" name="import_hosts" value="import_hosts" />
				<input type="submit" value="Import Hosts" />
			</form>
			<table border="2" class="hoverTable">
				<thead>
					<tr>
						<th>
							Name
						</td>
						<th>
							IP
						</th>
						<th>
							MAC
						</th>
						<th>
							Wakeup
						</th>
						<th>
							Group
						</th>
						<th>
							Satellite
						</th>
						<th>
							Active
						</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (!isset($hosts_list))
						{
							echo 'Keine Daten';
						}
						else
						{
							foreach($hosts_list as $host) : ?>
						<tr>
							<td><?php echo $host["hosts_name"]; ?></td>
							<td><?php echo $host["hosts_ip"]; ?></td>
							<td><?php echo $host["hosts_mac"]; ?></td>
							<td><?php echo $host["wakeups_name"]; ?></td>
							<td><?php echo $host["groups_name"]; ?>	</td>
							<td><?php echo $host["satellites_name"]; ?></td>
							<td align="center"
							<?php if($host["hosts_active"] == 1) { echo 'BGCOLOR="#00ff00"'; }
							else { echo 'BGCOLOR="#FF0000"'; }
								echo '>';
								echo $host["hosts_active"];
								?></td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="action_host" value="edit_host" />
									<input type="submit" value="Edit" />
								</form>
							</td>
							<td>
								<form method="POST" action="index.php"
								onSubmit="return ConfirmDelete();">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="delete_host" value="delete_host" />
									<input type="submit" value="Delete" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="start_host" value="start_host" />
									<input type="submit" value="Start Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="restart_host" value="restart_host" />
									<input type="submit" value="Restart Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="shutdown_host" value="shutdown_host" />
									<input type="submit" value="Shutdown Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $host["hosts_id"]; ?>" />
									<input type="hidden" name="check_host" value="check_host" />
									<input type="submit" value="Check Now" />
								</form>
							</td>
						<tr>

				<?php endforeach;
				//END ELSE
				}
				?>
				</tbody>
			</table><br/>
		</div>
	</div>
</body>
</html>
