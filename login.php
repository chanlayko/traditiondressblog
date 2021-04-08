<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";   
?>

<?php 
  
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdostat = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $pdostat -> bindValue(":email",$email); 
        $pdostat -> execute();
        $user = $pdostat -> fetch(PDO::FETCH_ASSOC);
        if($user){
            if(password_verify($password,$user['password'])){
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['user'] = $user['name'];
                $_SESSION['role'] = 1;
                $_SESSION['logged_in'] = time();
                
                header("Location: admin/index.php");
            }
        }
        echo "<script>alert('Incorrect credentials !!')</script>";
        
    }

?>
<?php include_once("header.php") ?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-film mr-2"></i>
            Catalog-Z
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link nav-link-1" aria-current="page" href="index.html">Photos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-2" href="videos.html">Videos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-3" href="about.html">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-4 active" href="register.php">Contact</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
 <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg"></div>

    <div class="container-fluid tm-mt-60">
        <div class="row tm-mb-50">
            <div class="col-lg-4 col-12 mb-5">
                <h2 class="tm-text-primary mb-5">Contact Page</h2>
                <form id="contact-form" action="login.php" method="post" class="tm-contact-form mx-auto">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                    <!-- <div class="form-group">
                        <input type="text" name="name" class="form-control rounded-0" placeholder="Name" required />
                        <p style="color:red;"><?php echo empty($nameError) ? '' : '$nameError'; ?></p>
                    </div> -->
                    <div class="form-group">
                        <input type="email" name="email" class="form-control rounded-0" placeholder="Email" required />
                    </div>
                    <!-- <div class="form-group">
                       <input type="text" name="phone" placeholder="Phone" class="form-control rounded-0" require>
                    </div> -->
                    <div class="form-group">
                       <input type="password" name="password" placeholder="Password" class="form-control rounded-0" require>
                    </div>
                    <!-- <div class="form-group">
                        <textarea name="address" id="" cols="10" rows="5" placeholder="Address" class="form-control">

                        </textarea>
                    </div> -->
                    <div class="form-group tm-text-right">
                        <button type="submit" class="btn btn-primary" name="login">Login Admin</button>
                    </div>
                </form>                
            </div>
            <div class="col-lg-4 col-12 mb-5">
                <div class="tm-address-col">
                    <h2 class="tm-text-primary mb-5">Our Address</h2>
                    <p class="tm-mb-50">Quisque eleifend mi et nisi eleifend pretium. Duis porttitor accumsan arcu id rhoncus. Praesent fermentum venenatis ipsum, eget vestibulum purus. </p>
                    <p class="tm-mb-50">Nulla ut scelerisque elit, in fermentum ante. Aliquam congue mattis erat, eget iaculis enim posuere nec. Quisque risus turpis, tempus in iaculis.</p>
                    <address class="tm-text-gray tm-mb-50">
                        120-240 Fusce eleifend varius tempus<br>
                        Duis consectetur at ligula 10660
                    </address>
                    <ul class="tm-contacts">
                        <li>
                            <a href="#" class="tm-text-gray">
                                <i class="fas fa-envelope"></i>
                                Email: info@company.com
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tm-text-gray">
                                <i class="fas fa-phone"></i>
                                Tel: 010-020-0340
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tm-text-gray">
                                <i class="fas fa-globe"></i>
                                URL: www.company.com
                            </a>
                        </li>
                    </ul>
                </div>                
            </div>
            <div class="col-lg-4 col-12">
                <h2 class="tm-text-primary mb-5">Our Location</h2>
                <!-- Map -->
                <div class="mapouter mb-4">
                    <div class="gmap-canvas">
                        <iframe width="100%" height="520" id="gmap-canvas"
                            src="https://maps.google.com/maps?q=Av.+L%C3%BAcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
                </div>               
            </div>
        </div>
        <div class="row tm-mb-74 tm-people-row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                <img src="img/people-1.jpg" alt="Image" class="mb-4 img-fluid">
                <h2 class="tm-text-primary mb-4">Ryan White</h2>
                <h3 class="tm-text-secondary h5 mb-4">Chief Executive Officer</h3>
                <p class="mb-4">
                    Mauris ante tellus, feugiat nec metus non, bibendum semper velit. Praesent laoreet urna id tristique fermentum. Morbi venenatis dui quis diam mollis pellentesque.
                </p>
                <ul class="tm-social pl-0 mb-0">
                    <li><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                <img src="img/people-2.jpg" alt="Image" class="mb-4 img-fluid">
                <h2 class="tm-text-primary mb-4">Catherine Pinky</h2>
                <h3 class="tm-text-secondary h5 mb-4">Chief Marketing Officer</h3>
                <p class="mb-4">
                    Sed faucibus nec velit finibus accumsan. Sed varius augue et leo pharetra, in varius lacus eleifend. Quisque ut eleifend lacus.
                </p>
                <ul class="tm-social pl-0 mb-0">
                    <li><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                <img src="img/people-3.jpg" alt="Image" class="mb-4 img-fluid">
                <h2 class="tm-text-primary mb-4">Johnny Brief</h2>
                <h3 class="tm-text-secondary h5 mb-4">Accounting Executive</h3>
                <p class="mb-4">
                    Sed faucibus nec velit finibus accumsan. Sed varius augue et leo pharetra, in varius lacus eleifend. Quisque ut eleifend lacus.
                </p>
                <ul class="tm-social pl-0 mb-0">
                    <li><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                <img src="img/people-4.jpg" alt="Image" class="mb-4 img-fluid">
                <h2 class="tm-text-primary mb-4">George Nelson</h2>
                <h3 class="tm-text-secondary h5 mb-4">Creative Art Director #C69</h3>
                <p class="mb-4">
                    Nunc convallis facilisis congue. Curabitur gravida rutrum justo sed pulvinar. Pellentesque ac ante in erat bibendum dignissim.
                </p>
                <ul class="tm-social pl-0 mb-0">
                    <li><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </div> <!-- container-fluid, tm-container-content -->

<?php include_once("footer.php") ?>