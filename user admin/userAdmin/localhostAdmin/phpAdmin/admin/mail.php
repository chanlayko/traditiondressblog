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
        <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="#" class="btn btn-primary btn-block mb-3">Receive To Mail Users</a>

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

                  $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id ORDER BY id DESC");
                  $stat -> execute();
                  $mail_result = $stat -> fetchAll();

                  $mail_count = count($mail_result);

                ?>
                <li class="nav-item active">
                  <a href="inbox_massage.php" class="nav-link active">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right"><?php echo $mail_count == '0'? '' : $mail_count; ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="sent_massage.php" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <?php 

                $author_id = $_SESSION['user_id'];

                $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND draft='draft'");
                $stat -> execute();
                $results = $stat -> fetchAll();

                $draft_count = count($results);

                ?>
                <li class="nav-item">
                  <a href="draft_massage.php" class="nav-link">
                    <i class="fas fa-filter"></i> Drafts
                    <span class="badge bg-warning float-right"><?php echo $draft_count == '0'? '' : $draft_count; ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <?php 

                    $author_id = $_SESSION['user_id'];

                    $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id");
                    $stat -> execute();
                    $trashresults = $stat -> fetchAll();

                    $trash_count = count($trashresults);

                  ?>

                  <a href="trash_massage.php" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                    <span class="badge bg-danger float-right"><?php echo $trash_count == '0'? '' : $trash_count; ?></span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Labels</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="delivery_order.php" class="nav-link">
                    <i class="far fa-circle text-danger"></i>
                    Important
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pickup_order.php" class="nav-link">
                    <i class="far fa-circle text-warning"></i>
                    Promotions
                  </a>
                </li>
                <li class="nav-item">
                  <a href="gift_order.php" class="nav-link">
                    <i class="far fa-circle text-primary"></i>
                    Social
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
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>
              <form action="inbox_massage.php" method="post">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <div class="card-tools">
                  <div class="input-group input-group-sm col-md-4 float-right">
                    <input type="text" class="form-control" name="search" placeholder="Search Mail">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <div class="card-body p-0">
                <div class="mailbox-controls">
                  <button type="button" class="btn btn-default btn-sm" style="padding-top: 5px;">
                    <input type="checkbox" class="checkbox" id="checkboxAll">
                  </button>
                  <div class="btn-group">
                    <button type="submit" name="delete" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                    <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-reply"></i></button>
                    </a>
                    <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-share"></i></button>
                    </a>
                  </div>
                  <!-- /.btn-group -->
                  <a href="inbox_massage.php">
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                  </a>
                  <div class="float-right">
                    <!-- <?php echo $total_dev > $total_count ? $total_count : $total_dev; ?>/<?php echo $total_count; ?> -->
                    <div class="btn-group">
                      <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                        <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>">
                          <i class="fas fa-chevron-left"></i></button>
                      </a>
                      <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                        <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-chevron-right"></i></button>
                      </a>
                    </div>
                    <!-- /.btn-group -->
                  </div>
                <!-- /.float-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <tbody>
                      <?php 
                        if (!empty(($result))) {
                          
                          foreach ($result as $value) {

                          $order_id = $value['order_id']; 
                          $stat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
                          $stat -> execute();
                          $orderResult = $stat -> fetchAll();
                            
                      ?>
                      <tr>
                        <td>
                          <div class="icheck-primary">
                            <input type="checkbox" name="checkboxAry[]" class="checkbox" value="<?php echo $value['id'] ?>" id="">
                            <label for="check1"></label>
                          </div>
                        </td>
                        <td class="mailbox-star"><a title="Important"><?php echo $value['mail_star'] == 1 ? "<i class='fas fa-star text-warning'></i>" : " " ; ?></a></td>
                        <td class="mailbox-name"><a href="read_massage.php?massage_id=<?php echo $value['order_id']; ?>&id=<?php echo $value['id']; ?>"><?php echo escape($value['mail']); ?></a></td>
                        <td class="mailbox-subject"><b><?php echo escape($value['subject']); ?></b> - <?php echo escape(substr($value['massage'], 0,80)) ?> . . . 
                        </td>
                        <td class="mailbox-attachment"><?php echo escape($value['draft']) == 'draft'? '<i class="fas fa-filter" title="Draft"></i>' : ''; ?></td>
                        <td class="mailbox-date" style="width: 115px;"><?php echo escape(date("d-m-Y",strtotime($value['created_at']))); ?></td>
                      </tr>

                      <?php     
                          }
                        }
                      ?>
                    
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer p-0">
                <div class="mailbox-controls">
                <button type="button" class="btn btn-default btn-sm" style="padding-top: 5px;">
                  <input type="checkbox" class="checkbox" id="checkboxAlls">
                </button>
                </button>
                <div class="btn-group">
                  <button type="submit" name="delete" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                  <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                    <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-reply"></i></button>
                  </a>
                  <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                    <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-share"></i></button>
                  </a>
                </div>
                  <!-- /.btn-group -->
                <a href="inbox_massage.php">
                  <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                </a>
                <div class="float-right">
                  <!-- <?php echo $total_dev > $total_count? $total_count : $total_dev; ?>/<?php echo $total_count; ?> -->
                  <div class="btn-group">
                      <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                        <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-chevron-left"></i></button>
                      </a>
                      <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                        <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-chevron-right"></i></button>
                      </a>
                    </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
                </div>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
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