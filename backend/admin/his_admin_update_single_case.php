<?php
// Server-Side Update Logic (no SweetAlert2)
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_POST['update_'])) {
    $compt_id       = intval($_GET['compt_id']);
    $compt_fname    = $_POST['compt_fname'];
    $compt_lname    = $_POST['compt_lname'];
    $sd_ref         = $_POST['sd_ref'];
    $compt_phone    = $_POST['compt_phone'];
    $compt_type     = $_POST['compt_type'];
    $compt_addr     = $_POST['compt_addr'];
    $victim         = $_POST['victim'];
    $date_occur     = $_POST['date_occur'];
    $offence_details= $_POST['offence_details'];

    $query = "UPDATE his_cases 
              SET compt_fname=?, compt_lname=?, victim=?, date_occur=?, sd_ref=?, 
                  compt_phone=?, compt_type=?, compt_addr=?, offence_details=?
              WHERE compt_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssssssssi',
        $compt_fname, $compt_lname, $victim, $date_occur,
        $sd_ref, $compt_phone, $compt_type, $compt_addr,
        $offence_details, $compt_id
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // flag for native JS alert
        $_SESSION['_updated'] = true;
    }
    $stmt->close();

    // redirect back to avoid form resubmission
    header("Location: his_admin_update_single_case.php?compt_id={$compt_id}");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

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
                                        <li class="breadcrumb-item"><a href="#">Cases Registered</a></li>
                                        <li class="breadcrumb-item active">Update Case</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Update Case Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php
                    // Fetch existing case data
                    $compt_id = intval($_GET['compt_id']);
                    $ret = "SELECT * FROM his_cases WHERE compt_id=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $compt_id);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_object();
                    $stmt->close();
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill All Fields</h4>
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Complainant's First Name</label>
                                                <input type="text" name="compt_fname" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->compt_fname) ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Complainant's Last Name</label>
                                                <input type="text" name="compt_lname" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->compt_lname) ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Date Of Occurrence</label>
                                                <input type="text" name="date_occur" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->date_occur) ?>"
                                                       placeholder="DD/MM/YYYY">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Victim(s)</label>
                                                <input type="text" name="victim" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->victim) ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Offence</label>
                                            <input type="text" name="compt_addr" class="form-control" 
                                                   required value="<?= htmlspecialchars($row->compt_addr) ?>">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Complainant's Number</label>
                                                <input type="text" name="compt_phone" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->compt_phone) ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Details of the Offence</label>
                                                <input type="text" name="offence_details" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->offence_details) ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Category</label>
                                                <select name="compt_type" class="form-control" required>
                                                    <?php foreach (['Choose','Criminal','Civil'] as $opt): ?>
                                                        <option <?= $row->compt_type === $opt ? 'selected' : '' ?>>
                                                            <?= $opt ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>SD Reference</label>
                                                <input type="text" name="sd_ref" class="form-control" 
                                                       required value="<?= htmlspecialchars($row->sd_ref) ?>">
                                            </div>
                                        </div>

                                        <button type="submit" name="update_" 
                                                class="ladda-button btn btn-success" data-style="expand-right">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end form row -->
                </div> <!-- end container-fluid -->
            </div> <!-- end content -->

            <?php include('assets/inc/footer.php'); ?>
        </div> <!-- end content-page -->
    </div> <!-- end wrapper -->

    <!-- JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <script>
        // Confirm before submitting update
        document.querySelector('button[name="update_"]').addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to update this case?')) {
                e.preventDefault();
            }
        });

        // Show native alert on successful update
        <?php if (isset($_SESSION['_updated'])): ?>
            window.addEventListener('load', function() {
                alert('Case details updated successfully');
            });
            <?php unset($_SESSION['_updated']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
