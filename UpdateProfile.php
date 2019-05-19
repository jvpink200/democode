<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
	$current_id = $_SESSION['id'];
	//echo "Your current id:" . $current_id;
	//echo $current_id;
	//$UN = $_POST['UN'];
	//echo $UN;
	$FN = $_POST['FN'];
	//echo $FN;
	$LN = $_POST['LN'];
	//echo $LN;
	
	$Bio = $_POST['Bio'];
	
	$PW = $_POST['PW'];

//
	$sqlQuery = $dbCon->prepare("SELECT FName,LName, UserName, Email,UserID, Type,Bio FROM room_mates_users_570 WHERE UserID = ?");
    $sqlQuery->bind_param("i",$current_id);
//

	if($sqlQuery->execute()){
		$sqlRes = $sqlQuery->get_result();
		//echo "success part 2";
	$rows = $sqlRes->fetch_assoc();
	$current_pw = $rows['Password'];
	//echo $current_pw;
	} 
	if($current_pw == $PW){
		//
		$update = $dbCon->prepare("UPDATE room_mates_users_570 SET FName = '$FN', Bio = '$Bio', LName='$LN' WHERE UserID= ?");
		$update->bind_param("i",$current_id);
		$update->execute(); 
		//
		if($update){
			//
			$update_History = $dbCon->prepare("UPDATE LogHistoryTable  SET FirstName ='$FN', LastName = '$LN' WHERE id = ?");
		$update_History->bind_param("i",$current_id);
		if($update_History->execute()){
			
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Updated!
</div>
<?php
			}
		}
	}
	
	else{
	//password was changed
	$encrypt_pw = password_hash($PW,PASSWORD_DEFAULT);
	//update query
	//
 $update_rm = $dbCon-> prepare("UPDATE room_mates_users_570 SET FName = '$FN', LName='$LN', Bio = '$Bio', Password = '$encrypt_pw' WHERE UserID = ?");
		$update_rm->bind_param("i",$current_id); 
	//

	if($update_rm->execute()){
		//
		 $update_H = $dbCon-> prepare("UPDATE LogHistoryTable SET FirstName ='$FN', LastName = '$LN' WHERE id = ?");
		$update_H->bind_param("i",$current_id); 
		//
		$update_H->execute();
		//echo "Success encrypt";
		//
		$newsql = $dbCon->prepare("SELECT * FROM room_mates_users_570 WHERE UserID = ?");
		$newsql->bind_param("i",$current_id);
		$newsql->execute(); 
		
		//
		
	if($newsql){
	$run_res = $newsql->get_result();
	$rows = $run_res->fetch_assoc();
	$hash_pw = $rows['Password'];
	//echo $hash_pw;
	$hash = password_verify($PW,$hash_pw);
	if($hash ==0){
		echo "something went wrong dont' want to see this";
	}
	else{
		//
		$sql_sel = $dbCon->prepare("SELECT * FROM room_mates_users_570 WHERE UserID = ? AND Password = ?");
		$sql_sel->bind_param("ss",$current_id,$hash_pw);
		$sql_sel->execute(); 
		//
		$sql_res = $sql_sel->get_result();
		if(!$row = $sql_res->fetch_assoc()){
			echo "Username and password don't match try again";
		}
		else{
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong> Updated! Please login with new Password on the next session.
</div>
<?php
						}
					}
				}	
			}
		}
?>
