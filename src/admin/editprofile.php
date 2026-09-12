<?php session_start(); ?>
<?php include "./templates/top.php"; ?>
<?php include "./templates/navbar.php"; ?>
<div class="container-fluid">
    <div class="row">
        <?php include "./templates/sidebar.php"; ?>

        <div class="row mt-5 w-100">
            <div class="col-md-6 mx-auto">
                <div class="card syaahi-admin-card p-4">
                    <h3 class="mb-4 text-center" style="font-family: 'Carter One', cursive; color: var(--dark-purple, #6b21a8);">Edit Profile ✨</h3>
                    <p class="message"></p>
                    <form id="admin-editprofile-form">
                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-bold">Full Name</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" name="name" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-bold">Email Address</label>
                            <input type="email" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" name="email" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="font-weight-bold">New Password (Optional)</label>
                            <input type="password" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="form-group mb-4">
                            <label for="cpassword" class="font-weight-bold">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" name="cpassword" id="cpassword" placeholder="Password">
                        </div>
                        <input type="hidden" name="admin_editprofile" value="1">
                        <div class="text-right">
                            <a href="profile.php" class="btn btn-light rounded-pill px-4 mr-2">Cancel</a>
                            <button type="button" class="btn btn-lavender btn-pill px-5 shadow-sm editprofile-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
  </div>
</div>

<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/editprofile.js?v=<?php echo time(); ?>"></script>