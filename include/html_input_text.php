<?php
// require_once('db_connection.php');

function html_input_text($db, $column_name, $table_name, $val, $read_only=true)
{
$result = '';
try {
	if ($read_only == true) {
		$sql = "select html.get_input_text('$column_name', '$table_name'::regclass, '$val', true)";
	}
	else {
		$sql = "select html.get_input_text('$column_name', '$table_name'::regclass, '$val', false)";
	}
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$result = $r['get_input_text'];
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

return $result;
}
?>
