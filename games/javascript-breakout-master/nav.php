<?php
	include("mysql_connect.php");
?>
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom" style="padding:12px;">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header page-scroll">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
      </button>
      <a class="navbar-brand" href="../../index.php">Game Rehabilitation</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="hidden">
          <a href="#page-top"></a>
        </li>
        <li class="page-scroll">
          <a href="../../index.php">GAMES</a>
        </li>
        <?php
  				if(!isset($_SESSION['login_user'])){
          echo '<li class="page-scroll">';
          echo '<a data-toggle="modal" data-target="#myModal">Login</a>';
          echo '</li>';
          echo  '<li class="page-scroll">';
          echo '<a data-toggle="modal" data-target="#myModal2">PROFILE</a>';
          echo  '</li>';
        }
				else{
					echo '<li class="page-scroll">';
					echo '<a>'.$_SESSION['login_user'].'</a>';
					echo '</li>';
				}
        ?>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <?php //include 'login.php'; ?>
  </div>
</div>
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <?php //include 'profile.php'; ?>
  </div>
</div>
<br/>
<br/>
<br/>
<br/>
