set search_path to public,pagamenti;

CREATE OR REPLACE FUNCTION pagamenti.crea_addebito(in_matricola character, in_importo numeric, in_causale character varying, in_data_scadenza date, in_anno_scolastico character, in_id_tipo_addebito integer)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE;
BEGIN
        RAISE LOG 'crea_addebito %', in_matricola;

	result := 0;
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.crea_addebito(character, numeric, character varying, date, character, integer) IS 'Crea un addebito con saldo a 0';



CREATE OR REPLACE FUNCTION pagamenti.crea_addebito_retta(in_matricola character, in_importo numeric, in_causale character varying, in_data_scadenza date, in_anno_scolastico character)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE;
        tipo_retta addebiti.id_tipo_addebito%TYPE := 1;
BEGIN
        RAISE LOG 'crea_addebito_retta matricola % importo %', in_matricola, in_importo;

	result := crea_addebito(in_matricola, in_importo, in_causale, in_data_scadenza, in_anno_scolastico, tipo_retta);
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.crea_addebito_retta(character, numeric, character varying, date, character) IS 'Crea un addebito di tipo retta con saldo a 0';



CREATE OR REPLACE FUNCTION pagamenti.crea_addebito_retta(in_matricola character, in_causale character varying, in_data_scadenza date, in_anno_scolastico character)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE;
BEGIN
        RAISE LOG 'crea_addebito_retta %', in_matricola;

	result := crea_addebito_retta(in_matricola, 290, in_causale, in_data_scadenza, in_anno_scolastico);
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.crea_addebito_retta(character, character varying, date, character) IS 'Crea un addebito retta con saldo a 0. L''importo viene calcolato in base alla scuola che si frequenta. La funzione fallisce per i casi speciali';

