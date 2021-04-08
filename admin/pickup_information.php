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
    
    $uspdo = $pdo -> prepare("SELECT * FROM user_order WHERE users_id=$author_id AND gift_order='pickup' ORDER BY id DESC");
    $uspdo -> execute();
    $usResult = $uspdo -> fetchAll();

    if (isset($_GET['success'])) {
      $post_id = $_GET['success'];
      $pusql = $pdo -> prepare("UPDATE user_order SET taked='success' WHERE id=$post_id");
      $result = $pusql -> execute();
      if($result){
        header("Location:pickup_information.php");
          // echo "<script>alert('Sussessfully Public Updated');window.location.href='post.php';</script>";
      }
    }

    if (isset($_GET['draft'])) {
      $post_id = $_GET['draft'];
      $desql = $pdo -> prepare("UPDATE user_order SET taked='draft' WHERE id=$post_id");
      $result = $desql -> execute();
      if($result){
        header("Location:pickup_information.php");
      }
    }

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                   <div class="form-group table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="J_table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Pickup Name</th>
                                <th>Order Information</th>
                                <th>Order Price</th>
                                <th>Success/ Draft</th>
                                <th>Post Count</th>
                                <th>Created At</th>
                                <th>Mail</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 

                                if($usResult){
                                    $i = 1;
                                    foreach($usResult as $value){
                                      $order_id = $value['id'];
                                      $updo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_user_id=$order_id");
                                      $updo -> execute();
                                      $uResult = $updo -> fetchAll();
                                      $sal_count = count($uResult);
                                ?>
                                     <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo escape($value['gift_name']) ?></td>
                                        <td><?php echo escape($value['con_info']) ?></td>
                                        <td><?php echo escape($value['total_price']) ?> ks</td>
                                        <td>
                                          <?php 
                                            if ($value['taked'] == "success") {

                                          ?>
                                            <a href='pickup_massage.php?od_id=<?php echo $value['id']; ?>'><button type="button" class="btn btn-block btn-outline-success" onclick="return confirm('Success ,Are you sure, you want to Checking Your Order this item')">Success</button></a>
                                          <?php
                                            }else{
                                          ?>
                                            <a href='pickup_massage.php?od_id=<?php echo $value['id']; ?>'><button type="button" class="btn btn-block btn-outline-warning" onclick="return confirm('Draft ,Are you sure, you want to Checking Your Order this item')">Draft</button></a>
                                          <?php
                                            }

                                          ?>
                                        </td>
                                        <td align="center">
                                          <a href="pickup_massage.php?od_id=<?php echo $value['id']; ?>">
                                            <input type="button" value="<?php echo $sal_count; ?>" class="btn btn-block btn-outline-info" style="width: 40px;">
                                          </a>
                                        </td>
                                        <td><?php echo escape(date("d-m-Y",strtotime($value['order_date']))) ?></td>
                                        <td>
                                          <a href="pickup_send_massage.php?id=<?php echo $value['id']; ?>">
                                            <input type="button" class="btn btn-block btn-outline-info" value="Send Massage">    
                                          </a>
                                        </td>
                                        <td style="text-align: center;">
                                          <a href="massage_delete.php?user_id=<?php echo $value['id']; ?>"><input type="button" class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure, you want to delete this item')"></a>
                                        </td>
                                    </tr> 

                                <?php
                                    $i++;
                                    }
                                }

                            ?>
                           
                        </tbody>
                    </table>

                   </div>
              </div>
              <!-- /.card-body -->
              
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
