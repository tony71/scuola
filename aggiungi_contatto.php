<?php
require_once('include/db_connection.php');

if (isset($_POST['submitted']) && ($_POST['submit'] == 'Registra')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'INSERT INTO contatti_persona (';
	$sql .= 'id_persona, ';
	$sql .= 'contatto, ';
	$sql .= 'commento) ';
	$sql .= 'VALUES (';
	$sql .= ':id_persona, ';
	$sql .= ':contatto, ';
	$sql .= ':commento)';
	

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":id_persona", $trimmed['id_persona']);
                $stm->bindParam(":contatto", $trimmed['contatto']);
                $stm->bindParam(":commento", $trimmed['commento']);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'contatti.php?id_persona=' . $trimmed['id_persona'];
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Registra Contatto';
include('include/header.html');


try {
	$id_persona = $_POST[id_persona];
	$sql = "select nome, cognome from persone where id_persona=:id_persona";
	$stm = $db->prepare($sql);
	$stm->bindParam(":id_persona", $id_persona, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Nuovo Contatto per ' . $m['cognome'] . ', ' . $m['nome'] . '</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

<form action="aggiungi_contatto.php" method="post">
	<fieldset>

		<label for="id_persona">Persona:</label>
		<input type="text" name="id_persona" id="id_persona" size="15" maxlength="15" value="<?php echo $id_persona; ?>" readonly="readonly" />

		<label for="contatto">Contatto:</label>
		<input type="text" name="contatto" id="contatto" size="15" maxlength="50" value="<?php if (isset($trimmed['contatto'])) echo $trimmed['contatto']; ?>" />

		<label for="commento">Commento:</label>
		<textarea name="commento" id="commento" rows="3" cols="30">
			<?php if (isset($trimmed['commento'])) echo $trimmed['commento']; ?>
		</textarea>
	</fieldset>
	<div align="center">
		<input type="submit" name="submit" value="Registra" />
	</div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
include('include/footer.html');
?>
