-- Schema
CREATE SCHEMA anagrafica_persone;
GRANT ALL ON SCHEMA anagrafica_persone TO tony;
GRANT ALL ON SCHEMA anagrafica_persone TO postgres;
GRANT ALL ON SCHEMA anagrafica_persone TO segreteria;

CREATE SCHEMA anagrafica_indirizzi;
GRANT ALL ON SCHEMA anagrafica_indirizzi TO tony;
GRANT ALL ON SCHEMA anagrafica_indirizzi TO postgres;
GRANT ALL ON SCHEMA anagrafica_indirizzi TO segreteria;

CREATE SCHEMA anagrafica_scuole;
GRANT ALL ON SCHEMA anagrafica_scuole TO tony;
GRANT ALL ON SCHEMA anagrafica_scuole TO postgres;
GRANT ALL ON SCHEMA anagrafica_scuole TO segreteria;

-- Table anagrafica_persone
ALTER TABLE persone           SET SCHEMA anagrafica_persone;
ALTER TABLE studenti          SET SCHEMA anagrafica_persone;
ALTER TABLE insegnanti        SET SCHEMA anagrafica_persone;
ALTER TABLE cittadinanze      SET SCHEMA anagrafica_persone;
ALTER TABLE contatti_persona  SET SCHEMA anagrafica_persone;
ALTER TABLE indirizzi_persone SET SCHEMA anagrafica_persone;

-- Trigger anagrafica_persone
ALTER FUNCTION                    setta_nome_cognome_breve() SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.setta_nome_cognome_breve() SET search_path = anagrafica_persone;

ALTER FUNCTION                    crea_nuovo_studente() SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.crea_nuovo_studente() SET search_path = anagrafica_persone;

ALTER FUNCTION converti_in_maiuscolo()            SET SCHEMA anagrafica_persone;

ALTER FUNCTION                    calcola_nuova_matricola_studente() SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.calcola_nuova_matricola_studente() SET search_path = anagrafica_persone;

-- Function anagrafica_persone
ALTER FUNCTION                    cancella_persona(integer) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cancella_persona(integer) SET search_path = anagrafica_persone;

ALTER FUNCTION                    cancella_studente(character) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cancella_studente(character) SET search_path = anagrafica_persone;

ALTER FUNCTION                    cerca_persone(IN nominativo character varying) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cerca_persone(IN nominativo character varying) SET search_path = anagrafica_persone, anagrafica_indirizzi;

ALTER FUNCTION                    cerca_studente(character varying) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cerca_studente(character varying) SET search_path = anagrafica_persone, anagrafica_indirizzi;

ALTER FUNCTION cerca_studenti(character varying, character, character, integer, character, character, character, date) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cerca_studenti(character varying, character, character, integer, character, character, character, date)
SET search_path = public, anagrafica_persone, anagrafica_indirizzi;

ALTER FUNCTION cerca_studenti(character varying, character[], character, integer, character, character, character, date) SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.cerca_studenti(character varying, character[], character, integer, character, character, character, date)
SET search_path = public, anagrafica_persone, anagrafica_indirizzi;

ALTER FUNCTION inserisci_persona("char", character varying, character varying, "char", character varying, character varying, date, character, character varying, character varying, character varying, character, character, character, character, character, character, character, character[])
SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.inserisci_persona("char", character varying, character varying, "char", character varying, character varying, date, character, character varying, character varying, character varying, character, character, character, character, character, character, character, character[])
SET search_path = anagrafica_persone;

ALTER FUNCTION modifica_persona("char", character varying, character varying, "char", character varying, character varying, date, character, character varying, character varying, character varying, character, character, character, character, character, character, character, character[])
SET SCHEMA anagrafica_persone;
ALTER FUNCTION anagrafica_persone.modifica_persona("char", character varying, character varying, "char", character varying, character varying, date, character, character varying, character varying, character varying, character, character, character, character, character, character, character, character[])
SET search_path = anagrafica_persone;

-- View anagrafica_persone
ALTER VIEW vista_persone              SET SCHEMA anagrafica_persone;
ALTER VIEW vista_studenti             SET SCHEMA anagrafica_persone;
ALTER VIEW vista_cittadinanze_persone SET SCHEMA anagrafica_persone;
ALTER VIEW vista_contatti_dipendenti  SET SCHEMA anagrafica_persone;
ALTER VIEW vista_domicili             SET SCHEMA anagrafica_persone;
ALTER VIEW vista_residenze            SET SCHEMA anagrafica_persone;



-- Table anagrafica_indirizzi
ALTER TABLE cap              SET SCHEMA anagrafica_indirizzi;
ALTER TABLE codici_catastali SET SCHEMA anagrafica_indirizzi;
ALTER TABLE codici_sidi      SET SCHEMA anagrafica_indirizzi;
ALTER TABLE province         SET SCHEMA anagrafica_indirizzi;
ALTER TABLE province_old     SET SCHEMA anagrafica_indirizzi;



-- Table anagrafica_scuole
ALTER TABLE anni_scolastici SET SCHEMA anagrafica_scuole;
ALTER TABLE attivita        SET SCHEMA anagrafica_scuole;
ALTER TABLE classi          SET SCHEMA anagrafica_scuole;
ALTER TABLE contatti_scuola SET SCHEMA anagrafica_scuole;
ALTER TABLE materie         SET SCHEMA anagrafica_scuole;
ALTER TABLE scuole          SET SCHEMA anagrafica_scuole;

-- Trigger anagrafica_scuole
ALTER FUNCTION anno_scolastico_valido() SET SCHEMA anagrafica_scuole;

---------------------
---------------------
-- Funzioni Errate --
---------------------
---------------------
DROP FUNCTION cerca_stato_studenti(character, character, date);

CREATE OR REPLACE FUNCTION cerca_stato_studenti(IN in_anno_scolastico character, IN in_stato_studente character, IN in_data date)
  RETURNS TABLE(anno_scolastico character, matricola_studente character, data_inizio date, data_fine date, stato_studente "char") AS
$BODY$
DECLARE
        sql text;
        tbl text;
        val text;
        exp text;
        and_exp text;
        where_exp text;
BEGIN
        exp := '';
        and_exp := '';
        where_exp := '';
        tbl := quote_ident('stato_studenti');

        IF ((in_anno_scolastico IS NOT NULL) AND (length(in_anno_scolastico) > 0)) THEN
                val := quote_literal(in_anno_scolastico);
                RAISE LOG 'Ricerca stato studenti anno scolastico %', val;
                exp := exp || and_exp || ' anno_scolastico=' || val;
                and_exp := ' AND ';
        END IF;

        IF ((in_stato_studente IS NOT NULL) AND (length(in_stato_studente) > 0)) THEN
                val := quote_literal(in_stato_studente);
                RAISE LOG 'Ricerca stato studenti stato_studente %', val;
                exp := exp || and_exp || ' stato_studente=' || val;
                and_exp := ' AND ';
        END IF;

        IF (in_data IS NOT NULL) THEN
                val := quote_literal(in_data);
                RAISE LOG 'Ricerca stato studenti data %', val;
                exp := exp || and_exp || val || ' BETWEEN data_inizio AND data_fine ';
                and_exp := ' AND ';
        END IF;

        IF (length(exp) > 0) THEN
		where_exp := ' WHERE ' || exp;
        END IF;

        RAISE LOG 'Ricerca studenti tabella %', tbl;

        sql := 'SELECT anno_scolastico, matricola_studente, data_inizio, data_fine, stato_studente FROM ' || tbl ||  where_exp;
        RAISE LOG 'Ricerca studenti sql %', sql;
        RETURN QUERY EXECUTE sql;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
--------------------------
--------------------------
-- Fine Funzioni Errate --
--------------------------
--------------------------

----------
----------
-- TEST --
----------
----------
select * from anagrafica_persone.cerca_persone('acc');

select * from anagrafica_persone.cerca_studente('accardi');
---------------
---------------
-- FINE TEST --
---------------
---------------

-----------------------------------------------
-----------------------------------------------
-- Settare il search_path per utenti e ruoli --
-- Presente nella verione 9.1.2 ma non nella --
-- 8.4.10                                    --
-- Modificare include/db_connection.php      --
-- per rimuovere il set search_path          --
-- che altrimenti prende il soppravvento     --
-----------------------------------------------
-----------------------------------------------
ALTER ROLE segreteria IN DATABASE scuola SET search_path=public, anagrafica_persone, anagrafica_indirizzi, anagrafica_scuole, pagamenti;
ALTER ROLE tony       IN DATABASE scuola SET search_path=public, anagrafica_persone, anagrafica_indirizzi, anagrafica_scuole, pagamenti;

