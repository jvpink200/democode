<?php
include 'connection/dbconnection.php';
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$id = $_SESSION['id'];
$sqlQuery = $dbCon->prepare("SELECT * FROM room_mates_users_570");
	$sqlQuery->execute();
	$sqlQuery->store_result();
	
$row_cnt = $sqlQuery->num_rows;

	$sqlQuery->close();
	
?>
<p>The Total Number of Users: <span style="color:white;"><?php echo $row_cnt;?></span></p>
<br/>
<div class="form-control" style="padding-bottom:37px; background-color:#c9e9f6;color:#45b3e0;font-size:18px;">
<span>Find Your Perfect Roommate: </span><input type="text" style="padding-left:5px; padding-bottom:0px;font-weight:bold;" id="filter"/>
</div>
<br/>
<table class="footable table toggle-circle" style="background-color:white;border-radius:8px;" data-filter="#filter" data-filter-minimum="1" data-page-size="5" data-first-text="FIRST" data-next-text="NEXT" data-previous-text="PREVIOUS" data-last-text="LAST">   
    <thead>
    <tr>
        <th data-toggle="true">UserName</th>
        <th data-hide="phone">FirstName</th>
		<th data-hide="phone">Last Name</th>
        <th data-hide="tablet,phone">Location</th>
		<th data-hide="tablet,phone">Max Individual Rent</th>
        <th>Details</th>
    </tr>
    </thead>
    <tbody>
    <?php

		$new_sqlQuery = $dbCon->prepare("SELECT * FROM room_mates_users_570");

	$new_sqlQuery->execute();
	
	$sqlRes = $new_sqlQuery->get_result();
	$new_sqlQuery->close();
	
	$newsql = $dbCon->prepare("SELECT * FROM Profile_Answers_570");
$newsql->execute();
$sqlResults = $newsql->get_result();
//
$photos = $dbCon->prepare("SELECT * FROM photo_table_570");
$photos->execute();
$photo_res = $photos->get_result();

while ($row = $sqlRes->fetch_assoc()) {
	
$new_rows = $sqlResults->fetch_assoc();

	$all_photos = $photo_res->fetch_assoc();
        ?>
        <tr>
            <td><?php echo $row['UserName']; ?></td>
            <td><?php echo $row['FName']; ?></td>
			 <td><?php echo $row['LName']; ?></td>
			  <td><?php echo $new_rows['City'] . ', ' . $new_rows['State']; ?></td>
			 <td><?php echo $new_rows['Max_Rent']; ?></td>
           
            <td>
                <a style="background-color: teal; color:white;"class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['UserID']; ?>"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>
                <!-- Modal -->
                <div data-backdrop="false" class="modal fade-out text-center" id="myModal<?php echo $row['UserID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['UserID']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel<?php echo $row['UserID']; ?>">Extra Information</h4>
                            </div>
                            <div class="modal-body">
							<form action="contact_user.php" method="post">
                                    <div class="form-group">
                                        <label for="UserName">UserName: </label>
                                       <?php echo $row['UserName'];?>
                                    </div>
                                    <div class="form-group">
                                        <label for="UserName">FirstName: </label>
                                        <?php echo $row['FName']; ?>
                                     </div>
									 <div class="form-group">
                                        <label for="UserName">Age:</label>
										<?php echo $new_rows['Age']; //Everything was  wrong coming from new_rows?>
                                    </div>
                                    <div class="form-group">
                                        <label for="UserName">Extra Information</label>
                                        <?php echo $row['Bio']; ?>
										<br/>
										<br/>
										<table class="table table-bordered text-center"  style="background-color: white;">
    <thead>
	<tr>
		<th class="text-center">Faith</th>
		<th class="text-center">PETS</th>
		<th class="text-center">Occupation</th>
    </tr>
    </thead>
    <tbody>
        <tr>
			<td  class="text-center"><?php echo $new_rows['Faith']; ?></td>
			<td  class="text-center"><?php echo $new_rows['PETS']; ?></td>
			<td  class="text-center"><?php echo $new_rows['Occupation']; ?></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered text-center"  style="background-color: white;">
    <thead>
	<tr>
		<th  class="text-center">Children</th>
		<th  class="text-center">Smoke</th>
		<th  class="text-center">Central A/C Prefences</th>

    </tr>
    </thead>
    <tbody>
        <tr>
			<td  class="text-center"><?php echo $new_rows['Children']; ?></td>
			<td  class="text-center"><?php echo $new_rows['Smoker']; ?></td>
			<td  class="text-center"> <?php echo $new_rows['AC_Prefence']; ?></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered text-center"  style="background-color: white;">
    <thead>
	<tr>
		<th  class="text-center">Central Heat Prefences</th>
		<th class="text-center">Cleanliness Level</th>
		<th  class="text-center">Sleep Habits</th>	
    </tr>
    </thead>
    <tbody>
        <tr>
			<td  class="text-center"><?php echo $new_rows['Heat_Prefence']; ?></td>
			<td class="text-center"><?php echo $new_rows['Cleanliness']; ?></td>
			<td  class="text-center"><?php echo $new_rows['Sleep_Habits']; ?></td>
        </tr>
    </tbody>
</table>


                                    </div>
									
						
									<div class="form-group">
                                        <label for="Profile_Pic">Profile Pic </label>
										<br/>
										<img src="profile_photos/<?php echo $all_photos['Photo_Name']; ?>" alt="profile_pic" width="100" height="150"/>
                                    </div>
									
                                    <div class="form-group">
									
                                        <button type="submit" name="contact_user" value="<?php echo $row['UserID'];?>" style="background-color: #866ab3; color:white; font-size:22px;"class="btn btn-default">Contact</button>
									</div>
                                    </form>  
									
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </td>
			   <?php
    }
	
	//$newsql->close();
    ?>
        </tr>
     
	 </tbody>
	<tfoot>
				<td colspan="7">
					<div class="pagination"></div>
				</td>
	</tfoot>
   
</table>
		
   <script type="text/javascript">
	$(function () {
		$('.footable').footable();
		$('#change-page-size').change(function (e) {
						e.preventDefault();
						var pageSize = $(this).val();
						$('.footable').data('page-size', pageSize);
						$('.footable').trigger('footable_initialized');
					});

					$('#change-nav-size').change(function (e) {
						e.preventDefault();
						var navSize = $(this).val();
						$('.footable').data('limit-navigation', navSize);
						$('.footable').trigger('footable_initialized');
					});
					
					
	}); 
</script>
 
<script type="text/javascript">
	$(function () {
		$('#footable1').footable();
	});
</script>