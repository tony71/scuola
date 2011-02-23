<?php
function select_tipo_addebito($dbtemp, $sql, $addebito)
{
	try {
		
		$stm = $dbtemp->query($sql);
		while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
			$option = '<option value="';
			$option .= $r['id_tipo_addebito'];
			$option .= '"';
			if ($r['id_tipo_addebito'] == $addebito) {
				$option .= ' selected="selected"';
			} 
			$option .= '>';
			$option .= $r['descrizione_tipo'];
			$option .= ' </option>';
			$options .= $option;
		}
	}

	catch(PDOException $e) {
    	   	echo $e->getMessage();
	}
	return $options;
}
?>
