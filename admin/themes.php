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
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ribbons</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper">
                        <div class="ribbon bg-primary">
                          Ribbon
                        </div>
                      </div>
                      Ribbon Default <br />
                      <small>.ribbon-wrapper.ribbon-lg .ribbon</small>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-info">
                          Ribbon Large
                        </div>
                      </div>
                      Ribbon Large <br />
                      <small>.ribbon-wrapper.ribbon-lg .ribbon</small>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-secondary">
                          Ribbon Extra Large
                        </div>
                      </div>
                      Ribbon Extra Large <br />
                      <small>.ribbon-wrapper.ribbon-xl .ribbon</small>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-success text-lg">
                          Ribbon
                        </div>
                      </div>
                      Ribbon Large <br /> with Large Text <br />
                      <small>.ribbon-wrapper.ribbon-lg .ribbon.text-lg</small>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-warning text-lg">
                          Ribbon
                        </div>
                      </div>
                      Ribbon Extra Large <br /> with Large Text <br />
                      <small>.ribbon-wrapper.ribbon-xl .ribbon.text-lg</small>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative p-3 bg-gray" style="height: 180px">
                      <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-danger text-xl">
                          Ribbon
                        </div>
                      </div>
                      Ribbon Extra Large <br /> with Extra Large Text <br />
                      <small>.ribbon-wrapper.ribbon-xl .ribbon.text-xl</small>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-sm-4">
                    <div class="position-relative">
                      <img src="../dist/img/photo1.png" alt="Photo 1" class="img-fluid">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-success text-lg">
                          Ribbon
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative">
                      <img src="../dist/img/photo2.png" alt="Photo 2" class="img-fluid">
                      <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-warning text-lg">
                          Ribbon
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="position-relative" style="min-height: 180px;">
                      <img src="../dist/img/photo3.jpg" alt="Photo 3" class="img-fluid">
                      <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-danger text-xl">
                          Ribbon
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
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
 