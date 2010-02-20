<?php
        // Dati tabella ricevute
        $tipo_pagamento = $_POST['tipo_pagamento'];

        $sql = "UPDATE ricevute SET ";
        $sql .= "tipo_pagamento=:tipo_pagamento ";
        $sql .= "WHERE id_ricevuta=:id_ricevuta ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":tipo_pagamento", $tipo_pagamento);

                $stm->bindParam(":id_ricevuta", $id_ricevuta);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
?>
