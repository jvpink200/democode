<?php
include 'connection/dbconnection.php';
session_start();
$id = $_SESSION['id'];
?>

<table class="footable table table-bordered"  style="background-color: white;">
    <thead>
    <tr>
        <th data-toggle="true">UserName</th>
        <th data-hide="phone">FirstName</th>
		<th data-hide="tablet,phone">Last Name</th>
		<th data-hide="tablet,phone">Location</th>
		<th data-hide="tablet,phone">Details</th>
        <th>Edit Details</th>
    </tr>
    </thead>
    <tbody>
 <?php
 //
 $sqlQuery = $dbCon->prepare("SELECT * FROM room_mates_users_570 where UserID = ?");
    $sqlQuery->bind_param("i",$id);
	$sqlQuery->execute();
	
	$sqlRes = $sqlQuery->get_result();
	//$res = $sqlRes->fetch_assoc();
 //

while ($row = $sqlRes->fetch_assoc()) {
	//
	 $location = $dbCon->prepare("SELECT City, State FROM Profile_Answers_570 WHERE UserID = ?");
    $location->bind_param("i",$id);
	$location->execute();
	
	$sqlRes = $location->get_result();
	//
	
	$results = $sqlRes->fetch_assoc();
        ?>
        <tr>
            <td><?php echo $row['UserName']; ?></td>
            <td><?php echo $row['FName']; ?></td>
			<td><?php echo $row['LName']; ?></td>
			<td><?php echo $results['City']; ?>,<?php echo $results['State'];?></td>
			<td><?php echo $row['Bio']; ?></td>
            <td>
                <a style="background-color: teal; color:white;"class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['UserID']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                <!-- Modal -->
                <div data-backdrop="false" class="modal fade-out" id="myModal<?php echo $row['UserID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['UserID']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel<?php echo $row['UserID']; ?>">Details</h4>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label for="UserName">UserName: </label>
										<?php echo $row['UserName']; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="FirstName">First Name</label>
										<input type="text" class="form-control" 
										id="FirstName<?php echo $row['id']; ?>" value="<?php echo $row['FName']; ?>"/>
                                     </div>
									 
									<div class="form-group">
                                        <label for="LastName">Last Name</label>
										<input type="text" class="form-control" 
										id="LastName<?php echo $row['id']; ?>" value="<?php echo $row['LName']; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label for="Bio">Details</label>
										<input type="text" class="form-control" id="Bio<?php echo $row['id']; ?>" value="<?php echo $row['Bio']; ?>"/>
                                    </div>
									
									 <div class="form-group">
                                        <label for="PW">PW</label>
										<input type="text" class="form-control" id="PW<?php echo $row['id']; ?>" value="<?php echo $row['Password']; ?>"/>
                                    </div>
                            </div>
                            <div class="modal-footer">
								 <button type="button" id="save" onclick="profile_update('<?php echo $row['id']; ?>')" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </td>
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