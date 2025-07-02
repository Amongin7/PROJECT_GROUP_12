<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Handle deletion
if (isset($_GET['delete_account'])) {
    $id    = intval($_GET['delete_account']);
    $sql   = "DELETE FROM his_accounts WHERE acc_id = ?";
    $stmt  = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['account_deleted'] = true;
    }
    $stmt->close();
    // Redirect to clear GET param
    header("Location: " . basename(__FILE__));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>

<?php if (isset($_SESSION['account_deleted'])): ?>
    <script>
        alert('Suspect property handed back.');
    </script>
    <?php unset($_SESSION['account_deleted']); ?>
<?php endif; ?>

<div id="wrapper">
    <?php include('assets/inc/nav.php'); ?>
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">APP</a></li>
                                    <li class="breadcrumb-item active">Manage Suspect's Property</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-12 text-sm-center form-inline">
                                        <div class="form-group mr-2" style="display:none">
                                            <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                <option value="">Show all</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input id="demo-foo-search" type="text" placeholder="Search"
                                                   class="form-control form-control-sm" autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="demo-foo-filtering"
                                       class="table table-bordered toggle-circle mb-0"
                                       data-page-size="7">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th data-toggle="true">Name of Suspect</th>
                                        <th data-hide="phone">Receiving Officer</th>
                                        <th data-hide="phone">Property Description</th>
                                        <th data-hide="phone">Date of Receipt</th>
                                        <th data-hide="phone">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ret  = "SELECT * FROM his_accounts WHERE acc_type = 'Payable Account' ORDER BY RAND()";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res  = $stmt->get_result();
                                    $cnt  = 1;
                                    while ($row = $res->fetch_object()):
                                    ?>
                                        <tr>
                                            <td><?= $cnt++; ?></td>
                                            <td><?= htmlspecialchars($row->acc_name); ?></td>
                                            <td><?= htmlspecialchars($row->acc_number); ?></td>
                                            <td>UGX <?= htmlspecialchars($row->acc_amount); ?></td>
                                            <td><?= htmlspecialchars($row->requestingDate); ?></td>
                                            <td>
                                                <a href="his_admin_view_single_APP.php?acc_id=<?= $row->acc_id; ?>"
                                                   class="badge badge-success">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="his_admin_update_single_APP.php?acc_id=<?= $row->acc_id; ?>"
                                                   class="badge badge-warning">
                                                    <i class="fas fa-clipboard-check"></i> Update
                                                </a>
                                                <a href="?delete_account=<?= $row->acc_id; ?>"
                                                   class="badge badge-danger delete-link">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile;
                                    $stmt->close();
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr class="active">
                                        <td colspan="6">
                                            <div class="text-right">
                                                <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->
        </div> <!-- content -->
        <?php include('assets/inc/footer.php'); ?>
    </div> <!-- content-page -->
</div> <!-- wrapper -->

<div class="rightbar-overlay"></div>

<!-- JS Scripts -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/libs/footable/footable.all.min.js"></script>
<script src="assets/js/pages/foo-tables.init.js"></script>
<script src="assets/js/app.min.js"></script>
<script>
    // Native confirm() before deletion
    document.querySelectorAll('.delete-link').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Do you want to delete this record?')) {
                window.location.href = this.getAttribute('href');
            }
        });
    });
</script>
</body>
</html>
