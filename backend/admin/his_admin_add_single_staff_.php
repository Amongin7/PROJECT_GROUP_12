<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_emp_Details'])) {
    $suspect_id         = $_POST['suspect_id'];
    $sd_ref             = $_POST['sd_ref'];
    $suspect_name       = $_POST['suspect_name'];
    $suspect_gender     = $_POST['suspect_gender'];
    $arresting_officer  = $_POST['arresting_officer'];
    $arrest_date        = $_POST['arrest_date'];

    $query = "INSERT INTO his_suspects 
              (suspect_id, sd_ref, suspect_name, suspect_gender, arresting_officer, arrest_date) 
              VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'ssssss', 
        $suspect_id, $sd_ref, $suspect_name, 
        $suspect_gender, $arresting_officer, $arrest_date
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['suspect_added'] = true;
    } else {
        $_SESSION['add_error'] = true;
    }
    $stmt->close();

    header("Location: his_admin_add_suspect.php?staff_number=" . urlencode($sd_ref));
    exit();
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
        $staff_number = $_GET['staff_number'];
        $ret = "SELECT * FROM his_staff WHERE staff_number=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('s', $staff_number);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_object();
        $stmt->close();
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
                                        <li class="breadcrumb-item"><a href="#">Suspects</a></li>
                                        <li class="breadcrumb-item active">Add Details</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    Capture <?= htmlspecialchars($row->staff_fname . ' ' . $row->staff_lname) ?> Details
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill all fields</h4>
                                    <form method="post">
                                        <!-- Read‐only staff info -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Staff Name</label>
                                                <input type="text" class="form-control" readonly 
                                                       value="<?= htmlspecialchars($row->staff_fname . ' ' . $row->staff_lname) ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Staff Directorate</label>
                                                <input type="text" class="form-control" readonly 
                                                       value="<?= htmlspecialchars($row->staff_dept) ?>">
                                            </div>
                                        </div>

                                        <!-- SD Reference -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Force Number / Rank</label>
                                                <input type="text" name="sd_ref" class="form-control" readonly 
                                                       value="<?= htmlspecialchars($row->staff_number) ?>">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Hidden suspect ID -->
                                        <input type="hidden" name="suspect_id" 
                                               value="<?= substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) ?>">

                                        <!-- Suspect details -->
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Suspect Name</label>
                                                <input type="text" name="suspect_name" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Gender</label>
                                                <input type="text" name="suspect_gender" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Arresting Officer</label>
                                                <input type="text" name="arresting_officer" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Date of Arrest</label>
                                                <input type="text" name="arrest_date" class="form-control" required>
                                            </div>
                                        </div>

                                        <button type="submit" name="add_emp_Details" 
                                                class="ladda-button btn btn-success" data-style="expand-right">
                                            Add Details
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                </div> <!-- end container-fluid -->
            </div> <!-- end content -->

            <?php include('assets/inc/footer.php'); ?>
        </div> <!-- end content-page -->

    </div> <!-- end wrapper -->

    <div class="rightbar-overlay"></div>

    <!-- Core JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <script>
        // Confirm before adding
        document.querySelector('button[name="add_emp_Details"]').addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to add these suspect details?')) {
                e.preventDefault();
            }
        });

        // Alert on success or error
        <?php if (isset($_SESSION['suspect_added'])): ?>
        window.addEventListener('load', function() {
            alert('Suspect details added successfully!');
        });
        <?php unset($_SESSION['suspect_added']); endif; ?>

        <?php if (isset($_SESSION['add_error'])): ?>
        window.addEventListener('load', function() {
            alert('Failed to add suspect details. Please try again.');
        });
        <?php unset($_SESSION['add_error']); endif; ?>
    </script>
</body>
</html>
