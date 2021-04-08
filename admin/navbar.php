  
<?php
  $link = $_SERVER['PHP_SELF'];
  $link_array = explode('/',$link);
  $page = end($link_array);
?>
  <div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> 
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li>
        <a href="../index.php?id=<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" value="View My Page" class="btn">
        </a>
      </li>
      <li>
          <a href="../registeradmin/logout.php">
              <input type="submit" value="Logout" class="btn" onclick="return confirm('Are you sure you want to LOGOUT this Admin')">
          </a>
      </li>
    </ul>
  </nav>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Blog Page</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo $page == 'index.php'? 'active': ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="post.php" class="nav-link <?php echo $page == 'post.php' || $page == 'add.php' || $page == 'edit.php' || $page == 'massage_order.php'? 'active': ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>POSTS</p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo $page == 'weelkly_report.php' || $page == 'royal_customer.php' || $page == 'best_saller.php'? 'menu-open':''; ?>">
            <a href="#" class="nav-link <?php echo $page == 'weelkly_report.php' || $page == 'royal_customer.php' || $page == 'best_saller.php'? 'active':''; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                REPORTS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weelkly_report.php" class="nav-link <?php echo $page == 'weelkly_report.php'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_customer.php" class="nav-link <?php echo $page == 'royal_customer.php'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_saller.php" class="nav-link <?php echo $page == 'best_saller.php'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Saller</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="massage.php" class="nav-link <?php echo $page == 'massage.php'? 'active' : ''; ?>">
              <i class="nav-icon fas fa-envelope"></i>
              <p>YOUR'S REGISTER</p>
                <span class="badge badge-info right">2</span>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo $page == 'order_information.php' || $page == 'pickup_information.php' || $page == 'gift_information.php' || $page == 'view_massage.php' || $page == 'pickup_massage.php' || $page == 'gift_massage.php' || $page == 'send_massage.php' || $page =='pickup_send_massage.php' || $page =='gift_send_massage.php' || $page == 'send_edit_massage.php'? 'menu-open':''; ?>">
            <a href="" class="nav-link <?php echo $page == 'order_information.php' || $page == 'pickup_information.php' || $page == 'gift_information.php' || $page == 'view_massage.php' || $page == 'pickup_massage.php' || $page == 'gift_massage.php' || $page == 'send_massage.php' || $page =='pickup_send_massage.php' || $page =='gift_send_massage.php' || $page == 'send_edit_massage.php'? 'active':''; ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                ORDER
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <?php if ($page == 'send_edit_massage.php') {
              $order_id = $_GET['id'];

              $pdostatpdo = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
              $pdostatpdo -> execute();
              $resultpdo = $pdostatpdo -> fetchAll();
            } ?>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="order_information.php" class="nav-link <?php echo $page == 'order_information.php' || $page == 'view_massage.php' || $page == 'send_massage.php'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pickup_information.php" class="nav-link <?php echo $page == 'pickup_information.php' || $page == 'pickup_massage.php' || $page =='pickup_send_massage.php' || $resultpdo[0]['gift_order'] == 'pickup'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pickup Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gift_information.php" class="nav-link <?php echo $page == 'gift_information.php' || $page == 'gift_massage.php' || $page =='gift_send_massage.php' || $resultpdo[0]['gift_order'] == 'gift'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gift Wrap Order</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo $page == 'inbox_massage.php' || $page == 'sent_massage.php' || $page == 'draft_massage.php' || $page == 'trash_massage.php' || $page == 'delivery_order.php' || $page == 'pickup_order.php' || $page == 'gift_order.php' || $page == 'read_massage.php'? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $page == 'inbox_massage.php' || $page == 'sent_massage.php' || $page == 'draft_massage.php' || $page == 'trash_massage.php' || $page == 'delivery_order.php' || $page == 'pickup_order.php' || $page == 'gift_order.php' || $page == 'read_massage.php'? 'active':''; ?>" >
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="inbox_massage.php" class="nav-link <?php echo $page == 'inbox_massage.php' || $page == 'sent_massage.php' || $page == 'draft_massage.php' || $page == 'trash_massage.php' || $page == 'delivery_order.php' || $page == 'pickup_order.php' || $page == 'gift_order.php'? 'active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link <?php echo $page == 'read_massage.php'? 'active': ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
            <li class="nav-item">
              <a href="sayadmin.php" class="nav-link <?php echo $page == 'sayadmin.php' || $page == 'sayadmin_massage.php' || $page == 'send_sayadmin.php' || $page == 'draft_sayadmin.php' || $page == 'trash_sayadmin.php' || $page == 'sayadmin_important.php' || $page == 'income_sayadmin.php' || $page == 'sayadmin_read_massage.php'? 'active': ''; ?>">
                <i class="nav-icon far fa-plus-square"></i>
                <p>Say Admin Massage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="themes.php" class="nav-link <?php echo $page == 'themes.php'? 'active':''; ?>">
                <i class="nav-icon far fa-image"></i>
                <p>Themes</p>
              </a>
            </li>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- /.navbar -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <!-- Content Wrapper. Contains page content -->
  