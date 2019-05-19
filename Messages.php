<?php
require ("connection/dbconnection.php");
session_start();
//echo "<br/>At message Page";
$session_id = $_SESSION["id"];
//echo "<br/>My Session ID is: " . $session_id;

/****************/
  $sqlQuery = $dbCon->prepare("SELECT UserID,UserName FROM room_mates_users_570 where UserID = ?");
    $sqlQuery->bind_param("i",$session_id);
	$sqlQuery->execute();
	
	$sqlRes = $sqlQuery->get_result();
	$results = $sqlRes->fetch_assoc();
/****************/


$UserSender = $results['UserName'];
$userid = $results['UserID'];

//echo $UserSender;
/*********/
 $run_sel = $dbCon->prepare("SELECT UserName FROM room_mates_users_570 where UserID = ?");
    $run_sel->bind_param("i",$id);
	$run_sel->execute();
	
	$run_res = $run_sel->get_result();
	$rows = $run_res->fetch_assoc();
/**********/


$username = $rows['UserName'];
//echo $username;
//Check for New Messages
/**********/
$viewed = 0;
$query = $dbCon->prepare("SELECT COUNT(id) AS numbers FROM private_messages WHERE userid=? AND viewed= ?");
    $query->bind_param("ss",$session_id,$viewed);
	$query->execute();
	
	$run_q = $query->get_result();
	$result = $run_q->fetch_assoc();
/**********/
$inboxMessagesNew = $result['numbers'];

//check for messages inbox only
$inbox_query = $dbCon->prepare("SELECT COUNT(id) AS numbers FROM private_messages WHERE userid=?");
$inbox_query->bind_param("i",$session_id);
$inbox_query->execute();
$run_inbox = $inbox_query->get_result();
$inbox_res = $run_inbox->fetch_assoc();
$inboxMessagesTotal = $inbox_res['numbers'];

//check for messages outbox only
$outbox_query = $dbCon->prepare("SELECT COUNT(id) AS numbers FROM pm_outbox WHERE userid=?");
$outbox_query->bind_param("i",$session_id);
$outbox_query->execute();
$run_outbox = $outbox_query->get_result();
/*************/

$outbox_res = $run_outbox->fetch_assoc();
$outboxMessages = $outbox_res['numbers'];
?>
<?php if($_SESSION['id']){ ?>
Private Messages: <a href="pm_inbox.php">InBox</a> <?php if($inboxMessagesNew > 0 ) { print "<b>UnRead (".$inboxMessagesNew.")</b>";}
else {}	?> <?php echo $inboxMessagesTotal; ?>, <a href="pm_outbox.php">OutBox</a> <?php print $outboxMessages; ?>, <a href="pm_send.php">Send New Message</a>
<?php 
}
?>

