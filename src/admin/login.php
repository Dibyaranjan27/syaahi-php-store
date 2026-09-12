<?php include "./templates/top.php"; ?>

<?php include "./templates/navbar.php"; ?>

<div class="container py-5">
    <div class="row justify-content-center" style="margin-top: 50px;">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="syaahi-form-card">
                <h3 class="form-title">Admin Login 🔒</h3>
                <p class="text-center text-muted mb-4">Please enter your credentials to access the dashboard.</p>
                
                <div class="message text-center mb-3"></div>
                
                <form id="admin-login-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="admin@syaahi.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="••••••" required>
                    </div>
                    <input type="hidden" name="admin_login" value="1">
                    <button type="button" class="btn btn-sakura btn-pill w-100 login-btn">
                        Login to Dashboard ✨
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/main.js?v=<?php echo time(); ?>"></script>
