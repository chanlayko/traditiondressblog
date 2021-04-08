<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";
    
    if(empty($_SESSION['userid'] && $_SESSION['loggedin'])){
        header("Location: login.php");
    }

    if($_SESSION['roles'] != 1){
         header("Location: login.php");
    }

    // if(!empty($_GET['pageno'])){
    //     $pageno = $_GET['pageno'];
    // }else{
    //     $pageno = 1;
    // }
    // $numOfrecs = 3;
    // $offset = ($pageno - 1) * $numOfrecs;
    
    // if(empty($_POST['search'])){
        $pdostat = $pdo -> prepare("SELECT * FROM users ORDER BY id DESC");
        $pdostat -> execute();
        $result = $pdostat -> fetchAll();
        $total_user = count($result);
                // $total_pages = ceil(count($RowResult) / $numOfrecs);

        // $sql = "SELECT * FROM admin_user ORDER BY id DESC LIMIT $offset,$numOfrecs";
        // $pdostat = $pdo -> prepare($sql);
        // $pdostat -> execute();
        // $result = $pdostat -> fetchAll();
        
    // }else{
    //     $searchkey = $_POST['search'];
    //     $sql = "SELECT * FROM admin_user WHERE username LIKE '%$searchkey%' ORDER BY id DESC";
    //     $pdostat = $pdo -> prepare($sql);
    //     $pdostat -> execute();
    //     $RowResult = $pdostat -> fetchAll();
    //     $total_pages = ceil(count($RowResult) / $numOfrecs);

    //     $sql = "SELECT * FROM admin_user WHERE username LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$numOfrecs";
    //     $pdostat = $pdo -> prepare($sql);
    //     $pdostat -> execute();
    //     $result = $pdostat -> fetchAll();
    // } 
    
    
?>

<!-- header -->
<?php include_once ("header.php"); ?>
<!-- nvabar include -->
<?php include_once ("navbar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Welcome To Admin <span style="color: #007bce; "> <?php echo $_SESSION['username']; ?></span></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
                    <h5 class="m-0 text-dark">Featured</h5>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <h6 class="float-md-right"><span class="badge badge-info"><?php echo $total_user; ?> </span> Post Counts</h6>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div>
              <div class="card-body">
               <div class="form-group">
                   <a href="add_user.php"><input type="submit" value="Add New User" class="btn btn-success"></a>
               </div>
               <div class="form-group table-responsive">
                <table class="table table-bordered table-striped table-hover" id="J_table">
                  <thead class="text-center">
                    <tr>
                      <th><input type="checkbox" id="selectallbox"></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>View</th>
                      <th>Created</th>
                    </tr>
                  </thead>
                  <tbody>
       <?php 
            if($result){
                $i = 1;
                foreach($result as $value){
            ?>
                    <tr>
                      <td align="center"><input type="checkbox" class="checkbox" name="chackboxArray[]" value="<?php echo $value['id']; ?>"></td>
                      <td align="center"><?php echo $i; ?></td>
                      <td><?php echo escape($value['Name']); ?> </td>
                      <td><?php echo escape($value['phone']) ?></td>
                      <td><?php echo escape($value['email']) ?></td>
                      <td>
                        <!-- <form action=""> -->
                         <?php 
                            if ($value['role'] == "Admin") {

                          ?>
                            <a href='post.php?deaft=<?php echo $value['id']; ?>'><button type='button' class='btn btn-block btn-outline-info' onclick="return confirm('Are you sure, you want to  Subscriber This User !!!')">Admin</button></a>
                          <?php
                            }else{
                          ?>
                            <a href='post.php?public=<?php echo $value['id']; ?>'><bittpm type='button' class='btn btn-block btn-outline-danger' onclick="return confirm('Draft ,Are you sure, you want to Admin This User !!!')">Subscriber</bittpm></a>
                          <?php
                            }

                          ?>
                        
                      </td>
                      <td><a href="#"><button type='button' class='btn btn-block btn-outline-info'>View</button></a></td>
                    <!-- </form> -->
                      <td><?php echo escape(date('d-m-Y',strtotime($value['created_at']))); ?> </td>

                      <!-- <?php

                        $post_id = $value['id'];
                        $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$post_id");
                        $salpdo -> execute();
                        $salResult = $salpdo -> fetchAll();
                        $post_count = count($salResult);

                      ?> -->
                      <!-- <form action="" method="post"> -->



                      <!-- <td align="center"><a href="edit.php?id=<?php echo $value['id']; ?>"><input type="button" value="Edit" class="btn btn-block bg-gradient-success text-center"></a></td> -->

                      <!-- <td align="center"><a href="delete.php?id=<?php echo $value['id']; ?>"><input type="button" value="Delete" class="btn btn-block bg-gradient-danger text-center" onclick="return confirm('Are you sure you want to delete this item')"></a></td> -->
                    </tr>  
            <?php
                $i++;
                }
            }

              if (isset($_GET['public'])) {
                $post_id = $_GET['public'];
                $pusql = $pdo -> prepare("UPDATE posts SET post_status='Public' WHERE id=$post_id");
                $result = $pusql -> execute();
                if($result){
                    echo "<script>alert('Sussessfully Public Updated');window.location.href='post.php';</script>";
                }
              }

              if (isset($_GET['deaft'])) {
                $post_id = $_GET['deaft'];
                $desql = $pdo -> prepare("UPDATE posts SET post_status='Deaft' WHERE id=$post_id");
                $result = $desql -> execute();
                if($result){
                    echo "<script>alert('Sussessfully Deaft Updated');window.location.href='post.php';</script>";
                }
              }
            ?>

                    </tbody>
                  </table>
                </div>
              </div>
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