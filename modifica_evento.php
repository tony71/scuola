<?php
require_once('include/db_connection.php');

if (isset($_POST['submitted']) && ($_POST['submit'] == 'Salva')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'UPDATE eventi_studente ';
	$sql .= 'SET commento=:commento ';
	$sql .= 'where id_evento=:id_evento';
	
        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":id_evento", $trimmed['id_evento']);
                $stm->bindParam(":commento", $trimmed['commento']);

                $stm->execute();
                
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$sql='select matricola_studente from eventi_studente where id_evento=:id_evento';
        try {
		$stm = $db->prepare($sql);
                $stm->bindParam(":id_evento", $trimmed['id_evento']);
		$stm->execute();
		$m = $stm->fetch(PDO::FETCH_BOTH);
		$matricola = $m['matricola_studente'];
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'eventi.php?matricola=' . $matricola;
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Modifica Evento';
include('include/header.html');


try {
	$id_evento = $_GET['id_evento'];
	$sql = "select nome_breve, cognome_breve, matricola_studente from studenti where matricola_studente in (select matricola_studente from eventi_studente where id_evento=:id_evento)";
	$stm = $db->prepare($sql);
	$stm->bindParam(":id_evento", $id_evento);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Modifica Evento per '.$m['nome_breve'].' '.$m['cognome_breve'].'</h1>';
	
	$matricola = $m['matricola_studente'];

	$sql = "select commento from eventi_studente where id_evento=:id_evento";
	$stm = $db->prepare($sql);
	$stm->bindParam(":id_evento", $id_evento);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);
	$commento = $m['commento'];
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

<form action="modifica_evento.php" method="post">
	<fieldset>
		<label for="id_evento">ID Evento:</label>
		<input type="text" name="id_evento" id="id_evento" size="15" maxlength="15" value="<?php echo $id_evento; ?>" readonly="readonly" />

		<label for="commento">Commento:</label>
		<textarea name="commento" id="commento" rows="3" cols="60"> 
			<?php echo $commento; ?>
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
