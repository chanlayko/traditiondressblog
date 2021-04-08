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
    
    $uspdo = $pdo -> prepare("SELECT * FROM user_register WHERE author_id=$author_id ORDER BY id DESC");
    $uspdo -> execute();
    $usResult = $uspdo -> fetchAll();

    if (isset($_GET['login'])) {
      $post_id = $_GET['login'];
      $pusql = $pdo -> prepare("UPDATE user_register SET login='login' WHERE id=$post_id");
      $result = $pusql -> execute();
      if($result){
        header("Location:massage.php");
          // echo "<script>alert('Sussessfully Public Updated');window.location.href='post.php';</script>";
      }
    }

    if (isset($_GET['unlogin'])) {
      $post_id = $_GET['unlogin'];
      $desql = $pdo -> prepare("UPDATE user_register SET login='unlogin' WHERE id=$post_id");
      $result = $desql -> execute();
      if($result){
        header("Location:massage.php");
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Login Active</th>
                                <th>Register At</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 

                                if($usResult){
                                    $i = 1;
                                    foreach($usResult as $value){
                                ?>
                                     <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo escape($value['first_name']) ?></td>
                                        <td><?php echo escape($value['last_name']) ?></td>
                                        <td><?php echo escape($value['email']) ?></td>
                                        <td align="center">
                                          <?php 
                                            if ($value['login'] == "login") {

                                          ?>
                                            <a href='massage.php?unlogin=<?php echo $value['id']; ?>'><button type="button" class="btn btn-block btn-outline-info" style="width:80px;">Login</button></a>
                                          <?php
                                            }else{
                                          ?>
                                            <a href='massage.php?login=<?php echo $value['id']; ?>'><button type="button" class="btn btn-block btn-outline-danger" style="width:80px;">Unlogin</button></a>
                                          <?php
                                            }

                                          ?>
                                          
                                        </td>
                                        <td><?php echo escape(date("d-m-Y",strtotime($value['create_at']))) ?></td>
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
