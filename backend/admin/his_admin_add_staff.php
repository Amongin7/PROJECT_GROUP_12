<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_doc'])) {
    $staff_fname  = $_POST['staff_fname'];
    $staff_lname  = $_POST['staff_lname'];
    $staff_number = $_POST['staff_number'];
    $staff_email  = $_POST['staff_email'];
    $staff_pwd    = sha1(md5($_POST['staff_pwd']));
    $staff_dept   = $_POST['staff_dept'];

    // Handle image upload
    $target_dir     = "uploads/";
    $filename       = basename($_FILES["staff_dpic"]["name"]);
    $new_filename   = time() . "_" . $filename;
    $target_file    = $target_dir . $new_filename;
    $uploadOk       = 1;
    $imageFileType  = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image
    $check = getimagesize($_FILES["staff_dpic"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['staff_add_error'] = "File is not a valid image.";
        $uploadOk = 0;
    }

    $allowed = ['jpg','jpeg','png','gif'];
    if (!in_array($imageFileType, $allowed)) {
        $_SESSION['staff_add_error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        if (move_uploaded_file($_FILES["staff_dpic"]["tmp_name"], $target_file)) {
            $staff_dpic = $target_file;

            $query = "INSERT INTO his_staff 
                      (staff_fname, staff_lname, staff_email, staff_pwd, staff_dept, staff_number, staff_dpic)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param(
                'sssssss',
                $staff_fname, $staff_lname, $staff_email,
                $staff_pwd, $staff_dept, $staff_number, $staff_dpic
            );
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['staff_added'] = true;
            } else {
                $_SESSION['staff_add_error'] = "Database error. Please try again.";
            }

            $stmt->close();
        } else {
            $_SESSION['staff_add_error'] = "There was an error uploading the file.";
        }
    }
    // Redirect to clear POST and show alert
    header("Location: his_admin_add_staff.php");
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

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Add Staff Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- inline error message if upload/DB failed -->
                    <?php if (isset($_SESSION['staff_add_error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['staff_add_error']) ?>
                        </div>
                        <?php unset($_SESSION['staff_add_error']); ?>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Force Number / Rank</label>
                                                <input type="text" name="staff_number" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <input type="text" name="staff_fname" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name</label>
                                                <input type="text" name="staff_lname" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Department</label>
                                                <input type="text" name="staff_dept" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" name="staff_email" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" name="staff_pwd" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Display Picture</label>
                                                <input type="file" name="staff_dpic" class="form-control-file" accept="image/*" required>
                                            </div>
                                        </div>
                                        <button type="submit" name="add_doc" class="btn btn-success">
                                            Add Staff
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end container -->
            </div> <!-- end content -->
            <?php include('assets/inc/footer.php'); ?>
        </div> <!-- end content-page -->
    </div> <!-- end wrapper -->

    <div class="rightbar-overlay"></div>
    <!-- Core JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
    // Native confirm before submission
    document.querySelector('button[name="add_doc"]').addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to add this staff member?')) {
            e.preventDefault();
        }
    });

    // Alert on successful add
    <?php if (isset($_SESSION['staff_added'])): ?>
    window.addEventListener('load', function() {
        alert('Staff registered successfully!');
    });
    <?php unset($_SESSION['staff_added']); endif; ?>
    </script>
</body>
</html>
