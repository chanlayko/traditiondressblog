<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";   
?>
<?php include_once("header.php") ?>

<?php

    $auId = $_GET['id'];

     if(!empty($_GET['pageno'])){
        $pageno = $_GET['pageno'];
    }else{
        $pageno = 1;
    }

    $numOfrecs = 12; 

    $offset = ($pageno - 1) * $numOfrecs;

    if(empty($_POST['search'])){
        $sql = "SELECT * FROM posts WHERE author_id=$auId AND post_status='Public' ORDER BY id DESC";
        $pdostat = $pdo -> prepare($sql);
        $pdostat -> execute();
        $RowResult = $pdostat -> fetchAll();
        $total_pages = ceil(count($RowResult) / $numOfrecs);

        $sql = "SELECT * FROM posts WHERE author_id=$auId AND post_status='Public' ORDER BY id DESC LIMIT $offset,$numOfrecs";
        $pdostat = $pdo -> prepare($sql);
        $pdostat -> execute();
        $result = $pdostat -> fetchAll();                       
      }else{
          $searchkey = $_POST['search'];
        $sql = "SELECT * FROM posts WHERE author_id=$auId AND post_status='Public' AND title LIKE '%$searchkey%' ORDER BY id DESC";
          $pdostat = $pdo -> prepare($sql);
          $pdostat -> execute();
          $RowResult = $pdostat -> fetchAll();
          $total_counts = count($RowResult);
          $total_pages = ceil(count($RowResult) / $numOfrecs);

        $sql = "SELECT * FROM posts WHERE author_id=$auId AND post_status='Public' AND title LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$numOfrecs";
          $pdostat = $pdo -> prepare($sql);
          $pdostat -> execute();
          $result = $pdostat -> fetchAll();
      } 

?> 
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
    <!-- search form -->
    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg">
    <?php
            $link = $_SERVER['PHP_SELF'];
            $link_array = explode('/',$link);
            $page = end($link_array);
        ?>
        <!-- SEARCH FORM -->
       <form class="d-flex tm-search-form" method="post" action="">
         <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">        
            <input class="form-control tm-search-input" type="search" name="search" placeholder="Search" aria-label="Search">
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
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                Latest Photos
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    Page <input type="text" value="<?php echo $pageno; ?>" size="1" class="tm-input-paging tm-text-primary"> of <?php echo $total_pages; ?>
                </form>
            </div>
        </div>
        <div class="row tm-mb-90 tm-gallery">
        <?php
            if($result){
                foreach($result as $value){
            ?>
                <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6 mb-5">
                    <figure class="effect-ming tm-video-item">
                        <?php 

                        $post_id = $value['id'];
                        $imgsql = $pdo -> prepare("SELECT * FROM multiple_image WHERE post_image_id=$post_id");
                        $imgsql -> execute();
                        $imgResult = $imgsql -> fetchAll();

                        ?>
                        <img src="admin/images/<?php echo $imgResult[0]['image_name']; ?>" alt="" class="img-responsive img-cover" id="">
                        <?php

                    ?>
                        <figcaption class="d-flex align-items-center justify-content-center">
                            <h2>View More</h2>
                            <a href="photo-detail.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $value['id']; ?>">View more</a>
                        </figcaption>                    
                    </figure>
                    

                            
                    <div>
                        <form action="addtocart.php" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <input type="hidden" name="qty" value="1">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                            <input type="hidden" name="auid" value="<?php echo $_GET['id']; ?>">
                            <h5>
                                <span><?php echo $value['title']; ?></span>
                            </h5>
                            <a href="addtocart.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $value['id']; ?>" class="link-black text-sm">
                                <button type="submit" name="likeTo" class="btn" style="color: #3ea1e8;">
                                    <i class="fas fa-heart fa-lg mr-1"></i>
                                </button>
                            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="">
                              <a href="addtocart.php?id=<?php echo $_GET['id']; ?>&p_id=<?php echo $value['id']; ?>" class="link-black text-sm">
                                <button type="submit" class="btn" name="cartTo" style="color: #3ea1e8;"><i class="fas fa-cart-plus fa-lg mr-2"></i></button>
                              </a>
                            </span>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between tm-text-gray">
                        <span>Price - <?php echo $value['price'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>4500</i>  ks</span>
                        <!-- <span class="tm-text-gray-light"><?php echo date('d,m,Y',strtotime($value['created_at'])) ?></span> -->
                    </div>
                </div>

            <?php
                }
            }

        ?>
                   
        </div> <!-- row -->
        <div class="row tm-mb-90" style="margin-top: -50px;">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col" >
                <nav aria-label="Page naigation example">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item">
                            <a href="index.php?id=<?php echo $auId ?>&pageno=1" class="tm-paging-link">First</a>
                        </li>
                        <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                            <a href="<?php if($pageno <= 1){ echo '#';}else{ echo "index.php?id=$auId&pageno=".($pageno-1);} ?>" class="tm-paging-link" style="width: 50px;"><<</a>
                        </li>
                        <li class="page-item"><a href="#" class="tm-paging-link"><?php echo $pageno; ?></a></li>
                        <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                            <a href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo "index.php?id=$auId&pageno=".($pageno+1);} ?>" class="tm-paging-link" style="width: 50px;">>></a>
                        </li>
                        <li class="page-item">
                            <a href="index.php?id=<?php echo $auId; ?>&pageno=<?php echo $total_pages ?>" class="tm-paging-link">Last</a>
                        </li>
                    </ul>  
               </nav>   
            </div>            
        </div>
    </div> <!-- container-fluid, tm-container-content -->

<?php include_once("footer.php") ?>



