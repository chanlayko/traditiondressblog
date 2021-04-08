<?php 
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

    if(!empty($_POST['search'])) { 
        setcookie('search',empty($_POST['search']), time() + (86400 * 30), "/");
    }else{
        if(empty($_GET['pageno'])){
            unset($_COOKIE['search']);
            setcookie('search', null, -1, '/');
        }
    }

    if(!empty($_GET['pageno'])){
        $pageno = $_GET['pageno'];
    }else{
        $pageno = 1;
    }

    $numOfrecs = 10;
    $offset = ($pageno - 1) * $numOfrecs;

    if(empty($_POST['search']) && empty($_COOKIE['search'])){

      $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='pickup' ORDER BY id DESC");
      $stat -> execute();
      $result = $stat -> fetchAll();

      $total_count = count($result);

      $total_page = ceil(count($result) / $numOfrecs);

      $total_dev = $pageno * $numOfrecs;

      $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='pickup' ORDER BY id DESC LIMIT $offset,$numOfrecs");
      $stat -> execute();
      $result = $stat -> fetchAll();

    }else{

      $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];

      $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='pickup' AND mail LIKE '%$searchKey%' ORDER BY id DESC");
      $stat -> execute();
      $result = $stat -> fetchAll();

      $total_count = count($result);

      $total_page = ceil(count($result) / $numOfrecs);

      $total_dev = $pageno * $numOfrecs;

      $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='pickup' AND mail LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
      $stat -> execute();
      $result = $stat -> fetchAll();
    }


    if (isset($_POST['delete'])) {
      if (isset($_POST['checkboxAry'])) {
        foreach ($_POST['checkboxAry'] as $checkArray) {

          $stats = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$checkArray");
          $stats -> execute();
          $Results = $stats -> fetchAll();

          $send_id = $Results[0]['order_id'];

          $ats = $pdo -> prepare("SELECT * FROM user_order WHERE id=$send_id");
          $ats -> execute();
          $Resul = $ats -> fetchAll();

          if ($Resul[0]['gift_order'] == 'gift' || $Resul[0]['gift_order'] == 'pickup') {
            
            $name = $Resul[0]['gift_name'];
            $mail = $Results[0]['mail'];
            $subject = $Results[0]['subject'];
            $order = $Results[0]['order_id'];
            $author = $Results[0]['author_id'];

            $stat = $pdo -> prepare("INSERT INTO delete_trash(delete_id,name,mail,subject,order_id,author_id) VALUES (:delete_id,:name,:mail,:subject,:order_id,:author_id)");
            $Result = $stat -> execute([':delete_id'=>$checkArray,':name'=>$name,':mail'=>$mail,':subject'=>$subject,':order_id'=>$order,':author_id'=>$author]);

            $tesql = $pdo -> prepare("DELETE FROM send_mail WHERE id=$checkArray");
            $teResult = $tesql -> execute();
            if ($teResult) {
              echo "<script>alert('Sussessfully Deleted Updated');window.location.href='inbox_massage.php';</script>";
            }
          }else{
            $name = $Resul[0]['first_name'].' '.$Resul[0]['last_name'];
            $mail = $Results[0]['mail'];
            $subject = $Results[0]['subject'];
            $order = $Results[0]['order_id'];
            $author = $Results[0]['author_id'];

            $stat = $pdo -> prepare("INSERT INTO delete_trash(delete_id,name,mail,subject,order_id,author_id) VALUES (:delete_id,:name,:mail,:subject,:order_id,:author_id)");
            $Result = $stat -> execute([':delete_id'=>$checkArray,':name'=>$name,':mail'=>$mail,':subject'=>$subject,':order_id'=>$order,':author_id'=>$author]);

            $tesql = $pdo -> prepare("DELETE FROM send_mail WHERE id=$checkArray");
            $teResult = $tesql -> execute();
            if ($teResult) {
              echo "<script>alert('Sussessfully Deleted Updated');window.location.href='inbox_massage.php';</script>";
            }
          }
        }
      }
    }
    

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>

  <!-- /.navbar -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
<?php include_once ("navbar_massage.php") ?>
        
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
                    <?php echo $total_dev > $total_count ? $total_count : $total_dev; ?>/<?php echo $total_count; ?>
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
                            <input type="checkbox" name="checkboxAry[]" class="checkbox" value="<?php echo $value['id'] ?>" id="check1">
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
                  <?php echo $total_dev > $total_count? $total_count : $total_dev; ?>/<?php echo $total_count; ?>
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
