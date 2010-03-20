<?php
        $sql = "INSERT INTO studenti (";
        $sql .= "matricola_studente";
        $sql .= ", id_persona";
        $sql .= ") VALUES (";
        $sql .= "DEFAULT";
        $sql .= ", :id_persona";
        $sql .= ") RETURNING matricola_studente";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":id_persona", $id_persona);

                $stm->execute();
		$r = $stm->fetch(PDO::FETCH_BOTH);
		$_POST['matricola'] = $r['matricola_studente'];
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		exit;
        }
?>
