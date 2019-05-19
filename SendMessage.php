<?php
session_start();
require ("connection/dbconnection.php");
/***********/
$id = $_SESSION["id"];
//echo "This is username".$id;

$sqlCommand = $dbCon->prepare("SELECT UserID,UserName FROM room_mates_users_570 where UserID = ?");
    $sqlCommand->bind_param("i",$id);
	$sqlCommand->execute();
 
		$run_rows = $sqlCommand->get_result();
	
/***********/


while ($row = $run_rows->fetch_assoc()){
	$pid = $row["UserID"];
	$current_username = $row["UserName"];
}
//echo $pid;
//echo "<br/>This is username ".$username;

//mysqli_free_result($result);

/*************/
$to_userid = $_POST["to_userid"];

$query_570 = $dbCon->prepare("SELECT UserID,UserName FROM room_mates_users_570 where UserID = ?");
    $query_570->bind_param("i",$to_userid);
	$query_570->execute();
 
		$run_q = $query_570->get_result();
/************/


while($rows = $run_q->fetch_assoc()){
	$TOid = $rows["UserID"];
	//echo "TO ID:". $TOid;
	$TOuser = $rows["UserName"];
}

if(isset($_POST["LogOut"])){
	header('Location:../LogOut.php');
}

if($_POST["pmSubmit"]){
		//echo "Pressed Here";
		$to_username = $_POST["to_username"]; 
		//echo "<br/>To UserName:". $to_username;
		$title = $_POST["title"];
		//echo "<br/>Title:".$title;
		$message = $_POST["message"];
		//echo "<br/>Message:".$message;
		$to_userid = $_POST["to_userid"];
		//echo "<br/>TO UserID:". $to_userid;
		$userid = $_POST["userid"];
		//echo "<br/> FROM UserID:". $userid;
		$from_username = $_POST["from_username"];
		//echo "From this user:".$from_username;
		$send_date = $_POST["send_date"];
		
		//require ("../connection/dbconnection.php");
		/****************/
		
		$id = $_SESSION["id"];
//echo "This is username".$id;

		$insert_570 = $dbCon->prepare("INSERT INTO pm_outbox (userid,username, to_userid, to_username, title, content,senddate) Values('$userid','$from_username','$to_userid','$to_username','$title','$message','$send_date')");

		if($insert_570->execute()){
		$insert_pm = $dbCon->prepare("INSERT INTO private_messages (userid,username,from_id, from_username, title, content,senddate) Values('$to_userid','$to_username','$userid','$from_username','$title','$message','$send_date')");
		$insert_pm->execute();
		
		$insert_all = $dbCon->prepare("INSERT INTO all_messages (userid,username,from_id, from_username, title, content,senddate) Values('$to_userid','$to_username','$userid','$from_username','$title','$message','$send_date')");
		$insert_all->execute();
			header('Location:../messages/pm_outbox.php');
		}
		/****************/
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.html";?>
  </head>
<body>
<!-- NAVBAR ================================================== -->
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
			<li class="active"><a href="SendMessage.php">Send Message</a></li>
			<li><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="SendMessage.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br/>

          <div class="container" id="private_message">
		  <div class="col-md-1"></div>
		  <div class="col-md-10 send_msg">
<form name="pmForm" id="pmForm" action="SendMessage.php" method="post">
<div  class="text-center">
<font>Sending Message To: <strong><em><?php echo $username; ?></em></strong></font><br /><br />
</div>
 <div class="form-group">
Subject:
<input name="title" class="input" required="required" id="pmSubject" type="text" tabindex="1"/>
</div>
Message:
<textarea required="required" class="input" name="message" id="pmTextArea" rows="8" style="width:98%;" tabindex="2"></textarea>
  <input name="to_userid" id="pm_sender_id" type="hidden" value="<?php echo $to_id; ?>" />
  <input name="to_username" id="pm_sender_name" type="hidden" value="<?php echo $username; ?>" />
  <input name="userid" id="pm_rec_id" type="hidden" value="<?php echo $id; ?>" />
  <input name="from_username" id="pm_rec_name" type="hidden" value="<?php echo $UserSender; ?>" />
  <input name="send_date" type="hidden" id="send_date" value="<?php echo date("l, jS F Y, g:i:s a");?>"/>
  <br />
  <input  type="submit" name="pmSubmit" style="background-color:white; color:black;margin-top:2%;margin-bottom:1.5%;" class="btn" value="Send Message To UserName: <?php echo $username;?>" />
  
</form> 
 </div>
  <div class="col-md-1"></div>
          </div>
		  
		    </body>
</html>