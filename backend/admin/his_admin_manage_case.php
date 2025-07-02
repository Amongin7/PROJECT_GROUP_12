<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Deletion logic
if (isset($_GET['delete'])) {
    $id  = intval($_GET['delete']);
    $sql = "DELETE FROM his_cases WHERE compt_id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: his_admin_manage_case.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('assets/inc/head.php'); ?>
    <!-- Offline Bootstrap CSS -->
    <link href="Assets/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">Cases Registered</a></li>
                                        <li class="breadcrumb-item active">Manage</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Manage Case Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Cases table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Complainant's Name</th>
                                                <th>SD Reference</th>
                                                <th>Nature of Offence</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret  = "SELECT * FROM his_cases ORDER BY RAND()";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res  = $stmt->get_result();
                                            $cnt  = 1;
                                            while ($row = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?= $cnt ?></td>
                                                    <td><?= "{$row->compt_fname} {$row->compt_lname}" ?></td>
                                                    <td><?= $row->sd_ref ?></td>
                                                    <td><?= $row->compt_addr ?></td>
                                                    <td><?= $row->compt_type ?></td>
                                                    <td>
                                                        <a href="?delete=<?= $row->compt_id ?>" class="badge badge-danger delete-link">
                                                            <i class="mdi mdi-trash-can-outline"></i> Delete
                                                        </a>
                                                        <a href="his_admin_view_single_case.php?compt_id=<?= $row->compt_id ?>&sd_ref=<?= $row->sd_ref ?>" class="badge badge-success">
                                                            <i class="mdi mdi-eye"></i> View
                                                        </a>
                                                        <a href="his_admin_update_single_case.php?compt_id=<?= $row->compt_id ?>" class="badge badge-primary">
                                                            <i class="mdi mdi-check-box-outline"></i> Update
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            }
                                            $stmt->close();
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!-- end .table-responsive -->
                            </div> <!-- end card-box -->
                        </div>
                    </div> <!-- end row -->

                </div> <!-- end container-fluid -->
            </div> <!-- end content -->

            <?php include('assets/inc/footer.php'); ?>
        </div> <!-- end content-page -->
    </div> <!-- end wrapper -->

    <!-- Core JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/libs/footable/footable.all.min.js"></script>
    <script src="assets/js/pages/foo-tables.init.js"></script>
    <!-- Offline Bootstrap JS bundle -->
    <script src="Assets/bootstrap.bundle.min.js"></script>
    <!-- Your app JS -->
    <script src="assets/js/app.min.js"></script>

    <script>
        // Native JS confirm() for deletes
        document.querySelectorAll('.delete-link').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this record?')) {
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    </script>
</body>

</html>
