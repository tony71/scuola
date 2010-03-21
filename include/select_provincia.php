<?php
// require_once('db_connection.php');

function select_provincia($db, $id_provincia)
{
$result = '';
try {
	$sql = "select * from province order by provincia";
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['id'];
		$option .= '"';
		$option .= (isset($id_provincia) && ($id_provincia == $r['id']) ? ' selected="yes"' : '');
		$option .= '>';
		$option .= $r['provincia'];
		$option .= ' </option>';
		$result .= $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

return $result;
}
?>
