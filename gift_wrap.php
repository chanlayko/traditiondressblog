<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

    $id = $_GET['id'];
    
    if (isset($_POST['payment'])) {
        
        $totalprice = $_POST['totalprice'];

        $contant = $_POST['con_info'];
        $gift_name = $_POST['name'];
        $gift_address = $_POST['gift_address'];

        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $company = $_POST['company'];
        $country = $_POST['country'];
        $township = $_POST['township'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = $pdo -> prepare("INSERT INTO user_order(gift_name,gift_address,first_name,last_name,con_info,phone,company,total_price,address,country,towship,gift_order,taked,users_id) VALUES (:gift_name,:gift_address,:first_name,:last_name,:con_info,:phone,:company,:total_price,:address,:country,:towship,:gift_order,:taked,:users_id)");
        $result = $sql -> execute(
            array(":gift_name"=>$gift_name,":gift_address"=>$gift_address,":first_name"=>$first_name,":last_name"=>$last_name,":con_info"=>$contant,":phone"=>$phone,":company"=>$company,":total_price"=>$totalprice,":address"=>$address,":country"=>$country,":towship"=>$township,":gift_order"=>'gift',":taked"=>"draft",":users_id"=>$id)
        );

        if ($result) {
            $giftid = $pdo -> lastInsertId();

                foreach($_SESSION['gift'] as $key => $qty){
                $sid = str_replace('id','',$key);

                    $salODstat = $pdo -> prepare("INSERT INTO sal_order (sal_user_id,sal_post_id,sal_qty,sal_author_id) VALUES (:sal_user_id,:sal_post_id,:sal_qty,:sal_author_id)");
                    $salODResult = $salODstat -> execute([':sal_user_id'=>$giftid,':sal_post_id'=>$sid,':sal_qty'=>$qty,':sal_author_id'=>$id]);
                
                    $qtyStat = $pdo -> prepare("SELECT image_quartity FROM posts WHERE id=".$sid);
                    $qtyStat -> execute();
                    $qtyResult = $qtyStat -> fetch(PDO::FETCH_ASSOC);

                    $upResult = $qtyResult['image_quartity'] - $qty;

                    $Stat = $pdo -> prepare("UPDATE posts SET image_quartity=:qty WHERE id=".$sid);
                    $Result = $Stat -> execute(
                        array(':qty'=>$upResult)
                    );
                }
            echo "<script>alert('Thank you. Your order has been received.');window.location.href='index.php?id=$id'</script>";
        }
        unset($_SESSION['gift']);
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
        <div class="row">
            <h2 style="text-align: center;">Gift Wrap Item Cart</h2>
        </div><br>
        <!-- <div class="container"> -->
            <div class="row">
                <div class="container col-xl-7 col-lg-7 col-md-12">
                    <div style="text-align: center;">
                        <h3>Gift Item Total</h3><br>
                    </div>
                    <div class="row mb-3 table-responsive" id="table">
                        

                            <?php if(isset($_SESSION['gift'])) :?>

                            <table class="table text-center table-hover">
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Product Title</th>
                                    <th>Total Price</th>
                                    <th>Quantity</th>
                                    <th colspan="2">Active</th>
                                </tr>
                                <?php
                                    $total = 0;
                                    $subtotal = 0;
                                    foreach ($_SESSION['gift'] as $key => $qty){
                                        
                                        $id = str_replace('id','',$key);
                                        
                                        $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=".$id);
                                        $stat -> execute();
                                        $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                        
                                        $total = $result['price'] * $qty;

                                        $subtotal += $total;
                                   
                                    ?>
                                        <tr style="line-height: 100px;">
                                            <td>
                                                <a href="gift_cart.php?p_id=<?php echo $result['id']; ?>&id=<?php echo $_GET['id']; ?>">
                                                    <span><i class="fas fa-times"></i></span>
                                                </a>
                                            </td>
                                            <td>
                                                <?php 
                                                    $post_id = $result['id'];
                                                    $imgSql = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$post_id");
                                                    $imgSql -> execute();
                                                    $imgResult = $imgSql -> fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <img src="admin/images/<?php echo $imgResult['image_name']; ?>" alt="" class="img-responsive img-cover" width="100px;">
                                                <?php 
                                                ?>
                                            </td>
                                            <td style="line-height: 30px;padding-top: 40px;"><?php echo escape($result['title']); ?></td>
                                            <td><span id="total"><?php echo escape($total); ?></span>&nbsp;ks</td>
                                            <td style="line-height: 0px;padding-top: 50px;" align="center">
                                                <input type="number" value="<?php echo $qty; ?>" name="qty" class="input-group" style="width: 50px;" id="qtyNum">
                                            </td>
                                        <form action="addtocart2.php" method="post">
                                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                            <input type="hidden" name="p_id" value="<?php echo $result['id']; ?>">
                                            <input type="hidden" name="qty" value="<?php echo $qty; ?>">
                                            <td>
                                                <input type="submit" value="Like To Cart" name="likecart" class="btn btn-sm btn-info">
                                            </td>
                                            <td>
                                                <input type="submit" value="Add To Cart" name="addcart" class="btn btn-sm btn-info">
                                            </td>
                                        </form>
                                        </tr>
                                        
                                    <?php

                                        }
                                     ?>
                                 <tr style="background-color: #eeeeee;">
                                            <td colspan="2">
                                                <h3>Total</h3>
                                            </td>
                                            <td></td>
                                            <td colspan="4">
                                                <h3>MMK <?php echo $subtotal; ?> ks</h3>
                                            </td>
                                        </tr>
                            </table>
                            <?php endif ?>

                        
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container col-xl-4 col-lg-4 col-md-12">
                    <div style="text-align: center;">
                        <h3>Delivery Information</h3><br>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                        <input type="hidden" name="totalprice" value="<?php echo $subtotal; ?>">
                        <div class="col-lg-12" style="background-color: #eeeeee;">
                            <div class="" style="padding-left: 15px;padding-right: 15px;">
                                <div style="padding-top: 10px;" class="col-md-12 mb-2">
                                    <label for="info"><h5 class="mb-2">Contant Information</h5></label>
                                    <input type="text" name="con_info" class="form-control" id="info" placeholder="Email or Mobile phone" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2" id="delivery">
                                        <h5>Your Massage</h5>
                                            <div class="col-md-12 mb-2">
                                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <textarea name="gift_address" id="" cols="30" rows="3" class="form-control" placeholder="Massages"></textarea>
                                            </div>
                                    </div>
                                    <div class="col-md-12 mb-4" id="delivery">
                                        <h5>Gift Wrap To Address</h5>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-2">
                                                <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-2">
                                                <input type="text" name="company" class="form-control" placeholder="Company (option)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-2">
                                                <input type="text" name="country" class="form-control" placeholder="Country" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" name="township" class="form-control" placeholder="Township" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="address" class="form-control" id="" cols="30" rows="3" placeholder="Gift Address" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: -30px;">
                                    <div class="col-md-12 mb-4">
                                        
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="form-group">
                                        <input type="submit" name="payment" value="Containe to Payment" class="btn btn-primary float-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
<!-- 
            <div class="row">
                
            </div> -->
        <!-- </div> -->
        
        
        
        
      
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
