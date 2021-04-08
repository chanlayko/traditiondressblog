<?php 
    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";   
?>

<?php  
  
    if(isset($_POST['login'])){
        $email = $_POST['email']; 
        $password = $_POST['password'];

        $pdostat = $pdo->prepare("SELECT * FROM users WHERE email=:email AND role='Admin'");
        $pdostat -> bindValue(":email",$email); 
        $pdostat -> execute();
        $user = $pdostat -> fetch(PDO::FETCH_ASSOC);
        if($user){
            if(password_verify($password,$user['password'])){
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['user'] = $user['Name'];
                $_SESSION['role'] = 'Admin';
                $_SESSION['logged_in'] = time();
                
                header("Location: ../admin/index.php");
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
  <title>Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../index.php"><b>Admin</b> Registration</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
       <!--  <div class="input-group mb-3">
          <input type="text" class="form-control" required placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> -->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- <div class="input-group mb-3">
          <input type="text" class="form-control" required placeholder="Phone">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div> -->
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <!-- <div class="input-group mb-3">
          <textarea name="address" id="" cols="10" rows="3" required placeholder="Address" class="form-control"></textarea>
        </div> -->
        <div class="row">
            <!-- <div class="col-8">
                <div class="input-group mb-3">
              <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary1" name="r1" checked>
                  <label for="radioPrimary1">Male&nbsp;</label>
              </div>
              <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" name="r1">
                    <label for="radioPrimary2">Falme</label>
                </div>
            </div>
            </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">LogIn</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="index.php" class="text-center">Created a new membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
