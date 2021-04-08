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

    if (isset($_POST['send'])) {

      $mail = $_POST['mail'];
      $subject = $_POST['subject'];
      $massage = $_POST['massage'];
      if ($subject == '' || $massage == '') {
        echo "<script>alert('Please ,Something to write checking to Subject and Massage !!!')</script>";
      }else{
        $star = $_POST['star'];

        $stat = $pdo -> prepare("INSERT INTO send_mail(mail,subject,massage,draft,order_method,mail_star,sayadmin,author_id) VALUES (:mail,:subject,:massage,:draft,:order_method,:mail_star,:sayadmin,:author_id)");
        $Result = $stat -> execute([':mail'=>$mail,':subject'=>$subject,':massage'=>$massage,':draft'=>'sent',':order_method'=>'send',':mail_star'=>$star,':sayadmin'=>'sayadmin',':author_id'=>$author_id]);

        if ($Result) {
          echo "<script>alert('Sending Massage Sussessfully In Send ..');window.location.href='sayadmin.php';</script>";
        }
      }
    }

    if (isset($_POST['draft'])) {

      $star = $_POST['star'];

      $mail = $_POST['mail'];
      $subject = $_POST['subject'];
      $massage = $_POST['massage'];
      if ($subject == '' || $massage == '') {
        echo "<script>alert('Please ,Something to write checking to Subject and Massage !!!')</script>";
      }else{
        $stat = $pdo -> prepare("INSERT INTO send_mail(mail,subject,massage,draft,order_method,mail_star,sayadmin,author_id) VALUES (:mail,:subject,:massage,:draft,:order_method,:mail_star,:sayadmin,:author_id)");
        $Result = $stat -> execute([':mail'=>$mail,':subject'=>$subject,':massage'=>$massage,':draft'=>'draft',':order_method'=>'sayadmin',':mail_star'=>$star,':sayadmin'=>'sayadmin',':author_id'=>$author_id]);

        if ($Result) {
          echo "<script>alert('Sending Massage Sussessfully In Draft ..');window.location.href='sayadmin.php';</script>";
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
<?php include_once ('navbar_sayadmin.php') ?>
       
        <!-- /.col -->
        <div class="col-md-9">
          <form action="" method="post">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Compose New Message &nbsp;&nbsp;<i class='fas fa-star text-danger float-right' id="astar"></i></h3>
              </div>
              <!-- /.card-header -->
              <?php
                $sql = $pdo -> prepare("SELECT * FROM admin_user");
                $sql -> execute();
                $result = $sql -> fetchAll();
               ?>
                <div class="card-body">
                  <div class="form-group">
                    <input class="form-control" name="mail" value="<?php echo $result[0]['email']; ?>" placeholder="To:">
                  </div>
                  <div class="form-group">
                    <input class="form-control" name="subject" placeholder="Subject:">
                  </div>
                  <div class="form-group" >
                      <input type="text" name="star" value="" id="checkboxstar">
                    </div>
                  <div class="form-group">
                      <textarea id="compose-textarea" name="massage" class="form-control" style="height: 300px">
                        
                      </textarea>
                  </div>
                  <div class="form-group">
                     <div class="float-right">
                        <div class="btn btn-default" id="btnstar1">
                          <i class='fas fa-star text-danger'></i> Important
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="btn btn-default" id="btnstar" style="border:1px solid red;">
                          <i class='fas fa-star text-danger'></i> Important
                        </div>
                      </div>
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
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
              </div>
              <!-- /.card-footer -->
            </div>
          </form>
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
