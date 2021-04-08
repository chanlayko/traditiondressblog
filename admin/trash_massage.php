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

    if(!empty($_POST['search'])) { 
        setcookie('search',empty($_POST['search']), time() + (86400 * 30), "/");
    }else{
        if(empty($_GET['pageno'])){
            unset($_COOKIE['search']);
            setcookie('search', null, -1, '/');
        }
    }

    if(!empty($_GET['pageno'])){
        $pageno = $_GET['pageno'];
    }else{
        $pageno = 1;
    }

    $numOfrecs = 10;
    $offset = ($pageno - 1) * $numOfrecs;

    if(empty($_POST['search']) && empty($_COOKIE['search'])){

      $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin='' ORDER BY id DESC");
      $stat -> execute();
      $result = $stat -> fetchAll();

      $total_count = count($result);

      $total_page = ceil(count($result) / $numOfrecs);

      $total_dev = $pageno * $numOfrecs;

      $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin='' ORDER BY id DESC LIMIT $offset,$numOfrecs");
      $stat -> execute();
      $result = $stat -> fetchAll();

    }else{

      $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];

      $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin='' AND mail LIKE '%$searchKey%' ORDER BY id DESC");
      $stat -> execute();
      $result = $stat -> fetchAll();

      $total_count = count($result);

      $total_page = ceil(count($result) / $numOfrecs);

      $total_dev = $pageno * $numOfrecs;

      $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin='' AND mail LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
      $stat -> execute();
      $result = $stat -> fetchAll();

    }

    if (isset($_POST['delete'])) {

      if (isset($_POST['checkboxAry'])) {
        foreach ($_POST['checkboxAry'] as $checkArray) {

          $tesql = $pdo -> prepare("DELETE FROM delete_trash WHERE id=$checkArray");
          $teResult = $tesql -> execute();
          if ($teResult) {
            echo "<script>alert('Sussessfully Deleted Updated');window.location.href='trash_massage.php';</script>";
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
    <section class="content">
      <div class="row">
<?php include_once ("navbar_massage.php") ?>
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Trash</h3>
              <form action="trash_massage.php" method="post">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <div class="card-tools">
                  <div class="input-group input-group-sm col-md-4 float-right">
                    <input type="text" class="form-control" name="search" placeholder="Search Mail">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
              <div class="card-body p-0">
                <div class="mailbox-controls">
                  <button type="button" class="btn btn-default btn-sm" style="padding-top: 5px;">
                    <input type="checkbox" class="checkbox" id="checkboxAll">
                  </button>
                  <div class="btn-group">
                    <button type="submit" name="delete" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                    <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-reply"></i></button>
                    </a>
                    <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-share"></i></button>
                    </a>
                  </div>
                <!-- /.btn-group -->
                <a href="trash_massage.php">
                  <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                </a>
                <div class="float-right">
                  <?php echo $total_dev > $total_count ? $total_count : $total_dev; ?>/<?php echo $total_count; ?>
                  <div class="btn-group">
                    <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>">
                        <i class="fas fa-chevron-left"></i></button>
                    </a>
                    <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-chevron-right"></i></button>
                    </a>
                  </div>
                <!-- /.float-right -->
                </div>
                <!-- /.float-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <tbody>
                      <?php 
                        if ($result) {
                          
                          foreach ($result as $value) {

                      ?>

                      <tr>
                        <td>
                          <div class="icheck-primary">
                            <input type="checkbox" name="checkboxAry[]" class="checkbox" value="<?php echo $value['id'] ?>" id="check1">
                            <label for="check1"></label>
                          </div>
                        </td>
                        <td><?php echo escape($value['name']); ?></td>
                        <td><?php echo escape($value['mail']); ?></td>
                        <td><?php echo escape($value['subject']); ?>
                        </td>
                        <td style="width: 115px;"><?php echo escape(date("d-m-Y",strtotime($value['created_at']))); ?></td>
                      </tr>

                      <?php     
                          }
                        }
                      ?>
                    
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer p-0">
                <div class="mailbox-controls">
                <button type="button" class="btn btn-default btn-sm" style="padding-top: 5px;">
                  <input type="checkbox" class="checkbox" id="checkboxAlls">
                </button>
                </button>
                <div class="btn-group">
                  <button type="submit" name="delete" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                  <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                    <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-reply"></i></button>
                  </a>
                  <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                    <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-share"></i></button>
                  </a>
                </div>
                <!-- /.btn-group -->
                <a href="trash_massage.php">
                  <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                </a>
                <div class="float-right">
                <?php echo $total_dev > $total_count? $total_count : $total_dev; ?>/<?php echo $total_count; ?>
                <div class="btn-group">
                    <a href="?pageno=<?php echo $pageno <= 1 ? '#' : $pageno - 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno <= 1 ? 'disabled': ''; ?>"><i class="fas fa-chevron-left"></i></button>
                    </a>
                    <a href="?pageno=<?php echo $pageno >= $total_page ? '#' : $pageno + 1; ?>">
                      <button type="button" class="btn btn-default btn-sm <?php echo $pageno >= $total_page ? 'disabled' : ''; ?>"><i class="fas fa-chevron-right"></i></button>
                    </a>
                  </div>
                <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
                </div>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
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
