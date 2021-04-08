<?php

session_start();
require_once "confiy/confiy.php";


if(isset($_POST['cartTo'])){

    $auid = $_POST['auid'];
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    
    $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
    $stat -> execute();
    $result = $stat -> fetch(PDO::FETCH_ASSOC);
    if($qty > $result['image_quartity']){
        echo "<script>alert('Not enough stock');window.location.href='like_cart.php?id=$auid'</script>";
    }else{
        if(isset($_SESSION['cart']['id'.$id])){
            $_SESSION['cart']['id'.$id] += $qty;
        }else{
            $_SESSION['cart']['id'.$id] = $qty;
        }
        header("Location:like_cart.php?id=$auid");
    }
}

?>