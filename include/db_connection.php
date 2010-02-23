<?php
try {
/*	if (isset($_SERVER['PHP_AUTH_USER'])
		and isset($_SERVER['PHP_AUTH_PW'])) {
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];
*/
		$user = 'postgres';
		$pass = 'fruntiX';
		$host = '172.16.1.22';
		$dbname = 'scuola';
		$conn_string = 'pgsql:host=' . $host . ';';
		$conn_string .= 'dbname=' . $dbname;
		$db = new PDO($conn_string, $user, $pass);
/*	}
	else {
		header('WWW-Authenticate: Basic Realm="Secret Stash"');
		header('HTTP/1.0 401 Unauthorized');
		print('You must provide the proper credentials!');
		exit;
	}*/
}
catch(PDOException $e)
{
        echo $e->getMessage();
	echo '<br />Exception code is: ' . $e->getCode();
	unset($_SERVER['PHP_AUTH_USER']);
	unset($_SERVER['PHP_AUTH_PW']);
	header('WWW-Authenticate: Basic Realm="Secret Stash"');
	header('HTTP/1.0 401 Unauthorized');
	print('You must provide the proper credentials!');
	exit;
}
?>
