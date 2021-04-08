<?php 
    require_once "../confiy/confiy.php";
    
    $post_id = $_GET['id'];
    $sql = "DELETE FROM posts WHERE id=$post_id";
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();

    $desql = $pdo -> prepare("DELETE FROM multiple_image WHERE post_image_id=$post_id");
    $deResult = $desql -> execute();
    
    header("Location: post.php");

?>