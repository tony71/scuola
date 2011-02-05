TEST:
set search_path=pagamenti,public;
-- select * from pagamenti.crea_report_addebiti_scaduti(current_date-100);

select * from pagamenti.crea_report_addebiti_scaduti(null);

-- select count(*) from vista_report_arretrati;


NUOVI OGGETTI:

CREATE OR REPLACE VIEW pagamenti.vista_addebiti_scaduti AS 
 SELECT vista_addebiti.id_addebito, vista_addebiti.importo, vista_addebiti.importo_residuo, vista_addebiti.causale, vista_addebiti.data_scadenza, vista_addebiti.anno_scolastico, vista_addebiti.matricola_studente, vista_addebiti.saldo, vista_addebiti.descrizione_tipo
   FROM pagamenti.vista_addebiti
  WHERE vista_addebiti.importo_residuo > 0::numeric AND vista_addebiti.data_scadenza < now();


CREATE OR REPLACE FUNCTION pagamenti.crea_report_addebiti_scaduti(IN in_data_scadenza date)
  RETURNS TABLE(matricola_studente character, cognome character varying, nome character varying, saldo_a_oggi numeric) AS
$BODY$DECLARE
        sql TEXT;
BEGIN
        RAISE LOG 'crea_report_addebiti_scaduti %', in_data_scadenza;

	sql := 'SELECT a.matricola_studente, b.nome, b.cognome, a.saldo_a_oggi from (';
        sql := sql || 'SELECT matricola_studente, sum(importo_residuo) as saldo_a_oggi FROM vista_addebiti_scaduti WHERE ($1 IS NULL OR data_scadenza >= $1) GROUP BY matricola_studente';
        sql := sql || ') a NATURAL JOIN vista_studenti b';
        
        RETURN QUERY EXECUTE sql USING in_data_scadenza;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;

COMMENT ON FUNCTION pagamenti.crea_report_addebiti_scaduti(date) IS 'Crea report addebiti scaduti';
