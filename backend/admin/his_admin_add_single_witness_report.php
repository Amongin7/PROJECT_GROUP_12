<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_witness_report'])) {
    $wit_compt_name       = $_POST['wit_compt_name'];
    $wit_offence_details  = $_POST['wit_offence_details'];
    $wit_sd_ref           = $_POST['wit_sd_ref'];
    $wit_witness          = $_POST['wit_witness'];
    $wit_witness_reports  = $_POST['wit_witness_reports'];
    $id                   = $_GET['id'];

    $query = "UPDATE his_witness 
              SET wit_compt_name      = ?, 
                  wit_offence_details = ?, 
                  wit_sd_ref          = ?, 
                  wit_witness         = ?, 
                  wit_witness_reports = ? 
              WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssssi', 
        $wit_compt_name, 
        $wit_offence_details, 
        $wit_sd_ref, 
        $wit_witness, 
        $wit_witness_reports, 
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['wit_report_success'] = true;
        header("Location: his_admin_add_single_witness_report.php?id=$id");
        exit();
    } else {
        $err = "Failed to update. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Suspects</a></li>
                                        <li class="breadcrumb-item active">Add Witness Report</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Witness Report</h4>
                            </div>
                        </div>
                    </div>

                    <?php
                    $id = $_GET['id'];
                    $ret = "SELECT * FROM his_witness WHERE id=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Complainant's Name</label>
                                                    <input type="text" readonly name="wit_compt_name" value="<?php echo htmlspecialchars($row->wit_compt_name); ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Details of Offence</label>
                                                    <input type="text" readonly name="wit_offence_details" value="<?php echo htmlspecialchars($row->wit_offence_details); ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>SD Reference</label>
                                                <input type="text" readonly name="wit_sd_ref" value="<?php echo htmlspecialchars($row->wit_sd_ref); ?>" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Witness Reports</label>
                                                <textarea name="wit_witness" class="form-control" id="editor"><?php echo htmlspecialchars($row->wit_witness); ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Further Comments</label>
                                                <textarea name="wit_witness_reports" class="form-control" id="editor1"><?php echo htmlspecialchars($row->wit_witness_reports); ?></textarea>
                                            </div>

                                            <button type="submit" name="add_witness_report" class="ladda-button btn btn-success" data-style="expand-right">Add Witness Reports</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <!-- CKEditor -->
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
        CKEDITOR.replace('editor1');
    </script>

    <!-- App Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- Native JS Alert -->
    <script>
    <?php if (isset($_SESSION['wit_report_success'])): ?>
        alert('Witness Report added successfully!');
        <?php unset($_SESSION['wit_report_success']); ?>
    <?php endif; ?>
    </script>
</body>
</html>
