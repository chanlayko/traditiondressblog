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

    $post_id = $_GET['post_id'];

    $sql = "SELECT * FROM sal_order WHERE sal_post_id=$post_id";
    $pdostat = $pdo -> prepare($sql);
    $pdostat -> execute();
    $results = $pdostat -> fetchAll();

    $total_count = count($results);

 
?>
 
<!-- header --> 
<?php include_once ("header.php"); ?> 
<!-- nvabar include -->
<?php include_once ("navbar.php"); ?> 
<!-- Main Sidebar Container -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <?php 
                      $pdostat = $pdo -> prepare("SELECT * FROM posts WHERE id=$post_id");
                      $pdostat -> execute();
                      $RowResult = $pdostat -> fetchAll();
                    ?>
                    <div>
                      <h3><?php echo $RowResult[0]['title']; ?></h3>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <h6 class="float-md-right"><span class="badge badge-info"><?php echo $total_count; ?></span> Massage Counts</h6>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div>
              <div class="card-body">
                
               <div class="form-group table-responsive">
                <table class="table table-bordered table-striped table-hover" id="J_table">
                  <thead class="text-center">
                    <tr>
                      <th>#</th>
                      <th>Order Name</th>
                      <th>Order Information</th>
                      <th>Order Price</th>
                      <th>Post Count</th>
                      <th>Order-Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if ($results) {
                      $i = 1;
                      foreach ($results as $values) {
                        
                        $order_id = $values['sal_user_id'];

                        $sql = "SELECT * FROM user_order WHERE id=$order_id ORDER BY id DESC";
                        $pdostat = $pdo -> prepare($sql);
                        $pdostat -> execute();
                        $result = $pdostat -> fetchAll();

                        if($result){
                            foreach($result as $value){

                        ?>
                              <tr>
                                <td align="center"><?php echo $i; ?></td>
                                <td><?php echo escape($value['first_name']." ".$value['last_name']); ?></td>
                                <td><?php echo escape($value['con_info']) ?></td>
                                <td><?php echo escape($value['total_price']);?> ks</td>
                                <td align="center">
                                  <?php
                                    $orders_id = $value['id'];
                                    $sql = "SELECT * FROM sal_order WHERE sal_user_id=$orders_id";
                                    $stat = $pdo -> prepare($sql);
                                    $stat -> execute();
                                    $Salresult = $stat -> fetchAll();
                                    $sal_count = count($Salresult);
                                   ?>
                                  <a href="<?php
                                      if($value['gift_order'] == 'gift'){
                                        echo 'gift_massage.php';
                                      }else if($value['gift_order'] == 'pickup'){
                                        echo 'pickup_massage.php';
                                      }else{
                                        echo 'view_massage.php';
                                      }

                                   ?>?od_id=<?php echo $value['id']; ?>">
                                    <input type="button" value="<?php echo $sal_count; ?>" class="btn btn-block btn-outline-info" style="width: 40px;">
                                  </a>

                                  <?php 
                                     
                                  ?>
                                </td>
                                <td><?php echo escape(date("d-m-Y",strtotime($value['order_date']))); ?></td>
                            </tr>  

                        <?php
                            }
                        }
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

 <?php include_once("footer.php"); ?>
