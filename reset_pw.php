<?php
include "connection/dbconnection.php";
if(isset($_POST['reset'])){
	$username = $_POST['username'];
	//echo "reset was pressed";
$email=$_POST['email']; 
$sqlQuery = $dbCon->prepare("SELECT Email from room_mates_users_570 where Email= ?");
    $sqlQuery->bind_param("i",$email);
	$sqlQuery->execute();
	$sqlRes = $sqlQuery->get_result();
	$n=$sqlRes->num_rows;
//echo $n; //ok
if($n==0){
	echo "Email or UserID is not registered";
die();
} 

else{
	
$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
$run=$dbCon->prepare("INSERT INTO token (token,email) Values ('{$token}','{$email}')");
$run->execute();
if($run){
                $to=$email;
                $subject="Forgot Password";
                $from = 'janetv@investbook.us';
				$uri = 'http://'. $_SERVER['HTTP_HOST'] ;
                $body='<body>
<p>Click on the given link to reset your password <a href="'.$uri.'/reset.php?token='.$token.'">Reset Password</a></p>

</body>';
                $headers = "From: " . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
                if(mail($to,$subject,$body,$headers)){
				
				header('Location:ResetLinkSent.php');
				
				}
	}
}

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forgot Password</title>
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
<div class="container">
        <div class="row">
			<div class="col-md-4"></div>
            <div class="modal-content col-md-4">
                <div class="modal-body">
                    <div class="modal-header">
                        <h3>Enter Email to Reset Password</h3>
                    </div>
                    <form action="recover.php" method="post">

                        <div class="form-group">
                            <label for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                                
								<input type="email" class="form-control" required="required" name="email" id="email" placeholder="Enter Email">
								
							</div>
						</div>
                            <div class="form-group">
                                <div class="input-group">
            
                                    <input type="submit" name="reset" value ="Send Email" class="btn btn-success"/>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col-md-4"></div>
    </div>
</body>
</html>