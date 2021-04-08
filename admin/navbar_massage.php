<?php
  $link = $_SERVER['PHP_SELF'];
  $link_array = explode('/',$link);
  $page = end($link_array);
?>
<div class="col-md-3">
  <a href="order_information.php" class="btn btn-primary btn-block mb-3">Go To Order Information</a>

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

          $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND sayadmin=''");
          $stat -> execute();
          $mail_result = $stat -> fetchAll();

          $mail_count = count($mail_result);

        ?>
        <li class="nav-item active">
          <a href="inbox_massage.php" class="nav-link <?php echo $page == 'inbox_massage.php'? 'active':''; ?>">
            <i class="fas fa-inbox"></i> Inbox
            <span class="badge bg-primary float-right"><?php echo $mail_count == '0'? '' : $mail_count; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="sent_massage.php" class="nav-link <?php echo $page == 'sent_massage.php'? 'active':''; ?>">
            <i class="far fa-envelope"></i> Sent
          </a>
        </li>
        <?php 

        $author_id = $_SESSION['user_id'];

        $stat = $pdo -> prepare("SELECT * FROM send_mail WHERE author_id=$author_id AND draft='draft' AND sayadmin=''");
        $stat -> execute();
        $results = $stat -> fetchAll();

        $draft_count = count($results);

        ?>
        <li class="nav-item">
          <a href="draft_massage.php" class="nav-link <?php echo $page == 'draft_massage.php'? 'active':''; ?>">
            <i class="fas fa-filter"></i> Drafts
            <span class="badge bg-warning float-right"><?php echo $draft_count == '0'? '' : $draft_count; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <?php 

            $author_id = $_SESSION['user_id'];

            $stat = $pdo -> prepare("SELECT * FROM delete_trash WHERE author_id=$author_id AND sayadmin=''");
            $stat -> execute();
            $trashresults = $stat -> fetchAll();

            $trash_count = count($trashresults);

          ?>

          <a href="trash_massage.php" class="nav-link <?php echo $page == 'trash_massage.php'? 'active':''; ?>">
            <i class="far fa-trash-alt"></i> Trash
            <span class="badge bg-danger float-right"><?php echo $trash_count == '0'? '' : $trash_count; ?></span>
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
          <a href="delivery_order.php" class="nav-link <?php echo $page == 'delivery_order.php'? 'active':''; ?>">
            <i class="far fa-circle text-danger"></i>
            Delivery Order
          </a>
        </li>
        <li class="nav-item">
          <a href="pickup_order.php" class="nav-link <?php echo $page == 'pickup_order.php'? 'active':''; ?>">
            <i class="far fa-circle text-warning"></i>
            Pickup Order
          </a>
        </li>
        <li class="nav-item">
          <a href="gift_order.php" class="nav-link <?php echo $page == 'gift_order.php'? 'active':''; ?>">
            <i class="far fa-circle text-primary"></i>
            Gift Wrap Order
          </a>
        </li>
      </ul>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>