<?php 
    require_once "../confiy/confiy.php";
    
    // $post_id = $_GET['post_id'];

    $user_order = $_GET['user_id'];

    $sql = "DELETE FROM user_order WHERE id=$user_order";
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();

    $sql = "DELETE FROM sal_order WHERE sal_user_id=$user_order";
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();

    $sql = "DELETE FROM send_mail WHERE order_id=$user_order";
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();
    
    header("Location: gift_information.php?");

?>
