<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add__xbt'])) {
    $xbt_compt_name      = $_POST['xbt_compt_name'];
    $xbt_sd_ref          = $_POST['xbt_sd_ref'];
    $xbt_compt_type      = $_POST['xbt_compt_type'];
    $xbt_compt_addr      = $_POST['xbt_compt_addr'];
    $xbt_victim          = $_POST['xbt_victim'];
    $xbt_number          = $_POST['xbt_number'];
    $xbt_offence_details = $_POST['xbt_offence_details'];
    $xbt_desc            = $_POST['xbt_desc'];

    $query = "INSERT INTO his_exhibit 
              (xbt_compt_name, xbt_sd_ref, xbt_compt_type, xbt_compt_addr, xbt_victim, xbt_number, xbt_offence_details, xbt_desc)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'ssssssss',
        $xbt_compt_name,
        $xbt_sd_ref,
        $xbt_compt_type,
        $xbt_compt_addr,
        $xbt_victim,
        $xbt_number,
        $xbt_offence_details,
        $xbt_desc
    );
    if ($stmt->execute()) {
        $success = "Exhibits Added Successfully";
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
    $ret    = "SELECT * FROM his_cases WHERE sd_ref=?";
    $stmt   = $mysqli->prepare($ret);
    $stmt->bind_param('s', $sd_ref);
    $stmt->execute();
    $res    = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <!-- Page Title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="his_staff_dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Exhibits</li>
                  </ol>
                </div>
                <h4 class="page-title">Add Case Exhibits</h4>
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
                        <input type="text" readonly name="xbt_compt_name"
                               value="<?= htmlspecialchars($row->compt_fname . ' ' . $row->compt_lname) ?>"
                               class="form-control" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Victim(s)</label>
                        <input type="text" readonly name="xbt_victim"
                               value="<?= htmlspecialchars($row->victim) ?>"
                               class="form-control" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>SD Reference</label>
                        <input type="text" readonly name="xbt_sd_ref"
                               value="<?= htmlspecialchars($row->sd_ref) ?>"
                               class="form-control" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Complainant's Address</label>
                        <input type="text" readonly name="xbt_compt_addr"
                               value="<?= htmlspecialchars($row->compt_addr) ?>"
                               class="form-control" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Case Type</label>
                        <input type="text" readonly name="xbt_compt_type"
                               value="<?= htmlspecialchars($row->compt_type) ?>"
                               class="form-control" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Details of Offence</label>
                      <input type="text" name="xbt_offence_details"
                             value="<?= htmlspecialchars($row->offence_details) ?>"
                             class="form-control" required>
                    </div>
                    <div class="form-row" style="display:none;">
                      <?php $pres_no = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5); ?>
                      <div class="form-group col-md-2">
                        <label>Exhibit Number</label>
                        <input type="text" name="xbt_number"
                               value="<?= htmlspecialchars($pres_no) ?>"
                               class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Exhibits</label>
                      <textarea name="xbt_desc" class="form-control" id="editor" required></textarea>
                    </div>
                    <button type="submit" name="add__xbt" class="btn btn-primary">
                      Add Exhibit
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
