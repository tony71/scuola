<?php
echo 'Available PDO drivers: <br />';
foreach(PDO::getAvailableDrivers() as $driver) {
        echo $driver.'<br />';
}
// print_r(PDO::getAvailableDrivers);
try {
	require_once('include/db_connection.php');
	$sql = 'select * from province';
	foreach($db->query($sql) as $row) {
		print $row['id_provincia'] . ' ';
		print $row['provincia'] . ' ';
		print $row['sigla'] . '<br />';
	}
}
catch(PDOException $e)
{
        echo $e->getMessage();
}
?>
