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
    
    $order_id = $_GET['od_id'];

    $pdoStat = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
    $pdoStat -> execute();
    $pdoResult = $pdoStat -> fetchAll();

    // $post_id = $pdoResult[0]['post_id'];

    // $sql = $pdo -> prepare("SELECT * FROM posts WHERE id=$post_id");
    // $sql -> execute();
    // $Result = $sql -> fetchAll();

    if (!empty(isset($_POST['delete']))) {
      if (isset($_POST['checkboxArrays'])) {
        foreach ($_POST['checkboxArrays'] as $valueId) {
          $sql = "DELETE FROM sal_order WHERE sal_post_id=$valueId AND sal_user_id=$order_id";
          $pdostat = $pdo -> prepare($sql);
          $result = $pdostat -> execute();
          if ($result) {
            $posql = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_user_id=$order_id");
            $posql -> execute();
            $poResult = $posql -> fetchAll();
            $userID = $poResult[0]['sal_user_id'];
            if ($userID == null) {
              $sql = "DELETE FROM user_order WHERE id=$order_id";
              $pdostat = $pdo -> prepare($sql);
              $result = $pdostat -> execute();

              $sql = "DELETE FROM sal_order WHERE sal_user_id=$order_id";
              $pdostat = $pdo -> prepare($sql);
              $result = $pdostat -> execute();

              $sql = "DELETE FROM send_mail WHERE order_id=$order_id";
              $pdostat = $pdo -> prepare($sql);
              $result = $pdostat -> execute();
              
              header("Location:pickup_information.php");
            }
            echo "<script>alert('Success ,your Item Delete.');window.location.href='pickup_massage.php?od_id=$order_id';</script>";
          }
        }
      }
      echo "<script>alert('Select to checkbox want to Delete for you item');window.location.href='pickup_massage.php?od_id=$order_id';</script>";
    }

    if (isset($_POST['success'])) {
      // $sal_qty = $_POST['sal_qty'];

      $pusql = $pdo -> prepare("UPDATE user_order SET taked='success' WHERE id=$order_id");
      $result = $pusql -> execute();

      // $sql = $pdo -> prepare("UPDATE sal_order SET sal_qty='$sal_qty' WHERE id=$valueId");
      // $results = $sql -> execute();

        header("Location:pickup_information.php");
      // if($result){
      //     echo "<script>alert('Success alert preview. This alert is dismissable.');window.location.href='pickup_information.php';</script>";
      // }

    }

    if (isset($_POST['draft'])) {
      // $sal_qty = $_POST['sal_qty'];
      // $post_id = $_GET['od_id'];
      $sql = $pdo -> prepare("UPDATE user_order SET taked='draft' WHERE id=$order_id");
      $result = $sql -> execute();

        header("Location:pickup_information.php");
      // $pusql = $pdo -> prepare("UPDATE sal_order SET sal_qty='$sal_qty' WHERE id=$post_id");
      // $results = $pusql -> execute();
      // if($result AND $results){
        // echo "<script>alert('Draft alert preview. This alert is dismissable.');window.location.href='pickup_information.php';</script>";
      // }
    }

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>

  <!-- /.navbar -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="m-0">Pickup Order Massage Feature</h3>
              </div>
              <br>
              <!-- <div class="card-body"> -->
                <div class="card card-default">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- <div class="row"> -->
                      <!-- <div class="col-md-12"> -->
                        <div class="form-group">
                          <form action="" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <div class="row">
                              <div class="col-md-6 mb-1">
                                <div class="row">
                                  <div class="col-md-12 mb-4">
                                    <label class="form-control-label">Order Information</label>
                                    <input type="text" class="form-control" value="<?php echo escape($pdoResult[0]['con_info']); ?>" disabled>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6 mb-2">
                                    <label class="form-control-label">Pickup Order Name</label>
                                    <input type="text" class="form-control" value="<?php echo escape($pdoResult[0]['gift_name']); ?>" disabled>  
                                  </div>
                                  <div class="col-md-6">
                                    <label class="form-control-label">Pickup Order Phone Number</label>
                                    <input type="text" class="form-control" value="<?php echo escape($pdoResult[0]['phone']); ?>" disabled>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label class="form-control-label">Pickup Order Total Prices</label>
                                    <input type="text" class="form-control" value="<?php echo escape($pdoResult[0]['total_price']); ?> MMK" disabled>
                                  </div>
                                  <div class="col-md-6">
                                    <label class="form-control-label">Pickup Order Date</label>
                                    <input type="text" class="form-control" value="<?php echo escape(date("d-m-Y",strtotime($pdoResult[0]['order_date']))); ?>" disabled>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6" style="margin-top: 30px;">
                                <div class="row">
                                  <div class="col-md-12 mb-3">
                                      <?php 
                                        $order_id = $_GET['od_id'];
                                        $pdostat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_user_id=$order_id");
                                        $pdostat -> execute(); 
                                        $results = $pdostat -> fetchAll();

                                        $order_count = count($results);
                                      ?>
                                      <input type="button" class="btn btn-block bg-gradient-secondary" value="<?php echo escape($order_count); ?> Count | Show Post Order !">
                                  </div>
                                  <div class="col-md-12">
                                    <?php 

                                      $stat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_user_id=$order_id");
                                      $stat -> execute();
                                      $statResult = $stat -> fetchAll();                                

                                      foreach ($statResult as $value) {

                                    ?>
                                    <div class="row mb-3">
                                        <?php
                                          $sal_post_id = $value['sal_post_id'];

                                          $sql = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$sal_post_id");
                                          $sql -> execute();
                                          $Result = $sql -> fetchAll();

                                        ?>

                                        <div class="col-md-4 col-4 mb-2">
                                          <img src="images/<?php echo $Result[0]['image_name']; ?>" alt="" style="width: 100px;">
                                        </div>
                                        <div class="col-md-1 col-1 mb-2" >
                                          <div class="" >
                                            <input type="checkbox" class="checkbox" name="checkboxArrays[]" value="<?php echo $sal_post_id; ?>">
                                          </div>
                                        </div>
                                        <?php 
                                          $sal_post_id = $Result[0]['post_image_id'];
                                          $sql = $pdo -> prepare("SELECT * FROM posts WHERE id=$sal_post_id");
                                          $sql -> execute();
                                          $Results = $sql -> fetchAll();

                                          $post_id = $Results[0]['id'];

                                        ?>
                                        <div class="col-md-5 col-5 mb-2">
                                          <?php echo escape($Results[0]['title']) ?>
                                        </div>
                                        <div class="col-md-2 col-2 mb-2" style="margin-left: -10px; ">
                                          <input type="text" class="form-control" value="<?php echo $value['sal_qty']; ?>" style="text-align: center;width: 50px;" >
                                        </div>
                                        <div class="col-md-6 col-12 mb-2">
                                          <a href="edit.php?id=<?php echo $post_id; ?>">
                                            <input type="button" value="View Post" class="form-control btn btn-block btn-outline-info">
                                          </a>
                                        </div>

                                        <?php

                                        ?>

                                    </div>

                                    <?php
                                      }
                                    ?>
                                  </div>
                                  <div class="col-md-6">
                                    <?php 
                                      $order_id = $_GET['od_id'];
                                      $susql = $pdo -> prepare("SELECT * FROM user_order WHERE id=$order_id");
                                      $susql -> execute();
                                      $suResults = $susql -> fetchAll();

                                      if ($suResults[0]['taked'] == 'success') {
                                    ?>
                                      <button type="submit" name="draft" class="btn btn-block bg-gradient-success btn-lg" onclick="return confirm('Are you sure Checking if you receive order item ...')">Success</button>
                                    <?php
                                      }else{
                                    ?>
                                      <button type="submit" name="success" class="btn btn-block bg-gradient-warning btn-lg" onclick="return confirm('Are you sure Checking if you receive order item...')">Draft</button>
                                    <?php
                                      }
                                    ?>

                                  </div>
                                  <div class="col-md-6">
                                    <button type="submit" name="delete" class="btn btn-block bg-gradient-danger btn-lg">Delete</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <!-- form end -->
                        <!-- </div> -->
                        
                      <!-- </div> -->
                      
                    </div>
                    <!-- /.row -->
                  </div>
                  <div class="card-footer">
                    Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
                    the plugin.
                  </div>
                </div>
              <!-- </div> -->
            </div>
          </div>
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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

<!--    footer end  -->
<?php include_once ("footer.php") ?>