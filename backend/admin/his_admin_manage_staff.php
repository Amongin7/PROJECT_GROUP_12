<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// ─── Delete handler ─────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM his_staff WHERE staff_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['staff_fired'] = true;
    }
    $stmt->close();
    header("Location: his_admin_manage_staff.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <?php
    // Immediately pop up the alert if we just deleted someone
    if (isset($_SESSION['staff_fired'])): ?>
      <script>
        alert('Staff deleted successfully');
      </script>
    <?php unset($_SESSION['staff_fired']); 
    endif;
    ?>

    <div id="wrapper">
      <?php include('assets/inc/nav.php'); ?>
      <?php include('assets/inc/sidebar.php'); ?>

      <div class="content-page">
        <div class="content container-fluid">
          <div class="page-title-box">
            <h4 class="page-title">Manage Staff Details</h4>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered mb-0">
              <thead>
                <tr>
                  <th>#</th><th>Name</th><th>Number</th>
                  <th>Dept</th><th>Email</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $mysqli->prepare("SELECT * FROM his_staff ORDER BY RAND()");
                $stmt->execute();
                $res = $stmt->get_result();
                $cnt = 1;
                while ($row = $res->fetch_object()):
                ?>
                <tr>
                  <td><?= $cnt ?></td>
                  <td><?= htmlspecialchars($row->staff_fname . ' ' . $row->staff_lname) ?></td>
                  <td><?= htmlspecialchars($row->staff_number) ?></td>
                  <td><?= htmlspecialchars($row->staff_dept) ?></td>
                  <td><?= htmlspecialchars($row->staff_email) ?></td>
                  <td>
                    <a href="?delete=<?= $row->staff_id ?>"
                       class="badge badge-danger delete-link">
                      <i class="mdi mdi-trash-can-outline"></i> Delete
                    </a>
                    <a href="his_admin_view_single_staff.php?staff_id=<?= $row->staff_id ?>"
                       class="badge badge-success">
                      <i class="mdi mdi-eye"></i> View
                    </a>
                    <a href="his_admin_update_single_staff.php?staff_number=<?= urlencode($row->staff_number) ?>"
                       class="badge badge-primary">
                      <i class="mdi mdi-check-box-outline"></i> Update
                    </a>
                  </td>
                </tr>
                <?php
                $cnt++;
                endwhile;
                $stmt->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php include('assets/inc/footer.php'); ?>
      </div>
    </div>

    <!-- Core JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script>
      // native confirm on delete
      document.querySelectorAll('.delete-link').forEach(btn => {
        btn.addEventListener('click', e => {
          e.preventDefault();
          if (confirm('Are you sure you want to remove this staff member?')) {
            window.location.href = btn.getAttribute('href');
          }
        });
      });
    </script>
</body>
</html>
