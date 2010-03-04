<?php
   $filename=$_GET['filename'];
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it><head>
<title><?php echo $_GET['titolo']; ?></title></head>
<body>
<?php
require_once('include/tabella_generica.php');
$sql = $_GET['sql'];
require_once('include/db_connection.php');
try {
	$stm = $db->query($sql);
	echo result_as_table($stm, 'border="1"');
}
catch(PDOException $e) {
	echo $e->getMessage();
}
?>
</body></html>
