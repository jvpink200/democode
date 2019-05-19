<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
if(isset($_SESSION['id'])) {
	$session_id = $_SESSION["id"];
	
	$sqlQuery = $dbCon->prepare("SELECT Complete FROM Profile_Answers_570 where UserID = ?");
    $sqlQuery->bind_param("i",$session_id);
	$sqlQuery->execute();
 
		$sqlRes = $sqlQuery->get_result();
	$results = $sqlRes->fetch_assoc();

	$completed = $results["Complete"];
	//echo $completed;
	if($completed == 0){
		header('Location:questionnaire.php');
		//$msg = "Please Complete Profile To View Other Users";
	}
/*if(isset($_POST['submit'])){
	$Gender = $_POST['gender'];
//echo $Gender;
$Age = $_POST['age'];
//echo $Age;
$City = $_POST['city'];
//echo $City;
$State = $_POST['state'];
//echo $State;
$Housing_Type = $_POST['housing'];
//echo $Housing_Type;
$Cleanliness = $_POST['Cleanliness'];
//echo $Cleanliness;
$sleep_habit = $_POST['sleep_habits'];
//echo $sleep_habit;
$completed = 1;
//echo $completed;
$children = $_POST['children'];

$heat = $_POST['heat_prefences'];

$AC = $_POST['ac_prefence'];

$smoker = $_POST['smoking_habits'];

$Place = $_POST['Place'];

$pets = $_POST['pets'];

$Max_Rent = $_POST['Max_Rent'];

$Length_Stay = $_POST['Length_Stay'];
		//echo "yes part 1";
		//echo $session_id;
		
			$UpdateProfile = $dbCon->prepare("UPDATE Profile_Answers_570 SET Complete = '$completed', Age = '$Age', State = '$State', Gender = '$Gender' , City = '$City' , Housing_Type = '$Housing_Type' , Cleanliness = '$Cleanliness' ,Sleep_Habits = '$sleep_habit', Children ='$children',AC_Prefence = '$AC', Heat_Prefence = '$heat', Smoker = '$smoker' , PETS = '$pets', Length_Stay ='$Length_Stay' ,Place = '$Place', Max_Rent = '$Max_Rent' WHERE UserID = ?");
    $UpdateProfile->bind_param("i",$session_id);
	$UpdateProfile->execute();

		$UpdateRes = $UpdateProfile->get_result();
	$ResultsPro = $UpdateRes->fetch_assoc();
		
		if($ResultsPro){
			$msg = "Success";
		}
}
*/
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
<body onload="viewdata()" style="background-color: #D6C7E2; overflow-y:scroll;">
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
			<li><a href="perfect-roommate-home-page.php">Home</a></li>
			<li><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="messages/pm_inbox.php">Messages</a></li>
			<li class="active"><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="My-Perfect-Roommate-Profile.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br/>
<br/>
<?php

$new_id = $_SESSION["id"];
date_default_timezone_set('America/Los_Angeles');

$run_query = $dbCon->prepare("SELECT * FROM Purchase_History_570 WHERE UserID =?");
    $run_query->bind_param("i",$new_id);
	$run_query->execute();
	
	$sqlRes = $run_query->get_result();
	$User_rows = $sqlRes->fetch_assoc();
	
$UsersRegDate = $User_rows['Purchase_Date'];
$sign_up = date("Y-m-d",strtotime($UsersRegDate));
//echo "Sign Up Date:".$sign_up;
$MembershipEnds = date("Y-m-d", strtotime(date("Y-m-d", strtotime($sign_up)). " + 8 day"));
//echo "MemberShip_End Date".$MembershipEnds;

$current_date = date("Y-m-d");
//echo "Current Date". $current_date;
if($current_date < $MembershipEnds){
	$status = "Active";
}
else{
	$status = "InActive";
}
?>
<div class="container text-center">
MemberShip is Currently: <b style="color:white; font-size:20px;"><?php echo $status;?></b>
<br/>
<br/>
Membership Effective Until: <?php echo $MembershipEnds;?>
<br/>
<br/>
Note Date Format: YYYY-MM-DD
</div>
<br/>
<div class="container">
<div id="info"></div>
        <div id="viewdata"></div>
</div>
<?php include "footer.html" ?>
<script type="text/javascript" src="JS/jquery.js"></script>
	<link href="FooTable/css/footable.core.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        if (!window.jQuery) { document.write('<script src="JS/jquery.js"><\/script>'); }
    </script>
    <script src="FooTable/js/footable.js" type="text/javascript"></script>
<script>
    function viewdata(){
        $.ajax({
            type: "GET",
            url: "profile_data.php"
        }).done(function( data ) {
            $('#viewdata').html(data);
        });
    }
	
	function profile_update(str){
	
	var id = str;
	var FN = $('#FirstName'+str).val();
	var LN = $('#LastName'+str).val();
	var UN = $('#UserName'+str).val();
	var PW = $('#PW'+str).val();
	
	var Bio = $('#Bio'+str).val();
	var datas="FN="+FN+"&LN="+LN+"&UN="+UN+"&PW="+PW+"&Bio="+Bio;
      
	$.ajax({
	   type: "POST",
	   url: "UpdateProfile.php?id="+id,
	   data: datas
	}).done(function( data ) {
	  $('#info').html(data);
	  viewdata();
	});
    }
</script>
</body>

</html>