<?php
include_once 'index.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wakeups List</title>
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
			Wakeup-List
			<?php //include 'header.php'; ?><br/> <br/>
			<table border="2" class="wakeups_table">
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
							Code
						</th>
						<th></th><th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (!isset($wakeups_list)) { echo "Keine Daten"; }
						else {
					foreach($wakeups_list as $wakeup) : ?>
						<tr>
							<td><?php echo $wakeup["wakeups_id"]; ?>
							</td>
							<td><?php echo $wakeup["wakeups_name"]; ?>
							</td>
							<td><?php echo $wakeup["wakeups_desc"]; ?>
							</td>
							<td><?php echo $wakeup["wakeups_code"]; ?>
							</td>
							<td>
								<form method="post" action="index.php">
									<input type="hidden" name="ci"
									value="<?php echo $wakeup["wakeups_id"]; ?>" />
									<input type="hidden" name="action_wakeup" value="edit_wakeup" />
									<input type="submit" value="Edit" />
								</form>
							</td>
							<td>
								<form method="POST" action="index.php"
								onSubmit="return ConfirmDelete();">
									<input type="hidden" name="ci"
									value="<?php echo $wakeup["wakeups_id"]; ?>" />
									<input type="hidden" name="delete_wakeup" value="delete_wakeup" />
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
				<input type="hidden" name="action_wakeup" value="add_wakeup" />
				<input type="submit" value="New Wakeup" />
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
