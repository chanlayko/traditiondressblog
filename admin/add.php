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

    if(isset($_POST['submit'])){

      $title = $_POST['title'];
      $price = $_POST['price'];
      $status = $_POST['post_status'];
      $contant = $_POST['contant'];
      $image_quantity = $_POST['image_quantity'];

      $sql = "INSERT INTO posts(title,price,post_status,contant,image_quartity,author_id) VALUES (:title,:price,:post_status,:contant,:image_quantity,:author)";
      $pdostat = $pdo -> prepare($sql);
      $result = $pdostat -> execute(array(':title'=>$title,':price'=>$price,':post_status'=>$status,':contant'=>$contant,':image_quantity'=>$image_quantity,':author'=>$_SESSION['user_id'])
        );

      if($result){
        $intpdo = $pdo -> lastInsertId();

        $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$intpdo");
        $stat -> execute();
        $statResult = $stat -> fetchAll();

        $post_id = $statResult[0]['id'];

        $extension = array('jpeg','jpg','png','gif');
        foreach ($_FILES['image']['tmp_name'] as $key => $value) {
        $filename = $_FILES['image']['name'][$key];

        $filename_tem = $_FILES['image']['tmp_name'][$key];

        $filelop = "images/".$filename;

        $imgfileType = pathinfo($filelop,PATHINFO_EXTENSION);
          
        if($imgfileType != 'png' && $imgfileType != 'jpg' && $imgfileType != 'jpeg' && $imgfileType != 'gif'){
          echo "<script>alert('Image may be png,jpg,jpeg,gif')</script>";
        }else{

        move_uploaded_file($filename_tem,$filelop);

            $insertsql = "INSERT INTO multiple_image (post_image_id,image_name) VALUES (:post_image_id,:finalimg)";
            $pdoqry = $pdo -> prepare($insertsql);
            $pdoResult = $pdoqry -> execute([":post_image_id"=>$post_id,":finalimg"=>$filename]);
          }
      }

        echo "<script>alert('Sussessfully Adding');window.location.href='post.php';</script>";
      }


      // $seSql = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$postId");
      // $seSql -> execute();
      // $seResult = $seSql -> fetchAll();
      // foreach ($seResult as $value) {
      //   $rr = $value['image_name'];
      //   echo $rr;
      // }
      // exit();

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
                <h5 class="m-0">Add Post</h5>
              </div>
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6 mb-2">
                     <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="mb-2">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" id="title" name="title" placeholder="Enter Your New Post Title" required>
                      </div>
                      <div class="mb-2">  
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter This Post of Price" required>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-2">
                            <label for="status">Post Status</label>
                            <select name="post_status" id="status" class="form-control">
                              <option value="Public">Public</option>
                              <option value="Deaft">Deaft</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="">
                            <label for="qty">Quartity</label>
                            <input type="number" class="form-control" id="qty" name="image_quantity" placeholder="Enter This Post of Quartity" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="">  
                        <label for="contant">Contant</label>
                        <div class="mb-3">
                          <textarea class="textarea" placeholder="Place some text here" name="contant" id="contant" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-12 mb-4">
                     <label for="muImage">Multiple Image View</label><br>
                      <input type="file" name="image[]" id="muImage" multiple required>
                  </div>
                  <div class="form-group">
                      <a href="#"><input type="submit" value="SUBMIT" name="submit" class="btn btn-primary"></a>
                      <a href="post.php"><input type="button" value="Black" class="btn btn-info"></a>
                  </div>
                </form>
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

<!--    footer end  -->
<?php include_once ("footer.php") ?>
