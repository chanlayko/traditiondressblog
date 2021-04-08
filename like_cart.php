<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

    
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
                    if ($like == 0) {
                        header("Location: index.php?id=".$_GET['id']);   
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
            <h2 style="text-align: center;">Like Wishlist</h2>
        </div><br>
        <div class="container">
            <div class="row mb-3 table-responsive">
                <?php if(isset($_SESSION['like'])) :?>
                <table class="table text-center table-hover">
                    <tr>
                        <th></th>
                        <th>Post Image</th>
                        <th>Post Title</th>
                        <th>Unit Price</th>
                        <th colspan="2" style="text-align: center;">Active</th>
                    </tr>
                    <?php
                        $total = 0;
                            foreach ($_SESSION['like'] as $key => $qty){
                                  
                                $id = str_replace('id','',$key);
                                
                                $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=".$id);
                                $stat -> execute();
                                $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                
                            ?>
                            <tr style="line-height: 100px;">
                                <td>
                                    <a href="move_item.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $result['id']; ?>">
                                        <button class="btn">
                                            <i class="fas fa-times"></i>
                                        </button>
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
                                <td><?php echo escape($result['title']); ?></td>
                                <td><?php echo escape($result['price']); ?> ks</td>
                                <td>
                                    <form action="addtocart1.php" method="post">
                                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                        <input type="hidden" name="auid" value="<?php echo $_GET['id']; ?>">
                                        <a href="addtocart1.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $result['id']; ?>">
                                            <input type="submit" value="Add To Cart" name="cartTo" class="btn btn-sm btn-info">
                                        </a>
                                        
                                    </form>
                                </td>
                                <td>
                                    <a href="photo-detail.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $result['id']; ?>">
                                        <input type="button" value="View Detail" class="btn btn-sm btn-info"></td>
                                    </a>
                            </tr>

                            <?php

                                }
                             ?>
                    
                </table>

                <?php endif ?>

            </div>
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
