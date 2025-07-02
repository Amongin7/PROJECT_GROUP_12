<?php
session_start();
include('assets/inc/config.php');

// Transfer logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trans_dept'])) {
    $staff_dept   = $_POST['staff_dept'];
    $staff_number = $_GET['staff_number'];

    $query = "UPDATE his_staff SET staff_dept=? WHERE staff_number = ?";
    $stmt  = $mysqli->prepare($query);
    $stmt->bind_param('ss', $staff_dept, $staff_number);
    $stmt->execute();

    if ($stmt && $stmt->affected_rows > 0) {
        $_SESSION['staff_transferred'] = true;
        header("Location: his_admin_transfer_single_staff.php?staff_number=" . urlencode($staff_number));
        exit();
    } else {
        $_SESSION['staff_transfer_error'] = "Transfer Failed. Please Try Again.";
        header("Location: his_admin_transfer_single_staff.php?staff_number=" . urlencode($staff_number));
        exit();
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
                                        <li class="breadcrumb-item active">Transfer Staff</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Transfer Staff From One Department To Another</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Transfer Form -->
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
                                                <label>Force Number/Rank</label>
                                                <input type="text" readonly value="<?php echo $row->staff_number; ?>" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Current Department</label>
                                                <input type="text" readonly value="<?php echo $row->staff_dept; ?>" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Transfer Department</label>
                                                <select name="staff_dept" class="form-control" required>
                                                    <option value="">Choose</option>
                                                    <option>Registration</option>
                                                    <option>Suspects</option>
                                                    <option>Exhibits</option>
                                                    <option>Accounting</option>
                                                    <option>Operation</option>
                                                </select>
                                            </div>

                                            <button type="submit" name="trans_dept" class="btn btn-success">Transfer Staff</button>
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

    <!-- JS Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- ✅ SweetAlert2 (Offline) -->
    <script src="assets/Sweetalert2-main/sweetalert2.all.min.js"></script>
    <script>
        <?php if (isset($_SESSION['staff_transferred']) && $_SESSION['staff_transferred']) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Staff transferred successfully!',
                showConfirmButton: false,
                timer: 2000
            });
            <?php unset($_SESSION['staff_transferred']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['staff_transfer_error'])) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Transfer Failed',
                text: '<?php echo $_SESSION['staff_transfer_error']; ?>',
                confirmButtonColor: '#d33'
            });
            <?php unset($_SESSION['staff_transfer_error']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
