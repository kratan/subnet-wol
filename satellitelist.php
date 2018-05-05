<?php 
include_once 'index.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Satellites List</title>
	
<script type="text/javascript">
function ConfirmDelete(){
	var d = confirm('Do you really want to delete data?');
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
			SATELLITES-LIST
			<?php //include 'header.php'; ?><br/> <br/>
			<table border="2" class="satellites_table">
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
							Satellites IP
						</th>
						<th>
							Subnet Mask
						</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if (!isset($satellites_list)) { echo "Keine Daten"; }
						else {
							foreach($satellites_list as $satellite) : ?>
						<tr>
							<td><?php echo $satellite["satellites_id"]; ?>
							</td>
							<td><?php echo $satellite["satellites_name"]; ?>
							</td>
							<td><?php echo $satellite["satellites_desc"]; ?>
							</td>
							<td><?php echo $satellite["satellites_ip"]; ?>
							</td>
							<td><?php echo $satellite["satellites_submask"]; ?>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci" 
									value="<?php echo $satellite["satellites_id"]; ?>" />
									<input type="hidden" name="action_satellite" value="edit_satellite" />
									<input type="submit" value="Edit" />
								</form> 
							</td>
							<td>
								<form method="post" action="index.php" 
								onSubmit="return ConfirmDelete();">
									<input type="hidden" name="ci" 
									value="<?php echo $satellite["satellites_id"]; ?>" />
									<input type="hidden" name="delete_satellite" value="delete_satellite" />
									<input type="submit" value="Delete" />
								</form>
							</td>
						<tr>
				<?php endforeach; 

				//end ELSE
				}
				?>
				</tbody>
			</table><br/>
			<form method="post" action="index.php">
				<input type="hidden" name="ci" />
				<input type="hidden" name="action_satellite" value="add_satellite" />
				<input type="submit" value="New Satellite" />
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
