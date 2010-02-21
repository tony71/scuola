<?php
$page_title = 'Addebiti';
include('include/header.html');

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	$table = $_POST['table'];
}
elseif (isset($_GET['table'])) {
	$table = $_GET['table'];
}
else {
	$table='vista_addebiti_non_pagati';
}

if (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
elseif (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
else {
}

$form = '<form action="addebiti.php" method="post">';
$form .= '<fieldset>';
$form .= '<legend>Seleziona una tabella</legend>';
if ($table == 'vista_addebiti_non_pagati') {
	$form .= ' Addebiti Non Pagati<input type="radio" name="table" value="vista_addebiti_non_pagati" checked="checked"/>';
}
else {
	$form .= ' Addebiti Non Pagati<input type="radio" name="table" value="vista_addebiti_non_pagati"/>';
}
if ($table == 'vista_addebiti_pagati') {
	$form .= ' Addebiti Pagati<input type="radio" name="table" value="vista_addebiti_pagati" checked="checked"/>';
}
else {
	$form .= ' Addebiti Pagati<input type="radio" name="table" value="vista_addebiti_pagati"/>';
}
if ($table == 'vista_addebiti') {
	$form .= ' Tutti gli Addebiti<input type="radio" name="table" value="vista_addebiti" checked="checked"/>';
}
else {
	$form .= ' Tutti gli Addebiti<input type="radio" name="table" value="vista_addebiti"/>';
}
$form .= '</fieldset>';
$form .= '<input type="submit" name="submit" value="Submit" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
$form .= '</form>';
echo $form;

try {
	$sql = "select count(id_addebito) from $table where matricola=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$r = $stm->fetch(PDO::FETCH_BOTH);
	
	$sql = "select nome, cognome from vista_studenti where matricola=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Addebiti Registrati (' . $r[0] . ') ' . $m['cognome'] . ', ' . $m['nome'] . '</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

$display = 10; // 10 records per page

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$pages = $_GET['p'];
}
else {
	$records = $r[0];
	if ($records > $display) {
		$pages = ceil($records/$display);
	}
	else {
		$pages = 1;
	}
}

if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
}
else {
	$start = 0;
}

$sql = "select id_addebito, importo, importo_residuo, causale, data_scadenza, anno_scolastico, matricola, saldo, descrizione_tipo from $table where matricola=:matricola order by anno_scolastico,id_addebito limit $display offset $start";
try {
	// $stm = $db->query($sql);
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$num = $stm->rowCount();
	if ($num > 0) {
		require('include/tabella_addebiti.php');
		$form = '<form action="ricevuta_rimborso.php" method="post">';
		$form .= result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
		$form .= '<input type="submit" name="crea" value="Crea Ricevuta" />';
		$form .= '<br />';
		$form .= '<input type="submit" name="crea" value="Crea Rimborso" />';
		$form .= '<input type="hidden" name="submitted" value="TRUE" />';
		$form .= '</form>';
		echo $form;
	}
	else {
		echo '<p class="error">Non sono presenti addebiti nel DB.</p>';
	}
}
catch(PDOException $e) {
        echo $e->getMessage();
}

echo '<div align="center">';
$form = '<form action="aggiungi_addebito.php" method="post">';
$form .= '<input type="submit" name="nuovo_addebito" value="Nuovo Addebito" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
$form .= '</form>';
echo $form;

echo '</div>';

if ($pages > 1) {
	echo '<br /><p>';
	$current_page = ($start/$display)+1;
	if ($current_page != 1) {
		$previous_button = '<a href="addebiti.php?s=';
		$previous_button .= ($start - $display);
		$previous_button .= '&p=';
		$previous_button .= $pages;
		$previous_button .= '&table=';
		$previous_button .= $table;
		$previous_button .= '&matricola=';
		$previous_button .= $matricola;
		$previous_button .= '">Precedente</a> ';
		echo $previous_button;
	}
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			$page_button = '<a href="addebiti.php?s=';
			$page_button .= (($display * ($i - 1)));
			$page_button .= '&p=';
			$page_button .= $pages;
			$page_button .= '&table=';
			$page_button .= $table;
			$page_button .= '&matricola=';
			$page_button .= $matricola;
			$page_button .= '">' . $i . '</a> ';
			echo $page_button;
		}
		else {
			echo $i . ' ';
		}
	}
	if ($current_page != $pages) {
		$next_button = '<a href="addebiti.php?s=';
		$next_button .= ($start + $display);
		$next_button .= '&p=';
		$next_button .= $pages;
		$next_button .= '&table=';
		$next_button .= $table;
		$next_button .= '&matricola=';
		$next_button .= $matricola;
		$next_button .= '">Prossima</a> ';
		echo $next_button;
	}
	echo '</p>';
}
include('include/footer.html');
?>
