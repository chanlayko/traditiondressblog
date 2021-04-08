<?php 









  ပိုေနေသာ အပိုင္ျဖစ္သည္
  









    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 'Admin'){
         header("Location: ../registeradmin/login.php");
    }
   
    $author_id = $_SESSION['user_id'];

    $order_id = $_GET['massage_id'];
    $mail_id = $_GET['id'];

    $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE order_id=$order_id AND id=$mail_id");
    $stat -> execute();
    $result = $stat -> fetchAll();

    // $author_id = $_SESSION['user_id'];

    // if (isset($_POST['send'])) {
    //   $order_id = $_POST['id'];

    //   $mail = $_POST['mail'];
    //   $subject = $_POST['subject'];
    //   $massage = $_POST['massage'];

    //   // $draft = $_POST['draft'];

    //   $stat = $pdo -> prepare("INSERT INTO send_mail(mail,subject,massage,order_id,author_id) VALUES (:mail,:subject,:massage,:order_id,:author_id)");
    //   $Result = $stat -> execute([':mail'=>$mail,':subject'=>$subject,':massage'=>$massage,':order_id'=>$order_id,':author_id'=>$author_id]);

    //   if ($Result) {
    //     echo "<script>alert('Sending Massage Sussessfully ..')</script>";
    //   }
    // }



?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>

  <!-- /.navbar -->
  
 
  
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
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                POSTS
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                REPORTS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weelkly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_customer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_saller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Saller</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="massage.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>YOUR'S REGISTER</p>
                <span class="badge badge-info right">2</span>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                ORDER
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="order_information.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gift_information.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gift Wrap Order</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sending Massage</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Mail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php 

      $order_id = $result[0]['order_id'];
      $pdoStat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
      $pdoStat -> execute();
      $pdoResult = $pdoStat -> fetch(PDO::FETCH_ASSOC);      

    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="order_information.php" class="btn btn-primary btn-block mb-3">Back to Mail</a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Information</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-circle text-danger"></i> <?php echo escape($pdoResult['first_name'] .' '.$pdoResult['last_name']); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-circle text-warning"></i> <?php echo escape($pdoResult['con_info']) ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-circle text-primary"></i> <?php echo escape($pdoResult['total_price']) ?> MMK</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="view_massage.php?id=<?php echo $pdoResult['id']; ?>"><i class="far fa-circle text-success"></i> <?php echo escape($pdoResult['order_count']) ?> Post Count</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Folders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <?php 

                  $author_id = $_SESSION['user_id'];

                  $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id");
                  $stat -> execute();
                  $results = $stat -> fetchAll();

                  $mail_count = count($results);

                  ?>
                  <li class="nav-item active">
                    <a href="inbox_massage.php" class="nav-link">
                      <i class="fas fa-inbox"></i> Inbox
                      <span class="badge bg-primary float-right"><?php echo $mail_count; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-envelope"></i> Sent
                    </a>
                  </li>
                  <?php 

                  $author_id = $_SESSION['user_id'];

                  $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND draft='draft'");
                  $stat -> execute();
                  $resultss = $stat -> fetchAll();

                  $draft_count = count($resultss);

                  ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-filter"></i> Drafts
                      <span class="badge bg-warning float-right"><?php echo $draft_count; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-trash-alt"></i> Trash
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <input type="hidden" name="id" value="<?php echo $_GET['massage_id']; ?>">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Send New Message</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group">
                    <input type="text"  value="<?php echo $pdoResult['con_info'] ?>" name="mail" class="form-control" placeholder="To:">
                  </div>
                  <div class="form-group">
                    <input type="text" name="subject" value="<?php echo escape($result[0]['subject']); ?>" class="form-control" placeholder="Subject:">
                  </div>
                  <div class="form-group">
                      <textarea id="compose-textarea" name="massage" class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php ?><?php echo escape($result[0]['massage']); ?></textarea>
                  </div>
                  <div class="form-group">
                    <div class="btn btn-default btn-file">
                      <i class="fas fa-paperclip"></i> Attachment
                      <input type="file" name="attachment">
                    </div>
                    <p class="help-block">Max. 32MB</p>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="float-right">
                    <a href="">
                      <button type="button" name="draft" value="draft" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                    </a>
                    <button type="submit" name="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                  </div>
                  <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </form>
            <!-- /.form -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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

<!--    footer end  -->
<?php include_once ("footer.php") ?>