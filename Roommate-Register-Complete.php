<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include ("connection/dbconnection.php");
if (isset($_POST['submit'])) {
   $uid = $_POST['UN'];
	$pwd = $_POST['PW'];
	
    $sqlQuery = $dbCon->prepare("select * from room_mates_users_570 where UserName = ?");
	$sqlQuery->bind_param("s",$uid);
	$sqlQuery->execute();
    $sqlResult = $sqlQuery->get_result();
				
	$res = $sqlResult->fetch_assoc();
     $current_password = $res['Password'];
	 $type = $res['Type'];
		//echo $current_password;
     if (password_verify($pwd, $current_password) && $type == 'User') { 
        $_SESSION['id'] = $res['UserID'];
		 $newid = $_SESSION['id'];
		 //echo $newid;
		date_default_timezone_set('America/Los_Angeles');
		$current_time = date('g:i:s');//This works for just no date
		$current_date = date('Y-m-d');
		//
		$HistoryTable = $dbCon->prepare("SELECT * FROM LogHistoryTable WHERE id = ?");
    $HistoryTable->bind_param("i",$newid);

		//

		if($HistoryTable->execute()){
			//
			$UpdateLog = $dbCon->prepare("UPDATE LogHistoryTable SET LoggedIn = '$current_date', LoggedInDate = '$current_date' WHERE id = ?");
		$UpdateLog->bind_param("i",$newid);
		$UpdateLog->execute(); 
			//
			//$updateLog = "UPDATE LogHistoryTable SET LoggedIn = '$current_date', LoggedInDate = '$current_date' WHERE id = '$newid'";
				//$update = mysqli_query($dbCon,$updateLog);
				if($UpdateLog){
					//
					$change_status = $dbCon->prepare("UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = ?");
		$change_status->bind_param("i",$newid);
		$change_status->execute(); 
					//
				//$change_status = "UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = '$newid'";
				//$run_change = mysqli_query($dbCon,$change_status);
				 header('Location:perfect-roommate-home-page.php');
				}
				
				else {
					echo "Login Was not updated";
				}
			}
			else{
				echo "Something went wrong with query";
				
				}     
    }
	/*
	elseif(password_verify($pwd, $current_password) && $type == 'SuperAdmin'){
		 $_SESSION['id'] = $res['id'];
		 $newid = $_SESSION['id'];
		 //echo $newid;
		date_default_timezone_set('America/Los_Angeles');
		$current_date = date('Y-m-d');
		$current_time = date('g:i:s');//This works for just no date
		$HistoryTable = "SELECT * FROM LogHistoryTable WHERE id = '$newid'";
		$select = mysqli_query($dbCon,$HistoryTable);
		if($select){
			$updateLog = "UPDATE LogHistoryTable SET LoggedIn = '$current_time',LoggedInDate = '$current_date' WHERE id = '$newid'";
				$update = mysqli_query($dbCon,$updateLog);
				if($update){
				$change_status = "UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = '$newid'";
				$run_change = mysqli_query($dbCon,$change_status);
					echo "Success Update";
				}
				
				else {
					echo "Nothing was updated";
				}
			}
			else{
				echo "Something went wrong with query";			
				}	
		} 
	 elseif(password_verify($pwd, $current_password) && $type == 'Admin'){
		 $_SESSION['id'] = $res['id'];
		 $newid = $_SESSION['id'];
		 //echo $newid;
		date_default_timezone_set('America/Los_Angeles');
		$current_date = date('Y-m-d');
		$current_time = date('g:i:s');//This works for just no date
		$HistoryTable = "SELECT * FROM LogHistoryTable WHERE id = '$newid'";
		$select = mysqli_query($dbCon,$HistoryTable);
		if($select){
			$updateLog = "UPDATE LogHistoryTable SET LoggedIn = '$current_time', LoggedInDate = '$current_date' WHERE id = '$newid'";
				$update = mysqli_query($dbCon,$updateLog);
				if($update){
				$change_status = "UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = '$newid'";
				$run_change = mysqli_query($dbCon,$change_status);
				 header('Location:Admin.php');
				}
				
				else {
					echo "Nothing was updated";
				}
			}
			else{
				echo "Something went wrong with the query";			
				}	
		}*/
     else { 
        /* If Invalid password Entered */
        echo "Password Was Not Correct";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Log In</title>
    <!-- Bootstrap -->
    <link type="text/css" href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link type="text/css" href="bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: lightskyblue;">
<br/>
<div class="container text-center" style="font-size:24px; color:white;">
You have Successfully Registered Please Login Below. 
</div>
<br/>
<br/>
<br/>
<div>
    <div class="container">
        <div class="row">
			<div class="col-md-4"></div>
            <div class="modal-content col-md-4">
                <div class="modal-body">
                    <div class="modal-header">
                        <h3>Login Area</h3>
                    </div>
                    <form action="LogIn.php" method="post">
                        <div class="form-group">

                            <label for="UserName">UserName</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" class="form-control" name="UN" required="required" placeholder="UserName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                                
								<input type="password" class="form-control" required="required" name="PW" id="password" placeholder="Password">
							</div>
							<p>Click <span><a href="reset_pw.php">Here</a></span> to Reset Password</p>
								<button type="button" class="btn btn-success" id="show_password" name="show_password">Show</button>
						</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="glyphicon glyphicon-lock"></span>
                                    <input type="submit" name="submit" value ="Log In" class="btn btn-primary" style="margin-left:5px;">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col-md-4"></div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="JS/jquery.js"></script>
<script src="JS/peekaboo2.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>
