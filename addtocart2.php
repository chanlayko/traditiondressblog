<?php 
    session_start();
    require_once "confiy/confiy.php";

    if(isset($_POST['likecart'])){

        $id = $_POST['id'];
        $p_id = $_POST['p_id'];
        $qty = $_POST['qty'];
        
        if(isset($_SESSION['like']['id'.$p_id])){
            $_SESSION['like']['id'.$p_id] += $qty;
        }else{
            $_SESSION['like']['id'.$p_id] = $qty;
        }
        echo "<script>alert('Having one more like cart..!');window.location.href='gift_wrap.php?id=$id'</script>";
    }

    if(isset($_POST['addcart'])){

        $id = $_POST['id'];
        $p_id = $_POST['p_id'];
        $qty = $_POST['qty'];
        
        $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
        $stat -> execute();
        $result = $stat -> fetch(PDO::FETCH_ASSOC);
        if($qty > $result['image_quartity']){
            echo "<script>alert('Not enough stock');window.location.href='gift_wrap.php?id=$id'</script>";
        }else{
            if(isset($_SESSION['cart']['id'.$p_id])){
                $_SESSION['cart']['id'.$p_id] += $qty;
            }else{
                $_SESSION['cart']['id'.$p_id] = $qty;
            }
            echo "<script>alert('Having one more add cart..!');window.location.href='gift_wrap.php?id=$id'</script>";

        }
    }

    // if ($_SESSION['gift']['id'.$_GET['p_id']]) {
    //     unset($_SESSION['gift']['id'.$_GET['p_id']]);

    //     header("Location: gift_wrap.php?id=".$_GET['id']."&p_id=".$_GET['p_id']);
    // }

?>