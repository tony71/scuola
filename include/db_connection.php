<?php
function autenticate()
{
	header('WWW-Authenticate: Basic Realm="Secret Stash"');
	header('HTTP/1.0 401 Unauthorized');
	print('You must provide the proper credentials!');
}

try {
	if (isset($_SERVER['PHP_AUTH_USER'])
		and isset($_SERVER['PHP_AUTH_PW'])) {
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];
		$host = 'bi-proc';
		$dbname = 'scuola';
		$conn_string = 'pgsql:host=' . $host . ';';
		$conn_string .= 'dbname=' . $dbname;
		$db = new PDO($conn_string, $user, $pass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		autenticate();
	}
	else {
		exit;
	}
}
catch(PDOException $e) {
	unset($_SERVER['PHP_AUTH_USER']);
	unset($_SERVER['PHP_AUTH_PW']);
	autenticate();
        echo $e->getMessage();
	echo '<br />Exception code is: ' . $e->getCode();
	exit;
}
?>
