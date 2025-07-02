<?php
    session_start();
    unset($_SESSION['staff_id']);
    unset($_SESSION['staff_number']);
    session_destroy();

    header("Location: his_staff_logout.php");
    exit;
?>