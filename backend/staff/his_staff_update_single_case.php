<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_Complainant'])) {
    $compt_fname      = $_POST['compt_fname'];
    $compt_lname      = $_POST['compt_lname'];
    $sd_ref           = $_GET['sd_ref'];
    $compt_phone      = $_POST['compt_phone'];
    $compt_type       = $_POST['compt_type'];
    $compt_addr       = $_POST['compt_addr'];
    $victim           = $_POST['victim'];
    $date_occur       = $_POST['date_occur'];
    $offence_details  = $_POST['offence_details'];

    $query = "UPDATE his_cases 
              SET compt_fname=?, compt_lname=?, victim=?, date_occur=?, 
                  compt_phone=?, compt_type=?, compt_addr=?, offence_details=? 
              WHERE sd_ref=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssssssss',
        $compt_fname,
        $compt_lname,
        $victim,
        $date_occur,
        $compt_phone,
        $compt_type,
        $compt_addr,
        $offence_details,
        $sd_ref
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success = "Complainant Details Updated";
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Cases</a></li>
                                    <li class="breadcrumb-item active">Manage Cases</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Update Case Details</h4>
                        </div>
                    </div>
                </div>

                <?php
                $sd_ref = $_GET['sd_ref'] ?? '';
                $ret    = "SELECT * FROM his_cases WHERE sd_ref=?";
                $stmt   = $mysqli->prepare($ret);
                $stmt->bind_param('s', $sd_ref);
                $stmt->execute();
                $res    = $stmt->get_result();
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
                                            <label>Complainant's First Name</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->compt_fname) ?>"
                                                   name="compt_fname" class="form-control"
                                                   placeholder="Complainant's First Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Complainant's Last Name</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->compt_lname) ?>"
                                                   name="compt_lname" class="form-control"
                                                   placeholder="Complainant's Last Name">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Date of Occurrence</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->date_occur) ?>"
                                                   name="date_occur" class="form-control"
                                                   placeholder="DD/MM/YYYY">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Victim(s)</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->victim) ?>"
                                                   name="victim" class="form-control"
                                                   placeholder="Victim(s)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Complainant's Address</label>
                                        <input type="text" required value="<?= htmlspecialchars($row->compt_addr) ?>"
                                               name="compt_addr" class="form-control"
                                               placeholder="Complainant's Address">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Complainant's Contact</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->compt_phone) ?>"
                                                   name="compt_phone" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Details of Offence</label>
                                            <input type="text" required value="<?= htmlspecialchars($row->offence_details) ?>"
                                                   name="offence_details" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Nature of Offence</label>
                                            <select name="compt_type" required class="form-control">
                                                <option value="">Choose</option>
                                                <option <?= $row->compt_type==='Criminal'?'selected':'' ?>>Criminal</option>
                                                <option <?= $row->compt_type==='Disciplinary'?'selected':'' ?>>Disciplinary</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" name="update_Complainant"
                                            class="ladda-button btn btn-success"
                                            data-style="expand-right">
                                        Update Case
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

            </div> <!-- container -->
        </div> <!-- content -->
        <?php include('assets/inc/footer.php'); ?>
    </div> <!-- content-page -->
</div> <!-- wrapper -->

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- App js-->
<script src="assets/js/app.min.js"></script>
<!-- Loading buttons js -->
<script src="assets/libs/ladda/spin.js"></script>
<script src="assets/libs/ladda/ladda.js"></script>
<!-- Buttons init js-->
<script src="assets/js/pages/loading-btn.init.js"></script>

<!-- Native JS Alert for feedback -->
<script>
<?php if (isset($success)): ?>
    alert('<?= addslashes($success) ?>');
<?php endif; ?>
<?php if (isset($err)): ?>
    alert('<?= addslashes($err) ?>');
<?php endif; ?>
</script>
</body>
</html>
