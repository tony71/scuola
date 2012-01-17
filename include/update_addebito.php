<?php
        // Dati tabella addebiti
        $importo = $_POST['importo'];
        $causale = $_POST['causale'];
        $data_scadenza = $_POST['data_scadenza'];
        $anno_scolastico = $_POST['anno_scolastico'];
        $id_tipo_addebito = $_POST['id_tipo_addebito'];
        $id_cliente = $_POST['id_persona'];

        $sql = "UPDATE addebiti SET ";
        $sql .= "importo=to_number(:importo, '99999D99')";
        $sql .= ", causale=:causale";
        $sql .= ", data_scadenza=:data_scadenza";
        $sql .= ", anno_scolastico=:anno_scolastico";
        $sql .= ", id_tipo_addebito=:id_tipo_addebito";
        $sql .= ", id_cliente=:id_persona";
        $sql .= " WHERE id_addebito=:id_addebito ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":importo", $importo);
                $stm->bindParam(":causale", $causale);
                $stm->bindParam(":data_scadenza", $data_scadenza);
                $stm->bindParam(":anno_scolastico", $anno_scolastico);

                $stm->bindParam(":id_addebito", $id_addebito);
                $stm->bindParam(":id_tipo_addebito", $id_tipo_addebito);
                $stm->bindParam(":id_persona", $id_cliente);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		syslog(LOG_INFO, $e->getMessage());
        }
?>
