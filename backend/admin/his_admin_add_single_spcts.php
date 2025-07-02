<?php
session_start();
include('assets/inc/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add__Details'])) {
    $suspect_id   = $_POST['suspect_id'];
    $sd_ref       = $_POST['sd_ref'];
    $suspect_name = $_POST['suspect_name'];
    $suspect_gender = $_POST['suspect_gender'];
    $arresting_officer = $_POST['arresting_officer'];
    $arrest_date  = $_POST['arrest_date'];
    $current_date = date("Y-m-d");

    $query = "INSERT INTO his_suspects 
        (Cid, suspect_number, suspect_sd_ref, suspect_name, suspect_gender, suspect_arresting_officer, suspect_arrest_date, suspect_daterec) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'ssssssss',
        $suspect_id,
        $suspect_id,
        $sd_ref,
        $suspect_name,
        $suspect_gender,
        $arresting_officer,
        $arrest_date,
        $current_date
    );

    if ($stmt->execute()) {
        $_SESSION['success_suspect'] = true;
        header("Location: " . $_SERVER['PHP_SELF'] . "?sd_ref=" . urlencode($sd_ref));
        exit();
    } else {
        $err = "Error occurred. Please try again.";
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
        $ret    = "SELECT * FROM his_cases WHERE sd_ref=?";
        $stmt   = $mysqli->prepare($ret);
        $stmt->bind_param('s', $sd_ref);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_object()) {
        ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row"><div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Suspect Details</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Suspect Registration for : <?= htmlspecialchars($row->sd_ref) ?></h4>
                        </div>
                    </div></div>

                    <div class="row"><div class="col-12"><div class="card"><div class="card-body">
                        <?php if (isset($err)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name of Complainant</label>
                                    <input type="text" readonly value="<?= htmlspecialchars($row->compt_fname . ' ' . $row->compt_lname) ?>" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Details of Offence</label>
                                    <input type="text" readonly value="<?= htmlspecialchars($row->offence_details) ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>SD Reference</label>
                                    <input type="text" name="sd_ref" readonly value="<?= htmlspecialchars($row->sd_ref) ?>" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <?php 
                                $length = 5;
                                $vit_no = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                            ?>
                            <input type="hidden" name="suspect_id" value="<?= htmlspecialchars($vit_no) ?>">

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Name</label>
                                    <input type="text" required name="suspect_name" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Gender</label>
                                    <select required name="suspect_gender" class="form-control">
                                        <option selected disabled>Choose Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Arresting Officer</label>
                                    <input type="text" required name="arresting_officer" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Date of Arrest</label>
                                    <input type="date" required name="arrest_date" class="form-control">
                                </div>
                            </div>
                            <button type="submit" name="add__Details" class="ladda-button btn btn-success" data-style="expand-right">
                                Add Suspect Details
                            </button>
                        </form>
                    </div></div></div></div>
                </div>
            </div>
        <?php } ?>

        <?php include('assets/inc/footer.php'); ?>
    </div>
    <div class="rightbar-overlay"></div>

    <!-- Core Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- Native JS Alert -->
    <script>
    <?php if (isset($_SESSION['success_suspect'])): ?>
        alert('Suspect Details Added Successfully');
        <?php unset($_SESSION['success_suspect']); ?>
    <?php endif; ?>
    </script>
</body>
</html>
