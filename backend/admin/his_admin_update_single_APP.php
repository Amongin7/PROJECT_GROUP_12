<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_acc'])) {
    $acc_id = $_POST['acc_id'];
    $acc_name = $_POST['acc_name'];
    $acc_desc = $_POST['acc_desc'];
    $acc_type = $_POST['acc_type'];
    $acc_number = $_POST['acc_number'];
    $acc_amount = $_POST['acc_amount'];
    $requesting_date = $_POST['requesting_date'];

    $query = "UPDATE his_accounts SET acc_name=?, acc_desc=?, acc_type=?, acc_amount=?, requestingDate=?, acc_number=? WHERE acc_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssi', $acc_name, $acc_desc, $acc_type, $acc_amount, $requesting_date, $acc_number, $acc_id);

    if ($stmt->execute()) {
        $_SESSION['update_success'] = true;
        header("Location: " . $_SERVER['PHP_SELF'] . "?acc_id=" . $acc_id);
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
                <?php
                if (!isset($_GET['acc_id']) || !is_numeric($_GET['acc_id'])) {
                    echo "<script>alert('Invalid Account ID');window.location='his_admin_dashboard.php';</script>";
                    exit();
                }
                $acc_id = $_GET['acc_id'];
                $ret = "SELECT * FROM his_accounts WHERE acc_id=?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('i', $acc_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) {
                    ?>
                    <div class="page-title-box">
                        <h4 class="page-title">Update APP - Account ID: <?php echo htmlspecialchars($row->acc_id); ?></h4>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <input type="hidden" name="acc_id" value="<?php echo $row->acc_id; ?>">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Name of Suspect</label>
                                                <input type="text" name="acc_name" required value="<?php echo htmlspecialchars($row->acc_name); ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Property Description</label>
                                                <input type="text" name="acc_amount" required value="<?php echo htmlspecialchars($row->acc_amount); ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Receiving Officer</label>
                                                <select name="acc_number" class="form-control">
                                                    <option selected value="<?php echo htmlspecialchars($row->acc_number); ?>"><?php echo htmlspecialchars($row->acc_number); ?></option>
                                                    <option value="75421 PC ODONGO ROY">75421 PC ODONGO ROY</option>
                                                    <option value="75421 PC WANI SAVIOR">75421 PC WANI SAVIOR</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Date</label>
                                                <input type="date" name="requesting_date" value="<?php echo htmlspecialchars($row->requestingDate); ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>More Details</label>
                                            <textarea name="acc_desc" class="form-control" id="editor"><?php echo htmlspecialchars($row->acc_desc); ?></textarea>
                                        </div>

                                        <div class="form-group" style="display:none;">
                                            <label>Account Type</label>
                                            <input type="text" name="acc_type" class="form-control" value="Payable Account">
                                        </div>

                                        <button type="submit" name="update_acc" class="ladda-button btn btn-warning">Update APP</button>
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

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- CKEditor -->
<script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
<script>CKEDITOR.replace('editor');</script>

<!-- Core JS -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/libs/ladda/spin.js"></script>
<script src="assets/libs/ladda/ladda.js"></script>
<script src="assets/js/pages/loading-btn.init.js"></script>

<!-- Native JS Alert -->
<script>
    <?php if (isset($_SESSION['update_success']) && $_SESSION['update_success']) : ?>
        alert('Account updated successfully!');
        <?php unset($_SESSION['update_success']); ?>
    <?php endif; ?>
</script>

</body>
</html>
