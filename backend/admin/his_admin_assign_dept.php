<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// ─── Handle Department Assignment ────────────────────────────────────────────
if (isset($_POST['assaign_dept'])) {
    // Safely pull from GET
    $staff_number = $_GET['staff_number'] ?? '';
    $staff_dept   = $_POST['staff_dept'];

    $sql  = "UPDATE his_staff SET staff_dept = ? WHERE staff_number = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $staff_dept, $staff_number);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['dept_assigned'] = true;
    }
    $stmt->close();

    // Redirect so we can show the alert on fresh load
    header("Location: his_admin_assign_dept.php?staff_number=" . urlencode($staff_number));
    exit();
}

// ─── Guard against missing staff_number ─────────────────────────────────────
$staff_number = $_GET['staff_number'] ?? '';
if ($staff_number === '') {
    // nothing to assign → back to staff list
    header('Location: his_admin_manage_staff.php');
    exit();
}

// ─── Fetch staff record ─────────────────────────────────────────────────────
$stmt = $mysqli->prepare("SELECT * FROM his_staff WHERE staff_number = ?");
$stmt->bind_param('s', $staff_number);
$stmt->execute();
$row = $stmt->get_result()->fetch_object();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <!-- Success alert on load -->
    <?php if (isset($_SESSION['dept_assigned'])): ?>
        <script>
          alert('Department assigned successfully!');
        </script>
        <?php unset($_SESSION['dept_assigned']); ?>
    <?php endif; ?>

    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content container-fluid">

                <!-- Page Title -->
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Staff</a></li>
                            <li class="breadcrumb-item active">Assign Department</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Assign Department</h4>
                </div>

                <!-- Optional Error Alert -->
                <?php if (isset($err)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>

                <!-- Assignment Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Fill all fields</h4>
                                <form method="post"
                                      onsubmit="return confirm('Are you sure you want to assign this department?');">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" readonly
                                                   value="<?= htmlspecialchars($row->staff_fname) ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" readonly
                                                   value="<?= htmlspecialchars($row->staff_lname) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" readonly
                                               value="<?= htmlspecialchars($row->staff_email) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Directorate</label>
                                        <select name="staff_dept" class="form-control" required>
                                            <option value="">Choose</option>
                                            <?php
                                            $depts = [
                                              'Crime Investigation','Crime Intelligence','Traffic',
                                              'Forensics','General duties','ICT',
                                              'Child and Family','FFU','Canine'
                                            ];
                                            foreach ($depts as $d): ?>
                                                <option <?= $row->staff_dept === $d ? 'selected' : '' ?>>
                                                    <?= $d ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="assaign_dept"
                                            class="ladda-button btn btn-success"
                                            data-style="expand-right">
                                        Assign Department
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end form row -->

            </div> <!-- end container-fluid -->
            <?php include('assets/inc/footer.php'); ?>
        </div> <!-- end content-page -->
    </div> <!-- end wrapper -->

    <!-- JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>
</body>
</html>
