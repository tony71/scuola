<?php
        // Dati tabella persone
        $tipo_parentela = $_POST['tipo_parentela'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $sesso = $_POST['sesso'];
        $id_famiglia = $_POST['id_famiglia'];
        $professione = $_POST['professione'];
        $data_nascita = $_POST['data_nascita'];
        $luogo_nascita = $_POST['luogo_nascita'];
        $cittadinanza = $_POST['cittadinanza'];
        $codice_fiscale = $_POST['codice_fiscale'];

        $sql = "UPDATE persone SET ";
        $sql .= "tipo_parentela=:tipo_parentela, ";
        $sql .= "nome=:nome, ";
        $sql .= "cognome=:cognome, ";
        $sql .= "sesso=:sesso, ";
        $sql .= "id_famiglia=:id_famiglia, ";
        $sql .= "professione=:professione, ";
        $sql .= "data_nascita=:data_nascita, ";
        $sql .= "luogo_nascita=:luogo_nascita, ";
        $sql .= "cittadinanza=:cittadinanza, ";
        $sql .= "codice_fiscale=:codice_fiscale ";
        $sql .= "WHERE id=:id ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":tipo_parentela", $tipo_parentela);
                $stm->bindParam(":nome", $nome);
                $stm->bindParam(":cognome", $cognome);
                $stm->bindParam(":sesso", $sesso);
                $stm->bindParam(":id_famiglia", $id_famiglia);
                $stm->bindParam(":professione", $professione);
                $stm->bindParam(":data_nascita", $data_nascita);
                $stm->bindParam(":luogo_nascita", $luogo_nascita);
                $stm->bindParam(":cittadinanza", $cittadinanza);
                $stm->bindParam(":codice_fiscale", $codice_fiscale);

                $stm->bindParam(":id", $id);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
?>
