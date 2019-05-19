<?php
//file reset.php
//title:Build your own Forgot Password PHP Script
include "connection/dbconnection.php";
session_start();
$token=$_GET['token'];

if(!isset($_POST['new_pw'])){
	//
	$digit = 0;
	$sqlQuery = $dbCon->prepare("SELECT email from token where token= ? and used=?");
    $sqlQuery->bind_param("si",$token,$digit);
	$sqlQuery->execute();
  
		$sqlRes = $sqlQuery->get_result();

	//
//$q="SELECT email from token where token='".$token."' and used=0";
//$r=mysqli_query($dbCon,$q);
while($row = $sqlRes->fetch_assoc())
   {
$email=$row['email'];
   }
if ($email!=''){
          $_SESSION['email']=$email;
}
else{ 
die("Invalid link or Password already changed");
}
}
$pass=$_POST['new_pw'];
$email=$_SESSION['email'];
if(!isset($pass)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Reset PW</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" type="text/css" href="css/styling.css">
</head>
<body>
<br/>
<br/>
<div class="col-md-4"></div>
<div class="col-md-4">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="new_pw_label">New Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                                
								<input type="password" class="form-control" required="required" name="new_pw" id="new_pw" placeholder="Password">
								
							</div>
												
												<!--<br/>
							<div class="pw_error"></div>
							<div class="pw_bar"></div>
							<div class="characters"></div>
							<div class="missing"></div> -->
							<br/>
								<button type="button" class="btn btn-primary" id="show_password" name="show_password">Show</button>
						</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="submit" name="submit" id="" value ="Change Password" class="btn btn-success">
                                </div>
                            </div>
                    </form>
                </div>
        </div>
</div>
<div class="col-md-4"></div>
<script src="JS/jquery.js"></script> 
<script src="JS/peekaboo.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
if(isset($_POST['submit'])){
$pass=$_POST['new_pw'];
$new_pw =  password_hash($pass,PASSWORD_DEFAULT);
//echo $new_pw;
if(isset($_POST['submit'])&&isset($_SESSION['email']))
{
	//
	$UpdateAnswers = $dbCon->prepare("UPDATE room_mates_users_570 set Password='$new_pw' where Email= ?");
		$UpdateAnswers->bind_param("s",$email);
		$UpdateAnswers->execute(); 
	//
//$q="UPDATE room_mates_users_570 set Password='$new_pw' where Email='$email'";
//$r=mysqli_query($dbCon,$q);
if($UpdateAnswers){
	//
	$new_q = $dbCon->prepare("UPDATE token set used=1 where token= ?");
		$new_q->bind_param("s",$token);
		$new_q->execute(); 
	//

	if($new_q){
		header('Location:Reset_Success.php');
	}
}
else{
	echo "something went wrong contact Developer";
}
}
}
?>