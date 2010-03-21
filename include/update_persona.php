<?php
        // Dati tabella persone
	include('dati_post_persona.php');

        $sql = "UPDATE persone SET ";
        $sql .= "tipo_parentela=:tipo_parentela";
        $sql .= ", nome=:nome";
        $sql .= ", cognome=:cognome";
        $sql .= ", sesso=:sesso";
        $sql .= ", id_famiglia=:id_famiglia";
        $sql .= ", professione=:professione";
        $sql .= ", data_nascita=:data_nascita";
        $sql .= ", luogo_nascita=:luogo_nascita";
        $sql .= ", cittadinanza=:cittadinanza";
        $sql .= ", codice_fiscale=:codice_fiscale";
        $sql .= ", via=:via";
        $sql .= ", numero_civico=:numero_civico";
        $sql .= ", citta=:citta";
        $sql .= ", id_provincia=:id_provincia";
        $sql .= ", cap=:cap";
        $sql .= ", quartiere=:quartiere";
        $sql .= " WHERE id_persona=:id";

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
                $stm->bindParam(":via", $via);
                $stm->bindParam(":numero_civico", $numero_civico);
                $stm->bindParam(":citta", $citta);
                $stm->bindParam(":id_provincia", $id_provincia);
                $stm->bindParam(":cap", $cap);
                $stm->bindParam(":quartiere", $quartiere, PDO::PARAM_STR, 2);

                $stm->bindParam(":id", $id);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
?>
