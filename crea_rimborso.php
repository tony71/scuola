<?php
$page_title = 'Crea Rimborso';
include('include/header.html');

require_once('include/db_connection.php');

foreach($_POST['id_addebito'] as $key => $value) {
	echo $key . '-' .$value.'<br />';
}

if (isset($_POST['submitted'])) {
}

include('include/footer.html');
?>
