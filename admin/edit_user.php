<?php 
    session_start();
    require_once "../../../../../confiy/confiy.php";
    require_once "../../../../../confiy/common.php";  
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 'Admin'){
         header("Location: ../registeradmin/login.php");
    }
?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 
  

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
           <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Adding Users</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
               // if(isset($_POST['submit'])){
               //     if(empty($_POST['name']) || empty($_POST['email'])){
               //              if(empty($_POST['name'])){
               //                  $nameError = "* Name cannot be Null *";
               //              }
               //              if(empty($_POST['email'])){
               //                  $emailError = "* Email cannot be Null *";
               //              }
               //          }elseif(!empty($_POST['password']) && strlen($_POST['password']) < 4){
               //              $passError = "* Password show be 4 characters at least *";
               //          }else{
               //              $id = $_POST['id'];
               //              $email = $_POST['email'];
               //              $name = $_POST['name'];
               //              $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                       
               //              if(empty($_POST['role'])){
               //                  $role = 0;
               //              }else{
               //                  $role = 1;
               //              }

               //              $empdostat = $pdo -> prepare("SELECT * FROM admin_user WHERE email=:email AND id!=:id");
               //              $empdostat -> execute(array(":email"=>$email,":id"=>$id));
               //              $emResult = $empdostat -> fetch(PDO::FETCH_ASSOC);

               //              if($emResult){
               //                  echo "<script>alert('Email duplicated !!')</script>";
               //              }else{
               //                  if($password != null){
               //                      $adpdostat = $pdo -> prepare("UPDATE admin_user SET username='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
               //                  }else{
               //                      $adpdostat = $pdo -> prepare("UPDATE admin_user SET username='$name',email='$email',role='$role' WHERE id='$id'");

               //                  }
               //                  $adReault = $adpdostat -> execute();
               //                  if($adReault){
               //                      echo "<script>alert('Sussessfully Your Data');window.location.href='admin_user.php';</script>";
               //                    }
               //              }
               //          }  
               //      }
               
               //      $pdostat = $pdo -> prepare("SELECT * FROM admin_user WHERE id=".$_GET['id']);
               //      $pdostat -> execute();
               //      $result = $pdostat -> fetchAll();
               
               
               ?>
              <form action="" method="post">
                <div class="card-body">
                 <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                 <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>" >
                  <div class="form-group">
                    <label for="exampleInputEmail1">Your Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['username']) ?>" id="exampleInputEmail1" placeholder="Enter Name">
                    <p style="color:red"><?php echo empty($nameError) ? '' : $nameError; ?></p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Your Email</label>
                    <input type="email" name="email" value="<?php echo escape($result[0]['email']); ?>" class="form-control" id="exampleInputPassword1" placeholder="Enter Email">
                    <p style="color:red"><?php echo empty($emailError) ? '' : $emailError; ?></p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword">Password <small style="color:gray">This User already has a Password</small></label>
                    <input type="password" name="password" value="" class="form-control" id="exampleInputPassword" placeholder="Password">
                    <p style="color:red"><?php echo empty($passError) ? '' : $passError; ?></p>
                  </div>
                  <div class="form-group"> 
                   <label for="exampleCheck1">Admin Check</label><br>
                    <input type="checkbox"  id="exampleCheck1" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="exampleCheck1">Check Admin</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                  <a href="admin_user.php"><button class="btn btn-primary">Black</button></a>
                </div>
              </form>
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

             