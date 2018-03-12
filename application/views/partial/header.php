<?php
if (isset($this->session->userdata['logged_in'])) {
$username = ($this->session->userdata['logged_in']['username']);
$usertype = ($this->session->userdata['logged_in']['usertype']);
} else {
header("location: login");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DMA Admin</title>
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/moment.js')?>"></script>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  	<link href="<?php echo base_url('css/style.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

    <!-- ClockPicker Stylesheet -->
    <link href="<?php echo base_url('assets/bootstrap-clockpicker/dist/bootstrap-clockpicker.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/jquery-ui/jquery-ui.css')?>" rel="stylesheet">




<script type="text/javascript">
    // Add the following into your HEAD section
    var timer = 0;
    function set_interval() {
      // the interval 'timer' is set as soon as the page loads
      timer = setInterval("auto_logout()", 300000);
      // the figure '10000' above indicates how many milliseconds the timer be set to.
      // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
      // So set it to 300000
    }

    function reset_interval() {
      //resets the timer. The timer is reset on each of the below events:
      // 1. mousemove   2. mouseclick   3. key press 4. scroliing
      //first step: clear the existing timer

      if (timer != 0) {
        clearInterval(timer);
        timer = 0;
        // second step: implement the timer again
        timer = setInterval("auto_logout()", 300000);
        // completed the reset of the timer
      }
    }

    function auto_logout() {
      // this function will redirect the user to the logout script
      window.location = "logout";
    }
</script>

<script type="text/javascript">
    // live clock
    var clock_tick = function clock_tick() {
      setInterval('update_clock();', 1000);
    }

    // start the clock immediatly
    clock_tick();

    var update_clock = function update_clock() {
      document.getElementById('liveclock').innerHTML = moment().format("MMMM Do YYYY h:mm A");
    }
</script>

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);



</script>

<script>
$( function() {
  $( ".datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
  });
} );


</script>

</head>

<body onload="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">
        <div class="wrapper">
            <div class="topbar">
                <div class="container">
                    <div class="navbar-left">
                        <div id="liveclock">
                            <?php echo date("F jS Y g:i A") ?>
                        </div>
                    </div>
                    <div class="navbar-right">
                        Logged in as: <?php echo $username; ?>
						/ <b id="logout"><a href="<?php echo site_url('authentication/logout/')?>/">Logout</a></b>
                    </div>
                    <div class="navbar-center" style=
                    "text-align:center">
                        <strong>Dragon Martial Arts
                        Academy</strong>
                    </div>
                </div>
        </div>



    <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><img src="<?php echo base_url('assets/images/dma_logo.png')?>" width="40" /></a>
        </div>

        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo site_url('student/display_home')?>/"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                <li class="active"><a href="<?php echo site_url('student/display_students')?>/"><i class="glyphicon glyphicon-user"></i> Students</a></li>
                <li id="reports_menu" class="dropdown" >
                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-file"></i> Reports <b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('student_reports/display_students_reports')?>/"/>By Student</a></li>
                
                </ul>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li class="active"><a href="<?php echo site_url('rgjj/lesson_chooser')?>/"><i class="glyphicon glyphicon-edit"></i> RGJJ360</a></li>

                <?php
                if ($usertype == "Admin") {
                echo '<li id="settings_menu" class="dropdown pull-right" >';
                echo '<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-cog"></i> Settings <b class="caret"></b></a>';
                echo '<ul class="dropdown-menu pull-right">';
                echo '<li><a href=' . site_url('users/display_users') . '/>Users</a></li>';
                echo '<li><a href=' . site_url('programs/display_programs') . '/>Class Schedule</a></li>';
                echo '</ul>';
                echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-clockpicker/dist/bootstrap-clockpicker.min.js')?>"></script>
    <script src="<?php echo base_url('assets/jquery-ui/jquery-ui.js')?>"></script>
