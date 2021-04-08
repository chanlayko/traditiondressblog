<?php 
    session_start();
    require_once "confiy/confiy.php";

    if(isset($_POST['likeTo'])){

        $auid = $_POST['auid'];
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        
        if(isset($_SESSION['like']['id'.$id])){
            $_SESSION['like']['id'.$id] += $qty;
        }else{
            $_SESSION['like']['id'.$id] = $qty;
        }
        echo "<script>alert('Having one more like cart..!');window.location.href='index.php?id=$auid'</script>";
    }

    if(isset($_POST['cartTo'])){

        $auid = $_POST['auid'];
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        
        $stat = $pdo -> prepare("SELECT * FROM posts WHERE id=$id");
        $stat -> execute();
        $result = $stat -> fetch(PDO::FETCH_ASSOC);
        if($qty > $result['image_quartity']){
            echo "<script>alert('Not enough stock');window.location.href='index.php?id=$auid'</script>";
        }else{
            if(isset($_SESSION['cart']['id'.$id])){
                $_SESSION['cart']['id'.$id] += $qty;
            }else{
                $_SESSION['cart']['id'.$id] = $qty;
            }
            echo "<script>alert('Having one more add cart..!');window.location.href='index.php?id=$auid'</script>";

        }
    }

?>