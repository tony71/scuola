<?php
$page_title = 'Visualizza Studenti';
include('include/header.html');

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	$table = $_POST['table'];
}
elseif (isset($_GET['table'])) {
	$table = $_GET['table'];
}
else {
	$table='vista_studenti';
}

$form = '<form action="visualizza_studenti.php" method="post">';
$form .= '<fieldset>';
$form .= '<legend>Seleziona una tabella</legend>';
if ($table == 'vista_studenti') {
	$form .= ' Tutti gli studenti<input type="radio" name="table" value="vista_studenti" checked="checked"/>';
}
else {
	$form .= ' Tutti gli studenti<input type="radio" name="table" value="vista_studenti"/>';
}
if ($table == 'vista_studenti_con_curriculum') {
	$form .= ' Studenti con cv<input type="radio" name="table" value="vista_studenti_con_curriculum" checked="checked"/>';
}
else {
	$form .= ' Studenti con cv<input type="radio" name="table" value="vista_studenti_con_curriculum"/>';
}
if ($table == 'vista_studenti_senza_curriculum') {
	$form .= ' Studenti senza cv<input type="radio" name="table" value="vista_studenti_senza_curriculum" checked="checked"/>';
}
else {
	$form .= ' Studenti senza cv<input type="radio" name="table" value="vista_studenti_senza_curriculum"/>';
}
$form .= '</fieldset>';
$form .= '<input type="submit" name="submit" value="Submit" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
// $form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '</form>';
echo $form;


/***********
echo "<script language=\"JavaScript\">\n";
echo "alert(\"javascript from php\");\n";
echo "</script>";
**************/

try {
	$sql = "select count(id) from $table";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo '<h1>Studenti Registrati (' . $r[0] . ')</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

$display = 10; // 10 records per page

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$pages = $_GET['p'];
}
else {
	$sql = "select count(id) from $table";
	try {
		$stm = $db->query($sql);
		$r = $stm->fetch(PDO::FETCH_BOTH);
		$records = $r[0];
		if ($records > $display) {
			$pages = ceil($records/$display);
		}
		else {
			$pages = 1;
		}
	}
	catch(PDOException $e) {
        	echo $e->getMessage();
	}
}

if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
}
else {
	$start = 0;
}

// Attenzione: togliendo order by cognome, nome e lasciando solo
// order by cognome la query con limit e offset salta alcune persone
// E se avessimo due persone con stesso nome e cognome: ORRORE, MORTE e
// DISTRUZIONE :-)
$sql = "select id, matricola, nome, cognome from $table order by cognome,nome limit $display offset $start";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num > 0) {
		require('include/tabella_studenti.php');
		echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
	}
	else {
		echo '<p class="error">Non sono presenti studenti nel DB.</p>';
	}
}
catch(PDOException $e)
{
        echo $e->getMessage();
}

if ($pages > 1) {
	echo '<br /><p>';
	$current_page = ($start/$display)+1;
	if ($current_page != 1) {
		$previous_button = '<a href="visualizza_studenti.php?s=';
		$previous_button .= ($start - $display);
		$previous_button .= '&p=';
		$previous_button .= $pages;
		$previous_button .= '&table=';
		$previous_button .= $table;
		$previous_button .= '">Precedente</a> ';
		echo $previous_button;
	}
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			$page_button = '<a href="visualizza_studenti.php?s=';
			$page_button .= (($display * ($i - 1)));
			$page_button .= '&p=';
			$page_button .= $pages;
			$page_button .= '&table=';
			$page_button .= $table;
			$page_button .= '">' . $i . '</a> ';
			echo $page_button;
		}
		else {
			echo $i . ' ';
		}
	}
	if ($current_page != $pages) {
		$next_button = '<a href="visualizza_studenti.php?s=';
		$next_button .= ($start + $display);
		$next_button .= '&p=';
		$next_button .= $pages;
		$next_button .= '&table=';
		$next_button .= $table;
		$next_button .= '">Prossima</a> ';
		echo $next_button;
	}
	echo '</p>';
}
include('include/footer.html');
?>
