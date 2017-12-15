<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
</head>
<body>

Create an account

<br/>

<!-- Send username to self to run script below -->
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
	<label>Enter a user Name: <input type="text" name="newuser" /></label>
	<input type="submit" value="Create account" />
</form>

<!-- Script to create user -->
<?php
    // check if create user button has been pressed
    // check that username is valid
    if (isset($_POST['newuser'])){
        $username = $_POST['newuser'];
        if( !preg_match('/^[\w_\.\-]+$/', $username) ){
            echo "Invalid filename";
	        exit;
        }

        // To create a new user, we need to:
        if(mkdir("/mod2/$username")){ // create a new directory
            if (!(false===(file_put_contents("/mod2/users.txt", "$username\n", FILE_APPEND)))){ // add username to users.txt
	            header("Location: fileaccess.php?username=$username");
    	        exit;
	        } else{
                echo "User creation fail";
                exit;
     	    }
        }
    }
?>


</body>
</html>
