<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_Complainant'])) {
    $compt_fname       = $_POST['compt_fname'];
    $compt_lname       = $_POST['compt_lname'];
    $sd_ref            = $_POST['sd_ref'];
    $compt_phone       = $_POST['compt_phone'];
    $compt_type        = $_POST['compt_type'];
    $compt_addr        = $_POST['compt_addr'];
    $victim            = $_POST['victim'];
    $date_occur        = $_POST['date_occur'];
    $offence_details   = $_POST['offence_details'];

    $query = "INSERT INTO his_cases 
              (compt_fname, offence_details, compt_lname, victim, date_occur, sd_ref, compt_phone, compt_type, compt_addr) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssssssss',
        $compt_fname,
        $offence_details,
        $compt_lname,
        $victim,
        $date_occur,
        $sd_ref,
        $compt_phone,
        $compt_type,
        $compt_addr
    );
    if ($stmt->execute()) {
        $success = "Case Details Added";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php');?>
<body>
    <div id="wrapper">
        <?php include("assets/inc/nav.php");?>
        <?php include("assets/inc/sidebar.php");?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_staff_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Cases</a></li>
                                        <li class="breadcrumb-item active">Register Case</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Add Form -->
                    <?php if (isset($err)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Complainant First Name</label>
                                <input type="text" required name="compt_fname" class="form-control" placeholder="Enter First Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Complainant Last Name</label>
                                <input type="text" required name="compt_lname" class="form-control" placeholder="Enter Last Name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Date Of Occurrence</label>
                                <input type="date" required name="date_occur" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Victim(s)</label>
                                <input type="text" required name="victim" class="form-control" placeholder="Victim(s) Involved">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>SD Reference</label>
                                <input type="text" name="sd_ref" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nature of Offence</label>
                                <input type="text" required name="compt_addr" class="form-control" placeholder="Nature of the Offence">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Complainant's Contact</label>
                                <input type="text" required name="compt_phone" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Details of Offence</label>
                                <input type="text" required name="offence_details" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Category</label>
                                <select name="compt_type" required class="form-control">
                                    <option value="">Choose</option>
                                    <option value="Civil">Civil</option>
                                    <option value="Criminal">Criminal</option>
                                    <option value="Disciplinary">Disciplinary</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" name="add_Complainant" class="btn btn-primary">Add Case</button>
                    </form>
                    <!-- end form -->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include("assets/inc/footer.php");?>
        </div>

    </div>
    <!-- END wrapper -->

    <!-- JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
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
