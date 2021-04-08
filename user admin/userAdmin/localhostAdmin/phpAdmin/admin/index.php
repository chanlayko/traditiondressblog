<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";
    
    if(empty($_SESSION['userid'] && $_SESSION['loggedin'])){
        header("Location: login.php");
    }

    if($_SESSION['roles'] != 1){
         header("Location: login.php");
    }
?>

<!-- header -->  
<?php include_once ("header.php"); ?>
<!-- nvabar include --> 
<?php include_once ("navbar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Welcome To Admin <span style="color: #007bce; "> <?php echo $_SESSION['username']; ?></span></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <?php 
              $author_id = $_SESSION['user_id'];

              $odstat = $pdo -> prepare("SELECT * FROM user_order WHERE users_id=$author_id");
              $odstat -> execute();
              $odresult = $odstat -> fetchAll();

              $odtotal_counts = count($odresult);
            ?>
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $odtotal_counts; ?></h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="order_information.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php 
              $author_id = $_SESSION['user_id'];

              $mastat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id");
              $mastat -> execute();
              $maresult = $mastat -> fetchAll();

              $matotal_counts = count($maresult);
            ?>
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $matotal_counts; ?></h3>

                <p>Inbox Massage</p>
              </div>
              <div class="icon">
                  <i class="nav-icon far fa-envelope"></i>
              </div>
              <a href="inbox_massage.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php 
            $author_id = $_SESSION['user_id'];

            $pdostat = $pdo -> prepare("SELECT * FROM user_register WHERE author_id=$author_id");
            $pdostat -> execute();
            $result = $pdostat -> fetchAll();

            $total_counts = count($result);
          ?>
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_counts; ?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="massage.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php 
            $author_id = $_SESSION['user_id'];

            $postat = $pdo -> prepare("SELECT * FROM posts WHERE author_id=$author_id");
            $postat -> execute();
            $poresult = $postat -> fetchAll();

            $pototal_counts = count($poresult);
          ?>
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $pototal_counts; ?></h3>

                <p>Post Count</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-th"></i>
              </div>
              <a href="post.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

 <?php include_once("footer.php"); ?>