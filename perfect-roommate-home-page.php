<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];

	$sqlQuery = $dbCon->prepare("SELECT Complete FROM Profile_Answers_570 where UserID = ?");
    $sqlQuery->bind_param("i",$id);
	$sqlQuery->execute();
	
	$sqlRes = $sqlQuery->get_result();
	$res = $sqlRes->fetch_assoc();

     $completed = $res['Complete'];
	
	//echo $completed;
	if($completed == 0){
		$sqlQuery->close();
		header('Location:questionnaire.php');
		//$msg = "Please Complete Profile To View Other Users";
	}

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

else{
    header('Location: LogIn.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include "header.html";?>
</head>
<body onload="viewdata()" style="background-color: #D6C7E2; overflow-x:hidden;">
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color:white; font-size:22px;" href="perfect-roommate-home-page.php">Perfect RoomMate</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav" style="font-size:18px;">
			<li class="active"><a href="perfect-roommate-home-page.php">Home</a></li>
			<li><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="messages/pm_inbox.php">Messages</a></li>
			<li><a href="RoomMate-FeedBack.php">Comments</a></li>
			<li><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="perfect-roommate-home-page.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br/> 

    <div class="container text-center">
	<div class="text-center">
	Hi, <?php echo $UN;?>
	</div>
	<br/>
        <div id="viewdata"></div>
    </div> 
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        if (!window.jQuery) { document.write('<script src="JS/jquery.js"><\/script>'); }
    </script> 
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/dist/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
	

	<link href="FooTable/css/footable.core.css" rel="stylesheet" type="text/css"/>
	<link href="FooTable/css/footable.metro.css" rel="stylesheet" type="text/css"/>

    <script src="FooTable/js/footable.js" type="text/javascript"></script>
	<script src="FooTable/js/footable.paginate.js" type="text/javascript"></script>
	<script src="FooTable/js/footable.sort.js" type="text/javascript"></script>
	<script src="FooTable/js/footable.filter.js" type="text/javascript"></script>
	
	
	
	<script>
    function viewdata(){
        $.ajax({
            type: "GET",
            url: "viewdata.php"
        }).done(function(data) {
            $('#viewdata').html(data);
        });
    }
	</script>
	<?php 
		include "footer.html";
	?>
</body>
</html>