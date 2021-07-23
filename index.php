<?php
require __DIR__.'/app/index.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>RO Dashboard</title>
	<!-- core:css -->
	<link rel="stylesheet" href="<?php homePath();?>assets/vendors/core/core.css">
	<!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="<?php homePath();?>assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?php homePath();?>assets/vendors/jquery-tags-input/jquery.tagsinput.min.css">
	<link rel="stylesheet" href="<?php homePath();?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<!-- end plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="<?php homePath();?>assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="<?php homePath();?>assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->
  <!-- Layout styles -->  
	<link rel="stylesheet" href="<?php homePath();?>assets/css/demo_2/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php homePath();?>assets/images/favicon.png" />
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="<?php homePath();?>assets/lobibox/css/lobibox.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="<?php homePath();?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
</head>
<body>
  
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
    <?php
      renderNavbar();
    ?>
		<!-- partial -->
	
		<div class="page-wrapper<?php echo (isset($_SESSION['email']) ? '' : ' full-page'); ?>">
			<?php
      // $path = $_SERVER['REQUEST_URI'];//remove / slash
      // if($path && file_exists(__DIR__.$path.'.php')){
      //   include(__DIR__.$path.'.php');
      // }
      // else {
      //   include(__DIR__.'pages/home.php');
      // }
      renderBody();
      ?>
    <div class="modal fade modal-large1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Modal body text goes here.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button name="save" type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
		</div>
	</div>

	<!-- core:js -->
	<script src="<?php homePath();?>assets/vendors/core/core.js"></script>
	<script src="<?php homePath();?>assets/js/moment.min.js"></script>
	<!-- endinject -->
  <!-- plugin js for this page -->
  <script src="<?php homePath();?>assets/vendors/chartjs/Chart.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/jquery.flot/jquery.flot.js"></script>
  <script src="<?php homePath();?>assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
  <script src="<?php homePath();?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/apexcharts/apexcharts.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/progressbar.js/progressbar.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/select2/select2.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<!-- end plugin js for this page -->
	<!-- inject:js -->
	<script src="<?php homePath();?>assets/vendors/feather-icons/feather.min.js"></script>
	<script src="<?php homePath();?>assets/js/template.js"></script>
	<!-- endinject -->
  <!-- custom js for this page -->
  <script src="<?php homePath();?>assets/js/dashboard.js"></script>
  <script src="<?php homePath();?>assets/js/datepicker.js"></script>
  <script src="<?php homePath();?>assets/lobibox/js/lobibox.min.js"></script>
  <script src="<?php homePath();?>assets/vendors/datatables.net/jquery.dataTables.js"></script>
	<script src="<?php homePath();?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="<?php homePath();?>assets/js/inputmask.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js" integrity="sha512-Mf4TMPxK1TE3jNpbt6cFIM9Rz+Ezs+mvG6SvEKq2ZYEAix8QNtbseSccunI4efVNtvfzrRmd8vVwRRBgYMtfnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- end custom js for this page -->
</body>
</html>    