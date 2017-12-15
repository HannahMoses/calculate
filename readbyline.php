<!-- readbyline.php -->
<!-- scans users.txt to see if user is listed in the document -->

<?php
  $h = fopen("/mod2/users.txt", "r");
  if (isset($_GET['Username'])){
    $username = $_GET['Username'];
    $linenum = 1;
    while( !feof($h) ){
		    if (trim(fgets($h)) == $username){
                header("Location: fileaccess.php?username=$username"); // brings the user to their file access page
                exit;
            }
    }
    // At this point, the 'while' loop has finished running, and has not found the specified user.
    // Return to login page.
    header("Location: login.php?invalidUser=true");
    exit;


fclose($h);
}
?>
