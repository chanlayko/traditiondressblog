<?php 





  ပိုေနေသာ အပိုင္ျဖစ္သည္











    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 'Admin'){
         header("Location: ../registeradmin/login.php");
    }
   
    if(isset($_POST['submit'])){
        if(empty($_POST['title']) || empty($_POST['price'])){ 
            if(empty($_POST['title'])){
                $titleError = "* Title cannot be Null";  
            }
            if(empty($_POST['price'])){
                $priceError = "* Price cannot be Null";
            }
        }else{
            $id = $_GET['id']; 
            $title = $_POST['title'];
            $price = $_POST['price'];
            $contant = $_POST['contant'];  

            $extension = array('jpeg','jpg','png','gif');
            foreach ($_FILES['image']['tmp_name'] as $key => $value) {
              $filename = $_FILES['image']['name'][$key];
              $filename_tem = $_FILES['image']['tmp_name'][$key];


             if($filename != null){
                $ext = pathinfo($filename,PATHINFO_EXTENSION);

                $finalimg = '';
                $postId = $_GET['id'];

                if (in_array($ext, $extension)) {
                  if (!file_exists('images/'.$filename)) {
                    move_uploaded_file($filename_tem, 'images/'.$filename);
                    $finalimg = $filename;
                  }else{
                    $filename = str_replace('.','-',basename($filename,$ext));
                    $newfilename = $filename.time().".".$ext;
                    move_uploaded_file($filename_tem, 'images/'.$newfilename);
                    $finalimg = $newfilename;
                  }
                  $creattime = date('Y-m-d h:i:s');

                  $insertqry = "INSERT INTO multiple_image (post_image_id,image_name,image_createtime) VALUES (:post_image_id,:finalimg,:creattime)";
                  $pdoqry = $pdo -> prepare($insertqry);
                  $pdoResult = $pdoqry -> execute([":post_image_id"=>$postId,":finalimg"=>$finalimg,":creattime"=>$creattime]);
                  // mysqli_query($con,$insertqry);

                  // header('Location: nav.php');
                }else{
                  //display error
                }
                $sql = "UPDATE posts SET title='$title',price='$price',contant='$contant' WHERE id='$id'";
                $pdostat = $pdo -> prepare($sql);
                $result = $pdostat -> execute();
                if($result){
                    echo "<script>alert('Sussessfully Updated');window.location.href='multiple_image.php';</script>";
                }


              }else{
                $sql = "UPDATE posts SET title='$title',price='$price',contant='$contant' WHERE id='$id'";
                $pdostat = $pdo -> prepare($sql);
                $result = $pdostat -> execute();
                if($result){
                    echo "<script>alert('Sussessfully Updated');window.location.href='multiple_image.php';</script>";
                }
            }
          }
        }
      }


    $sql = "SELECT * FROM multiple_image WHERE post_image_id=".$_GET['id'];
    $stat = $pdo -> prepare($sql);
    $stat -> execute();
    $result = $stat -> fetchAll();


    // if ($result[0]['post_image_id']  !== Null) {
      $image_id = $result[0]['post_image_id'];

      // $author_id = $_SESSION['user_id'];

      $sql = "SELECT * FROM posts WHERE id=$image_id";
      $pdostat = $pdo -> prepare($sql);
      $pdostat -> execute();
      $postresult = $pdostat -> fetchAll();
    // }

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Blog Page</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="post.php" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                POSTS
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                REPORTS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weelkly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporting</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Reports</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="royal_customer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_saller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Saller</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="massage.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>MASSAGES</p>
                <span class="badge badge-info right">2</span>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                ORDER
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="order_information.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gift_information.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gift Wrap Order</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
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
                <h3 class="m-0">Update Post</h3>
              </div>
              <br>
              <!-- <div class="card-body"> -->
                <div class="card card-default">
                  <!-- <div class="card-header">
                    <h3 class="m-1 card-title"><?php echo escape($postresult[0]['title']); ?></h3>
                  </div> -->
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <form action="" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <input type="hidden" name="image_id" value="<?php echo escape($result[0]['image_id']) ?>">
                            <input type="hidden" name="id" value="<?php echo escape($postresult[0]['id']) ?>">

                            <label for="title" class="form-control-label">Title</label>
                            <input type="tex" class="form-control" name="title" id="title" placeholder="Edit Title" value="<?php echo escape($postresult[0]['title']); ?>"><p style="color:red"><?php echo empty($titleError) ? '' : $titleError; ?></p>

                            <label for="price" class="form-control-label">Price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="Edit Price" value="<?php echo escape($postresult[0]['price']); ?>"><p style="color:red"><?php echo empty($priceError) ? '' : $priceError; ?></p>

                            <label for="contant" class="form-control-label">Contant</label>
                            <textarea name="contant" id="contant" rows="5" class="form-control"><?php echo escape($postresult[0]['contant']); ?></textarea>
                            <div class="form-group">
                              <br>
                              <h5>Image Gallery</h5>
                              <input type="file" name="image[]" multiple><br><br>
                              <div class="form-group">
                                <?php 
                                  $post_id = $_GET['id'];
                                  $imgSta = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$post_id");
                                  $imgSta -> execute();
                                  $imgResult = $imgSta -> fetchAll();

                                  foreach ($imgResult as $value) {
                                ?>
                                  <img src="images/<?php echo $value['image_name']; ?>" alt="" style="margin-top: 5px;width: 100px;">
                                <?php 
                                  }
                                ?>
                              </div>
                            </div>
                            <!-- <div class=""> -->
                              <a href="#">
                                <input type="submit" value="Update Data" name="submit" class="btn btn-success">
                              </a>
                            <!-- </div> -->
                          </form>
                          <!-- form end -->
                        </div>
                        
                      </div>
                      
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