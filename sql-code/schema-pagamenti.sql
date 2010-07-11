-- Da richiamare nel seguente modo:
-- psql -d scuola --file=schema-pagamenti.sql
--
-- Creo il nuovo schema
CREATE SCHEMA pagamenti;
--
-- Sposto le tabelle
ALTER TABLE addebiti SET SCHEMA pagamenti;
ALTER TABLE pagamenti SET SCHEMA pagamenti;
ALTER TABLE ricevute SET SCHEMA pagamenti;
ALTER TABLE ricevute_riga SET SCHEMA pagamenti;
ALTER TABLE rimborsi SET SCHEMA pagamenti;
ALTER TABLE tipo_addebito SET SCHEMA pagamenti;
/***** Le sequenze sono spostate automaticamente dai comandi sopra ******
ALTER SEQUENCE addebiti_id_addebito_seq SET SCHEMA pagamenti;
ALTER SEQUENCE pagamenti_id_seq SET SCHEMA pagamenti;
ALTER SEQUENCE ricevute_id_ricevuta_testata_seq SET SCHEMA pagamenti;
ALTER SEQUENCE tipo_addebito_id_tipo_addebito_seq SET SCHEMA pagamenti;
***************************************************************************/
--
-- Sposto le funzioni
-- ALTER FUNCTION crea_addebito(character, numeric, character varying, date, character, integer) SET SCHEMA pagamenti;
-- ALTER FUNCTION crea_addebito_retta(character, numeric, character varying, date, character) SET SCHEMA pagamenti;
-- ALTER FUNCTION crea_addebito_retta(character, character varying, date, character) SET SCHEMA pagamenti;
ALTER FUNCTION crea_ricevuta(bigint) SET SCHEMA pagamenti;
ALTER FUNCTION crea_ricevuta(bigint[]) SET SCHEMA pagamenti;
ALTER FUNCTION crea_rimborso(bigint) SET SCHEMA pagamenti;
ALTER FUNCTION crea_rimborso(bigint[]) SET SCHEMA pagamenti;
--
-- Sposto le funzioni trigger
ALTER FUNCTION calcola_importo_ricevuta() SET SCHEMA pagamenti;
ALTER FUNCTION calcola_numero_ricevuta() SET SCHEMA pagamenti;
ALTER FUNCTION calcola_numero_ricevuta2() SET SCHEMA pagamenti;
--
-- Sposto le viste
ALTER VIEW vista_addebiti SET SCHEMA pagamenti;
ALTER VIEW vista_addebiti_non_pagati SET SCHEMA pagamenti;
ALTER VIEW vista_addebiti_pagati SET SCHEMA pagamenti;
ALTER VIEW vista_ricevute SET SCHEMA pagamenti;
ALTER VIEW vista_ricevute_riga SET SCHEMA pagamenti;
--
-- Funzionamento
/******************************************************************************
scuola=> select * from addebiti;
ERROR:  relation "addebiti" does not exist
LINE 1: select * from addebiti;
                      ^
scuola=> select * from pagamenti.addebiti;
...
(10 rows)

scuola=> show search_path;
  search_path   
----------------
 "$user",public
(1 row)

scuola=> set search_path to public,pagamenti;
SET
scuola=> select * from addebiti;
...
(10 rows)


scuola=> show search_path;
    search_path    
-------------------
 public, pagamenti
(1 row)


******************************************************************************/
-- La set search_path e' di sessione: se esco da psql devo
-- rilanciare il comando
--
-- Unica modifica da fare sul codice php e' aggiungere al file
-- include/db_connection.php la seguente riga:
-- $db->query('set search_path to public,pagamenti');
-- dopo la DateStyle
