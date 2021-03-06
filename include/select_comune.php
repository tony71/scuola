<?php
// require_once('db_connection.php');

function select_comune($db, $id_comune, $id_provincia='')
{
$result = '';
try {
	if (isset($id_provincia) && !empty($id_provincia)) {
		$sql = "select * from codici_catastali where provincia='$id_provincia' order by comune";
	}
	else {
		$sql = "select * from codici_catastali order by comune";
	}
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['codice'];
		$option .= '"';
		$option .= (isset($id_comune) && ($id_comune == $r['codice']) ? ' selected="yes"' : '');
		$option .= '>';
		$option .= $r['comune'] . ' - ' . $r['provincia'];
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
