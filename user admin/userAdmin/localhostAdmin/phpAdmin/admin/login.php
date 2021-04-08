<?php
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

    if(isset($_POST['signin'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM admin_user WHERE email=:email";
        $pdostat = $pdo->prepare($sql);
        $pdostat -> bindValue(":email",$email);
        $pdostat -> execute();
        $user = $pdostat -> fetch(PDO::FETCH_ASSOC);
        if($user){
            if(password_verify($password,$user['password'])){
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['roles'] = 1;
                $_SESSION['loggedin'] = time();
                
                header("Location: index.php");
            }
        }
        echo "<script>alert('Incorrect credentials !!')</script>";
        
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

      <form action="login.php" method="post">
       <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="signin" class="btn btn-primary btn-block">Log In</button>
          </div>
          <div class="col-4">
            <a href="register.php">
              <input type="button" class="btn btn-primary" value="Register Login">
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
