<!--Server side code to handle  Animal Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_animal_presc']))
		{
			$pres_pat_name = $_POST['pres_pat_name'];
			//$pres_pat_number = $_POST['pres_pat_number'];
            $pres_pat_type = $_POST['pres_pat_type'];
            $pres_pat_addr = $_POST['pres_pat_addr'];
            $pres_pat_age = $_POST['pres_pat_age'];
            $pres_number = $_GET['pres_number'];
            $pres_ins = $_POST['pres_ins'];
            $pres_pat_ailment = $_POST['pres_pat_ailment'];
            //sql to insert captured values
			$query="UPDATE   his_prescriptions  SET pres_pat_name = ?, pres_pat_type = ?, pres_pat_addr = ?, pres_pat_age = ?, pres_pat_ailment = ?, pres_ins = ? WHERE pres_number = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssss', $pres_pat_name, $pres_pat_type, $pres_pat_addr, $pres_pat_age,  $pres_pat_ailment, $pres_ins, $pres_number);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Animal Prescription Updated";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Animal Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $pres_number = $_GET['pres_number'];
                $ret="SELECT  * FROM his_prescriptions WHERE pres_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$pres_number);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
            ?>
                <div class="content-page">
                    <div class="content">

                        <!-- Start Content-->
                        <div class="container-fluid">
                            
                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Equipments</a></li>
                                                <li class="breadcrumb-item active">Manage Prescriptions</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Update Animal Prescription</h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Fill all fields</h4>
                                            <!--Add Animal Form-->
                                            <form method="post">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Animal Owner's Name</label>
                                                        <input type="text" required="required" readonly name="pres_pat_name" value="<?php echo $row->pres_pat_name;?>" class="form-control" id="inputEmail4" placeholder="Animal's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Animal Age</label>
                                                        <input required="required" type="text" readonly name="pres_pat_age" value="<?php echo $row->pres_pat_age;?>" class="form-control"  id="inputPassword4" placeholder="Animal`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Animal Type</label>
                                                        <input required="required" type="text" readonly name="pres_pat_addr" value="<?php echo $row->pres_pat_addr;?>" class="form-control"  id="inputPassword4" placeholder="Animal`s Age">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Animal Type</label>
                                                        <input required="required" readonly type="text" name="pres_pat_type" value="<?php echo $row->pres_pat_type;?>" class="form-control"  id="inputPassword4" placeholder="Animal`s Age">
                                                    </div>

                                                </div>

                                                <div class="form-group ">
                                                        <label for="inputCity" class="col-form-label">Animal Condition</label>
                                                        <input required="required" type="text" value="<?php echo $row->pres_pat_ailment;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                </div>
                                                <hr>
                                                

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Prescription</label>
                                                        <textarea required="required"  type="text" class="form-control" name="pres_ins" id="editor"><?php echo $row->pres_ins;?></textarea>
                                                </div>

                                                <button type="submit" name="update_animal_presc" class="ladda-button btn btn-primary" data-style="expand-right">Update Animal Prescription</button>

                                            </form>
                                            <!---->
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                    <?php include('assets/inc/footer.php');?>
                    <!-- end Footer -->

                </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    
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