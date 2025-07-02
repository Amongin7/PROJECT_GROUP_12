<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_witness'])) {
    $wit_compt_name      = $_POST['wit_compt_name'];
    $wit_offence_details = $_POST['wit_offence_details'];
    $wit_sd_ref          = $_POST['wit_sd_ref'];
    $wit_witness         = $_POST['wit_witness'];
    $id                  = $_POST['id'];

    $query = "INSERT INTO his_witness 
              (wit_compt_name, wit_offence_details, wit_sd_ref, wit_witness, id) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssss',
        $wit_compt_name,
        $wit_offence_details,
        $wit_sd_ref,
        $wit_witness,
        $id
    );
    if ($stmt->execute()) {
        $success = "Witness Added Successfully";
    } else {
        $err = "Please Try Again Or Try Later";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
  <script>
    window.addEventListener('load', function() {
      <?php if (isset($success)): ?>
        alert('<?= addslashes($success) ?>');
        <?php unset($success); ?>
      <?php endif; ?>
      <?php if (isset($err)): ?>
        alert('<?= addslashes($err) ?>');
        <?php unset($err); ?>
      <?php endif; ?>
    });
  </script>

  <div id="wrapper">
    <?php include("assets/inc/nav.php"); ?>
    <?php include("assets/inc/sidebar.php"); ?>

    <?php
    $sd_ref = $_GET['sd_ref'] ?? '';
    $ret    = "SELECT * FROM his_cases WHERE sd_ref = ?";
    $stmt   = $mysqli->prepare($ret);
    $stmt->bind_param('s', $sd_ref);
    $stmt->execute();
    $res    = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <!-- Page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Witness</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Form -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <form method="post">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Complainant's Name</label>
                        <input type="text" name="wit_compt_name" readonly
                          value="<?= htmlspecialchars($row->compt_fname . ' ' . $row->compt_lname) ?>"
                          class="form-control" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Details of Offence</label>
                        <input type="text" name="wit_offence_details" readonly
                          value="<?= htmlspecialchars($row->offence_details) ?>"
                          class="form-control" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>SD Reference</label>
                      <input type="text" name="wit_sd_ref" readonly
                        value="<?= htmlspecialchars($row->sd_ref) ?>"
                        class="form-control" required>
                    </div>
                    <div class="form-row" style="display:none;">
                      <div class="form-group col-md-2">
                        <?php $pres_no = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5); ?>
                        <label>Witness ID</label>
                        <input type="text" name="id" value="<?= htmlspecialchars($pres_no) ?>" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Witness</label>
                      <textarea name="wit_witness" id="editor" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="add_witness" class="btn btn-success">
                      Add Witness
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } // end while ?>
    <?php include('assets/inc/footer.php'); ?>
  </div> <!-- end wrapper -->

  <!-- CKEditor -->
  <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
  <script>CKEDITOR.replace('editor');</script>

  <!-- Vendor JS -->
  <script src="assets/js/vendor.min.js"></script>
  <!-- App JS -->
  <script src="assets/js/app.min.js"></script>
  <!-- Ladda JS -->
  <script src="assets/libs/ladda/spin.js"></script>
  <script src="assets/libs/ladda/ladda.js"></script>
  <script src="assets/js/pages/loading-btn.init.js"></script>
</body>
</html>
