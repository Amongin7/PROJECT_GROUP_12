<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_doc'])) {
    $staff_fname = $_POST['staff_fname'];
    $staff_lname = $_POST['staff_lname'];
    $staff_number = $_GET['staff_number'];
    $staff_email = $_POST['staff_email'];
    $staff_pwd = sha1(md5($_POST['staff_pwd']));
    $staff_dpic = $_FILES["staff_dpic"]["name"];

    move_uploaded_file($_FILES["staff_dpic"]["tmp_name"], "uploads/" . $staff_dpic);

    $query = "UPDATE his_staff SET staff_fname=?, staff_lname=?, staff_email=?, staff_pwd=?, staff_dpic=? WHERE staff_number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssss', $staff_fname, $staff_lname, $staff_email, $staff_pwd, $staff_dpic, $staff_number);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['staff_updated'] = true;
        header("Location: his_admin_update_single_staff.php?staff_number=" . $staff_number);
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

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                                        <li class="breadcrumb-item active">Manage Staff</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Update Staff Details</h4>
                            </div>
                        </div>
                    </div>

                    <?php
                    $staff_number = $_GET['staff_number'];
                    $ret = "SELECT * FROM his_staff WHERE staff_number=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $staff_number);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">First Name</label>
                                                    <input type="text" required name="staff_fname" value="<?php echo $row->staff_fname; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Last Name</label>
                                                    <input type="text" required name="staff_lname" value="<?php echo $row->staff_lname; ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input type="email" required name="staff_email" value="<?php echo $row->staff_email; ?>" class="form-control">
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Password</label>
                                                    <input type="password" required name="staff_pwd" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Profile Picture</label>
                                                    <input type="file" required name="staff_dpic" class="form-control btn btn-success" accept="image/*">
                                                </div>
                                            </div>

                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Update Staff</button>
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

    <div class="rightbar-overlay"></div>

    <!-- JS Dependencies -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- ✅ SweetAlert2 Offline -->
    <script src="assets/Sweetalert2-main/sweetalert2.all.min.js"></script>
    <script>
        <?php if (isset($_SESSION['staff_updated']) && $_SESSION['staff_updated']) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Staff details updated successfully!',
                showConfirmButton: false,
                timer: 2000
            });
            <?php unset($_SESSION['staff_updated']); ?>
        <?php endif; ?>
    </script>

</body>

</html>
