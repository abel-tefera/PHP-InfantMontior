<?php require APPROOT . '/views/inc/header.php';?>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Add an Incubator</h2>
        <p>Please fill out this form to add an incubator</p>
        <form action="<?php echo URLROOT; ?>/pages/addIncubator" method="post">
          <div class="form-group">
            <label for="num">Incubator number: <sup>*</sup></label>
            <input type="text" name="num" class="form-control form-control-lg <?php echo (!empty($data['num_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['num']; ?>">
            <span class="invalid-feedback"><?php echo $data['num_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <input type="submit" value="Add" class="btn btn-success btn-block">
            </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>