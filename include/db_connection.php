<?php
function autenticate()
{
	header('WWW-Authenticate: Basic Realm="Inserire nome utente e password"');
	header('HTTP/1.0 401 Unauthorized');
	print('Devi autenticarti per poter accedere al database');
}

try {
	session_start();
	if (isset($_SERVER['PHP_AUTH_USER'])
		and isset($_SERVER['PHP_AUTH_PW'])) {
		syslog(LOG_INFO, 'Using _Server');
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];
	}
	else if (isset($_SESSION['username'])
		and isset($_SESSION['password'])) {
		syslog(LOG_INFO, 'Using _Session');
		$user = $_SESSION['username'];
		$pass = $_SESSION['password'];
	}
	else {
		syslog(LOG_INFO, 'Autenticate');
		autenticate();
		exit;
	}
	syslog(LOG_INFO, 'Username: '.$user);
	// syslog(LOG_INFO, 'Password: '.$pass);
	$host = 'localhost';
	$dbname = 'scuola';
	$conn_string = 'pgsql:host=' . $host . ';';
	$conn_string .= 'dbname=' . $dbname;
	$db = new PDO($conn_string, $user, $pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('set DateStyle=SQL,Euro');
	$db->query('set lc_numeric="it_IT.UTF-8"');
	$db->query('set search_path to public,pagamenti');
}
catch(PDOException $e) {
	unset($_SERVER['PHP_AUTH_USER']);
	unset($_SERVER['PHP_AUTH_PW']);
	autenticate();
        echo $e->getMessage();
	echo '<br />Exception code is: ' . $e->getCode();
	syslog(LOG_INFO, $e->getCode());
	exit;
}
?>
