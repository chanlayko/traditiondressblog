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

    // $massage_id = $_GET['massage_id'];

    $id = $_GET['id'];

    $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$id");
    $stat -> execute();
    $result = $stat -> fetchAll();

    if (isset($_POST['readDelete'])) {

      $order_id = $result[0]['order_id'];

      $dstat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
      $dstat -> execute();
      $dresult = $dstat -> fetchAll();

      if ($dresult[0]['gift_order'] == 'gift' || $dresult[0]['gift_order'] == 'pickup') {

        $name = $dresult[0]['gift_name'];
        $mail = $result[0]['mail'];
        $subject = $result[0]['subject'];
        $order = $result[0]['order_id'];
        $author = $result[0]['author_id'];

        $stat = $pdo -> prepare("INSERT INTO delete_trash(delete_id,name,mail,subject,order_id,author_id) VALUES (:delete_id,:name,:mail,:subject,:order_id,:author_id)");
        $Result = $stat -> execute([':delete_id'=>$id,':name'=>$name,':mail'=>$mail,':subject'=>$subject,':order_id'=>$order,':author_id'=>$author]);

        $tesql = $pdo -> prepare("DELETE FROM send_mail WHERE id=$id");
        $teResult = $tesql -> execute();
        if ($teResult) {
          echo "<script>alert('Sussessfully Deleted Updated');window.location.href='inbox_massage.php';</script>";
        }
      }else{

        $name = $dresult[0]['first_name'].' '.$dresult[0]['last_name'];
        $mail = $result[0]['mail'];
        $subject = $result[0]['subject'];
        $order = $result[0]['order_id'];
        $author = $result[0]['author_id'];

        $stat = $pdo -> prepare("INSERT INTO delete_trash(delete_id,name,mail,subject,order_id,author_id) VALUES (:delete_id,:name,:mail,:subject,:order_id,:author_id)");
        $Result = $stat -> execute([':delete_id'=>$id,':name'=>$name,':mail'=>$mail,':subject'=>$subject,':order_id'=>$order,':author_id'=>$author]);

        $tesql = $pdo -> prepare("DELETE FROM send_mail WHERE id=$id");
        $teResult = $tesql -> execute();
        if ($teResult) {
          echo "<script>alert('Sussessfully Deleted Updated');window.location.href='inbox_massage.php';</script>";
        }
      }

    }

    if (isset($_POST['read_send'])) {
      $send_id = $_GET['id'];

      $stat = $pdo -> prepare("UPDATE send_mail SET draft='sent' WHERE id=$send_id");
      $updResult = $stat -> execute();
      if ($updResult) {
        echo "<script>alert('Sussessfully Sending Massage Updated');window.location.href='inbox_massage.php';</script>";
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
            <form action="" method="post">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <div class="card-header">
                <h3 class="card-title">Read Mail</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i class="fas fa-chevron-left"></i></a>
                  <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Next"><i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="mailbox-read-info">
                  <?php 
                    $order_id = $result[0]['order_id'];
                    $stat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
                    $stat -> execute();
                    $Result = $stat -> fetchAll();
                  ?>
                  <h5>Name : 
                    <?php 
                      if ($Result[0]['gift_order'] == 'gift') {
                        $stat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id AND gift_order='gift'");
                        $stat -> execute();
                        $Result = $stat -> fetchAll();
                        echo $Result[0]['gift_name'];
                      }else if ($Result[0]['gift_order'] == 'pickup') {
                        $stat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id AND gift_order='pickup'");
                        $stat -> execute();
                        $Result = $stat -> fetchAll();
                        echo $Result[0]['gift_name'];
                      }else{
                        echo $Result[0]['first_name'].' '.$Result[0]['last_name'];
                      }
                    ?>
                      
                  </h5>
                  <h5>Message Subject : <?php echo escape($result[0]['subject']); ?></h5>
                  <h6>Mail From: <?php echo escape($result[0]['mail']); ?>
                    <span class="mailbox-read-time float-right"><?php echo $result[0]['created_at'] ?></span></h6>
                </div>
                <!-- /.mailbox-read-info -->
                <div class="mailbox-controls with-border text-center">
                  <div class="btn-group">
                    <button type="submit" name="readDelete" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                      <i class="far fa-trash-alt"></i></button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                      <i class="fas fa-reply"></i></button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                      <i class="fas fa-share"></i></button>
                  </div>
                  <!-- /.btn-group -->
                  <?php 
                    $order_id = $_GET['id'];

                    $stats = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$order_id");
                    $stats -> execute();
                    $Results = $stats -> fetchAll();

                    if ($Results[0]['draft'] == 'draft') {
                      echo '<button type="button" class="btn btn-warning btn-sm disabled" data-toggle="tooltip" title="Print">
                    <i class="fas fa-filter"> </i> Draft
                  </button>';
                    }else{
                      echo '<button type="button" class="btn btn-warning btn-sm disabled" data-toggle="tooltip" title="Print">
                    <i class="fas fa-envelope"></i> sent
                  </button>';
                    }
                  ?>
                  
                  
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                  <?php echo $result[0]['massage']; ?>
                </div>
                <!-- /.mailbox-read-message -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-white">
                <!-- -------------- ///////// ------------------ -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <div class="float-right">
                <?php 
                  $order_id = $_GET['id'];

                  $stats = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$order_id");
                  $stats -> execute();
                  $Results = $stats -> fetchAll();
                ?>
                  ‌<a href="send_edit_massage.php?id=<?php echo $Results[0]['order_id']; ?>&se_id=<?php echo $order_id; ?>">
                    <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                  </a>
                  <button type="submit" name="read_send" class="btn btn-default" <?php echo $Results[0]['draft'] != 'draft' ? 'disabled' : ''; ?> ><i class="far fa-envelope"></i> Send</button>
                </div>
                <button type="submit" name="readDelete" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                
              </div>
              <!-- /.card-footer -->
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
