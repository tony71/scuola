<?php
if (isset($_POST['submitted'])) {
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	require_once('include/db_connection.php');
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
}
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			Login
		</title>
		<link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<form method="post" action="login.php">
			<label>Nome Utente:</label>
			<input type="text" name="username" />
			<br />
			<label>Password:</label>
			<input type="password" name="password" />
			<input type="submit" name="submit" value="Login" />
			<input type="hidden" name="submitted" value="TRUE" />
		</form>
	</body>
</html>
<?php
}
?>
