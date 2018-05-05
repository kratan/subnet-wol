<?php
include_once 'index.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Groups List</title>
<script type="text/javascript">
function ConfirmDelete(){
	var d = confirm('Do you really want to delete data?');
	if(d == false){
		return false;
	}
}

function Confirm_restart_shutdown(){
        var d = confirm('Do you really want to shutdown or restart?');
        if(d == false){
                return false;
        }
}
</script>
</head>
<body>
	<div class="wrapper">
		<div class="content" >
			<br/>
			GROUPS-LIST
			<?php //include 'header.php'; ?><br/> <br/>
			<table border="2" class="groups_table">
				<thead>
					<tr>
						<th>
							ID
						</td>
						<th>
							Name
						</th>
						<th>
							Description
						</th>
						<th>
							Wakeup ID
						</th>
						<th>
							Delay
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
						if (!isset($groups_list))
						{
							echo "No Entries in Groups-List. Please add a group";
						}
						else
						{
						foreach($groups_list as $group) : ?>
						<tr>
							<td><?php echo $group["groups_id"]; ?>
							</td>
							<td><?php echo $group["groups_name"]; ?>
							</td>
							<td><?php echo $group["groups_desc"]; ?>
							</td>
							<td><?php echo $group["wakeups_name"]; ?>
							 </td>
                                                        <td align="center" <?php
							echo '>';
							echo $group["groups_delay"];
							 ?>
							</td>
							<td align="center"
							<?php
								if($group["groups_active"] == 1) { echo 'BGCOLOR="#00ff00"'; }
								else { echo 'BGCOLOR="#FF0000"'; }
								echo '>';
								echo $group["groups_active"];
							?>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="action_group" value="edit_group" />
									<input type="submit" value="Edit" />
								</form>
							</td>
							<td>
								<form method="POST" action="index.php"
								onSubmit="return ConfirmDelete();">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="delete_group" value="delete_group" />
									<input type="submit" value="Delete" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="start_group" value="start_group" />
									<input type="submit" value="Start Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php"
								onSubmit="return Confirm_restart_shutdown();">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="restart_group" value="restart_group" />
									<input type="submit" value="Restart Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php"
								onSubmit="return Confirm_restart_shutdown();">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="shutdown_group" value="shutdown_group" />
									<input type="submit" value="Shutdown Now" />
								</form>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $group["groups_id"]; ?>" />
									<input type="hidden" name="check_group" value="check_group" />
									<input type="submit" value="Check Now" />
								</form>
							</td>
						<tr>
				<?php endforeach;
					//else END
					}
				?>
				</tbody>
			</table><br/>
			<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_group" value="add_group" />
				<input type="submit" value="New Group" />
				<br/>
				<br/>
			</form>
			<form method="post" action="index.php">
				<input type="submit" value="Home" />
			</form>
			<br/>
		</div>
	</div>
</body>
</html>
