<?php
if (isset($_POST['submitted'])) {
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	require_once('include/db_connection.php');
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'main_index.php';
	header("Location: http://$host$uri/$extra");
}
else {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php
			if (isset($javascript)) {
				echo '<script type="text/javascript" src="';
				echo $javascript;
				echo '"></script>';
			}
		?>
		<title>
			<?php echo $page_title; ?>
		</title>
		<link rel="stylesheet" href="include/style.css" type="text/css" media="screen" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div id="header">
			<h1>Oratorio Salesiano Michele Rua</h1>
			<h2>un bel posto per studiare...</h2>
		</div>
		<div id="content">
		<form method="post" action="index.php">
			<label>Nome Utente:</label>
			<input type="text" name="username" />
			<br />
			<label>Password:</label>
			<input type="password" name="password" />
			<input type="submit" name="submit" value="Login" />
			<input type="hidden" name="submitted" value="TRUE" />
		</form>
<?php
}
include('include/footer.html');
?>
