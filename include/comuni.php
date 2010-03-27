<?php
require_once('db_connection.php');
$provincia = $_GET['provincia'];
require('select_comune.php');
echo select_comune($db, '', $provincia);
?>
