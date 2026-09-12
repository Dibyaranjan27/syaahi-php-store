 <nav class="navbar fixed-top flex-md-nowrap p-0 shadow-sm" style="background-color: #ffffff; z-index: 1040;">
    	<?php
    		if (isset($_SESSION['admin_id'])) {
    			?>
					<a class="navbar-brand col-sm-3 col-md-2 mr-0 d-md-none" style="font-family: 'WindSong', cursive; font-size: 2rem; color: var(--dark-purple, #3b0764); padding-left: 20px;" href="index.php">Syaahi</a>
					<ul class="navbar-nav px-3 ml-auto">
					<li class="nav-item text-nowrap">					
    				<a class="nav-link btn btn-outline-sakura btn-pill btn-sm px-3 mt-1 mb-1" href="../admin/admin-logout.php">Sign out</a>
    			<?php
    		}else{
    			$uriAr = explode("/", $_SERVER['REQUEST_URI']);
    			$page = end($uriAr);
    			if ($page === "login.php") {
    				?>
						<a class="navbar-brand col-sm-3 col-md-2 mr-0 d-md-none" style="font-family: 'WindSong', cursive; font-size: 2rem; color: var(--dark-purple, #3b0764); padding-left: 20px;" href="../index.php">Syaahi</a>
						<ul class="navbar-nav px-3 ml-auto">
						<li class="nav-item text-nowrap">
	    				<a class="nav-link btn btn-outline-lavender btn-pill btn-sm px-3 mt-1 mb-1" href="../login.php">Go Back To Login</a>
	    			<?php
    			}else{
    				?>
						<a class="navbar-brand col-sm-3 col-md-2 mr-0 d-md-none" style="font-family: 'WindSong', cursive; font-size: 2rem; color: var(--dark-purple, #3b0764); padding-left: 20px;" href="../index.php">Syaahi</a>
						<ul class="navbar-nav px-3 ml-auto">
					    <li class="nav-item text-nowrap">
	    				<a class="nav-link btn btn-outline-lavender btn-pill btn-sm px-3 mt-1 mb-1" href="../admin/login.php">Login</a>
	    			<?php
    			}		
    		}
    	?> 
    </li>
  </ul>
</nav>