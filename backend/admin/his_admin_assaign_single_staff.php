<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['assaign_dept'])) {
    $staff_dept = $_POST['staff_dept'];
    $staff_number = $_GET['staff_number'];

    $query = "UPDATE his_staff SET staff_dept=? WHERE staff_number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ss', $staff_dept, $staff_number);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['dept_assigned'] = true;
        header("Location: his_admin_assign_dept.php?staff_number=" . $staff_number);
        exit(); // Ensure redirect is honored
    } else {
        $err = "Please Try Again Later.";
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

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
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
                        </div>
                    </div>

                    <!-- Optional Error Alert -->
                    <?php if (isset($err)) { ?>
                        <div class="alert alert-danger"><?php echo $err; ?></div>
                    <?php } ?>

                    <!-- Staff Assignment Form -->
                    <?php
                    $staff_number = $_GET['staff_number'];
                    $ret = "SELECT * FROM his_staff WHERE staff_number=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $staff_number);
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
                                                    <label>First Name</label>
                                                    <input type="text" readonly value="<?php echo $row->staff_fname; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Last Name</label>
                                                    <input type="text" readonly value="<?php echo $row->staff_lname; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" readonly value="<?php echo $row->staff_email; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Directorate</label>
                                                <select name="staff_dept" class="form-control" required>
                                                    <option value="">Choose</option>
                                                    <option>Crime Investigation</option>
                                                    <option>Crime Intelligence</option>
                                                    <option>Traffic</option>
                                                    <option>Forensics</option>
                                                    <option>General duties</option>
                                                    <option>ICT</option>
                                                    <option>Child and Family</option>
                                                    <option>FFU</option>
                                                    <option>Canine</option>
                                                </select>
                                            </div>
                                            <button type="submit" name="assaign_dept" class="ladda-button btn btn-success" data-style="expand-right">
                                                Assign Department
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <!-- Footer -->
            <?php include('assets/inc/footer.php'); ?>
        </div>

    </div>

    <!-- JavaScript Dependencies -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- ✅ SweetAlert2 Offline -->
    <script src="assets/Sweetalert2-main/sweetalert2.all.min.js"></script>
    <script>
        <?php if (isset($_SESSION['dept_assigned']) && $_SESSION['dept_assigned']) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Department assigned successfully!',
                showConfirmButton: false,
                timer: 2000
            });
            <?php unset($_SESSION['dept_assigned']); ?>
        <?php endif; ?>
    </script>
</body>

</html>
