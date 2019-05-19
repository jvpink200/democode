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
$to_userid = $_POST["contact_user"];

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
if($_POST["send_message"]){
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
		
		$insert_all= $dbCon->prepare("INSERT INTO all_messages (userid,username,from_id, from_username, title, content,senddate) Values('$to_userid','$to_username','$userid','$from_username','$title','$message','$send_date')");
		$insert_all->execute();
		
			header('Location:messages/pm_outbox.php');
		}
		/****************/
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "messages/header.html";?>
  </head>
<body>
<!-- NAVBAR ================================================== -->
	<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color:teal;">
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
			<li class="active"><a href="perfect-roommate-home-page.php">Send Message</a></li>
			<li><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="Messages.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br/>
<div class="container">
		  <div class="col-md-1"></div>
		  <div class="col-md-10 send_msg">
<table class="table" style="border:1px solid transparent;">
<form name="Send_To" method="post" action="send_contact_message.php">
<thead>
	<tr style="border:2px solid transparent;">
	<div class="form-group">
	<td width="80" class="text-center">
    <div><label for="title">Subject </label></div>
	</td>
    <td><input name="title" required="required" id="title" type="text" class="form-control" style="border:none;"></td>
	</div>
	</tr>
	<tr style="border:2px solid transparent;">
	<div class="form-group">
	<td width="80" class="text-center">
    <div><label for="message">Message</label></div>
	</td>
	<td><textarea name="message" rows="5" required="required" id="message" class="form-control" style="resize:none;"></textarea></td>
	</div>
	</tr>
</thead>
<tbody>
	<td colspan="2" class="text-center">
	<input type="submit" name="send_message" id="send_message" class="btn btn-primary" value="Send Message To UserName : <?php print $TOuser;?>"/>
	<input name="to_userid" type="hidden" id="to_userid" value="<?php print $TOid;?>"/>
	<input name="to_username" type="hidden" id="to_username" value="<?php print $TOuser;?>"/>
	<input name="userid" type="hidden" id="userid" value="<?php print $pid;?>"/>
	<input name="from_username" type="hidden" id="from_username" value="<?php print $current_username;?>"/>
	<input name="send_date" type="hidden" id="send_date" value="<?php echo date("l, jS F Y, g:i:s a");?>"/></td>
</form>
	</table>
	 </div>
  <div class="col-md-1"></div>
          </div>
<?php
include "footer.html"
?>
</body>
</html>