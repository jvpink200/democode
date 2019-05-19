<?php
include 'connection/dbconnection.php';
session_start();
$id = $_SESSION['id'];
?>
<br/>
<p class="questionnaire text-center">Questionnaire Results</p>
<table class="footable table table-bordered text-center"  style="background-color: white; margin-bottom:10%;">
    <thead>  
    <tr>
        <th data-toggle="true" class="text-center">UserName</th>
        <th data-hide="phone" class="text-center">FirstName</th>
		<th data-hide="tablet,phone"class="text-center">Location</th>
		<th data-hide="tablet,phone" class="text-center">Faith</th>
		<th data-hide="tablet,phone" class="text-center">PETS</th>
		<th data-hide="tablet,phone" class="text-center">Occupation</th>
		<th data-hide="phone"class="text-center">OWN Place & Housing Type</th>
		<th data-hide="all">Children</th>
		<th data-hide="all">Smoker</th>
		<th data-hide="all">Max Rent</th>		
		<th data-hide="all">Age</th>
		<th data-hide="all">Central A/C Prefences</th>
		<th data-hide="all">Central Heat Prefences</th>
		<th data-hide="all">Cleanliness Level</th>
		<th data-hide="all">Sleep Habits</th>
		
    </tr>
    </thead>
    <tbody>
 <?php
 
 /*********/
 $select = $dbCon->prepare("SELECT * FROM room_mates_users_570 where UserID = ?");
    $select->bind_param("i",$id);
	$select->execute();
 
		$sel_res= $select->get_result();
 /********/

while ($rows_sel = $sel_res->fetch_assoc()) {
	
	/********/
	 $select = $dbCon->prepare("SELECT * FROM Profile_Answers_570 WHERE UserID =?");
    $select->bind_param("i",$id);
	$select->execute();
 
		$query_res= $select->get_result();
	/********/

	$results = $query_res->fetch_assoc();
        ?>
        <tr>
            <td><?php echo $rows_sel['UserName']; ?></td>
            <td><?php echo $rows_sel['FName']; ?></td>
			<td><?php echo $results['City']; ?>,<?php echo $results['State'];?></td>
			<td><?php echo $results['Faith']; ?></td>
			<td><?php echo $results['PETS']; ?></td>
			<td><?php echo $results['Occupation']; ?></td>
			<td><?php echo $results['Place']; ?>,<span style="padding-left:10px;"><?php echo $results['Housing_Type']?></span></td>
			<td><?php echo $results['Children']; ?></td>
			<td><?php echo $results['Smoker']; ?></td>
			<td><?php echo $results['Max_Rent']; ?></td>
			
			<td><?php echo $results['Age']; ?></td>
			<td><?php echo $results['AC_Prefence']; ?></td>
			<td><?php echo $results['Heat_Prefence']; ?></td>
			<td><?php echo $results['Cleanliness']; ?></td>
			<td><?php echo $results['Sleep_Habits']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>