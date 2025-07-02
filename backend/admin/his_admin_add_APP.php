<?php
session_start();
include('assets/inc/config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_acc'])) {
    $acc_name       = $_POST['acc_name'];
    $acc_desc       = $_POST['acc_desc'];
    $acc_type       = $_POST['acc_type'];
    $acc_number     = $_POST['acc_number'];
    $acc_amount     = $_POST['acc_amount'];
    $requestingDate = $_POST['requesting_date'];

    $query = "INSERT INTO his_accounts 
              (acc_name, acc_desc, acc_type, acc_number, acc_amount, requestingDate) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'ssssss',
        $acc_name,
        $acc_desc,
        $acc_type,
        $acc_number,
        $acc_amount,
        $requestingDate
    );
    $stmt->execute();

    if ($stmt && $stmt->affected_rows > 0) {
        $_SESSION['account_added'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $err = "Please try again or try later";
    }
    $stmt->close();
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
                                        <li class="breadcrumb-item"><a href="#">APP</a></li>
                                        <li class="breadcrumb-item active">Add Suspect's Property</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Property Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <?php if (isset($err)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                    <?php endif; ?>

                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" onsubmit="return confirm('Are you sure you want to add this property?');">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Name of Suspect</label>
                                                <input type="text" name="acc_name" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Property Amount</label>
                                                <input type="text" name="acc_amount" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Receiving Officer</label>
                                                <select name="acc_number" required class="form-control">
                                                    <option value="">Choose Officer</option>
                                                    <option value="75421 PC ODONGO ROY">75421 PC ODONGO ROY</option>
                                                    <option value="75421 PC WANI SAVIOR">75421 PC WANI SAVIOR</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Date</label>
                                                <input type="date" name="requesting_date" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>More Details</label>
                                            <textarea name="acc_desc" required class="form-control" id="editor"></textarea>
                                        </div>

                                        <input type="hidden" name="acc_type" value="Payable Account">

                                        <button type="submit" name="add_acc" class="ladda-button btn btn-success" data-style="expand-right">
                                            Add Account
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <!-- Rich Text Editor -->
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
    <script> CKEDITOR.replace('editor'); </script>

    <!-- Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- Native JS alert on success -->
    <script>
        window.addEventListener('load', function() {
            <?php if (isset($_SESSION['account_added'])): ?>
                alert('Suspect property added successfully!');
                <?php unset($_SESSION['account_added']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
