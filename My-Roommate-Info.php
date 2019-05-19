<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connection/dbconnection.php';
session_start();
if(isset($_SESSION["UserID"])) {
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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<link type="text/css" rel="stylesheet" href="CSS/styling.css">
    <link href="CSS/jumbotron.css" type="text/css" rel="stylesheet">
<title>PerfectRoomMate HomePage</title>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/dist/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" href="CSS/styling.css" type="text/css">
</head>
<body onload="viewdata()" style="background-color: #D6C7E2">
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="navbar-brand" style="color:white; font-size:22px;">PerfectRoomMate</div>
        </div>
        <div id="navbar" class="navbar-collapse collapse" style="font-size:18px;">
		<div style="color:white;"><a href="perfect-roommate-home-page.php">Return To Home Page</a></div>
            <form class="navbar-form navbar-right" action="My-Roommate-Info.php" method="post">
                <div class="form-group">
                    <input type="submit" name="LogOut" Value="Log Out">
                </div>
            </form>
              <form class="navbar-form navbar-right">
                  <div class="form-group">
                      <a href="My-Perfect-Roommate-Profile.php"><input type="submit" name="Profile" Value="My Profile"></a>
                  </div>
              </form>
        </div>
        </div>
    </nav>
<br/>
<br/>
<br/>
<div class="container">
<input type="Radio" name="gender" value="Female" style="margin-right:5px;"> Female <br/>
<input type="Radio" name="gender" value="Male" style="margin-right:5px;"> Male <br/>
<br/>
<div>
Age: <br/>
<input type="text" required="required" name="Age" >
</div> 
<div>
Will Children be Present? <br/>
 <select>
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
</div> 
<div>
Do you currently smoke? <br/>
 <select name="smoking_habits">
  <option value="Yes">Yes</option>
  <option value="No">No</option>
</select>
</div> 

<div>
Cleanliness Level <br/>
 <select name="Cleanliness">
  <option value="Messy">Messy</option>
  <option value="Avg">Average</option>
  <option value="Clean">Clean</option>
</select>
</div> 
<div>
Do you have pets?
<select name="pets">
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</div>
<br/>
<div>
Occupation:
<select name="occupation">
<option value="Pro">Professional</option>
<option value="Student">Student</option>
<option value="Military">Military</option>
<option value="Retired">Retired</option>
</select>
</div>
<br/>
<div>
Location(s):
<input type="text" required="required" name="Location">
</div>
<div>
Do you have a place?
<select name="room">
<option value=""> <br/>
<option value="Yes">Yes <br/>
<option value="No"> No <br/>
</select>
</div>
<div id="available_housing">
Housing Type:
<br/>
<input type="Radio" name="housing" value="Apartment"> Apartment <br/>
<input type="Radio" name="housing" value="House"> House <br/>
<input type="Radio" name="housing" value="Condo"> Condo <br/>
<input type="Radio" name="housing" value="Condo"> TownHouse <br/>
</div>
<div>
Central A/C Prefences
<br/>
<select>
<option> Always On During the Summer
<option> Hardly Use in the Summer
<option> Don't use at all! <br/>
</select>
</div>
<div>
Central Heater Prefences
<br/>
<select>
<option> Always On During the Winter
<option> Hardly Used in the Winter
<option> Don't use at all!
</select>
</div>
<div>
Sleeping Habits
<br/>
<select>
<option> Light Sleeper <br/>
<option> Heavy Sleeper <br/>
<option> Varies/Other <br/>
</select>
</div>

<div>
Options
<br/>
<select>
<option> <br/>
<option><br/>
<option><br/>
</select>
</div>
Planning to Stay with RoomMate
<br/>
<select>
<option value="year"> 1 year or more <br/>
<option value="12_months"> 12 months or less<br/>
<option value="10_months"> 10 months or less<br/>
<option value="8_months">8 months or less<br/>
<option value="6_months">6 months or less<br/>
<option value="4_months or less">4 months or less<br/>
</select>
<option><br/>
</select>
</div>
</body>

</html>