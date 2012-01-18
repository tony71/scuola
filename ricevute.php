<?php
$page_title = 'Ricevute';
include('include/header.html');

require_once('include/db_connection.php');

if (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
elseif (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
else {
}

try {
	$sql = "select count(distinct id_ricevuta) from vista_ricevute_riga where matricola_studente=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$r = $stm->fetch(PDO::FETCH_BOTH);
	
	$sql = "select nome, cognome from vista_studenti where matricola_studente=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Ricevute di '.$m['nome'].' '.$m['cognome'].'</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

$display = 20; // 20 records per page

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

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'default';

switch ($sort) {
	case 'numero':
		$order_by = 'numero_ricevuta desc';
		break;
	case 'importo':
		$order_by = 'importo_totale desc';
		break;
	case 'data':
		$order_by = 'data_ricevuta desc';
		break;
	case 'as':
		$order_by = 'anno_scolastico asc';
		break;
	case 'default':
		$order_by = 'data_ricevuta desc, id_ricevuta desc';
		break;
	default:
		$order_by = 'data_ricevuta desc, id_ricevuta desc';
		$sort = 'default';
		break;
}

$sql = "select * from vista_ricevute_new where matricola_studente='$matricola' order by $order_by limit $display offset $start";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num > 0) {
		require('include/tabella_ricevute.php');
		echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"', "ricevute.php?matricola=$matricola");
	}
	else {
		echo '<p class="error">Non sono presenti ricevute nel DB.</p>';
	}
}
catch(PDOException $e) {
        echo $e->getMessage();
}

if ($pages > 1) {
	echo '<br /><p>';
	$current_page = ($start/$display)+1;
	if ($current_page != 1) {
		$previous_button = '<a href="ricevute.php?s=';
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
			$page_button = '<a href="ricevute.php?s=';
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
		$next_button = '<a href="ricevute.php?s=';
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

echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';

include('include/footer.html');
?>
