<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['ad_id'];

// Validate acc_id
if (!isset($_GET['acc_id']) || !is_numeric($_GET['acc_id'])) {
    echo "<script>alert('Invalid or missing Account ID.'); window.location.href='his_admin_dashboard.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <?php
                    $acc_id = intval($_GET['acc_id']);
                    $ret = "SELECT * FROM his_accounts WHERE acc_id = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $acc_id); // Now using 'i' for integer
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($res->num_rows === 0) {
                        echo "<div class='alert alert-warning mt-4'>No record found for Account ID: <strong>" . htmlspecialchars($acc_id) . "</strong></div>";
                    } else {
                        while ($row = $res->fetch_object()) {
                    ?>

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">APP</a></li>
                                        <li class="breadcrumb-item active">Accounts</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Account ID: <?php echo htmlspecialchars($row->acc_id); ?> Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <div class="tab-content pt-0">
                                            <div class="tab-pane active show" id="product-1-item">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-7">
                                        <div class="pl-xl-3 mt-3 mt-xl-0">
                                            <h4 class="mb-3">Account Number: <?php echo htmlspecialchars($row->acc_number); ?></h4>
                                            <hr>
                                            <h5 class="text-danger">Account Name: <?php echo htmlspecialchars($row->acc_name); ?></h5>
                                            <hr>
                                            <h5 class="text-danger">Account Amount: $<?php echo number_format($row->acc_amount, 2); ?></h5>
                                            <hr>
                                            <h5 class="text-danger">Account Type: <?php echo htmlspecialchars($row->acc_type); ?></h5>
                                            <hr>
                                            <h5>Account Description:</h5>
                                            <p class="text-muted mb-4">
                                                <?php echo nl2br(htmlspecialchars($row->acc_desc)); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        } // end while
                    } // end if
                    ?>

                </div>
            </div>

            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <div class="rightbar-overlay"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

<?php if(isset($success)) { ?>
<script>
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo addslashes($success); ?>',
            timer: 2000,
            showConfirmButton: false
        });
    }, 100);
</script>
<?php } ?>

<?php if(isset($err)) { ?>
<script>
    setTimeout(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($err); ?>',
            timer: 2000,
            showConfirmButton: false
        });
    }, 100);
</script>
<?php } ?>

</body>
</html>
