<?php
include 'connection/dbconnection.php';

if(isset($_POST['bt-upload']))
{
	$target_dir="profile_photos/";
	$target_file=$target_dir.basename($_FILES['img']['name']);
	$imgType=pathinfo($target_file,PATHINFO_EXTENSION);
	$imgSize=$_FILES['img']['size']/1024; //size in kb
	$check=getimagesize($_FILES['img']['tmp_name']);
	$uploadOk=1;
	$msg='';
	if($check!==false)
	{
		$uploadOk=1;
	}
	else
	{
		$msg .= "file is not image";
		$uploadOk=0;
	}
	
	if($imgSize>500)
	{
		$msg .="image size exceeds.....";
		$uploadOk=0;
	}
	
	if($imgType!="jpg" && $imgType!="jpeg" && $imgType!="gif" && $imgType!="png")
	{
		$msg.="please check image type..";
		$uploadOk=0;
	}
	
	if(!$uploadOk==0)
	{
		if(!move_uploaded_file($_FILES['img']['tmp_name'],$target_file))
		{
			$msg.="error in uploading image..";
		}
		else
		{
			date_default_timezone_set('America/Los_Angeles');
		$current_date = date("Y-m-d");
		$upload_time = date('g:i:s');
			$insert=mysqli_query($dbCon,"INSERT INTO photo_table_570(Photo_Name,size,Uploaded_Date,Uploaded_Time) VALUES ('".$_FILES['img']['name']."','".$imgSize."','$current_date','$upload_time')");
			if($insert)
			{
			?>
			<script>alert('image uploaded successfully..');</script>
			<?php
			}
			else
			{
				echo 'error in sql query';
			}
		}
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Simple Image Upload in Php with Database</title>
</head>

<body>
<center>
<h2>Image Upload in PHP</h2>
<span style="color:#FF0000"><?php echo isset($msg)? $msg:''; ?></span>
<form method="post" enctype="multipart/form-data">

Select Image: <input type="file" name="img" /><br /><br />
<input type="submit" name="bt-upload" value="Upload" />

</form>
</center>

Uploaded Images:::<br /><br />
<?php

$query="SELECT * FROM photo_table_570";
$run = mysqli_query($dbCon,$query);

	while($result=mysqli_fetch_array($run))
	{
		?>
		<img src="profile_photos/<?php echo $result['Photo_Name']; ?>" height="150px" height="150px" alt="<?php echo $result['Photo_Name']; ?>" />
		<?php
	}


?>

</body>
</html>
