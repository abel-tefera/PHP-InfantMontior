<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/pages/viewInfants" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
  <h2>Edit Infant</h2>
    <p>Enter data with this form</p>
    <form action="<?php echo URLROOT; ?>/updates/editInfant/<?php echo $data['id']; ?>" method="post">
          <div class="form-group">
            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="dateofbirth">Date of birth: <sup>*</sup></label>
            <input readonly type="date" name="dateofbirth" class="form-control form-control-lg <?php echo (!empty($data['date_of_birth_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['dateofbirth']; ?>">
            <!-- <span class="invalid-feedback"><?php echo $data['date_of_birth_err']; ?></span> -->
          </div>

          <div class="form-group">
            <label for="sel2">Sex: <sup>*</sup></label>
            <input readonly type="text" name="sex" class="form-control form-control-lg <?php echo (!empty($data['date_of_birth_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['sex']; ?>">
          </div>
          <div class="form-group">
            <label for="sel3">Incubator: <sup>*</sup></label>

            <select name="incubator" class="form-control" id="sel3">
                <?php foreach ($data['inc'][1] as $incubator): ?>
                <option <?php echo ($data['incu'] == $incubator['Number']) ? 'selected' : ''; ?>> <?php echo $incubator['Number'];?></option>
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
<?php require APPROOT . '/views/inc/footer.php';?>