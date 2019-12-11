<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('info');?>

  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-3"><?php echo $data['title']; ?></h1>
      <p class="lead"><?php echo $data['description']; ?></p>
    </div>
  </div>
  <ul class="navbar-nav ml-auto">
<?php require APPROOT . '/views/inc/footer.php'; ?>

