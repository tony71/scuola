<?php
        // Dati tabella addebiti
        $id_persona = $_POST['id_persona'];
        $old_contatto = $_POST['old_contatto'];
        $old_commento = $_POST['old_commento'];
        $contatto = $_POST['contatto'];
        $commento = $_POST['commento'];

        $sql = "UPDATE contatti_persona SET ";
        $sql .= "contatto=:contatto";
        $sql .= ", commento=:commento";
        $sql .= " WHERE id_persona=:id_persona ";
        $sql .= "   AND contatto=:old_contatto ";
        $sql .= "   AND commento=:old_commento ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":contatto", $contatto);
                $stm->bindParam(":commento", $commento);
                $stm->bindParam(":old_contatto", $old_contatto);
                $stm->bindParam(":old_commento", $old_commento);

                $stm->bindParam(":id_persona", $id_persona);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		syslog(LOG_INFO, $e->getMessage());
        }
?>
