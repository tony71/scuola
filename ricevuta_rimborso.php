<?php
if (isset($_POST['crea'])) {
	if ($_POST['crea'] == 'Crea Rimborso') {
		require('crea_rimborso.php');
	}
	else {
		require('crea_ricevuta.php');
	}
}
?>
