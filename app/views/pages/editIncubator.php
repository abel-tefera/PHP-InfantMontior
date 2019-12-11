<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/pages/viewIncubators" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
  <h2>Edit Incubator</h2>
    <p>Enter data with this form</p>
    <form action="<?php echo URLROOT; ?>/updates/editIncubator/<?php echo $data['id']; ?>" method="post">
          <div class="form-group">
            <label for="num">Incubator number: <sup>*</sup></label>
            <input type="text" name="num" class="form-control form-control-lg <?php echo (!empty($data['num_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['num']; ?>">
            <span class="invalid-feedback"><?php echo $data['num_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <input type="submit" value="Edit" class="btn btn-success btn-block">
            </div>
          </div>
          </div>
        </form>
        <?php require APPROOT . '/views/inc/footer.php';?>