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
    
    $sql = "SELECT * FROM user_order WHERE users_id=$author_id ORDER BY id DESC";
    $pdostat = $pdo -> prepare($sql);
    $pdostat -> execute();
    $result = $pdostat -> fetchAll(); 


    if (isset($_POST['filter'])) {
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];
      $sql = $pdo -> prepare("SELECT * FROM user_order WHERE users_id=$author_id AND order_date BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC");
      $sql -> execute();
      $result = $sql -> fetchAll();
    }else{
      $sql = "SELECT * FROM user_order WHERE users_id=$author_id ORDER BY id DESC";
      $pdostat = $pdo -> prepare($sql);
      $pdostat -> execute();
      $result = $pdostat -> fetchAll(); 
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
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <div class="form-group col-md-7 col-sm-6">
                  <form action="" method="post">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="row">
                        Show Form
                        <div class="col-md-4">
                          <input type="date" style="" name="from_date" id="form_date" class="form-control" required>
                        </div>
                        To 
                        <div class="col-md-4 mb-1">
                          <input type="date" style="" name="to_date" id="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                          <input type="submit" value="Submit" name="filter" id="filter">
                        </div>
                      </div>                  
                  </form>
                </div><br>
                   <div class="form-group table-responsive" id="order_table">
                    <table class="table table-bordered table-striped table-hover" id="J_table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Order Name</th>
                                <th>Order information</th>
                                <th>Order Price</th>
                                <th>Post Count</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 

                                if(!empty($result)){
                                    $i = 1;
                                    foreach($result as $value){
                                      $gift_order = $value['gift_order'];

                                ?>
                                     <tr>
                                        <td><?php echo $i ?></td>
                                        <td>
                                          <?php 
                                            if ($gift_order == 'gift' || $gift_order == 'pickup') {
                                              echo escape($value['gift_name']);
                                            }else{
                                              echo escape($value['first_name'].' '.$value['last_name']);
                                            }
                                          ?>
                                        </td>
                                        <td><?php echo escape($value['con_info']) ?></td>
                                        <td><?php echo escape($value['total_price']) ?> ks</td>
                                        <td align="center">
                                          <?php 
                                            $order_id = $value['id'];
                                            $sql = "SELECT * FROM sal_order WHERE sal_user_id=$order_id ORDER BY id DESC";
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
                                        </td>
                                        <td><?php echo escape(date('d-m-Y',strtotime($value['order_date']))) ?></td>
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
