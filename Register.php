<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'connection/dbconnection.php';
if(isset($_POST['Register'])){
		//echo "success part 1";
session_start();
				$FN = $_POST['FN'];
		$LN = $_POST['LN'];
		$UN = $_POST['UN'];
		//echo $UN;
		$PW = $_POST['PW'];
		$Email = $_POST['Email'];
		$Type = 'User';
		date_default_timezone_set('America/Los_Angeles');
		$current_date = date("Y-m-d");
		
		$stmt = $dbCon->prepare("SELECT UserName,Email FROM room_mates_users_570 WHERE UserName =?");
		 $stmt->bind_param("s",$UN);
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		$row = $result->fetch_assoc();
			$dbUN = $row['UserName'];
			$dbEmail = $row['Email'];
			echo "<br/>DB Email".$dbEmail;
		if($UN == $dbUN){
			//echo "Sorry UserName Already Exists";
			if($Email == $dbEmail){
				echo "An Account Registered to: ".$dbEmail." Already Exists Please Log In";
			}
		}
		
		elseif($Email == $dbEmail){
			echo "EMAIL ALREADY EXISTS Please Log In";
		}
		
	elseif($Email != $dbEmail && $UN !=$dbUN){
			$status = 'New';
				$Type = 'User'; 
					//encrypt password here using bcrypt		
					$encrypt_pw = password_hash($PW,PASSWORD_DEFAULT);
					$insert_rm = $dbCon->prepare("INSERT INTO room_mates_users_570(FName,LName,Password,UserName,Type,Email) Values (?,?,?,?,?,?)");
					if($insert_rm){
						//echo "success";
					}
					else{
						echo "somethings wrong here";
					}
					$insert_rm->bind_param("ssssss",$FN,$LN,$encrypt_pw,$UN,$Type,$Email);
					$insert_rm->execute();	 
						if ($insert_rm) {
							//echo "success insert_rm<br/>";
						$select = $dbCon->prepare("SELECT UserID,FName,LName,UserName,Email FROM room_mates_users_570 WHERE UserName = ?");
						$select->bind_param("s",$UN);
						$select->execute();
						
						$select_rows = $select->get_result();
				
				$rows = $select_rows->fetch_assoc();
						
						$id = $rows['UserID'];
						//echo $id;
						$FirstName = $rows['FName'];
						$LastName = $rows['LName'];
						$UserName = $rows['UserName'];
						$dbID = $rows['UserID'];
						$log_status = "New";
						$LHT_insert = $dbCon->prepare("INSERT INTO LogHistoryTable (id,FirstName,LastName,UserName,Status) Values(?,?,?,?,?)");
						$LHT_insert->bind_param("issss",$id,$FirstName,$LastName,$UserName,$log_status);
						$LHT_insert->execute();
						if($LHT_insert){
							//echo "success LHT_insert <br/>";
							$questionaire = $dbCon->prepare("INSERT INTO Profile_Answers_570 (UserID) Values(?)");
							$questionaire->bind_param("i",$id);
							$questionaire->execute();							
							if($questionaire){
								$questionaire->close();
							//echo "success profile answered id inserted";
									}
								} 
								
					if($query = $dbCon->prepare("INSERT INTO Purchase_History_570 (Purchase_Date,UserName,Email,amt_paid_570,num_access_days_570,UserID,token) Values(?,?,?,?,?,?,?)")){
							$query ->bind_param("sssdsis",$current_date, $UN,$Email,$actual_amt_485,$num_days_485,$id,$paypal_token);
							$query->execute();
							$query->close();
							//echo "success";
					}
					else{
						echo "Something went wrong Contact Support please.";
					} 
						}
						
											$target_dir="profile_photos/";
	$target_file=$target_dir.basename($_FILES['img']['name']);
	$imgType=pathinfo($target_file,PATHINFO_EXTENSION);
	$imgSize=$_FILES['img']['size']/1024; //size in kb
	$check=getimagesize($_FILES['img']['tmp_name']);
	$uploadOk=1;
	$new_msg='';
	if($check!==false)
	{
		$uploadOk=1;
	}
	else
	{
		$new_msg .= "file is not image";
		$uploadOk=0;
	}
	
	if($imgSize>500)
	{
		$new_msg .="image size exceeds.....";
		$uploadOk=0;
	}
	
	if($imgType!="jpg" && $imgType!="jpeg" && $imgType!="gif" && $imgType!="png")
	{
		$new_msg.="please check image type..";
		$uploadOk=0;
	}
	
	if(!$uploadOk==0)
	{
		if(!move_uploaded_file($_FILES['img']['tmp_name'],$target_file))
		{
			$new_msg.="error in uploading image..";
		}
		else
		{
			date_default_timezone_set('America/Los_Angeles');
		$current_date = date("Y-m-d");
		$upload_time = date('g:i:s');
		$file_name = $_FILES['img']['name'];
		$File_Status = "New Profile Pic";
			$insert_image = $dbCon->prepare("INSERT INTO photo_table_570(Photo_Name,Uploaded_Date,Uploaded_Time,File_Status,UserName,size,UploadedByID) Values(?,?,?,?,?,?,?)");
				
				$insert_image ->bind_param("ssssssi",$file_name,$current_date,$upload_time,$File_Status,$UserName,$imgSize,$dbID);
				$insert_image->execute();
			//$insert_image->bind_param("ssssiss",$file_name,$file_size,$current_date,$current_time,$dbID,$dbUN,$File_Status);
			//$insert_image->execute();
			if($insert_image)
			{
				//echo "DB ID:".$dbID;
				//header('Location:Roommate-Register-Complete.php');
			}
			else
				{
					echo 'error in sql query';
				}
			}
		}
	}
	else{
		echo "Something Went Wrong Contact Support";
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
    <title>Register Page</title>

    <!-- Bootstrap -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: #5bc0de;">
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-default" style="margin-top:15%;">
                <div class="panel-body" style="background-color: #a6e1ec;">
                    <div class="page-header" style="margin-top:5px;">
                        <h3 class="text-center">Register Form</h3>
                    </div>
                    <form class="form-horizontal" action="Register.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white;"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" required="required" class="form-control" name="FN" id="FN" value="<?php echo $FN;?>" placeholder="Enter First Name">
                                </div>
                            </div>
							<div class="col-sm-1"></div>
                        </div>
                        <div class="form-group">
                            <label for="LastName" class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: #5bc0de;"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" required="required" class="form-control" name="LN" id="LN" value="<?php echo $LN;?>" placeholder="Enter Last Name">
                                </div>
                            </div>
							<div class="col-sm-1"></div>
                        </div>
                        <div class="form-group">
                            <label for="Email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white;">@</span>
                                    <input type="email" required="required" class="form-control" name="Email" value="<?php echo $Email;?>"id="Email" placeholder="Enter Email">				
                                </div>
								<span style="color:white;font-size:18px;"><?php echo $msg;?></span>
                            </div>
							<div class="col-sm-1"></div>
                        </div>
                        <div class="form-group">
                            <label for="Password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: #5bc0de;"><span class="glyphicon glyphicon-star"></span></span>
                                    <input type="password" required="required" class="form-control" name="PW" id="PW" placeholder="Enter Password">
                                </div>
                            </div>
							<div class="col-sm-1"></div>
                        </div>
                        <div class="form-group">
                            <label for="UserName" class="col-sm-3 control-label">UserName</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white;"><span class="glyphicon glyphicon-flash"></span></span>
                                    <input type="text" required="required" class="form-control" name="UN" id="UN" value="<?php echo $UN;?>" placeholder="Enter UserName">
								</div>
								 <div style="color:white;font-size:18px;"><?php echo $msg2;?></div>
                            </div>
							<div class="col-sm-1"></div>
                        </div>
						<div class="form-group">
							<label for="img" class="col-sm-3 control-label">Profile Pic</label>
							<div class="col-sm-8">
								<div class="input-group">	
									<input type="file" name="img" required="required" />
									<span style="color:white;font-size:18px;"><?php echo $new_msg; ?></span>
								</div>
							</div>
							<div class="col-sm-1"></div>
						</div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <input type="submit" name="Register" style="background-color: #5bc0de; color:white; font-size:18px;" class="btn"  id="Register" value="Register"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="bootstrap/dist/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/dist/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
