<?php
require_once('include/db_connection.php');

if (isset($_POST['submitted']) && ($_POST['submit'] == 'Salva')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'INSERT INTO addebiti (';
	$sql .= 'importo, ';
	$sql .= 'causale, ';
	$sql .= 'data_scadenza, ';
	$sql .= 'anno_scolastico, ';
	$sql .= 'matricola, ';
	$sql .= 'id_tipo_addebito) ';
	$sql .= 'VALUES (';
	$sql .= "to_number(:importo, '99999D99'), ";
	$sql .= ':causale, ';
	$sql .= ':data_scadenza, ';
	$sql .= ':anno_scolastico, ';
	$sql .= ':matricola, ';
	$sql .= ':id_tipo_addebito)';

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":importo", $trimmed['importo']);
                $stm->bindParam(":causale", $trimmed['causale']);
                $stm->bindParam(":data_scadenza", $trimmed['data_scadenza']);
                $stm->bindParam(":anno_scolastico", $trimmed['anno_scolastico']);
                $stm->bindParam(":matricola", $trimmed['matricola']);
                $stm->bindParam(":id_tipo_addebito", $trimmed['id_tipo_addebito']);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		syslog(LOG_INFO, $e->getMessage());
		syslog(LOG_INFO, $e->getCode());
        }

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'addebiti.php?matricola=' . $trimmed['matricola'];
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Registra Addebito';
include('include/header.html');


try {
	$matricola = $_POST['matricola'];
	$sql = "select nome, cognome from vista_studenti where matricola_studente=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Nuovo Addebito per '.$m['nome'].' '.$m['cognome'].'</h1>';
}
catch(PDOException $e) {
        echo '<p class="error">' . $e->getMessage(). '</p>';
	syslog(LOG_INFO, $e->getMessage());
}

?>

<form action="aggiungi_addebito.php" method="post">
	<fieldset>
		<input type="hidden" name="matricola" id="matricola" value="<?php echo $matricola; ?>" />
		<p>
		<label for="causale">Causale:</label>
		<input type="text" name="causale" id="causale" size="60" maxlength="100" value="<?php if (isset($trimmed['causale'])) echo $trimmed['causale']; ?>" />
		</p>
		<p>
		
		<label for="id_tipo_addebito">Tipo Addebito:</label>
		<!--
		<input type="text" name="id_tipo_addebito" id="id_tipo_addebito" size="9" maxlength="9" value="<?php if (isset($trimmed['id_tipo_addebito'])) echo $trimmed['id_tipo_addebito']; ?>" />
		-->
		<select name="id_tipo_addebito" id="id_tipo_addebito">
			<?php
			include('include/select_tipo_addebito.php');
			echo select_tipo_addebito($db, 'select id_tipo_addebito, descrizione_tipo from tipo_addebito', $trimmed['id_tipo_addebito']);
			?>
		</select>

		<label for="anno_scolastico">Anno Scolastico:</label>
		<!--
		<input type="text" name="anno_scolastico" id="anno_scolastico" size="9" maxlength="9" value="<?php if (isset($trimmed['anno_scolastico'])) echo $trimmed['anno_scolastico']; ?>" />
		-->
		<select name="anno_scolastico" id="anno_scolastico">
			<?php
			include('include/select_anno.php'); 
			echo select_anno_scolastico($db);
			?>
		</select>
		</p>
		<p>
		<label for="importo">Importo:</label>
		<input type="text" name="importo" id="importo" size="10" maxlength="10" value="<?php if (isset($trimmed['importo'])) echo $trimmed['importo']; ?>" />

		<label for="data_scadenza">Data Scadenza:</label>
		<input type="text" name="data_scadenza" id="data_scadenza" size="10" maxlength="10" value="<?php if (isset($trimmed['data_scadenza'])) echo $trimmed['data_scadenza']; ?>" />
		</p>

	</fieldset>

	<div class="navigation">
		<ul>
			<li><input type="submit" name="submit" value="Salva" class="brg"/></li>
			<li><a href="addebiti.php?matricola=<?php echo $matricola; ?>">Annulla</a></li>
		</ul>
	</div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
include('include/footer.html');
?>
