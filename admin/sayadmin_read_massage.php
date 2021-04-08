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

    $massage_id = $_GET['massage_id'];

    $stats = $pdo -> prepare("SELECT * FROM admin_user");
    $stats -> execute();
    $Results = $stats -> fetchAll();

    $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$massage_id");
    $stat -> execute();
    $Result = $stat -> fetchAll();

    if (isset($_POST['readDelete'])) {

      $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$massage_id");
      $stat -> execute();
      $result = $stat -> fetchAll();

      $order_id = $result[0]['order_id'];

      $dstat = $pdo -> prepare("SELECT * FROM admin_user");
      $dstat -> execute();
      $dresult = $dstat -> fetchAll();

        $name = $dresult[0]['username'];
        $mail = $result[0]['mail'];
        $subject = $result[0]['subject'];
        $author = $result[0]['author_id'];

        $stat = $pdo -> prepare("INSERT INTO delete_trash(delete_id,name,mail,subject,sayadmin,author_id) VALUES (:delete_id,:name,:mail,:subject,:sayadmin,:author_id)");
        $Result = $stat -> execute([':delete_id'=>$massage_id,':name'=>$name,':mail'=>$mail,':sayadmin'=>'admin',':subject'=>$subject,':author_id'=>$author]);

        $tesql = $pdo -> prepare("DELETE FROM send_mail WHERE id=$massage_id");
        $teResult = $tesql -> execute();
        if ($teResult) {
          echo "<script>alert('Sussessfully Deleted Updated');window.location.href='sayadmin.php';</script>";
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
<?php include_once ('navbar_sayadmin.php') ?>

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
                  <h5>Name : <?php echo escape($Results[0]['username']);?>&nbsp;&nbsp; <?php echo $Result[0]['mail_star'] == '1'? '<i class="fas fa-star text-danger"></i>':'';?></h5>
                  <h5>Message Subject : <?php echo escape($Result[0]['subject']); ?></h5>
                  <h6>Mail From: <?php echo escape($Result[0]['mail']); ?>
                    <span class="mailbox-read-time float-right"><?php echo $Result[0]['created_at'] ?></span></h6>
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
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                  <?php echo $Result[0]['massage']; ?>
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
