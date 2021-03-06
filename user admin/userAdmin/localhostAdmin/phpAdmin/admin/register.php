<?php
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

  if(isset($_POST['register'])){
       $name = $_POST['name'];
       $email = $_POST['email'];
       $password = $_POST['password'];
       
       if(empty($name) || empty($email) || empty($password) || strlen($password) <4){
           if(empty($name)){
               $nameError = "* Name is Require *";
           }
           if(empty($email)){
               $emailError = "* Email is Require *";
           }
           if(empty($password)){
               $passError = "* Password is Require *";
           }
           if(strlen($password) < 4){
               $passError = "* Password should be 4 characters at least *";
           }
       }else{
           $password = password_hash($password,PASSWORD_DEFAULT);
           
           $regStat = $pdo -> prepare("SELECT * FROM admin_user WHERE email=:email");
           $regStat -> execute([":email"=>$email]);
           $regResult = $regStat -> fetch(PDO::FETCH_ASSOC);
           if($regResult){
               echo "<script>alert('Emial duplicaed !!')</script>";
           }else{
               $stat = $pdo -> prepare("INSERT INTO admin_user (username,email,password) VALUE (:username,:email,:password)");
               $inqu = $stat -> execute(
                   array(':username'=>$name,':email'=>$email,':password'=>$password)
               );  
               if($inqu){
                   echo "<script>alert('Sussessfully insert your Data');window.location.href='login.php';</script>";
               }
           }
       }
   }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="login.php"><b>Blog</b><span class="span"> Admin</span></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
       <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
       <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <p style="color: red;"><?php echo empty($passError) ? '' : $passError; ?></p>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="register" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <div class="col-4">
            <a href="login.php">
              <input type="button" class="btn btn-primary" value="Log In Admin">
              <!-- <button class="btn btn-primary btn-block"></button> -->
            </a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../../../dist/js/adminlte.min.js"></script>

</body>
</html>
