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
   
    $send_id = $_GET['se_id'];

    $stats = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$send_id");
    $stats -> execute();
    $results = $stats -> fetchAll();

    if (isset($_POST['send'])) {

      $send_id = $_GET['se_id'];

      $sql = "DELETE FROM send_mail WHERE id=$send_id";
      $pdostat = $pdo -> prepare($sql);
      $result = $pdostat -> execute();

      $order_method = $results[0]['order_method'];
      $order_id = $_POST['id'];
      $star = $_POST['star'];
      $mail = $_POST['mail'];
      $subject = $_POST['subject'];
      $massage = $_POST['massage'];

      $stat = $pdo -> prepare("INSERT INTO send_mail(mail,subject,massage,draft,order_method,mail_star,order_id,author_id) VALUES (:mail,:subject,:massage,:draft,:order_method,:mail_star,:order_id,:author_id)");
      $Result = $stat -> execute([':mail'=>$mail,':subject'=>$subject,':massage'=>$massage,':draft'=>'sent',':order_method'=>$order_method,':mail_star'=>$star,':order_id'=>$order_id,':author_id'=>$author_id]);

      if ($Result) {
        // $sed_id = $pdo -> lastInsertId();
        echo "<script>alert('Sending Massage Sussessfully In Send ..');window.location.href='inbox_massage.php';</script>";
      }
    }

    if (isset($_POST['draft'])) {

      $send_id = $_GET['se_id'];

      $order_id = $_POST['id'];

      $order_method = $results[0]['order_method'];

      $star = $_POST['star'];
      $mail = $_POST['mail'];
      $subject = $_POST['subject'];
      $massage = $_POST['massage'];

      $stat = $pdo -> prepare("UPDATE send_mail SET mail='$mail',subject='$subject',massage='$massage',draft='draft',order_method='$order_method',mail_star='$star',order_id='$order_id',author_id='$author_id' WHERE id=$send_id");
      $Result = $stat -> execute();

      if ($Result) {
        echo "<script>alert('Update Massage Sussessfully In Draft ..');window.location.href='inbox_massage.php';</script>";
      }
    }



?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>

  <!-- /.navbar -->
  
    <?php 

      $order_id = $_GET['id'];

      $pdoStat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
      $pdoStat -> execute();
      $pdoResult = $pdoStat -> fetch(PDO::FETCH_ASSOC);      

      $updo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_user_id=$order_id");
      $updo -> execute();
      $uResult = $updo -> fetchAll();
      $sal_count = count($uResult);
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="order_information.php" class="btn btn-primary btn-block mb-3">Back to Delivery Order</a>
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
                    <a class="nav-link" href="#"><i class="far fa-circle text-danger"></i>
                     <?php
                        $order_id = $_GET['id'];
                        $Stat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
                        $Stat -> execute();
                        $Result = $Stat -> fetchAll(); 

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

                        $send_id = $_GET['se_id'];
                        $tat = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$send_id");
                        $tat -> execute();
                        $Resul = $tat -> fetchAll(); 

                        if ($Resul[0]['mail_star'] == 1) {
                          echo "<i class='fas fa-star text-warning float-right' id='ast' title='Important'></i>";
                        }else{
                          echo "<i class='fas fa-star text-warning float-right' id='asta' title='Important'></i>";
                        }

                      ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-circle text-warning"></i> <?php echo escape($pdoResult['con_info']) ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-circle text-primary"></i> <?php echo escape($pdoResult['total_price']) ?> MMK</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php if($Result[0]['gift_order'] == 'gift'){echo 'gift_massage.php';}elseif($Result[0]['gift_order'] == 'pickup'){echo 'pickup_massage.php';}else{echo 'view_massage.php';} ?>?od_id=<?php echo $pdoResult['id']; ?>"><i class="far fa-circle text-success"></i> <?php echo $sal_count; ?> Post Count</a>
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
                    $result = $stat -> fetchAll();

                    $mail_count = count($result);
                  ?>
                  <li class="nav-item active">
                    <a href="inbox_massage.php" class="nav-link">
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
                  $resultss = $stat -> fetchAll();

                  $draft_count = count($resultss);

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
            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Send New Message</h3>
                </div>
                <!-- /.card-header -->
                <?php 
                  $rep_id = $_GET['id'];
                  $send_id = $_GET['se_id'];
                  $at = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$send_id AND order_id=$rep_id");
                  $at -> execute();
                  $resul = $at -> fetchAll();
                ?>
                <div class="card-body">
                  <div class="form-group">
                    <input type="text"  value="<?php echo $pdoResult['con_info'] ?>" name="mail" class="form-control" placeholder="To:">
                  </div>
                  <div class="form-group">
                    <input type="text" name="subject" value="<?php echo $resul[0]['subject']; ?>" class="form-control" id="sendsubject" placeholder="Subject:" required>
                  </div>
                  <div class="form-group" >
                    <input type="text" name="star" value="<?php echo $Resul[0]['mail_star'] ?>" id="checkboxsta">
                  </div>
                  <div class="form-group">
                      <textarea id="compose-textarea" name="massage" class="form-control sendtext" style="height: 300px" required>
                        <?php echo $resul[0]['massage']; ?>
                      </textarea>
                  </div>
                  <div class="form-group">
                    <?php
                      $send_id = $_GET['se_id'];

                      $tat = $pdo -> prepare("SELECT * FROM send_mail WHERE id=$send_id");
                      $tat -> execute();
                      $Resul = $tat -> fetchAll(); 

                      if ($Resul[0]['mail_star'] == 1) {
                        echo '<div class="float-right">
                                <div class="btn btn-default" id="btnst" style="border:1px solid yellow;">
                                  <i class="fas fa-star text-warning"></i> Important
                                </div>
                              </div>
                              <div class="float-right">
                                <div class="btn btn-default" id="btnst1">
                                  <i class="fas fa-star text-warning"></i> Important
                                </div>
                              </div>';
                      }else{
                        echo '<div class="float-right">
                                <div class="btn btn-default" id="btnsta1">
                                  <i class="fas fa-star text-warning"></i> Important
                                </div>
                              </div>
                              <div class="float-right">
                                <div class="btn btn-default" id="btnsta" style="border:1px solid yellow;">
                                  <i class="fas fa-star text-warning"></i> Important
                                </div>
                              </div>';
                      }

                    ?>
                    
                    
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
                    <button type="submit" name="draft" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                    <button type="submit" name="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                  </div>
                  <button type="button" id="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
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
