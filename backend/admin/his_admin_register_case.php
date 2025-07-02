<?php
session_start();
include('assets/inc/config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['add_'])) {
    $compt_fname = $_POST['compt_fname'];
    $compt_lname = $_POST['compt_lname'];
    $sd_ref = $_POST['sd_ref'];
    $compt_phone = $_POST['compt_phone'];
    $compt_type = $_POST['compt_type'];
    $compt_addr = $_POST['compt_addr'];
    $victim = $_POST['victim'];
    $date_occur = $_POST['date_occur'];
    $offence_details = $_POST['offence_details'];

    $query = "INSERT INTO his_cases (compt_fname, offence_details, compt_lname, victim, date_occur, sd_ref, compt_phone, compt_type, compt_addr)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssssss", $compt_fname, $offence_details, $compt_lname, $victim, $date_occur, $sd_ref, $compt_phone, $compt_type, $compt_addr);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Execution Failed: " . $stmt->error;
        }
    } else {
        $error = "Prepare Statement Failed: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Bootstrap CSS -->
<link href="/ACRMS/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="/ACRMS/assets/css/icons.min.css" rel="stylesheet" />
<link href="/ACRMS/assets/css/app.min.css" rel="stylesheet" />
<!-- SweetAlert2 (Offline) -->
<script src="/ACRMS/assets/Sweetalert2-main/sweetalert2.all.min.js"></script>
    <?php include('assets/inc/head.php'); ?>
</head>
<body>
    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"> Files</a></li>
                                        <li class="breadcrumb-item active">Open a </li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add  Details</h4>
                            </div>
                        </div>
                    </div>     
                    <!-- end page title --> 

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Add  Form -->
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Complainant First Name</label>
                                                <input type="text" required name="compt_fname" class="form-control" placeholder="Enter First Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Complainant Last Name</label>
                                                <input type="text" required name="compt_lname" class="form-control" placeholder="Enter Last Name">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Date Of Occurrence</label>
                                                <input type="date" required name="date_occur" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Victim(s)</label>
                                                <input type="text" required name="victim" class="form-control" placeholder="Victim(s) Involved">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">SD Reference</label>
                                                <input type="text" name="sd_ref" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Nature of Offence</label>
                                                <input type="text" required name="compt_addr" class="form-control" placeholder="Nature of the Offence">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label">Complainant's Contact</label>
                                                <input type="text" required name="compt_phone" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label">Details of Offence</label>
                                                <input type="text" required name="offence_details" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label">Category of the </label>
                                                <select name="compt_type" required class="form-control">
                                                    <option value="">Choose</option>
                                                    <option value="Civil">Civil</option>
                                                    <option value="Criminal">Criminal</option>
                                                    <option value="Disciplinary">Disciplinary</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" name="add_" class="btn btn-primary">Add </button>
                                    </form>
                                    <!-- End  Form -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

   

    <!-- SweetAlert Notification Logic -->
    <?php if (isset($success) && $success): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: ' Details Added Successfully',
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'his_admin_manage_case.php';
            });
        </script>
    <?php elseif (isset($error)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: <?php echo json_encode($error); ?>
            });
        </script>
    <?php endif; ?>
</body>
</html>
