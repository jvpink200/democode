<?php
error_reporting(E_ALL & ~E_NOTICE);
include ("connection/dbconnection.php");
if ($_POST['LogIn']) {
	session_start();
	$uid = $_POST['UN'];
	$pwd = $_POST['PW'];
	
    $sqlQuery = $dbCon->prepare("select * from room_mates_users_570 where UserName = ?");
    $sqlQuery->bind_param("s",$uid);
	$sqlQuery->execute();
	
	$sqlRes = $sqlQuery->get_result();
	$res = $sqlRes->fetch_assoc();
     $current_password = $res['Password'];
	 $type = $res['Type'];
	 $sqlQuery->close();
		//echo $current_password;
     if (password_verify($pwd, $current_password) && $type == 'User') { 
        $_SESSION['id'] = $res['UserID'];
		 $newid = $_SESSION['id'];
		 //echo $newid;
		date_default_timezone_set('America/Los_Angeles');
		$current_time = date('g:i:s');//This works for just no date
			
		$HistoryTable = $dbCon->prepare("SELECT * FROM LogHistoryTable WHERE id = ?");
		$HistoryTable->bind_param("i",$newid);
		$HistoryTable->execute(); 
		$select = $HistoryTable->get_result();
		
		if($select){
		$HistoryTable->close();
		$UpdateLog = $dbCon->prepare("UPDATE LogHistoryTable SET LoggedIn = ? WHERE id = ?");
		$UpdateLog->bind_param("si",$current_time,$newid);
		$UpdateLog->execute(); 
				if($UpdateLog){
		$UpdateLog->close();
				$change_status = $dbCon->prepare("UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = ?");
				$change_status->bind_param("i",$newid);
				$change_status->execute();
				if($change_status){
					$change_status->close();
				header('Location:perfect-roommate-home-page.php');
					}
					else{
						echo "Please Contact Support";
					}
				}
				
				else {
					echo "Please Contact Support Sorry Something Went Wrong";
				}
			}
			else{
				echo "Sorry, Something Went Wrong Please Contact Support";				
				}     
    }
	 elseif(password_verify($pwd, $current_password) && $type == 'Admin'){
		 $_SESSION['id'] = $res['UserID'];
		 $newid = $_SESSION['id'];
		 //echo $newid;
		date_default_timezone_set('America/Los_Angeles');
		$current_time = date('g:i:s');//This works for just no date
			
		$HistoryTable = $dbCon->prepare("SELECT * FROM LogHistoryTable WHERE id = ?");
		$HistoryTable->bind_param("i",$newid);
		$HistoryTable->execute(); 
		$select = $HistoryTable->get_result();
		
		if($select){
		$select->close();
		$UpdateLog = $dbCon->prepare("UPDATE LogHistoryTable SET LoggedIn = ? WHERE id = ?");
		$UpdateLog->bind_param("si",$current_time,$newid);
		$UpdateLog->execute(); 
				if($UpdateLog){
					$UpdateLog->close();
				$change_status = $dbCon->prepare("UPDATE LogHistoryTable SET Status = 'Currently Logged In' where id = ?");
				$change_status->bind_param("i",$newid);
				$change_status->execute();
				if($change_status){
				header('Location:Admin.php');
					}
					else{
						echo "Please Contact Support";
					}
				}
				
				else {
					echo "Please Contact Support Sorry Something Went Wrong";
				}
			}
			else{
				echo "Sorry, Something Went Wrong Please Contact Support";				
				}  
		}
     else { 
        /* If Invalid password Entered */
       
?>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
<br/>
<p class="text-center">Password Was Incorrect</p>
			<p class="text-center"><a href="recover.php">Click Here to Reset Password</a></p>
</div>
<?php
    }

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
          <div class="navbar-brand" style="color:white;font-size:24px;">PerfectRoomMate</div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="index.php" method="post">
            <div class="form-group">
              <input type="text" placeholder="UserName" name="UN" class="form-control" Value="<?php echo $uid;?>">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" name="PW" class="form-control" Value="<?php echo $pwd;?>">
            </div>
              <input type="submit" name="LogIn"  value ="Log In" class="btn btn-success"/>
          </form>
            <div style="color:white;font-size:18px; margin-left:37%;"><?php echo $message?></div>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!--Main Section-->
    <div class="main_section">
	<div class="container text-center">
	<div class="img_style"><div class="col-md-2"></div><div class="text_block col-md-8">Helping You Find the Perfect Roommate!</div><div class="col-md-2"></div></div>
	</div>
    </div>

<div class="container text-center all_plans">
      <!-- Example row of columns -->
	  <p class="plans_heading">MemberShip Plans & Pricing</p>	  
        <div class="col-md-3">
		<div class="skyblue_block">
		 <div class="white_block">
          <p class="column_headings">Get Access For <b>7</b> Days</p>
		  <p class="pricing_style">$1.95</p>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="KPVX2PVNL3YAE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
 
		 </div>
        </div>
		</div>

        <div class="col-md-3">
		<div class="skyblue_block">
		  <div class="white_block">
          <p class="column_headings">Get Access for <b>14</b> Days </p>
		  <p class="pricing_style"> $2.95</p>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GR3WPRAWDGEDC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

		  </div>
		</div>
       </div> 
	   
        <div class="col-md-3">
		<div class="skyblue_block">
		<div class="white_block">
          <p class="column_headings">Get Access for <b>30</b> Days</p>
          <p class="pricing_style">$4.95</p>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GR3WPRAWDGEDC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		</div>
		</div>
        </div>
		
		 <div class="col-md-3">
		<div class="skyblue_block last_block">
		<div class="white_block">
          <p class="column_headings">Get Access for <b>365</b> Days</p>
          <p class="pricing_style">$9.95</p>
		  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GR3WPRAWDGEDC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		</div>
		</div>
		
        </div>
		 <div class="text-center change_price">*Introductory Pricing Subject to Change*</div> 
		</div>
	<?php include "footer.html" ?>
  </body>
</html>
