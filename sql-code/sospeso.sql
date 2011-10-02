-- Function: pagamenti.crea_report_addebiti_scaduti(date)

-- DROP FUNCTION pagamenti.crea_report_addebiti_scaduti(date);

CREATE OR REPLACE FUNCTION pagamenti.crea_report_addebiti_scaduti(IN in_data_scadenza date)
  RETURNS TABLE(matricola_studente character, nome character varying, cognome character varying, saldo_a_oggi numeric, sospeso boolean) AS
$BODY$DECLARE
        sql TEXT;
BEGIN
        RAISE LOG 'crea_report_addebiti_scaduti %', in_data_scadenza;

	sql := 'SELECT a.matricola_studente, b.nome, b.cognome, a.saldo_a_oggi, a.sospeso from (';
        sql := sql || 'SELECT matricola_studente, sum(importo_residuo) as saldo_a_oggi, sospeso FROM vista_addebiti_scaduti WHERE ($1 IS NULL OR data_scadenza >= $1) GROUP BY matricola_studente, sospeso';
        sql := sql || ') a NATURAL JOIN vista_studenti b';
        
        RETURN QUERY EXECUTE sql USING in_data_scadenza;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;

COMMENT ON FUNCTION pagamenti.crea_report_addebiti_scaduti(date) IS 'Crea report addebiti scaduti';

-- Function: pagamenti.crea_report_addebiti_scaduti_as(date)

-- DROP FUNCTION pagamenti.crea_report_addebiti_scaduti_as(date);

CREATE OR REPLACE FUNCTION pagamenti.crea_report_addebiti_scaduti_as(IN in_data_scadenza date)
  RETURNS TABLE(matricola_studente character, nome character varying, cognome character varying, saldo_a_oggi numeric, saldo_as numeric, sospeso boolean) AS
$BODY$DECLARE
        sql TEXT;
BEGIN
        RAISE LOG 'crea_report_addebiti_scaduti_as %', in_data_scadenza;

	sql := 'SELECT a.matricola_studente, a.nome, a.cognome, a.saldo_a_oggi, b.saldo_a_oggi AS saldo_as, a.sospeso from crea_report_addebiti_scaduti(null)';
        sql := sql || ' a LEFT OUTER JOIN (select * from vista_saldo_studente_as WHERE anno_scolastico=calcola_anno_scolastico()) b ON (a.matricola_studente=b.matricola_studente)';
        
        RETURN QUERY EXECUTE sql USING in_data_scadenza;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;

COMMENT ON FUNCTION pagamenti.crea_report_addebiti_scaduti_as(date) IS 'Crea report addebiti scaduti e addebito anno scolastico corrente';

-- Function: pagamenti.attiva_addebito(bigint)

-- DROP FUNCTION pagamenti.attiva_addebito(bigint);

CREATE OR REPLACE FUNCTION pagamenti.attiva_addebito(in_id_addebito bigint)
  RETURNS boolean AS
$BODY$DECLARE
 result boolean := false;
BEGIN
 RAISE LOG 'id_addebito %', in_id_addebito;

 BEGIN
  UPDATE addebiti SET sospeso=false WHERE id_addebito=in_id_addebito;
  result := true;
  
  IF (NOT FOUND) THEN
	result := false;
	RAISE LOG 'id_addebito % non esiste', in_id_addebito;
  END IF;
 END;
 

 RETURN result;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.attiva_addebito(bigint) IS 'Attiva l''addebito';


-- Function: pagamenti.sospendi_addebito(bigint)

-- DROP FUNCTION pagamenti.sospendi_addebito(bigint);

CREATE OR REPLACE FUNCTION pagamenti.sospendi_addebito(in_id_addebito bigint)
  RETURNS boolean AS
$BODY$DECLARE
 result boolean := false;
BEGIN
 RAISE LOG 'id_addebito %', in_id_addebito;

 BEGIN
  UPDATE addebiti SET sospeso=true WHERE id_addebito=in_id_addebito;
  result := true;
  
  IF (NOT FOUND) THEN
	result := false;
	RAISE LOG 'id_addebito % non esiste', in_id_addebito;
  END IF;
 END;
 

 RETURN result;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

COMMENT ON FUNCTION pagamenti.sospendi_addebito(bigint) IS 'Sospende l''addebito';


-- View: pagamenti.vista_addebiti

-- DROP VIEW pagamenti.vista_addebiti;

CREATE OR REPLACE VIEW pagamenti.vista_addebiti AS 
 SELECT a.id_addebito, a.importo, a.importo - a.saldo AS importo_residuo, a.causale, a.data_scadenza, a.anno_scolastico, a.matricola AS matricola_studente, a.saldo, b.descrizione_tipo, a.sospeso
   FROM pagamenti.addebiti a
NATURAL JOIN pagamenti.tipo_addebito b;


-- View: pagamenti.vista_addebiti_non_pagati

-- DROP VIEW pagamenti.vista_addebiti_non_pagati;

CREATE OR REPLACE VIEW pagamenti.vista_addebiti_non_pagati AS 
 SELECT a.id_addebito, a.importo, a.importo_residuo, a.causale, a.data_scadenza, a.anno_scolastico, a.matricola_studente, a.saldo, a.descrizione_tipo, a.sospeso
   FROM pagamenti.vista_addebiti a
  WHERE a.importo_residuo > 0.0;


-- View: pagamenti.vista_addebiti_non_pagati2

-- DROP VIEW pagamenti.vista_addebiti_non_pagati2;

CREATE OR REPLACE VIEW pagamenti.vista_addebiti_non_pagati2 AS 
 SELECT a.id_addebito, a.importo, a.importo_residuo, a.causale, a.data_scadenza, a.anno_scolastico, a.matricola_studente, a.saldo, a.descrizione_tipo, a.sospeso
   FROM pagamenti.vista_addebiti a
  WHERE a.importo_residuo >= 0.0;


-- View: pagamenti.vista_addebiti_pagati

-- DROP VIEW pagamenti.vista_addebiti_pagati;

CREATE OR REPLACE VIEW pagamenti.vista_addebiti_pagati AS 
 SELECT a.id_addebito, a.importo, a.importo_residuo, a.causale, a.data_scadenza, a.anno_scolastico, a.matricola_studente, a.saldo, a.descrizione_tipo, a.sospeso
   FROM pagamenti.vista_addebiti a
  WHERE a.importo_residuo = 0.0;



-- View: pagamenti.vista_addebiti_scaduti

-- DROP VIEW pagamenti.vista_addebiti_scaduti;

CREATE OR REPLACE VIEW pagamenti.vista_addebiti_scaduti AS 
 SELECT vista_addebiti.id_addebito, vista_addebiti.importo, vista_addebiti.importo_residuo, vista_addebiti.causale, vista_addebiti.data_scadenza, vista_addebiti.anno_scolastico, vista_addebiti.matricola_studente, vista_addebiti.saldo, vista_addebiti.descrizione_tipo, vista_addebiti.sospeso
   FROM pagamenti.vista_addebiti
  WHERE vista_addebiti.importo_residuo > 0::numeric AND vista_addebiti.data_scadenza < now();

