<?php
        $tipo_parentela = $_POST['tipo_parentela'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $sesso = $_POST['sesso'];
        $id_famiglia = $_POST['id_famiglia'];
        $professione = (empty($_POST['professione']) ? NULL : $_POST['professione']);
        $data_nascita = (empty($_POST['data_nascita']) ? NULL : $_POST['data_nascita']);
        $luogo_nascita = (empty($_POST['luogo_nascita']) ? NULL : $_POST['luogo_nascita']);
        $cittadinanza = (empty($_POST['cittadinanza']) ? NULL : $_POST['cittadinanza']);
        $codice_fiscale = (empty($_POST['codice_fiscale']) ? NULL : $_POST['codice_fiscale']);
        $via = (empty($_POST['via']) ? NULL : $_POST['via']);
        $numero_civico = (empty($_POST['numero_civico']) ? NULL : $_POST['numero_civico']);
        $citta = (empty($_POST['citta']) ? NULL : $_POST['citta']);
        $id_provincia = (empty($_POST['id_provincia']) ? NULL : $_POST['id_provincia']);
        $cap = (empty($_POST['cap']) ? NULL : $_POST['cap']);
        $quartiere = (empty($_POST['quartiere']) ? NULL : $_POST['quartiere']);
        $stato_nascita = (empty($_POST['stato_nascita']) ? NULL : $_POST['stato_nascita']);
        $provincia_nascita = (empty($_POST['provincia_nascita']) ? NULL : $_POST['provincia_nascita']);
        $comune_nascita = (empty($_POST['comune_nascita']) ? NULL : $_POST['comune_nascita']);
        $provincia_residenza = (empty($_POST['provincia_residenza']) ? NULL : $_POST['provincia_residenza']);
        $comune_residenza = (empty($_POST['comune_residenza']) ? NULL : $_POST['comune_residenza']);
?>
