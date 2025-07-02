<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_animal_witness'])) {
    $wit_compt_name       = $_POST['wit_compt_name'];
    $wit_offence_details  = $_POST['wit_offence_details'];
    $wit_sd_ref           = $_POST['wit_sd_ref'];
    $wit_witness_reports  = $_POST['wit_witness_reports'];
    $wit_witness          = $_POST['wit_witness'];

    $query = "INSERT INTO his_witness 
              (wit_compt_name, wit_offence_details, wit_sd_ref, wit_witness_reports, wit_witness) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssss',
        $wit_compt_name,
        $wit_offence_details,
        $wit_sd_ref,
        $wit_witness_reports,
        $wit_witness
    );

    if ($stmt->execute()) {
        $_SESSION['witness_added'] = true;
        header("Location: " . $_SERVER['PHP_SELF'] . "?sd_ref=" . urlencode($wit_sd_ref));
        exit();
    } else {
        $err = "Please Try Again Or Try Later";
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

    <?php
    $sd_ref = $_GET['sd_ref'] ?? '';
    $ret = "SELECT * FROM his_cases WHERE sd_ref=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $sd_ref);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_object()) {
    ?>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="page-title-box">
                    <h4 class="page-title">Add Relevant Witnesses</h4>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Name of Complainant</label>
                                            <input type="text" name="wit_compt_name"
                                                   value="<?php echo htmlspecialchars($row->compt_fname . ' ' . $row->compt_lname); ?>"
                                                   class="form-control" readonly required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Details of Offence</label>
                                            <input type="text" name="wit_offence_details"
                                                   value="<?php echo htmlspecialchars($row->offence_details); ?>"
                                                   class="form-control" readonly required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>SD Reference</label>
                                        <input type="text" name="wit_sd_ref"
                                               value="<?php echo htmlspecialchars($row->sd_ref); ?>"
                                               class="form-control" readonly required>
                                    </div>

                                    <div class="form-row" style="display: none;">
                                        <div class="form-group col-md-2">
                                            <?php $pres_no = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 5); ?>
                                            <label>CRB</label>
                                            <input type="text" name="wit_witness"
                                                   value="<?php echo htmlspecialchars($pres_no); ?>"
                                                   class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Witness Details</label>
                                        <textarea name="wit_witness_reports" class="form-control" id="editor" required></textarea>
                                    </div>

                                    <button type="submit" name="add_animal_witness" class="btn btn-success">
                                        Add Witness
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php } ?>
        <?php include('assets/inc/footer.php'); ?>
    </div>
</div>

<!-- CKEditor -->
<script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
<script>CKEDITOR.replace('editor');</script>

<!-- Core JS -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/libs/ladda/spin.js"></script>
<script src="assets/libs/ladda/ladda.js"></script>
<script src="assets/js/pages/loading-btn.init.js"></script>

<!-- Native JS Alert -->
<script>
<?php if (isset($_SESSION['witness_added'])): ?>
    alert('Witness added successfully!');
    <?php unset($_SESSION['witness_added']); ?>
<?php endif; ?>
</script>

</body>
</html>
