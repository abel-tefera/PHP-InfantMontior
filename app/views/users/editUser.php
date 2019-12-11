<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/pages/viewUsers" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
  <h2>Edit User</h2>
    <p>Enter data with this form</p>
    <form action="<?php echo URLROOT; ?>/updates/editUser/<?php echo $data['id']; ?>" method="post">
    <div class="form-group">
            <label>Name:<sup>*</label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
        </div> 
        <div class="form-group">
            <label>Username:<sup>*</sup></label>
            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
            <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
        </div> 
        <div class="form-group">
            <label for="sel1">Role:<sup>*</sup></label>
            <select name="role" class="form-control" id="sel1">
                <option <?php echo ($data['role'] == "Doctor") ? 'selected' : ''; ?>>Doctor</option>
                <option <?php echo ($data['role'] == "Nurse") ? 'selected' : ''; ?>>Nurse</option>
                <option <?php echo ($data['role'] == "Admin") ? 'selected' : ''; ?>>Admin</option>
            </select>
            <!-- <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>"> -->
            <!-- <span class="invalid-feedback"><?php echo $data['role_err']; ?></span> -->
        </div>    
        <div class="form-row">
          <div class="col">
            <input type="submit" class="btn btn-success btn-block" value="Register">
          </div>
        </div>
        </form>
<?php require APPROOT . '/views/inc/footer.php';?>