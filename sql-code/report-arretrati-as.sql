-- Report Arretrati con in piu' una colonna per gli arretrati dell'anno scolastico in corso
-----------
-- VISTA --
-----------
CREATE OR REPLACE VIEW pagamenti.vista_saldo_studente_as AS 
 SELECT a.matricola_studente, a.anno_scolastico, sum(a.importo_residuo) AS saldo_a_oggi
   FROM pagamenti.vista_addebiti_non_pagati a
  WHERE a.data_scadenza < 'now'::text::date
  GROUP BY a.matricola_studente, a.anno_scolastico;

GRANT ALL ON TABLE pagamenti.vista_saldo_studente_as TO postgres;
GRANT ALL ON TABLE pagamenti.vista_saldo_studente_as TO segreteria;


--------------
-- FUNZIONE --
--------------
CREATE FUNCTION pagamenti.crea_report_addebiti_scaduti_as(IN in_data_scadenza date)
  RETURNS TABLE(matricola_studente character, nome character varying, cognome character varying, saldo_a_oggi numeric, saldo_as numeric) AS
$BODY$DECLARE
        sql TEXT;
BEGIN
        RAISE LOG 'crea_report_addebiti_scaduti_as %', in_data_scadenza;

	sql := 'SELECT a.matricola_studente, a.nome, a.cognome, a.saldo_a_oggi, b.saldo_a_oggi AS saldo_as from crea_report_addebiti_scaduti(null)';
        sql := sql || ' a LEFT OUTER JOIN (select * from vista_saldo_studente_as WHERE anno_scolastico=calcola_anno_scolastico()) b ON (a.matricola_studente=b.matricola_studente)';
        
        RETURN QUERY EXECUTE sql USING in_data_scadenza;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;

COMMENT ON FUNCTION pagamenti.crea_report_addebiti_scaduti_as(date) IS 'Crea report addebiti scaduti e addebito anno scolastico corrente';


----------
-- TEST --
----------
set search_path=pagamenti, public;
select * from crea_report_addebiti_scaduti_as(null); --"09-276    "
select * from crea_report_addebiti_scaduti(null) order by matricola_studente;


select a.matricola_studente
from crea_report_addebiti_scaduti(null) a
where not exists (select * from crea_report_addebiti_scaduti_as(null) where matricola_studente=a.matricola_studente)
; -- 0877
