<?php 
    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 'Admin'){
         header("Location: ../registeradmin/login.php");
    }
    
    $author_id = $_SESSION['user_id'];

    $stat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_author_id=$author_id GROUP BY sal_post_id ORDER BY id DESC");
    $stat -> execute();
    $statResult = $stat -> fetchAll();

    // foreach ($statResult as $value1) {
    
    //   $sal_post = $value1['sal_post_id'];

    //   if (isset($_POST['select'])) {

    //     $count = $_POST['count'];

    //     $poststat = $pdo -> prepare("SELECT * FROM posts WHERE id=$sal_post AND sals_order >= $count");
    //     $poststat -> execute();
    //     $postResult = $poststat -> fetchAll();
    //     foreach ($postResult as $value2) {
          
    //       $post_id = $value2['id'];

    //       $stat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$post_id GROUP BY sal_post_id ORDER BY id DESC");
    //       $stat -> execute();
    //       $statResult = $stat -> fetchAll();

    //       foreach ($statResult as $valu) {
    //       echo$kkk =  $valu['sal_post_id'];
    //       echo "<br>";
            
    //       }
    //     }
        
    //   }
      
    // }

?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <div class="form-group col-md-7 col-sm-6">
                  <form action="" method="post">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                    <table class="">
                        <th>Saller Count</th>
                        <th>
                          <input type="number" name="count" value="" class="form-control">
                        </th>
                        <th><input type="submit" name="select" value="Select" class="btn btn-primary"></th>
                    </table>
                  </form>
                </div>
                   <div class="form-group table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="J_table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Post Title</th>
                                <th>Quartity</th>
                                <th>Order Sale</th>
                                <th>Price</th>
                                <th>Edit Post</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 

                                 if (isset($_POST['select'])) {
                                  $i = 1;
                                    foreach ($statResult as $values) {

                                      $sal_post = $values['sal_post_id'];

                                      if (isset($_POST['select'])) {

                                        $count = $_POST['count'];

                                          if ($count == '') {
                                            $order_id = $values['sal_post_id'];
                                            $postsql = $pdo -> prepare("SELECT * FROM posts WHERE id=$order_id"); 
                                            $postsql -> execute();
                                            $postresult = $postsql -> fetchAll();

                                    ?>
                                        <tr>
                                            <td align="center"><?php echo $i ?></td>
                                            <td><?php echo escape($postresult[0]['title']) ?></td>
                                            <td align="center"><?php echo escape($postresult[0]['id'] .'/'.$postresult[0]['image_quartity']) ?></td>

                                            <?php
                                              $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$order_id");
                                              $salpdo -> execute();
                                              $salResult = $salpdo -> fetchAll();
                                              $post_count = 0;
                                              foreach ($salResult as $valu) {
                                                $post_count += $valu['sal_qty'];
                                              }
                                             ?>
                                            <td align="center"><?php echo $post_count; ?></td>

                                                
                                            <td align="center"><?php echo escape($post_count * $postresult[0]['price']) ?> ks</td>
                                            <td>
                                              <a href="edit.php?id=<?php echo $postresult[0]['id']; ?>"><input type="button" class="btn btn-block btn-outline-info" value="View Post"></a>
                                            </td>
                                        </tr>  

                                    <?php

                                        $i++;
                                          }else{
                                            $poststat = $pdo -> prepare("SELECT * FROM posts WHERE id=$sal_post AND sals_order >= $count");
                                            $poststat -> execute();
                                            $postResult = $poststat -> fetchAll();
                                            foreach ($postResult as $value) {
                                              
                                              $post_id = $value['id'];

                                              $stat = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$post_id GROUP BY sal_post_id ORDER BY id DESC");
                                              $stat -> execute();
                                              $statResul = $stat -> fetchAll();

                                              foreach ($statResul as $valu) {

                                                $order_id = $valu['sal_post_id'];
                                                $postsql = $pdo -> prepare("SELECT * FROM posts WHERE id=$order_id"); 
                                                $postsql -> execute();
                                                $postresult = $postsql -> fetchAll();

                                    ?>
                                        <tr>
                                            <td align="center"><?php echo $i ?></td>
                                            <td><?php echo escape($postresult[0]['title']) ?></td>
                                            <td align="center"><?php echo escape($postresult[0]['id'] .'/'.$postresult[0]['image_quartity']) ?></td>

                                            <?php
                                              $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$order_id");
                                              $salpdo -> execute();
                                              $salResult = $salpdo -> fetchAll();
                                              $post_count = 0;
                                              foreach ($salResult as $valu) {
                                                $post_count += $valu['sal_qty'];
                                              }
                                             ?>
                                            <td align="center"><?php echo $post_count; ?></td>

                                                
                                            <td align="center"><?php echo escape($post_count * $postresult[0]['price']) ?> ks</td>
                                            <td>
                                              <a href="edit.php?id=<?php echo $postresult[0]['id']; ?>"><input type="button" class="btn btn-block btn-outline-info" value="View Post"></a>
                                            </td>
                                        </tr>  

                                    <?php

                                        $i++;
                                        }
                                      }
                                            
                                          }

                                }
                              }
                            }else{
                              if($statResult){
                                    $i = 1;
                                    foreach ($statResult as $values) {
                                        $order_id = $values['sal_post_id'];
                                        $postsql = $pdo -> prepare("SELECT * FROM posts WHERE id=$order_id"); 
                                        $postsql -> execute();
                                        $postresult = $postsql -> fetchAll();

                                ?>
                                    <tr>
                                        <td align="center"><?php echo $i ?></td>
                                        <td><?php echo escape($postresult[0]['title']) ?></td>
                                        <td align="center"><?php echo escape($postresult[0]['id'] .'/'.$postresult[0]['image_quartity']) ?></td>

                                        <?php
                                          $salpdo = $pdo -> prepare("SELECT * FROM sal_order WHERE sal_post_id=$order_id");
                                          $salpdo -> execute();
                                          $salResult = $salpdo -> fetchAll();
                                          $post_count = 0;
                                          foreach ($salResult as $valu) {
                                            $post_count += $valu['sal_qty'];
                                          }
                                         ?>
                                        <td align="center"><?php echo $post_count; ?></td>

                                            
                                        <td align="center"><?php echo escape($post_count * $postresult[0]['price']) ?> ks</td>
                                        <td>
                                          <a href="edit.php?id=<?php echo $postresult[0]['id']; ?>"><input type="button" class="btn btn-block btn-outline-info" value="View Post"></a>
                                        </td>
                                    </tr>  

                                <?php

                                    $i++;
                                    }
                                }
                            }

                            ?>
                           
                        </tbody>
                    </table>

                   </div>
              </div>
              <!-- /.card-body -->
              
            </div>

          </div>
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<!--    footer end  -->
<?php include_once ("footer.php") ?>
