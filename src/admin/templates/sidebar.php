<nav class="col-md-2 d-none d-md-block sidebar py-3">
      <div class="sidebar-sticky">
        <div class="text-center mb-4">
            <span style="font-family: 'WindSong', cursive; font-size: 3rem; color: var(--dark-purple, #3b0764);">Syaahi</span>
        </div>
        <ul class="nav flex-column">

          <?php 
            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);
          ?>
          		  
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'feedback.php') ? 'active' : ''; ?>" href="feedback.php">
              <i class="fas fa-envelope-open-text"></i> Feedbacks
            </a>
          </li>	  
        </ul>  
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-4 border-bottom">
        <h1 class="h2" style="font-family: 'Carter One', cursive; color: var(--dark-purple, #6b21a8);">Hello, <?php echo $_SESSION["admin_name"]; ?> 👋</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>