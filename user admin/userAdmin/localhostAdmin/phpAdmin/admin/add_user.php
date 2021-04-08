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
                    if(isset($_POST['submit'])){
                         if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4){
                            if(empty($_POST['name'])){
                                $nameError = "* Name cannot be Null *";
                            }
                            if(empty($_POST['email'])){
                                $emailError = "* Email cannot be Null *";
                            }
                            if(empty($_POST['password'])){
                                $passError = "* Password cannot be Null *";
                            }
                            if(strlen($_POST['password']) < 4){
                                $passError = "* Password show be 4 characters at least *";
                            }
                        }else{
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                            if(empty($_POST['role'])){
                                $role = 0;
                            }else{
                                $role = 1;
                            }

                            $empdostat = $pdo -> prepare("SELECT * FROM users WHERE email=:email");
                            $empdostat -> bindValue(":email",$email);
                            $empdostat -> execute();
                            $emResult = $empdostat -> fetch(PDO::FETCH_ASSOC);

                            if($emResult){
                                echo "<script>alert('Email duplicated !!')</script>";
                            }else{
                                $adpdostat = $pdo -> prepare("INSERT INTO users(user,email,password,role) VALUES (:user,:email,:password,:role)");
                                $adReault = $adpdostat -> execute(
                                    array(":user"=>$name,":email"=>$email,":password"=>$password,":role"=>$role)
                                );
                                if($adReault){
                                    echo "<script>alert('Sussessfully Your Data');window.location.href='admin_user.php';</script>";
                                  }
                            }

                        }
                    }
               
               
               ?>
              <form action="" method="post">
                <div class="card-body">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                 <div class="form-group">
                    <label for="exampleName">Name</label>
                    <input type="text" class="form-control" name="name" id="exampleName" placeholder="Enter Your Name">
                    <p style="color:red"><?php echo empty($nameError) ? '' : $nameError; ?></p>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter Your email">
                    <p style="color:red"><?php echo empty($emailError) ? '' : $emailError; ?></p>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    <p style="color:red"><?php echo empty($passError) ? '' : $passError; ?></p>

                  </div>
                  <div class="form-group">
                   <label for="exampleCheck1">Admin Check</label><br>
                    <input type="checkbox"  id="exampleCheck1" name="role">
                    <label class="form-check-label" for="exampleCheck1">Check Admin</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                  <button class="btn btn-primary"><a href="admin_user.php" style="color: white;">Black Admin</a></button>
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

             