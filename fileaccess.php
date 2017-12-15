<!DOCTYPE html>
<html>
<head>
<title>File Access</title>
</head>
<body>

<?php
	//To check how username has been provided (the destroy button send it via POST)
	// if username has not been provided, redirect to login
    if (isset($_GET['username'])){
        $username = $_GET['username'];
    } else if (isset($_POST['username'])){
        $username = $_POST['username'];
    } else{
	    header("Location: login.php");
        exit;
    }

    echo "Hello ".htmlentities($username)."!";?>
	<br/>
	<br/>
	Your files are:
	<?php
	// To list all  files in the user's folder
    $filearray = preg_grep('/^([^.])/', scandir("/mod2/$username/"));
    foreach ($filearray as $filename){
        echo htmlentities($filename)."\n";
    }
?>

<br/>
<br/>

<!-- View file form -->
<form action="viewfile.php" method="GET">
	<label>View file : <input type="text" name="filename" /></label>
	<input type="hidden" name="user" value="<?php echo htmlentities($username)?>"/>
	<input type="submit" value="view" />
</form>

<br/>

<!-- Upload file form (uploads form with data, not exceeding the prescibed value-->
<form enctype="multipart/form-data" action="uploadfile.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<input type="hidden" name="user" value="<?php echo htmlentities($username)?>"/>
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form>

<br/>
<br/>

<!-- Remove file form -->
<form action="rmfile.php" method="GET">
	<label>Delete file : <input type="text" name="filename" /></label>
	<input type="hidden" name="user" value="<?php echo htmlentities($username)?>"/>
	<input type="submit" value="delete" />
</form>

<br/>
<br/>

<!-- Remove file form -->
<form action="sharefile.php" method="GET">
        <label>File to share with another user : <input type="text" name="filename" /></label>
	    <label>Username to share with : <input type="text" name="friend" /></label>
        <input type="hidden" name="user" value="<?php echo htmlentities($username)?>"/>
        <input type="submit" value="share" />
</form>

<br/>
<br/>

Messages:

<?php
	// Server response to file upload
	if (isset($_GET['upload'])){
	    $upload = $_GET['upload'];
		if ($upload == "success"){
			echo "Successful file upload!";
		} else if ($upload == "failed"){
			echo "File did not upload :(";
		}
	}
?>

<?php
	// Server response to file delete
	if (isset($_GET['delete'])){
	    $delete = $_GET['delete'];
		if ($delete == "success"){
			echo "Successfully deleted file";
		} else if ($delete == "failed"){
			echo "File deletion failure. Check if file name was correctly entered.";
		}
	}
?>

<?php
	// Server response to file share
	if (isset($_GET['share'])){
	    $share = $_GET['share'];
		if ($share == "success"){
			echo "Successfully shared file";
		} else if ($share == "failed"){
			echo "File share failure. Check that target user does not already have the file.";
		}else if ($share == "nouser"){
			echo "File share failure. Check that target user was entered correctly.";
		}
	}
?>

<br/>
<br/>

<!-- Logout button -->
<form action="login.php">
	<input type="submit" value="Log out" />
</form>

<br/>

<!-- Delete account form -->
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="username" value="<?php echo htmlentities($username)?>"/>
	<input type="submit" name="destroybutton" value="Delete account"/>
</form>

<br/>
<br/>

<?php
	// Delete account confirmation
	if (isset($_POST['destroybutton'])){
	    echo "Are you absolutely sure? This will destroy your account and permanently delete ALL files.";
?>
		<!-- Delete account confirmation button -->
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<input type="hidden" name="username" value="<?php echo htmlentities($username)?>"/>
			<input type="submit" name="confirmdestroy" value="Destory my account"/>
		</form>
<?php
	}
	// Delete account response displays "Dwstroy account failed", if the account was not deleted.
	if (isset($_POST['confirmdestroy'])){
		if (!((deletefiles("/mod2/$username/")) === false)){ // Delete all files associated with user
			if ((rmuserlist($username))===true){ //Remove user from users.txt
				header("Location: login.php");
					exit;
			}
		}
		echo "Destroy account failed";
    }
	// Delete all files associated with user
	// code obtained from here http://stackoverflow.com/questions/1334398/how-to-delete-a-folder-with-contents-using-php
	function deletefiles($path){
    	if (is_dir($path) === true){
	        $files = array_diff(scandir($path), array('.', '..'));
	        foreach ($files as $file){
            deletefiles(realpath($path) . '/' . $file);
       	}
        	return rmdir($path);
    	}else if (is_file($path) === true){
        	return unlink($path);
    	}
   		return false;
	}

	// Remove user from users.txt
	// code modified from http://stackoverflow.com/questions/5712878/how-to-delete-a-line-from-the-file-with-php
	function rmuserlist($name){
		$rmsuccess = false;
		$contents = file_get_contents("/mod2/users.txt");
		if (!($contents === false)){
			$contents = str_replace($name, '', $contents);
			if (!($contents === false)){
				if (!((file_put_contents("/mod2/users.txt", $contents)) === false)){
					$rmsuccess = true;
				}
			}
		}
        return $rmsuccess;

}
?>


</body>
</html>
