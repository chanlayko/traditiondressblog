<?php 
    session_start();
    
    if ($_SESSION['like']['id'.$_GET['p_id']]) {
    	unset($_SESSION['like']['id'.$_GET['p_id']]);

    	header("Location: like_cart.php?id=".$_GET['id']);
    }

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