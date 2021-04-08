<?php 
    session_start();
    
    if ($_SESSION['gift']['id'.$_GET['p_id']]) {
        unset($_SESSION['gift']['id'.$_GET['p_id']]);

        header("Location: gift_wrap.php?id=".$_GET['id']);
    }

    $gift = 0;
    if(isset($_SESSION['gift'])){
        foreach ($_SESSION['gift'] as $key => $qty){
            $gift += $qty;
        }
    }

    if ($gift == 0) {
        header("Location: index.php?id=".$_GET['id']);
        
    }

?>