<nav class="col-md-2 d-md-block sidebar py-3 collapse" id="mobileSidebar">
      <div class="sidebar-sticky">
        <div class="text-center mb-4 d-none d-md-block">
            <a href="index.php" style="text-decoration: none;">
                <span style="font-family: 'WindSong', cursive; font-size: 3.5rem; color: var(--dark-purple, #3b0764);">Syaahi</span>
            </a>
        </div>
        <ul class="nav flex-column">

          <?php 
            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);
          ?>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'index.php') ? 'active' : ''; ?>" href="index.php">
              <i class="fas fa-home"></i> Dashboard
            </a>
          </li>			  
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'profile.php') ? 'active' : ''; ?>" href="profile.php">
              <i class="fas fa-user-circle"></i> Profile
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'admin.php') ? 'active' : ''; ?>" href="admin.php">
              <i class="fas fa-user-shield"></i> Admins
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'users.php') ? 'active' : ''; ?>" href="users.php">
              <i class="fas fa-users"></i> Users
            </a>
          </li>	
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
              <i class="fas fa-layer-group"></i> Categories
            </a>
          </li>		  
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'addproduct.php') ? 'active' : ''; ?>" href="addproduct.php">
              <i class="fas fa-box-open"></i> Products
            </a>
          </li>	
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'comment.php') ? 'active' : ''; ?>" href="comment.php">
              <i class="fas fa-comments"></i> Comments
            </a>
          </li>		  

          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'feedback.php') ? 'active' : ''; ?>" href="feedback.php">
              <i class="fas fa-envelope-open-text"></i> Feedbacks
            </a>
          </li>	  
        </ul>  
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-md-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-4 border-bottom">
        <h1 class="h2" style="font-family: 'Carter One', cursive; color: var(--dark-purple, #6b21a8);">Hello, <?php echo $_SESSION["admin_name"]; ?> 👋</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a class="btn btn-outline-sakura btn-pill px-4 shadow-sm" href="../admin/admin-logout.php">
            <i class="fas fa-sign-out-alt"></i> Sign out
          </a>
        </div>
      </div>