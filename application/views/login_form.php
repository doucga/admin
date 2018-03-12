<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
$location = "location: " . base_url('authentication/user_login_process');
header($location);
}
?>
<head>
<title>Login</title>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
</head>
<body>
	<div class="wrapper">

<?php
if (isset($logout_message)) {
echo "<div class='message'>";
echo $logout_message;
echo "</div>";
}
?>
<?php
if (isset($message_display)) {
echo "<div class='message'>";
echo $message_display;
echo "</div>";
}
?>
<div id="main">
<div id="login">

<?php echo form_open('authentication/user_login_process'); ?>
<div class="text-center">
<?php
echo "<div class='error_msg'>";
if (isset($error_message)) {
echo $error_message;
}
echo validation_errors();
echo "</div>";
?>
<div>
<img src="<?php echo base_url('assets/images/dma_logo.png')?>" width="200" height="40" class="center-block img-responsive"/>
</div>

	<!-- Button HTML (to Trigger Modal) -->
	<a href="#myModal" class="trigger-btn" data-toggle="modal">CLICK TO LOG IN</a>
</div>
</div>
<!-- Modal HTML -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="<?php echo base_url('assets/images/dma_logo_50x57.png')?>" alt="DMA">
				</div>
				<h4 class="modal-title">Instructor Login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="/DMA/kiosk/admin/validation.php" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Username" required="required">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" required="required">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-btn">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#"></a>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
</div>

</div>
</body>
</html>
