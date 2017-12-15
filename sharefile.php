<!-- sharefile.php -->
<!-- copies file to target user's directory -->

<?php

# same stuff and script provided from the wiki for checking file name and username validity

if (isset($_GET['filename']) && isset($_GET['user']) && isset($_GET['friend'])){
    $filename = $_GET['filename'];

    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
    	echo "Invalid filename";
	    exit;
    }

    // Get the username and make sure that it is alphanumeric with limited other characters.
    // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
    // since we will be concatenating the string to load files from the filesystem.
    $username = $_GET['user'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
	    echo "Invalid username";
	    exit;
    }

    $friend = $_GET['friend'];
    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $friend) ){
    	echo "Invalid target user";
	    exit;
    }

    if (!file_exists("/mod2/$friend")){ // check if target user even exists
	    header("Location: fileaccess.php?username=$username&share=nouser");
        exit;
    } else if(file_exists("/mod2/$friend/$filename")){ // check that target user does not have a file with the same name (copy function overwrites)
	    header("Location: fileaccess.php?username=$username&share=failed");
        exit;
    } else if (copy("/mod2/$username/$filename","/mod2/$friend/$filename")){ // copy and check for success
	    header("Location: fileaccess.php?username=$username&share=success");
        exit;
    }
    else{ // for all other failures
    	header("Location: fileaccess.php?username=$username&share=failed");
        exit;
    }

}

?>
