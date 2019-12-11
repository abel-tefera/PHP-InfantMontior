<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
<?php if (isset($_SESSION['user_id'])): ?>
      <?php if ($_SESSION['user_role'] == 'Admin'): ?>
      <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/viewUsers">View</a>
      </li>
      <!-- <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
      </li> -->
      <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Register</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/registerInfant">Infant</a>
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/registerIncubator">Incubator</a>
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/register/Doctor">Doctor</a>
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/register/Nurse">Nurse</a>
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/register/Admin">Admin</a>
            </div>
          </li> -->
      <?php elseif ($_SESSION['user_role'] == 'Nurse'): ?>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Add</a>
      <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/pages/addInfant">Infant</a>
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/pages/addIncubator">Incubator</a>
      </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">View</a>
      <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/pages/viewInfants">Infants</a>
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/pages/viewIncubators">Incubator</a>
      </div>
      </li>
      <!-- <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
      </li> -->
      <?php elseif ($_SESSION['user_role'] == 'Doctor'): ?>
      <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/pages/viewInfants">View Infants</a>
        </li>
<?php endif;?>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Hi, <?php echo $_SESSION['user_name']; ?></a>
      <div class="dropdown-menu">
       <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
      </div>
      </li>
<?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
        </li>
      <?php endif;?>
      </ul>
    </div>
  </div>
</nav>