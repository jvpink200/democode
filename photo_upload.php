<?php if(!empty($_FILES['file']['name'][0])){
		//echo "ok"; 

		$files = $_FILES['file'];
		
		$uploaded = array();
		$$succeeded = array();
		$failed = array();
		
		foreach($files['name'] as $position =>$file_name) {
			$file_tmp = $files['tmp_name'][$position];
			$file_size = $files['size'][$position];
			$file_error = $files['error'][$position];
			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end($file_ext));	
			
			$file_name_new = $file_name;
			$title = 'To be Added';
			$file_destination = 'profile_photos/' . $file_name_new;
			
			if(move_uploaded_file($file_tmp, $file_destination)){
				$uploaded[$position] = $file_destination;
				//echo "ok";
				$name = $file_name;
				date_default_timezone_set('America/Los_Angeles');
				$upload_date = date('Y-m-d');
				$upload_time = date('g:i:s');
				
				$id = $_SESSION['id'];
				//echo $id;
				$select = "SELECT * FROM room_mates_users_570 where UserID = '$id'";
				$run_sel = mysqli_query($dbCon,$select);
				$results = mysqli_fetch_assoc($run_sel);
				$User = $results['UserName'];
				$file_status = 'Active';
				//echo $User;
				//
				$insert = $dbCon->prepare("INSERT INTO Photo_Table (FileName,Uploaded_Date,Uploaded_Time, Uploaded_By,Uploaded_By_ID,File_Status) Values('$name','$upload_date','$upload_time','$User','$id','$file_status')");
	$insert->execute();
	

				//

				
				//$select = "SELECT * FROM Photo_Table WHERE FileName = '$name' && Uploaded_By_ID = '$id'";
				//$run_select = mysqli_query($dbCon,$select);
				
				//$results = mysqli_fetch_assoc($run_select);
				//$file_id = $results['FileID'];
				
				//$new_insert = "INSERT INTO DocsUploadedHistory (FileName,UploadedByID,UploadedBy,FileID,UploadedDate,UploadedTime) //Values('$name','$id','$User','$file_id','$upload_date','$upload_time')";
				//$run_new = mysqli_query($dbCon,$new_insert);
			}
		}
?>