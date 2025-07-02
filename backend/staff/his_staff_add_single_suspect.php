<?php
session_start();
include('assets/inc/config.php');

// 1) Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add__Details'])) {
    $suspect_number    = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
    $Cid               = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
    $suspect_sd_ref    = $_POST['suspect_sd_ref'] ?? '';
    $suspect_name      = $_POST['suspect_name'];
    $suspect_gender    = $_POST['suspect_gender'];
    $officer           = $_POST['arresting_officer'];
    $arrest_date       = $_POST['arrest_date'];
    $date_rec          = date('Y-m-d');

    $insert = $mysqli->prepare("
      INSERT INTO his_suspects
        (suspect_number, suspect_sd_ref, suspect_name, suspect_gender,
         Cid, suspect_arresting_officer, suspect_arrest_date, suspect_daterec)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insert->bind_param(
        'ssssssss',
        $suspect_number,
        $suspect_sd_ref,
        $suspect_name,
        $suspect_gender,
        $Cid,
        $officer,
        $arrest_date,
        $date_rec
    );
    if ($insert->execute()) {
        $_SESSION['success'] = "Suspect details added successfully";
    } else {
        $_SESSION['err'] = "Please try again or try later";
    }
    $insert->close();
}

// 2) Determine the current case reference
//    Accept either ?sd_ref= or ?staff_number=
if (!empty($_GET['sd_ref'])) {
    $sd_ref = $_GET['sd_ref'];
} elseif (!empty($_GET['staff_number'])) {
    $sd_ref = $_GET['staff_number'];
}
// persist to session so if you POST back, you still know it
if (!empty($sd_ref)) {
    $_SESSION['current_sd_ref'] = $sd_ref;
} else {
    $sd_ref = $_SESSION['current_sd_ref'] ?? null;
}

// 3) Fetch the case (if we have an sd_ref)
$case         = null;
$case_missing = false;
if ($sd_ref) {
    $c = $mysqli->prepare("SELECT * FROM his_cases WHERE sd_ref = ?");
    $c->bind_param('s', $sd_ref);
    $c->execute();
    $case = $c->get_result()->fetch_object();
    $c->close();
    if (!$case) {
        $case_missing = true;
    }
} else {
    $case_missing = true;
}

// 4) If we found the case, fetch its suspects
$suspects = null;
if (!$case_missing) {
    $s = $mysqli->prepare("SELECT * FROM his_suspects WHERE suspect_sd_ref = ?");
    $s->bind_param('s', $sd_ref);
    $s->execute();
    $suspects = $s->get_result();
    $s->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
<script>
window.addEventListener('load', function() {
  <?php if (!empty($_SESSION['success'])): ?>
    alert('<?= addslashes($_SESSION['success']) ?>');
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['err'])): ?>
    alert('<?= addslashes($_SESSION['err']) ?>');
    <?php unset($_SESSION['err']); ?>
  <?php endif; ?>
});
</script>

<div id="wrapper">
  <?php include("assets/inc/nav.php"); ?>
  <?php include("assets/inc/sidebar.php"); ?>

  <div class="content-page">
    <div class="content container-fluid">

      <?php if ($case_missing): ?>
        <div class="alert alert-warning">Case reference missing or not found.</div>
      <?php else: ?>

        <div class="page-title-box">
          <h4 class="page-title">Case: <?= htmlspecialchars($case->sd_ref) ?></h4>
          <p>
            <?= htmlspecialchars($case->compt_fname . ' ' . $case->compt_lname) ?>
            — <?= htmlspecialchars($case->offence_details) ?>
          </p>
        </div>

        <!-- Add Suspect Form -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="header-title">Add Suspect</h4>
                <form method="post">
                  <input type="hidden" name="suspect_sd_ref" value="<?= htmlspecialchars($sd_ref) ?>">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Suspect Name</label>
                      <input type="text" name="suspect_name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Gender</label>
                      <select name="suspect_gender" class="form-control" required>
                        <option value="" disabled selected>Choose</option>
                        <option>Male</option>
                        <option>Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Arresting Officer</label>
                      <input type="text" name="arresting_officer" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Date of Arrest</label>
                      <input type="date" name="arrest_date" class="form-control" required>
                    </div>
                  </div>
                  <button type="submit" name="add__Details" class="btn btn-success">
                    Add Suspect
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Suspects List -->
        <div class="row">
          <div class="col-12">
            <div class="card-box">
              <h4 class="header-title">Suspects</h4>
              <div class="table-responsive">
                <table class="table table-bordered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Number</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Officer</th>
                      <th>Date Arrest</th>
                      <th>Recorded</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $cnt = 1; while ($s = $suspects->fetch_object()): ?>
                    <tr>
                      <td><?= $cnt++ ?></td>
                      <td><?= htmlspecialchars($s->suspect_number) ?></td>
                      <td><?= htmlspecialchars($s->suspect_name) ?></td>
                      <td><?= htmlspecialchars($s->suspect_gender) ?></td>
                      <td><?= htmlspecialchars($s->suspect_arresting_officer) ?></td>
                      <td><?= htmlspecialchars($s->suspect_arrest_date) ?></td>
                      <td><?= htmlspecialchars($s->suspect_daterec) ?></td>
                    </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>

      <?php include('assets/inc/footer.php'); ?>
    </div>
  </div>
</div>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
</body>
</html>
