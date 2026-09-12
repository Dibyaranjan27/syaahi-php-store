<?php 
session_start();  
if (!isset($_SESSION['admin_id'])) {
  header("location:login.php");
}

include "./templates/top.php"; 

?>

<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Dashboard</h2>
      	</div>
      </div>

	    <div class="row">
		
		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="profile.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--mint, #86efac);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Profile</h4>
							<small class="text-white-50">Manage your account</small>
						</div>
						<i class="fas fa-user-circle"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="admin.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--sky, #7dd3fc);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Admins</h4>
							<small class="text-white-50">Manage admin roles</small>
						</div>
						<i class="fas fa-user-shield"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="users.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--sky, #7dd3fc);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Users</h4>
							<small class="text-white-50">Manage customers</small>
						</div>
						<i class="fas fa-users"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="categories.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--sakura, #f9a8d4);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Categories</h4>
							<small class="text-white-50">Organize products</small>
						</div>
						<i class="fas fa-layer-group"></i>
					</div>
				</div>
			</a>
		</div>
		
		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="addproduct.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--sakura, #f9a8d4);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Products</h4>
							<small class="text-white-50">Add new items</small>
						</div>
						<i class="fas fa-box-open"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="comment.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--lavender, #c084fc);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Comments</h4>
							<small class="text-white-50">Manage reviews</small>
						</div>
						<i class="fas fa-comments"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="report.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--lavender, #c084fc);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Reports</h4>
							<small class="text-white-50">View analytics</small>
						</div>
						<i class="fas fa-chart-bar"></i>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xl-4 col-sm-6 mb-4">
			<a href="feedback.php" class="text-decoration-none">
				<div class="card syaahi-admin-card text-white h-100" style="background-color: var(--lavender, #c084fc);">
					<div class="card-body d-flex align-items-center justify-content-between p-4">
						<div>
							<h4 class="mb-0">Feedbacks</h4>
							<small class="text-white-50">User messages</small>
						</div>
						<i class="fas fa-envelope-open-text"></i>
					</div>
				</div>
			</a>
		</div>		
		
		</div>

  </div>
</div>
 


<?php include_once("./templates/footer.php"); ?>

