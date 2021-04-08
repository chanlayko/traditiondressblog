  <div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
       <?php
        $link = $_SERVER['PHP_SELF'];
        $link_array = explode('/',$link);
        $page = end($link_array);
      ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
          <li>
              <a href="#">
                  <input type="submit" value="Logout" class="btn">
              </a>
          </li>
        </ul>
  </nav>
  <!-- /.navbar -->
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../../../../../dist/img/user2-160x160.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $_SESSION['username']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo $page == 'index.php' ? 'active': '' ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Blog Admin
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="user.php" class="nav-link <?php echo $page == 'user.php'? 'active': '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="mail.php" class="nav-link <?php echo $page == 'mail.php'? 'active': '' ?>">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mail
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="themes.php" class="nav-link <?php echo $page == 'themes.php'? 'active': '' ?>">
              <i class="nav-icon far fa-image"></i>
              <p>
                Themes
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- ../dist/img/user2-160x160.jpg -->
  <!--  -->