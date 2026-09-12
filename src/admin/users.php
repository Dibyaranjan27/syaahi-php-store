<?php session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
      	<h2>Users</h2>
      </div>
      
      <div class="table-responsive">
        <table class="table table-pastel table-borderless">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Area Name</th>
			  <th>Action</th>
            </tr>
          </thead>
          <tbody id="user_list"></tbody>
        </table>
      </div>
    </main>
  </div>
</div>


<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/users.js?v=<?php echo time(); ?>"></script>