<!-- rmfile.php -->
<!-- removes file from user's directory -->

<?php

# The same stuff and script, provided from the wiki for checking file name and username validity

if (isset($_GET['filename']) && isset($_GET['user'])){
    $filename = $_GET['filename'];

    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
    	echo "Invalid filename";
	    exit;
    }

    // Get the username and make sure, that it is alphanumeric with limited other characters.
    // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check,
    // since we will be concatenating the string to load files from the filesystem.
    $username = $_GET['user'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
	    echo "Invalid username";
	    exit;
    }

    $full_path = sprintf("/mod2/%s/%s", $username, $filename);

    // delete the file at that path
    // redirect to fileaccess and specify success
    if(unlink($full_path)){
        header("Location: fileaccess.php?username=$username&delete=success");
        exit;
    }else{
        header("Location: fileaccess.php?username=$username&delete=failed");
        exit;
    }

}

?>
