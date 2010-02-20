<?php
$importo_riga = $_POST['importo_riga'];
$id_addebito = $_POST['id_addebito'];
foreach($id_addebito as $k => $addebito) {
        // Dati tabella ricevute_riga

	$importo = $importo_riga[$k];

        $sql = "UPDATE ricevute_riga SET ";
        $sql .= "importo_riga=:importo_riga ";
        $sql .= "WHERE id_ricevuta=:id_ricevuta ";
        $sql .= "AND id_addebito=:id_addebito ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":importo_riga", $importo);

                $stm->bindParam(":id_ricevuta", $id_ricevuta);
                $stm->bindParam(":id_addebito", $addebito);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
}
?>
