<?php require APPROOT . '/views/inc/header.php';?>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Register an Infant</h2>
        <p>Please fill out this form to register an infant</p>
        <form action="<?php echo URLROOT; ?>/pages/addInfant" method="post">
          <div class="form-group">
            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="dateofbirth">Date of birth: <sup>*</sup></label>
            <input type="date" name="dateofbirth" placeholder="DD-MM-YYYY" class="form-control form-control-lg <?php echo (!empty($data['date_of_birth_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['dateofbirth']; ?>">
            <span class="invalid-feedback"><?php echo $data['date_of_birth_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="sel2">Sex: <sup>*</sup></label>

            <select name="sex" class="form-control" id="sel2">
                <option>Female</option>
                <option>Male</option>
            </select>
            <!-- <input type="sex" name="sex" class="form-control form-control-lg <?php echo (!empty($data['sex_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['sex']; ?>">
            <span class="invalid-feedback"><?php echo $data['sex_err']; ?></span> -->
          </div>

          <div class="form-group">
            <label for="sel3">Incubator: <sup>*</sup></label>

            <select name="incubator" class="form-control" id="sel3">
                <?php foreach ($data['inc'][1] as $incubator): ?>
                <option><?php echo $incubator['Number']; ?></option>
                <?php endforeach?>
            </select>
          </div>

          <div class="form-group">
            <label for="mother_name">Mother's name: <sup>*</sup></label>
            <input type="mother_name" name="mother_name" class="form-control form-control-lg <?php echo (!empty($data['mother_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['mother_name']; ?>">
            <span class="invalid-feedback"><?php echo $data['mother_name_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <input type="submit" value="Register" class="btn btn-success btn-block">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
 
<?php require APPROOT . '/views/inc/footer.php';?>