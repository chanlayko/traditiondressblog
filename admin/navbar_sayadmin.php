
<?php
  $link = $_SERVER['PHP_SELF'];
  $link_array = explode('/',$link);
  $page = end($link_array);
?>
<div class="col-md-3">
  <a href="<?php echo $page == 'sayadmin.php'? 'sayadmin_massage.php':'sayadmin.php'; ?>" class="btn btn-primary btn-block mb-3">Go To Say Admin Massage</a>
  <!-- <a href="#" class="btn btn-default btn-block mb-3"><?php echo $result[0]['mail']; ?></a> -->
  <!-- <div class="col-md-12 mb-3"> -->
  <?php
    $sql = $pdo -> prepare("SELECT * FROM admin_user");
    $sql -> execute();
    $results = $sql -> fetchAll();
   ?>
    <button type="button" class="btn btn-default btn-block mb-3"><?php echo $results[0]['email']; ?></button>
  <!-- </div> -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Folders</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-pills flex-column">
        <?php 

          $author_id = $_SESSION['user_id'];

          $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND sayadmin='sayadmin'");
          $stat -> execute();
          $mail_result = $stat -> fetchAll();

          $mail_count = count($mail_result);

        ?>
        <li class="nav-item active">
          <a href="sayadmin.php" class="nav-link <?php echo $page == 'sayadmin.php'? 'active':''; ?>">
            <i class="fas fa-inbox"></i> Inbox
            <span class="badge bg-primary float-right"><?php echo $mail_count == '0'? '' : $mail_count; ?></span>
          </a>
        </li>
        <?php 

          $author_id = $_SESSION['user_id'];

          $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='send' AND sayadmin='sayadmin'");
          $stat -> execute();
          $seresult = $stat -> fetchAll();

          $sending_count = count($seresult);

        ?>
        <li class="nav-item">
          <a href="send_sayadmin.php" class="nav-link <?php echo $page == 'send_sayadmin.php'? 'active':''; ?>">
            <i class="fas fa-share" style="color:red;"></i> Sending
            <span class="badge bg-danger float-right"><?php echo $sending_count == '0'? '' : $sending_count; ?></span>
          </a>
        </li>
        <?php 

        $author_id = $_SESSION['user_id'];

        $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND order_method='income' AND sayadmin='sayadmin'");
        $stat -> execute();
        $inresults = $stat -> fetchAll();

        $income_count = count($inresults);

        ?>
        <li class="nav-item">
          <a href="income_sayadmin.php" class="nav-link <?php echo $page == 'income_sayadmin.php'? 'active':''; ?>">
            <i class="fas fa-reply" style="color:green;"></i> Incoming
            <span class="badge bg-success float-right"><?php echo $income_count == '0'? '' : $income_count; ?></span>
          </a>
        </li>
        <?php 

        $author_id = $_SESSION['user_id'];

        $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND draft='draft' AND sayadmin='sayadmin'");
        $stat -> execute();
        $results = $stat -> fetchAll();

        $draft_count = count($results);

        ?>
        <li class="nav-item">
          <a href="draft_sayadmin.php" class="nav-link <?php echo $page == 'draft_sayadmin.php'? 'active':''; ?>">
            <i class="fas fa-filter"></i> Draft
            <span class="badge bg-warning float-right"><?php echo $draft_count == '0'? '' : $draft_count; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <?php 

            $author_id = $_SESSION['user_id'];

            $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin='admin'");
            $stat -> execute();
            $trashresults = $stat -> fetchAll();

            $trash_count = count($trashresults);

          ?>

          <a href="trash_sayadmin.php" class="nav-link <?php echo $page == 'trash_sayadmin.php'? 'active':''; ?>">
            <i class="far fa-trash-alt"></i> Trash
            <span class="badge bg-secondary float-right"><?php echo $trash_count == '0'? '' : $trash_count; ?></span>
          </a>
        </li>
      </ul>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Labels</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a href="sayadmin_important.php" class="nav-link <?php echo $page == 'sayadmin_important.php'? 'active':''; ?>">
            <i class="far fa-circle text-danger"></i>
            Important
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle text-warning"></i>
            Promotions
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle text-primary"></i>
            Social
          </a>
        </li>
      </ul>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>