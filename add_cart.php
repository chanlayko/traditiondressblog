<?php 
    session_start();
    require_once "confiy/confiy.php";
    require_once "confiy/common.php";

    $id = $_GET['id'];
    
    if (isset($_POST['payment'])) {

        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $cont_info = $_POST['cont_info'];
        $company = $_POST['company'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $township = $_POST['township'];
        $phone = $_POST['phone'];

        $qty = $_POST['qty'];

        $total_price = $_POST['total_price'];
        $total_qty = $_POST['total_qty'];

        $sql = $pdo -> prepare("INSERT INTO user_order(first_name,last_name,con_info,phone,company,total_price,address,country,towship,taked,users_id) VALUES (:first_name,:last_name,:con_info,:phone,:company,:total_price,:address,:country,:towship,:taked,:users_id)");
        $result = $sql -> execute([':first_name'=>$first_name,':last_name'=>$last_name,':con_info'=>$cont_info,':phone'=>$phone,':company'=>$company,':total_price'=>$total_price,':address'=>$address,':country'=>$country,':towship'=>$township,':taked'=>'draft',':users_id'=>$id]);

        if($result){
            $salODid = $pdo -> lastInsertId();

                foreach($_SESSION['cart'] as $key => $qty){
                $sid = str_replace('id','',$key);

                    $salODstat = $pdo -> prepare("INSERT INTO sal_order (sal_user_id,sal_post_id,sal_qty,sal_author_id) VALUES (:user_id,:post_id,:qty,:author_id)");
                    $salODResult = $salODstat -> execute([':user_id'=>$salODid,':post_id'=>$sid,':qty'=>$qty,':author_id'=>$id]);
                
                    $qtyStat = $pdo -> prepare("SELECT image_quartity FROM posts WHERE id=".$sid);
                    $qtyStat -> execute();
                    $qtyResult = $qtyStat -> fetch(PDO::FETCH_ASSOC);

                    $upResult = $qtyResult['image_quartity'] - $qty;

                    $upstat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_author_id=$id GROUP BY sal_post_id");
                    $upstat -> execute();
                    $upstatResult = $upstat -> fetchAll();

                    foreach ($upstatResult as $value) {
                        $sal_post = $value['sal_post_id'];

                        $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$sal_post");
                        $salpdo -> execute();
                        $salResult = $salpdo -> fetchAll();

                        $post_count = 0;

                        foreach ($salResult as $value) {
                          $post_count += $value['sal_qty'];
                        }

                        $pod_sal = $pdo -> prepare("UPDATE posts SET image_quartity=:qty,sals_order=:post_count WHERE id=$sal_post");
                        $result = $pod_sal -> execute(
                            array(':qty'=>$upResult,':post_count'=>$post_count)
                        );
                    }

                    // $Stat = $pdo -> prepare("UPDATE posts SET image_quartity=:qty WHERE id=".$sid);
                    // $Result = $Stat -> execute(
                    //     array(':qty'=>$upResult)
                    // );
                }
        }
            echo "<script>alert('Thank you. Your order has been received.');window.location.href='index.php?id=$id'</script>";
        unset($_SESSION['cart']);
    }

     if (isset($_POST['pickup'])) {

        $total_price = $_POST['total_price'];

        $pickup_name = $_POST['pickup_name'];
        $pickup_phone= $_POST['pickup_phone'];
        $cont_info = $_POST['cont_info'];

        $total_qty = $_POST['total_qty'];

        $sql = $pdo -> prepare("INSERT INTO user_order(gift_name,con_info,phone,total_price,gift_order,taked,users_id) VALUES (:gift_name,:con_info,:phone,:total_price,:gift_order,:taked,:users_id)");
        $result = $sql -> execute(
            array(':gift_name'=>$pickup_name,':con_info'=>$cont_info,':phone'=>$pickup_phone,':total_price'=>$total_price,':gift_order'=>'pickup',':taked'=>'draft',':users_id'=>$id)
        );

        if($result){
            $salid = $pdo -> lastInsertId();

                foreach($_SESSION['cart'] as $key => $qty){
                $sid = str_replace('id','',$key);

                    $salODstat = $pdo -> prepare("INSERT INTO sal_order (sal_user_id,sal_post_id,sal_qty,sal_author_id) VALUES (:user_id,:post_id,:qty,:author_id)");
                    $salODResult = $salODstat -> execute([':user_id'=>$salid,':post_id'=>$sid,':qty'=>$qty,':author_id'=>$id]);
                
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
        unset($_SESSION['cart']);
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

                    if ($cart == 0) {
                        header("Location: index.php?id=".$_GET['id']);   
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
            <h2 style="text-align: center;">Shopping Cart</h2>
        </div><br>
        <div class="container">
            <form action="" method="post">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="total_qty" value="<?php echo $total_qty; ?>">
        	   <div class="row">
	        	<div class="container col-xl-6 col-lg-6 mb-4" style="margin-right: 10px;">
	        		<div style="text-align: center;">
	            		<h3>Cart Total</h3><br>
	            	</div>
		            <div class="row mb-3 table-responsive" id="table">
                		<?php if(isset($_SESSION['cart'])) :?>
		                <table class="table text-center table-hover">
		                    <tr>
		                        <th></th>
		                        <th>Product</th>
		                        <th>Product Title</th>
		                        <th>Price</th>
		                        <th>Quantity</th>
		                    </tr>
		                    <?php
		                        $total = 0;
                                $subtotal = 0;
                                $total_qty = 0;
		                            foreach ($_SESSION['cart'] as $key => $qty){
		                                  
		                                $id = str_replace('id','',$key);
		                                
		                                $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=".$id);
		                                $stat -> execute();
		                                $result = $stat -> fetch(PDO::FETCH_ASSOC);
		                                
		                                $total = $result['price'] * $qty;

                                        $subtotal += $total;

                                        $total_qty += $qty;

		                            ?>
		                            <tr style="line-height: 100px;">
		                                <td>
		                                    <a href="move_item1.php?id=<?php echo $result['id']; ?>&id=<?php echo $_GET['id']; ?>">
		                                        <button class="btn">
		                                            <span><i class="fas fa-times"></i></span>
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
		                                <td style="line-height: 30px;padding-top: 40px;"><?php echo escape($result['title']); ?></td>
		                                <td><span id="total"><?php echo escape($total); ?></span>&nbsp;ks</td>
		                                <td style="line-height: 0px;padding-top: 50px;">
                                            <div id="mydiv">
                                                <input type="number" value="<?php echo $qty; ?>" class="input-group" style="width: 50px;" id="qtyNum">
                                            </div>
		                                </td>
		                                
		                            </tr>

		                            <?php

		                                }
		                             ?>

                                <tr style="background-color: #eeeeee;">
                                    <td>
                                        <h3>Total</h3>
                                    </td>
                                    <td></td>
                                    <td colspan="3">
                                        <div class="div">
                                            
                                        </div>
                                        <h3>MMK <?php echo $subtotal;  ?> ks</h3>
                                        <input type="hidden" name="total_price" value="<?php echo $subtotal; ?>">
                                    </td>
                                </tr>
		                </table>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                <?php endif ?>

		            </div>
		        </div>
		        <div class="container col-xl-5 col-lg-5 mb-4">
	        		<div class="row">
		            	<div style="text-align: center;">
		            		<h3>Delivery Information</h3><br>
		            	</div>
	            		<div class="col-lg-12" style="background-color: #eeeeee;">
                			<div class="" style="padding-left: 15px;padding-right: 15px;">
                				<div style="padding-top: 10px;" class="mb-4">
				            		<label for="info"><h5 class="mb-2">Contant Information</h5></label>
				            		<input type="text" name="cont_info" class="form-control" id="info" placeholder="Email or Mobile phone" required>
				            	</div>
				            	<div class="form-group mb-4">
			        				<h5>Delivery Method</h5>
			        				<div style="line-height:40px;border: 1px solid gray;padding-left: 10px; border-radius: 3px;" id="delmon">
			        				 	<input type="radio" id="del" name="mon" checked>
			        				 	<label for="del"><span>Delivery</span></label>
			        				</div>
			        				<div style="line-height: 40px;border: 1px solid gray;padding-left: 10px;border-radius: 3px;" id="pickupmon">
			        					<input type="radio" id="pic" name="mon">
			        					<label for="pic"><span>Pickup</span></label>
			        				</div>
			        			</div>
			        			<div class="mb-4" id="delivery">
			        				<h5>Delivery Address</h5>
			        				<div class="row">
			        					<div class="col-lg-6 col-md-6 mb-2">
			        						<input type="text" name="firstName" class="form-control" placeholder="First Name" >
			        					</div>
			        					<div class="col-lg-6 col-md-6 mb-2">
			        						<input type="text" name="lastName" class="form-control" placeholder="Last Name" >
			        					</div>
			        				</div>
			        				<div class="row mb-2">
                                        <div class="col-md-12">
                                            <input type="number" name="phone" class="form-control" placeholder="Phone" >
                                        </div>
                                    </div>
			        				<div class="row">
			        					<div class="col-lg-6 col-md-6 mb-2">
			        						<input type="text" name="country" class="form-control" placeholder="Country" >
			        					</div>
			        					<div class="col-lg-6 col-md-6 mb-2">
			        						<input type="text" name="township" class="form-control" placeholder="Township" >
			        					</div>
			        				</div>
                                    <div class="form-group">
                                        <input type="text" name="company" class="form-control mb-2" placeholder="Company (option)">
                                        <textarea name="address" class="form-control" id="" cols="" rows="2"placeholder="Address"></textarea>
                                    </div>
			        				
			        			</div>
			        			<div class="mb-4" id="pickup">
                                    <h5>Your Contant</h5>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <input type="text" name="pickup_name" class="form-control" placeholder="Your Name">
                                            </div>
                                            <div class="">
                                                <input type="text" name="pickup_phone" class="form-control" placeholder="Contant Phone">
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Pickup Location</h5>
		        					<div class="row col-md-12" style="margin-left: 10px;">
                                        <div class="row" style="line-height:40px;border: 1px solid gray;border-radius: 3px;">
                                            <div class="col-7">
                                                <input type="radio" checked> ထားဝယ် <br>
                                                <p style="padding-left: 15px; font-size: 13px;">564 Complex, 66 Laydaungkan Road,Thinganyun</p>
                                            </div>
                                            <div class="col-5" >
                                                <div class="float-right">
                                                    Free
                                                </div><br>
                                                <div>
                                                    <p style="font-size: 13px;" class="float-right">Usually ready in 24 hours</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
			        			</div>
			        			<div class="row">
                                    <div class="mb-4" id="pay">
		        					   <input type="submit" name="payment" value="Containe Payment" class="btn btn-primary float-right">
                                    </div>
                                    <div class="mb-4" id="pick">
                                       <input type="submit" name="pickup" value="Containe Pickup" class="btn btn-primary float-right">
                                    </div>
			        			</div>
                			</div>
	        			</div>
	        		</div>
	        	</div>
	           </div>
            </form>
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
