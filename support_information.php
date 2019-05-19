<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	$select = $dbCon->prepare("SELECT UserName FROM room_mates_users_570 WHERE UserID= ?");
	$select->bind_param("i",$id);
	$select->execute();
	$sel_res = $select->get_result();
	$results = $sel_res->fetch_assoc();
	$UN = $results["UserName"];
    if(isset($_POST['LogOut'])){
        header('Location:LogOut.php');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<?php include "header.html";?>
</head>
<body style="background-color: #D6C7E2; overflow-x:hidden;">
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header text-center">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color:white; font-size:22px;" href="perfect-roommate-home-page.php">Perfect RoomMate</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse text-center">
          <ul class="nav navbar-nav" style="font-size:18px;">
			<li><a href="perfect-roommate-home-page.php">Home</a></li>
			<li><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="messages/pm_inbox.php">Messages</a></li>
			<li class="active"><a href="../support_information.php">Support</a></li>
			<li><a href="RoomMate-FeedBack.php">Comments</a></li>
			<li><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="support_information.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<br/>
	<br/>
		<br/>
	<div class="container text-center margin-top:10%;">Hi! <span><?php echo $UN; ?></span></div>
		<br/>
			<br/>
	<div class="container text-center">
		<div class="col-md-1"></div>
			<div class="col-md-10 support_info" style="background-color:skyblue; border-radius:10px;">
				<div class="col-md-2"></div>
				<div class="col-md-8"><img src="images/support_info.jpg" class="support_img" width="auto" height="auto" alt="coming soon"/></div>
				<div class="col-md-2"></div>
			</div>
		<div class="col-md-1"></div>
	</div>	
		<?php include "footer.html" ?>
</body>
</html>