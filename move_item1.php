<?php 
    session_start();
    
	if ($_SESSION['cart']['id'.$_GET['id']]) {
		unset($_SESSION['cart']['id'.$_GET['id']]);

		header("Location: add_cart.php?id=".$_GET['auid']);
	}

	$cart = 0;
    if(isset($_SESSION['cart'])){
        foreach ($_SESSION['cart'] as $key => $qty){
            $cart += $qty;
        }
    }

    if ($cart == 0) {
		header("Location: index.php?id=".$_GET['auid']);
    	
    }

?>