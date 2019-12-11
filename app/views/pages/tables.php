<?php require APPROOT . '/views/inc/header.php';?>
<!-- <h1 class="display-3"><?php echo $data['title']; ?></h1> -->
<h1 class="display-3"><?php echo $data['header']; ?></h1>
<?php $arr = array();
$countA = 0;
$countB = 0;?>
<?php flash('info');?>
<table class="table">
  <thead>
    <tr>
    <?php foreach ($data['fields'] as $field): ?>
        <th scope="col">
        <?php if ($field != 'password' && $field != 'id' && $field != 'image_directory') {
    if ($field != 'Duration') {
        echo $field;
    } else {
        echo $field . ' (days)';
    }
    // echo $countA;
    array_push($arr, $countA);
    $countA += 1;
} else {
    $countA += 1;
    continue;
}
?>
        </th>
    <?php endforeach?>
    <th scope="col">OPERATIONS</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['rows'] as $row): ?>
        <tr>
        <?php foreach ($row as $singleRow): ?>
            <!-- <th scope="row">1</th> -->
            <td>
                <?php if (in_array($countB, $arr)):
    echo $singleRow;
    $countB += 1;
    ?>
				                <?php else:$countB += 1;
    continue;?>
				                <?php endif;?>
            </td>
        <?php endforeach?>
        <?php $countB = 0;?>
        <td>
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                        <?php if ($_SESSION['user_role'] == "Doctor"): ?>
                          <form action="<?php echo URLROOT; ?>/pages/chart/<?php echo $row['id']; ?>" method="get">
                              <button type="submit" class="btn btn-primary">Status</button>
                          </form>
                          <span><pre> </pre></span>
                <?php else: ?>
                        <form action="<?php echo URLROOT; ?>/updates/edit<?php echo rtrim($data["header"], 's'); ?>/<?php echo $row['id']; ?>" method="get">
                            <button type="submit" class="btn btn-secondary">Edit</button>
                        </form>
                        <span><pre> </pre></span>
                        <!-- <form action="<?php echo URLROOT; ?>/updates/delete<?php echo rtrim($data["header"], 's'); ?>/<?php echo $row['id']; ?>" method="post"> -->
                        <form action="<?php echo URLROOT; ?>/updates/delete/<?php echo ($_SESSION['user_role'] != 'Nurse') ? $row['id'] : $row['id'] . '/' . rtrim($data["header"], 's'); ?>" method="post">
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                <?php endif;?>

                          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button> -->
                        </div>
                    </div>
        </td>
        </tr>
    <?php endforeach?>
  </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php';?>
