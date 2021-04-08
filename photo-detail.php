<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";
     
    $blogId = $_GET['p_id'];

    $shpdosta = $pdo -> prepare("SELECT * FROM posts WHERE id=$blogId");
    $shpdosta -> execute();
    $shResult = $shpdosta -> fetchAll(); 

    if (isset($_POST['submit'])) {


        $box_value = $_POST['box'];
        $post_result = $shResult[0]['price'];

        $box_result = $box_value * $post_result;

        $user_name = $_POST['user_name'];
        $user_phone = $_POST['user_phone'];
        $users_id = $_GET['id'];
        $user_massage = $_POST['message'];

        $sql = $pdo -> prepare("INSERT INTO user_order(user_name,user_phone,user_massage,total_price,users_id,post_id) VALUES (:name,:phone,:massage,:price,:users_id,:post_id)");
        $result = $sql -> execute(
            array(":name"=>$user_name,":phone"=>$user_phone,":massage"=>$user_massage,":price"=>$box_result,":users_id"=>$users_id,":post_id"=>$blogId)
        );

        foreach ($_POST['checkbox'] as $checkValue) {
        $userId = $_POST['userId'];

            $sql = $pdo -> prepare("INSERT INTO user_multiple_image(user_id,order_image_id) VALUES (:user_id,:order_image_id)");
            $results = $sql -> execute(
                array(":user_id"=>$userId,":order_image_id"=>$checkValue)
            );
        }
        if($result && $results){
            echo "<script>alert('\"Thank You !\" Your Sending Order Sussfully.');window.location.href='photo-detail.php?id=$users_id&p_id=$blogId';</script>";
        }
    }

?>
<?php include_once("header.php") ?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?id=<?php echo $_GET['id']; ?>">
            <i class="fas fa-film mr-2"></i>
            Catalog-Z
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link nav-link-1 active" aria-current="page" href="index.php?id=<?php echo $_GET['id']; ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-2" href="videos.html">Videos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-3" href="register.php?id=<?php echo $_GET['id']; ?>">Register (or) Sign in</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-4" href="register.php">Contact</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg">
        <form class="d-flex tm-search-form">
            <input class="form-control tm-search-input" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success tm-search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="row" style="margin-left: 10px;">
            <div class="col-md-6 mb-2" id="like">
                 <?php
                    $like = 0;
                    if(isset($_SESSION['like'])){
                        foreach ($_SESSION['like'] as $key => $qty){
                            $like += $qty;
                        }
                    }
                ?>
                <a href="like_cart.php?id=<?php echo $_GET['id']; ?>" style="color: white;">
                    <div class="col-md-10" style="float: left;">
                        <i class="fas fa-heart fa-lg mr-2" style="font-size: 30px;"></i>
                    </div>
                    <div class="col-md-2" style="float:left;">
                        <?php echo $like; ?>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-2" id="cart">
                <?php
                    $cart = 0;
                    if(isset($_SESSION['cart'])){
                        foreach ($_SESSION['cart'] as $key => $qty){
                            $cart += $qty;
                        }
                    }
                ?>
                <a href="add_cart.php?id=<?php echo $_GET['id']; ?>" style="color: white;">
                    <div class="col-md-10" style="float: left;">
                        <i class="fas fa-cart-plus fa-lg mr-2" style="font-size: 30px;"></i>
                    </div>
                    <div class="col-md-2" style="float:left;">
                        <?php echo $cart; ?>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4" style="margin-top: -10px;">
            <h2 class="col-12 tm-text-primary">Photo title goes here</h2>
        </div>
        <div class="row tm-mb-90">            
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12" id="class">
                <div>
                    <?php 
                        $stat = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$blogId");
                        $stat -> execute();
                        $result = $stat -> fetchAll();

                    ?>
                        <img src="admin/images/<?php echo $result[0]['image_name']; ?>" class="img-fluid pad"  alt="Photo" id="mainImage">
                    <?php 

                    ?>
                </div>
                <div>
                    <div>
                        <form action="" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <div id="divBox">
                                <input type="text" name="box" value="" style="width: 50px;" id="hidden">
                            </div> 
                        </form>
                    </div><br>
                    <div class="row mb-3 tm-gallery">
                        <?php 
                            $stat = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$blogId");
                            $stat -> execute();
                            $result = $stat -> fetchAll();

                            foreach($result as $value){
                        ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 mb-3" onclick="changeImage(event);" id="myDiv" style="">
                            <div>
                               <div id="btnStop">
                                    <img src="admin/images/<?php echo $value['image_name']; ?>" style="" class="img-fluid" >
                                </div>
                                <div class="d-flex justify-content-between tm-text-gray">
                                    <span class="tm-text-gray-light">
                                        CG - <?php echo $value['image_id']; ?>        
                                    </span>
                                    <span>
                                        <input type="checkbox" name="checkbox[]" value="<?php echo $value['image_id']; ?>">
                                    </span>
                                </div> 
                            </div>
                        </div>

                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="" style="background-color: #eeeeee; padding:10px;">
                    
                        <?php 
                          $userPdo = $pdo -> prepare("SELECT * FROM user_order");
                          $userPdo -> execute();
                          $userResult = $userPdo -> fetchAll();
                          foreach($userResult as $value){
                          ?>
                            <input type="hidden" name="userId" value="<?php echo $value['id']+1; ?>">
                          <?php
                              }
                          ?>
                    <input type="hidden" name="user_id" value="<?php echo $useResult[0]['id']; ?>">
                    
                    <div>
                        <p class="mb-4">
                            <h2><?php echo escape($shResult[0]['title']); ?></h2>
                        </p>
                        
                        <p>
                            <?php
                                $author_id = $shResult[0]['author_id'];
                                $idpdo = $pdo -> prepare("SELECT * FROM users WHERE id=$author_id");
                                $idpdo -> execute();
                                $idResult = $idpdo -> fetchAll();
                             ?>
                            <h5>by - <?php echo escape($idResult[0]['Name']); ?></h5>
                        </p>
                    </div>
                    
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="col-md-12 mr-6 mb-2">
                            <p class="mb-4" style="font-size: 20px;margin-top: -10px;">Price - <?php echo $shResult[0]['price'] ?> &nbsp;ks</p>
                        </div>
                        <div class="col-md-12 mr-4 mb-2" style="margin-top: -10px;">
                            <span class="tm-text-gray-dark mb-4" style="text-align: justify;"><?php echo $shResult[0]['contant'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            if(isset($_POST['cartTo'])){

                                $auid = $_GET['id'];
                                $id = $_GET['p_id'];
                                $qty = $_POST['cart_number'];
                                
                                $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
                                $stat -> execute();
                                $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                if($qty > $result['image_quartity']){
                                    echo "<script>alert('Not enough stock');window.location.href='photo-detail.php?id=$auid&p_id=$id'</script>";
                                }else{
                                    if(isset($_SESSION['cart']['id'.$id])){
                                        $_SESSION['cart']['id'.$id] += $qty;
                                    }else{
                                        $_SESSION['cart']['id'.$id] = $qty;
                                    }
                                    echo "<script>alert('Having one more add cart..!');window.location.href='photo-detail.php?id=$auid&p_id=$id'</script>";
                                }
                            }

                            if(isset($_POST['addcart'])){

                                $auid = $_GET['id'];
                                $id = $_GET['p_id'];
                                $qty = $_POST['cart_number'];

                                $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
                                $stat -> execute();
                                $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                if($qty > $result['image_quartity']){
                                    echo "<script>alert('Not enough stock');window.location.href='photo-detail.php?id=$auid&p_id=$id'</script>";
                                }else{
                                    if(isset($_SESSION['cart']['id'.$id])){
                                        $_SESSION['cart']['id'.$id] += $qty;
                                    }else{
                                        $_SESSION['cart']['id'.$id] = $qty;
                                    }
                                    echo "<script>alert('Is Ok go to By Now');window.location.href='add_cart.php?id=$auid'</script>";
                                }
                                
                            }

                            if(isset($_POST['giftcart'])){
                                $auid = $_GET['id'];
                                $id = $_GET['p_id'];
                                $qty = $_POST['cart_number'];
                                
                                $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
                                $stat -> execute();
                                $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                if($qty > $result['image_quartity']){
                                    echo "<script>alert('Not enough stock');window.location.href='photo-detail.php?id=$auid&p_id=$id'</script>";
                                }else{
                                    if(isset($_SESSION['gift']['id'.$id])){
                                        $_SESSION['gift']['id'.$id] += $qty;
                                    }else{
                                        $_SESSION['gift']['id'.$id] = $qty;
                                    }
                                    echo "<script>alert('It is Ok ');window.location.href='gift_wrap.php?id=$auid'</script>";
                                }
                            }

                        ?>
                        <form action="" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                    <div class="input-group" id="DivCart">
                                        <span class="input-group-addon"><input type="button" class="form-control" value="-" id="declade"></span>
                                        <input type="text" class="form-control" name="cart_number" id="cart_number" value="1" style="padding: 0px;text-align: center; !improtant">
                                        <span class="input-group-addon"><input type="button" class="form-control" value="+" id="include"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-2">
                                    <input type="submit" class="form-control" value="Add To Cart" name="cartTo">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                <input type="submit" class="form-control" name="addcart" value="BY IT NOW">
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                                <!-- <a href="gift_wrap.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $_GET['p_id']; ?>"> -->
                                    <input type="submit" class="form-control" name="giftcart" value="A GIFT WRAP">
                                <!-- </a> -->
                            </div>
                        </form>
                    </div>  
                    <form action="" method="post">
                        <div class="form-group" id="hiddenClass" style="margin-top: -25px;">
                            <div>
                                <h5>Sending Multiple Images To Admin<hr></h5>                        
                            </div>
                            <input type="text" name="user_name" class="form-control rounded-0" placeholder="Name" required >
                            <input type="text" name="user_phone" placeholder="Phone" class="form-control rounded-0" required style="margin-top: 10px;">
                            <textarea rows="2" name="message" class="form-control rounded-0" placeholder="Address" style="margin-top: 10px;" required></textarea>
                            <input type="submit" name="submit" value="Send Massages" class="btn btn-primary" style="margin-top: 10px;padding:5px;font-size: 16px;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Photos
            </h2>
        </div>
        <div class="row mb-3 tm-gallery">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4 col-4 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="img/img-05.jpg" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>Morning</h2>
                        <a href="#">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light">26 Sep 2020</span>
                    <span>16,008 views</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4 col-4 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="img/img-06.jpg" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>Pinky</h2>
                        <a href="#">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light">22 Sep 2020</span>
                    <span>12,860 views</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4 col-4 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="img/img-07.jpg" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>Bus</h2>
                        <a href="#">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light">12 Sep 2020</span>
                    <span>10,900 views</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="img/img-08.jpg" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>New York</h2>
                        <a href="#">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light">4 Sep 2020</span>
                    <span>11,300 views</span>
                </div>
            </div>        
        </div> <!-- row -->
    </div> <!-- container-fluid, tm-container-content -->
<?php include_once("footer.php") ?>
