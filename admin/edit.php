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

  $id = $_GET['id'];

  $sql = "SELECT * FROM posts WHERE id=$id";
  $pdostat = $pdo -> prepare($sql);
  $pdostat -> execute();
  $postresult = $pdostat -> fetchAll();

  if(!empty(isset($_POST['delete']))){
    if (isset($_POST['Image'])) {
      foreach($_POST['Image'] as $ImageValue){
        $query = $pdo -> prepare("DELETE FROM multiple_image WHERE image_id=$ImageValue");
        $qresult = $query -> execute(); 
        if ($qresult) {
          echo "<script>alert('Success ,your Item Delete.');window.location.href='edit.php?id=$id';</script>";
        }
      }
    }
    echo "<script>alert('Select to checkbox want to Delete for you item');window.location.href='edit.php?id=$id';</script>";
  }
   
  if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $post_status = $_POST['post_status'];
    $contant = $_POST['contant'];
    $post_qty = $_POST['post_qty'];

    $sql = "UPDATE posts SET title='$title',price='$price',post_status='$post_status',contant='$contant',image_quartity='$post_qty' WHERE id='$id'";
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();
    if($result){
        echo "<script>alert('Sussessfully Updated');window.location.href='post.php';</script>";
    }

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

          $insertqry = "INSERT INTO multiple_image (post_image_id,image_name) VALUES (:post_image_id,:finalimg)";
          $pdoqry = $pdo -> prepare($insertqry);
          $pdoResult = $pdoqry -> execute([":post_image_id"=>$postId,":finalimg"=>$finalimg]);
       
          }
      }
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
                            <div class="row mb-3">
                              <div class="col-md-7">
                                <div class="mb-2">
                                  <label for="title" class="form-control-label">Title</label>
                                  <input type="text" class="form-control" name="title" id="title" placeholder="Edit Title" value="<?php echo escape($postresult[0]['title']); ?>">
                                </div>
                                <div class="mb-2">
                                  <label for="price" class="form-control-label">Price</label>
                                  <input type="text" class="form-control" name="price" id="price" placeholder="Edit Price" value="<?php echo escape($postresult[0]['price']); ?>">
                                </div>
                                <div class="mb-2">
                                  <div class="row">
                                    <div class="col-md-6 mb-2">
                                      <label for="status" class="form-control-label">Status</label>
                                      <select name="post_status" id="" class="form-control">
                                        <option value="<?php echo escape($postresult[0]['post_status']); ?>"><?php echo escape($postresult[0]['post_status']); ?></option>
                                        <?php 
                                          if ($postresult[0]['post_status'] == 'Public') {
                                            echo "<option value='Deaft'>Deaft</option>";
                                          }else{
                                            echo "<option value='Public'>Public</option>";
                                          }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="col-md-6">
                                      <label for="qty" class="form-control-label">Quartity</label>
                                      <input type="text" class="form-control" name="post_qty" id="qty" placeholder="Edit Quartity" value="<?php echo escape($postresult[0]['image_quartity']); ?>">
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="mb-2">
                                </div> -->
                                <div class="mb-2">
                                  <label for="contant" class="form-control-label">Contant</label>
                                  <textarea id="compose-textarea" name="contant" class="form-control" style="height: 300px"><?php echo escape($postresult[0]['contant']); ?></textarea>
                                </div>
                              </div>

                              <div class="col-md-5">
                                <div class="form-group">
                                  <h5>Image Gallery</h5>
                                  <input type="file" name="image[]" multiple><br><br>
                                  <!-- <div class="col-lg-4" id="hiddenselect">
                                      <select name="bulk_option" id="" class="form-control">
                                          <option value="Delete">Delete</option>
                                      </select>
                                  </div> -->
                                  <div id="divBoxImage">
                              
                                  </div>
                                  <div class="form-group">
                                    <?php 
                                      $post_id = $_GET['id'];
                                      $imgSta = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$post_id");
                                      $imgSta -> execute();
                                      $imgResult = $imgSta -> fetchAll();

                                      foreach ($imgResult as $value) {
                                    ?>
                                      <label for="todoCheck3">
                                      <input type="checkbox" id="Image" name="Image[]" value="<?php echo $value['image_id'] ?>">
                                        <img src="images/<?php echo $value['image_name']; ?>" alt="" style="margin-top: 5px;width: 100px;">
                                      </label>
                                    <?php 
                                      }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <input type="submit" value="Update Data" name="submit" class="btn btn-success">
                                  <button name="delete" class="btn btn-warning">Delete Photos</button>
                                </div>
                              </div>
                            </div>
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