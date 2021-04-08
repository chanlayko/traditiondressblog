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

    $sql = "SELECT * FROM posts WHERE author_id=$author_id ORDER BY id DESC";
    $pdostat = $pdo -> prepare($sql);
    $pdostat -> execute();
    $result = $pdostat -> fetchAll();

    $total_counts = count($result);

    if (isset($_POST['apply'])) {
      if(isset($_POST['chackboxArray'])){
        foreach($_POST['chackboxArray'] as $chackboxValue){
          $bulk_option = $_POST['bulk_option'];
          switch($bulk_option){
            case 'Public':
            $pusql = $pdo -> prepare("UPDATE posts SET post_status='$bulk_option' WHERE id=$chackboxValue");
            $puResult = $pusql -> execute();
            if($result){
              echo "<script>alert('Sussessfully Public Updated');window.location.href='post.php';</script>";
            }
            break;

            case 'Deaft':
              $desql = $pdo -> prepare("UPDATE posts SET post_status='$bulk_option' WHERE id=$chackboxValue");
              $deResult = $desql -> execute();
              if ($deResult) {
                echo "<script>alert('Sussessfully Deaft Updated');window.location.href='post.php';</script>";
              }
              break;
           
            case 'Delete':
              $tesql = $pdo -> prepare("DELETE FROM posts WHERE id=$chackboxValue");
              $teResult = $tesql -> execute();
              if ($teResult) {
                echo "<script>alert('Sussessfully Deleted Updated');window.location.href='post.php';</script>";
              }
              break;
          }
        }
      }
    }
 
?>
 
<!-- header --> 
<?php include_once ("header.php"); ?> 
<!-- nvabar include -->
<?php include_once ("navbar.php"); ?>
  
 

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
                    <h6 class="float-md-right"><span class="badge badge-info"><?php echo $total_counts; ?> </span> Post Counts</h6>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div>
            <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <div class="card-body">
                <div class="row mb-2">
                  <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <select name="bulk_option" id="" class="form-control">
                      <option value="">--- Select Option ---</option>
                      <option value="Public">Public</option>
                      <option value="Deaft">Deaft</option>
                      <option value="Delete">Delete</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6">
                    <input type="submit" name="apply" value="Apply Now" class="btn btn-primary">
                    <a href="add.php"><input type="button" value="New Blog Posts" class="btn btn-success"></a>
                  </div>
                </div>
                <div class="form-group table-responsive">
                  <table class="table table-bordered table-striped table-hover" id="J_table">
                    <thead class="text-center">
                      <tr>
                        <th><input type="checkbox" id="selectallbox"></th>
                        <th>#</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Contant</th>
                        <th>Count</th>
                        <th>Quartity</th>
                        <th>Deaft</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
           <?php 
                if($result){
                    $i = 1;
                    foreach($result as $value){
                ?>
                      <tr>
                        <td><input type="checkbox" class="checkbox" name="chackboxArray[]" value="<?php echo $value['id']; ?>"></td>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo escape($value['title']); ?></td>
                        <td><?php echo escape($value['price']) ?> ks</td>
                        <td>
                          <!-- <form action=""> -->
                            <?php 
                              if ($value['post_status'] == "Public") {

                            ?>
                              <a href='post.php?deaft=<?php echo $value['id']; ?>'><button type='button' class='btn btn-block btn-outline-info'>Public</button></a>
                            <?php
                              }else{
                            ?>
                              <a href='post.php?public=<?php echo $value['id']; ?>'><bittpm type='button' class='btn btn-block btn-outline-danger'>Deaft</bittpm></a>
                            <?php
                              }

                            ?>
                          
                        </td>
                        <td><?php echo escape(substr($value['contant'], 0,80)) ?></td>

                        <?php

                          $post_id = $value['id'];
                          $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$post_id");
                          $salpdo -> execute();
                          $salResult = $salpdo -> fetchAll();
                          $post_count = count($salResult);

                        ?>
                        <td align="center"><a href="massage_order.php?post_id=<?php echo $value['id']; ?>"><button type='button' class='btn btn-block btn-outline-info <?php echo $post_count == 0? 'disabled' : ''; ?>' style="width: 50px;"><?php echo escape($post_count); ?></button></a></td>

                        <td align="center"><button type='button' class='btn btn-block btn-outline-info disabled' style="width: 50px;"><?php echo escape($value['image_quartity']) ?></button></td>

                        <td><?php echo escape(date('d-m-Y',strtotime($value['created_at']))); ?></td>

                        <td align="center"><a href="edit.php?id=<?php echo $value['id']; ?>"><input type="button" value="Edit" class="btn btn-block bg-gradient-success text-center"></a></td>

                        <td align="center"><a href="delete.php?id=<?php echo $value['id']; ?>"><input type="button" value="Delete" class="btn btn-block bg-gradient-danger text-center" onclick="return confirm('Are you sure you want to delete this item')"></a></td>
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
            </form>

              <!-- /.card-body -->
            <!-- <div class="card-footer clearfix">
              <nav aria-label="Page naigation example">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                      <a href="<?php if($pageno <= 1){ echo '#';}else{ echo "?pageno=".($pageno-1);} ?>" class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                      <a href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo "?pageno=".($pageno+1);} ?>" class="page-link">Next</a>
                    </li>
                    <li class="page-item"><a href="?pageno=<?php echo $total_pages ?>" class="page-link">Last</a></li>
                </ul>  
              </nav>
            </div> -->
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
 