<?php
require 'connection/dbconnection.php';
session_start();
	$id = $_SESSION['id'];
	//echo $id;
	$result = $dbCon->prepare("SELECT * FROM LogHistoryTable WHERE id = ?");
	$result->bind_param("i",$id);
	$result->execute();
	 $results = $result->get_result();
	if($results){
		$res = $results->fetch_assoc();
		$LoggedIn = $res['LoggedIn'];
		//echo $LoggedIn;
		$LoggedOut = $res['LoggedOut'];
		//echo $LoggedOut;
		date_default_timezone_set('America/Los_Angeles');
		$current_time = date('g:i:s');//This works for just no date
		$current_date = date('Y-m-d');
		$run_update = $dbCon->prepare("UPDATE LogHistoryTable SET LoggedOut = '$current_time',LogOutDate ='$current_date' where id = ?");
		$run_update->bind_param("i",$id);
		$run_update->execute(); 
		
		$run_Log = $dbCon->prepare("UPDATE `LogHistoryTable` SET `TotalTimeLoggedIn`= (SELECT TIMEDIFF( `LoggedOut` , `LoggedIn` ) ) WHERE id = ?");
		$run_Log->bind_param("i",$id);
		$run_Log->execute(); 

			if($run_Log){
				$change_status = $dbCon->prepare("UPDATE LogHistoryTable SET Status = 'Logged Out' where id = ?");
				$change_status->bind_param("i",$id);
				$change_status->execute(); 
				
				unset($_SESSION['id']);
				session_destroy();
				$mess= "Logged Out Successfully";
			}
			else{
				print "something went wrong with query";
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
    <title>Log Back In</title>
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
<body>
<br/>
<div class="container logged_out text-center">
<?php echo $mess;?>
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
							<br/>
							<p>Click <span><a href="reset_pw.php">Here</a></span> to Reset Password</p>
								<button type="button" id="show_password" class="btn btn-success" name="show_password">Show</button>
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
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>

