<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
if(isset($_SESSION['id'])) {
	$session_id = $_SESSION['id'];
	
		$sqlQuery = $dbCon->prepare("SELECT FName,LName, UserName, Email,UserID, Type,Bio FROM room_mates_users_570 WHERE UserID = ?");
    $sqlQuery->bind_param("i",$session_id);
	$sqlQuery->execute();
 
		$sqlRes = $sqlQuery->get_result();
	$rows = $sqlRes->fetch_assoc();


	
	$userid = $rows['UserID'];
	$UN = $rows['UserName'];
	$sqlQuery->close();
	/**************/
		$run_select = $dbCon->prepare("SELECT Complete FROM Profile_Answers_570 where UserID = ?");
    $run_select->bind_param("i",$session_id);
	$run_select->execute();
 
		$run_rows = $run_select->get_result();
	$results = $run_rows->fetch_assoc();
	/************/

	$completed = $results["Complete"];
	
	if($completed == 0){
		$run_select->close();
		$msg = "Questionnaire must be completed to View other users";
	}
	else{
		$msg = "Questionnaire Completed!";
	}

	if(isset($_POST['submit'])){
	$Gender = $_POST['gender'];
//echo $Gender;
$Age = $_POST['age'];
//echo $Age;
$City = $_POST['city'];
//echo $City;
$State = $_POST['state'];
//echo $State;
$Housing_Type = $_POST['housing'];
//echo $Housing_Type;
$Cleanliness = $_POST['Cleanliness'];
//echo $Cleanliness;
$sleep_habit = $_POST['sleep_habits'];
//echo $sleep_habit;
$completed = 1;
//echo $completed;
$children = $_POST['children'];

$Faith = $_POST['Faith'];

$heat = $_POST['heat_prefences'];

$AC = $_POST['ac_prefence'];

$smoker = $_POST['smoking_habits'];

$Place = $_POST['Place'];

$pets = $_POST['pets'];

$Max_Rent = $_POST['Max_Rent'];

$occupation = $_POST['occupation'];

$Length_Stay = $_POST['Length_Stay'];

		/***********/
		$UpdateAnswers = $dbCon->prepare("UPDATE Profile_Answers_570 SET Complete = '$completed', Age = '$Age', State = '$State', City = '$City' , Housing_Type = '$Housing_Type' , Cleanliness = '$Cleanliness' ,Sleep_Habits = '$sleep_habit', Children ='$children',AC_Prefence = '$AC', Heat_Prefence = '$heat', Smoker = '$smoker' , PETS = '$pets', Length_Stay ='$Length_Stay' ,Place = '$Place', Max_Rent = '$Max_Rent',Occupation = '$occupation' , Faith = '$Faith' WHERE UserID = ?");
		$UpdateAnswers->bind_param("i",$session_id);
		$UpdateAnswers->execute(); 
		$UpdateAnswers->close();
		/*************/		
}

    if(isset($_POST['LogOut'])){
        header('Location:LogOut.php');
    }
}
else{
    header('Location: LogIn.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include "header.html";?>
</head>
<body onload="ViewResults()" style="background-color: #D6C7E2; overflow-y:scroll;">
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
			<li><a href="perfect-roommate-home-page.php">Home</a></li>
			<li class="active"><a href="questionnaire.php">Questionnaire</a></li>
			<li><a href="messages/pm_inbox.php">Messages</a></li>
			<li><a href="My-Perfect-Roommate-Profile.php" style="text-decoration:none;">Profile</a></li>
            <li><form action="questionnaire.php" method="post" style="margin-top:8px; margin-left:10px;"><button type="submit" class="btn btn-default" name="LogOut">Log Out</button></form></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br/>
<div class="container text-center"><h2>Hi! <span style="color:white;"><?php echo $UN;?></span></h2></div>
<br/>
<div class="container">
<p class="text-center"><span style="font-size:18px;">Note: </span><span style="color:white;"><?php echo $msg; ?></span>
</div>
<br/>
<p class="heading1 text-center">Questionnaire Profile</p>
<section id="questionnaire" class="container">
<br/>
<form method="post" action="questionnaire.php">

<div class="block1 container">
<div class="col-md-3">
<div class="text-center">
Faith
<br/>
<div class="form-group">
<input type="text" name="Faith" placeholder="(Optional)..." class="text-center"/>
</div>
</div>
</div>

<div class="col-md-3">
<div class="text-center">
Occupation <br/>
<select name="occupation" required="required" class="text-center">
<option value="Professional">Professional</option>
<option value="Student">Student</option>
<option value="Military">Military</option>
<option value="Retired">Retired</option>
</select>
</div> 
</div> 
<div class="col-md-3">
<div class="text-center">
Will Children be Present? <br/>
 <select name="children" required="required" class="text-center">
	<option value=""></option>
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
</div>
</div> 

<div class="col-md-3">
<div style="text-align:center;">Do you smoke?
<br/>
 <select name="smoking_habits" required="required" style="text-align:center;">
  <option value="" style="text-align:center;"></option>
  <option value="Yes" style="text-align:center;">Yes</option>
  <option value="No" style="text-align:center;">No</option>
   <option value="Trying to Quit" style="text-align:center;">Trying to Quit</option>
</select>
</div>
</div> 

</div>
<div class="block2 container">
<div class="col-md-3">
<div class="text-center">Max Rent Willing to Pay?
<br/>
(Only You) 
<br/>

<div class="form-group">
<span>$</span>
<input  type="text" name="Max_Rent" required="required" placeholder="Enter Max Rent..." class="text-center"/>
</div>
</div>
</div>



<div class="col-md-3">
<div class="text-center">Cleanliness Level <br/>
 <select name="Cleanliness" required="required" class="text-center">
  <option value="Messy">Messy</option>
  <option value="Average">Average</option>
  <option value="Clean">Clean</option>
</select>
</div> 
</div> 
<div class="col-md-3">
<div class="text-center">
Do you have pets? <br/>
<select name="pets" required="required" class="text-center">
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</div>
</div>
<div class="col-md-3">
<div class="text-center">
Planning to Stay <br/> with RoomMate
<br/>
<select id="Length_Stay" name="Length_Stay" required="required" class="text-center">
<option value="1 year or more"> 1 year or more </option>
<option value="12 months or less"> 12 months or less</option>
<option value="10 months or less"> 10 months or less</option>
<option value="8 months or less">8 months or less</option>
<option value="6 months or less">6 months or less</option>
<option value="4 months or less">4 months or less</option>
</select>
<option><br/>
</select>
</div>
</div>
</div>
<br/>
<div class="block3 container">
<div class="col-md-3">
<div class="text-center">
Do you have a place? <br/>
<select name="Place" required="required" class="text-center">
<option value="Yes">Yes </option>
<option value="No"> No </option>
</select>
</div>
</div>

<div class="col-md-3">
<div id="housing" class="text-center">
Housing Type <br/>
<select name="housing" required="required" class="text-center">
<option value="Apartment"> Apartment </option>
<option value="House"> House </option>
<option value="Condo"> Condo </option> 
<option value="TownHouse"> TownHouse </option> 
<option value="Mobile_Home"> Mobile Home </option>
<option value="Any"> Any </option>  
</select>
</div>
</div>

<div class="col-md-3">
<div class="text-center">
City <br/>
<input type="text" required="required" name="city" placeholder="Enter City..." class="text-center">
</div>
</div>
<div class="col-md-3">
<div class="text-center">
State <br/>
<select name="state" required="required" size="1" class="text-center">
  <option value="AK">AK</option>
  <option value="AL">AL</option>
  <option value="AR">AR</option>
  <option value="AZ">AZ</option>
  <option value="CA">CA</option>
  <option value="CO">CO</option>
  <option value="CT">CT</option>
  <option value="DC">DC</option>
  <option value="DE">DE</option>
  <option value="FL">FL</option>
  <option value="GA">GA</option>
  <option value="HI">HI</option>
  <option value="IA">IA</option>
  <option value="ID">ID</option>
  <option value="IL">IL</option>
  <option value="IN">IN</option>
  <option value="KS">KS</option>
  <option value="KY">KY</option>
  <option value="LA">LA</option>
  <option value="MA">MA</option>
  <option value="MD">MD</option>
  <option value="ME">ME</option>
  <option value="MI">MI</option>
  <option value="MN">MN</option>
  <option value="MO">MO</option>
  <option value="MS">MS</option>
  <option value="MT">MT</option>
  <option value="NC">NC</option>
  <option value="ND">ND</option>
  <option value="NE">NE</option>
  <option value="NH">NH</option>
  <option value="NJ">NJ</option>
  <option value="NM">NM</option>
  <option value="NV">NV</option>
  <option value="NY">NY</option>
  <option value="OH">OH</option>
  <option value="OK">OK</option>
  <option value="OR">OR</option>
  <option value="PA">PA</option>
  <option value="RI">RI</option>
  <option value="SC">SC</option>
  <option value="SD">SD</option>
  <option value="TN">TN</option>
  <option value="TX">TX</option>
  <option value="UT">UT</option>
  <option value="VA">VA</option>
  <option value="VT">VT</option>
  <option value="WA">WA</option>
  <option value="WI">WI</option>
  <option value="WV">WV</option>
  <option value="WY">WY</option>
</select>
</div>
</div>

</div>
<br/>
<div class="block4 container">
<div class="col-md-3">
<div class="text-center">
Central A/C Prefences
<br/>
<select name="ac_prefence" required="required" class="text-center">
<option> Always Used During the Summer</option>
<option> Sometimes Used in the Summer</option>
<option> Hardly Used in the Summer</option>
<option> Don't use at all! </option>
<option> Varies</option>
</select>
</div>
</div>

<div class="col-md-3">
<div class="text-center">
Sleeping Habits
<br/>
<select name="sleep_habits" required="required" class="text-center">
<option> Light Sleeper </option>
<option> Heavy Sleeper </option>
<option> Varies/Other </option>
</select>
</div>
</div>

<div class="col-md-3">
<div class="text-center">
Central Heater Prefences
<br/>
<select name="heat_prefences" required="required" class="text-center">
<option> Always Used During the Winter</option>
<option> Sometimes Used in the Winter</option>
<option> Hardly Used in the Summer</option>
<option> Don't use at all!</option>
<option> Varies</option>
</select>
</div>
</div>

<div class="col-md-3">
<div class="text-center">
Age <br/>
    <select name="age" required="required" id="age" class="text-center">
     <?php
	 $i = 18;
	 while ($i<99){
		?>
		 <option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php
		 $i++;
	 }
	  ?>
    </select>
</div>

</div>
</div>
<br/>
<div class="container">
<div class="text-center"><input type="submit" class="btn btn-success" style="font-size:24px; font-weigth:bold;background-color:#c9e9f6;color:#45b3e0;border:none;" name="submit" id="submit" value="Submit"></div></div>
</form>
<br/>
</section>
<br/>
<div class="container">
<div id="ViewResults">
</div>
</div>
<?php include "footer.html";?>

	<link href="FooTable/css/footable.core.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        if (!window.jQuery) { document.write('<script src="JS/jquery.js"><\/script>'); }
    </script>
    <script src="FooTable/js/footable.js" type="text/javascript"></script>
	<script>
    function ViewResults(){
        $.ajax({
            type: "GET",
            url: "RoomMate-Questionaire-Results.php"
        }).done(function( data ) {
            $('#ViewResults').html(data);
        });
    }
	</script>
</body>

</html>