<?php

function select_anno_scolastico($db, $as='')
{
	$result = '';
	try {
		if (isset($as) && !empty($as)) {
			$anno = $as;
		}
		else {
			$sql = 'select * from calcola_anno_scolastico()';
			$stm = $db->query($sql);
			$r = $stm->fetch(PDO::FETCH_BOTH);
			$anno = $r['calcola_anno_scolastico'];
		}
		$sql = 'select anno from anni_scolastici order by anno desc';
		$stm = $db->query($sql);
		while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
			$option = '<option value="';
			$option .= $r['anno'];
			$option .= '"';
			$option .= ($r['anno'] == $anno ? ' selected="yes"' : '');
			$option .= '>';
			$option .= $r['anno'];
			$option .= ' </option>';
			$result .= $option;
		}
	}
	catch(PDOException $e) {
       		echo $e->getMessage();
		syslog(LOG_INFO, $e->getMessage());
	}

	return $result;
}

?>
