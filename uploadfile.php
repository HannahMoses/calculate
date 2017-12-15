<!-- uploadfile.php -->
<!-- Uploads file to user's directory -->

<?php

	// Get the filename and make sure it is valid
	$filename = basename($_FILES['uploadedfile']['name']);
	if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
		echo "Invalid filename";
		exit;
	}

	// Get the username and make sure it is valid
	$username = $_POST['user'];
	if( !preg_match('/^[\w_\-]+$/', $username) ){
		echo "Invalid username";
		exit;
	}

	$full_path = sprintf("/mod2/%s/%s", $username, $filename);

	if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
		header("Location: fileaccess.php?username=$username&upload=success"); // success response
		exit;
	}else{
		header("Location: fileaccess.php?username=$username&upload=failed"); // failure response
		exit;
	}

?>
