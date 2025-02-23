<?php 

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user">
				<i class="fa fa-plus"></i> New user
			</button>
		</div>
	</div>
	<br>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><b>User List</b></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="userTable">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Name</th>
								<th class="text-center">Username</th>
								<th class="text-center">Type</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								include 'db_connect.php';
								$type = array("", "Admin", "Staff", "Alumnus/Alumna");
								$users = $conn->prepare("SELECT * FROM users ORDER BY name ASC");
								$users->execute();
								$result = $users->get_result();
								$i = 1;
								while ($row = $result->fetch_assoc()):
							?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo htmlspecialchars(ucwords($row['name'])); ?></td>
								<td><?php echo htmlspecialchars($row['username']); ?></td>
								<td><?php echo $type[$row['type']]; ?></td>
								<td>
									<center>
										<div class="btn-group">
											<button type="button" class="btn btn-primary btn-sm">Action</button>
											<button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item edit_user" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Edit</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Delete</a>
											</div>
										</div>
									</center>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div> <!-- /.table-responsive -->
			</div> <!-- /.card-body -->
		</div> <!-- /.card -->
	</div> <!-- /.col-lg-12 -->
</div> <!-- /.container-fluid -->

<script>
$(document).ready(function(){
	// Initialize DataTables
	$('#userTable').DataTable();
	
	// Open modal for new user
	$('#new_user').click(function(){
		uni_modal('New User', 'manage_user.php');
	});
	
	// Open modal for editing user
	$('.edit_user').click(function(){
		uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'));
	});
	
	// Delete user confirmation
	$('.delete_user').click(function(){
		_conf("Are you sure you want to delete this user?", "delete_user", [$(this).attr('data-id')]);
	});
});

// Function to delete user
function delete_user(id){
	start_load();
	$.ajax({
		url: 'ajax.php?action=delete_user',
		method: 'POST',
		data: {id: id},
		success: function(resp){
			if(resp == 1){
				alert_toast("User successfully deleted", 'success');
				setTimeout(function(){
					location.reload();
				}, 1500);
			}
		}
	});
}
</script>
