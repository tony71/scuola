<?php
require_once('include/db_connection.php');

if (isset($_POST['submitted']) && ($_POST['submit'] == 'Salva')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'INSERT INTO eventi_studente (';
	$sql .= 'matricola_studente, ';
	$sql .= 'data, ';
	$sql .= 'commento) ';
	$sql .= 'VALUES (';
	$sql .= ':matricola_studente, ';
	$sql .= ':data, ';
	$sql .= ':commento)';
	
        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":matricola_studente", $trimmed['matricola']);
                $stm->bindParam(":data", $trimmed['data']);
                $stm->bindParam(":commento", $trimmed['commento']);

                $stm->execute();
                
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'eventi.php?matricola=' . $trimmed['matricola'];
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Salva Evento';
include('include/header.html');


try {
	$matricola = $_POST['matricola'];
	$sql = "select nome_breve, cognome_breve from studenti where matricola_studente=:matricola_studente";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola_studente", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Nuovo Evento per '.$m['nome_breve'].' '.$m['cognome_breve'].'</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

<form action="aggiungi_evento.php" method="post">
	<fieldset>
		<label for="matricola">Matricola:</label>
		<input type="text" name="matricola" id="matricola" size="15" maxlength="15" value="<?php echo $matricola; ?>" readonly="readonly" />
<br />
		<label for="data">Data:</label>
		<input type="text" name="data" id="data" size="15" maxlength="10" value="<?php if (isset($trimmed['data'])) echo $trimmed['data']; ?>" />
<br />
		<label for="commento">Commento:</label>
		<textarea name="commento" id="commento" rows="3" cols="60"> 
			<?php if (isset($trimmed['commento'])) echo $trimmed['commento']; ?>
		</textarea>
	</fieldset>
	<div align="center">
		<input type="submit" name="submit" value="Salva" />
		<a href="eventi.php?matricola=<?php echo $matricola; ?>">Annulla</a>

	</div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
include('include/footer.html');
?>
