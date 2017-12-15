<!-- login.php -->
<!-- options to log in or create new account -->

<!DOCTYPE html>
<html>
<head>
<title>File sharing site</title>
</head
>
<body>
<!-- Login form -->
<form action="readbyline.php" method="GET">
	<label>User Name: <input type="text" name="Username" /></label>
	<input type="submit" value="login" />
</form>

<!-- Login failure response -->
<?php
	if (isset($_GET['invalidUser'])){
		if ($_GET['invalidUser']){
			echo "User not found";
		}
	}
?>

<br/>

<!-- link to user creation -->
New user? <a href="signup.php">Create an account</a>

</body>
</html>
