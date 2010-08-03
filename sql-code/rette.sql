-- Table: pagamenti.configurazione_rette

-- DROP TABLE pagamenti.configurazione_rette;

SET search_path = pagamenti, public, pg_catalog;

CREATE TABLE pagamenti.configurazione_rette
(
  numero_rata integer NOT NULL,
  codice_meccanografico character(10) NOT NULL,
  importo numeric(7, 2) NOT NULL,
  causale character varying(100),
  giorno_scadenza integer NOT NULL,
  mese_scadenza integer NOT NULL,
  CONSTRAINT configurazione_rette_pkey PRIMARY KEY(numero_rata, codice_meccanografico, giorno_scadenza, mese_scadenza),
  CONSTRAINT configurazione_rette_scuole_fkey FOREIGN KEY (codice_meccanografico)
      REFERENCES scuole (codice_meccanografico) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT configurazione_rette_importo_check CHECK (importo >= 0::numeric)     
)
WITH (
  OIDS=FALSE
);
-- ALTER TABLE pagamenti.configurazione_rette OWNER TO tony;
-- GRANT ALL ON TABLE pagamenti.configurazione_rette TO tony;
GRANT ALL ON TABLE pagamenti.configurazione_rette TO segreteria;

-----------------------------------------------------------
-----------------------------------------------------------
-- ATTENZIONE: controlla scadenze, importi e numero rate --
-----------------------------------------------------------
-----------------------------------------------------------
-- Infanzia
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (1, 'TO1A139001', 165, 'Rata 1', 18, 9);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (2, 'TO1A139001', 165, 'Rata 2', 10, 10);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (3, 'TO1A139001', 165, 'Rata 3', 10, 11);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (4, 'TO1A139001', 165, 'Rata 4', 10, 12);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (5, 'TO1A139001', 165, 'Rata 5', 10, 1);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (6, 'TO1A139001', 165, 'Rata 6', 10, 2);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (7, 'TO1A139001', 165, 'Rata 7', 10, 3);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (8, 'TO1A139001', 165, 'Rata 8', 10, 4);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (9, 'TO1A139001', 165, 'Rata 9', 10, 5);

-- Elementare
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (1, 'TO1E02100R', 250, 'Rata 1', 18, 9);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (2, 'TO1E02100R', 250, 'Rata 2', 10, 10);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (3, 'TO1E02100R', 250, 'Rata 3', 10, 11);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (4, 'TO1E02100R', 250, 'Rata 4', 10, 12);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (5, 'TO1E02100R', 250, 'Rata 5', 10, 1);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (6, 'TO1E02100R', 250, 'Rata 6', 10, 2);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (7, 'TO1E02100R', 250, 'Rata 7', 10, 3);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (8, 'TO1E02100R', 250, 'Rata 8', 10, 4);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (9, 'TO1E02100R', 250, 'Rata 9', 10, 5);

-- Media
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (1, 'TO1M054009', 290, 'Rata 1', 18, 9);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (2, 'TO1M054009', 290, 'Rata 2', 10, 10);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (3, 'TO1M054009', 290, 'Rata 3', 10, 11);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (4, 'TO1M054009', 290, 'Rata 4', 10, 12);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (5, 'TO1M054009', 290, 'Rata 5', 10, 1);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (6, 'TO1M054009', 290, 'Rata 6', 10, 2);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (7, 'TO1M054009', 290, 'Rata 7', 10, 3);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (8, 'TO1M054009', 290, 'Rata 8', 10, 4);
INSERT INTO configurazione_rette(numero_rata, codice_meccanografico, importo, causale, giorno_scadenza, mese_scadenza)
VALUES (9, 'TO1M054009', 290, 'Rata 9', 10, 5);


-- Funzioni
-- Function: pagamenti.crea_addebito(character, numeric, character varying, date, character, integer)

-- DROP FUNCTION pagamenti.crea_addebito(character, numeric, character varying, date, character, integer);

CREATE OR REPLACE FUNCTION pagamenti.crea_addebito(in_matricola character, in_importo numeric, in_causale character varying, in_data_scadenza date, in_anno_scolastico character, in_id_tipo_addebito integer)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE := 0;
        cnt integer := 0;
BEGIN
        RAISE LOG 'crea_addebito %', in_matricola;

        SELECT COUNT(*)
        INTO cnt
        FROM addebiti
        WHERE data_scadenza=in_data_scadenza
          AND anno_scolastico=in_anno_scolastico
          AND matricola=in_matricola
          AND id_tipo_addebito=in_id_tipo_addebito;

        IF (cnt = 0) THEN
		SELECT nextval('addebiti_id_addebito_seq')
		INTO result;

		INSERT INTO addebiti(id_addebito, importo, causale, data_scadenza, anno_scolastico, matricola, saldo, id_tipo_addebito)
		VALUES(result, in_importo, in_causale, in_data_scadenza, in_anno_scolastico, in_matricola, 0, in_id_tipo_addebito);
	END IF;
	
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
-- ALTER FUNCTION pagamenti.crea_addebito(character, numeric, character varying, date, character, integer) OWNER TO tony;
COMMENT ON FUNCTION pagamenti.crea_addebito(character, numeric, character varying, date, character, integer) IS 'Crea un addebito con saldo a 0';

-- Function: pagamenti.crea_addebito_retta(character, numeric, character varying, date, character)

-- DROP FUNCTION pagamenti.crea_addebito_retta(character, numeric, character varying, date, character);

CREATE OR REPLACE FUNCTION pagamenti.crea_addebito_retta(in_matricola character, in_importo numeric, in_causale character varying, in_data_scadenza date, in_anno_scolastico character)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE;
        tipo_retta addebiti.id_tipo_addebito%TYPE := 1;
BEGIN
	SELECT id_tipo_addebito
	INTO tipo_retta
	FROM tipo_addebito
	WHERE descrizione_tipo='rette';
	
        RAISE LOG 'crea_addebito_retta matricola % importo %', in_matricola, in_importo;

	result := crea_addebito(in_matricola, in_importo, in_causale, in_data_scadenza, in_anno_scolastico, tipo_retta);
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
-- ALTER FUNCTION pagamenti.crea_addebito_retta(character, numeric, character varying, date, character) OWNER TO tony;
COMMENT ON FUNCTION pagamenti.crea_addebito_retta(character, numeric, character varying, date, character) IS 'Crea un addebito di tipo retta con saldo a 0';


-- Function: pagamenti.crea_addebito_retta(integer, character, character)

-- DROP FUNCTION pagamenti.crea_addebito_retta(integer, character, character);

CREATE OR REPLACE FUNCTION pagamenti.crea_addebito_retta(in_numero_rata integer, in_matricola character, in_anno_scolastico character)
  RETURNS bigint AS
$BODY$DECLARE
        result addebiti.id_addebito%TYPE;
        tmp_stud vista_studenti_cv%ROWTYPE;
        tmp_conf_rette configurazione_rette%ROWTYPE;
        data_scadenza date;
        tmp_anno integer;
BEGIN
        RAISE LOG 'crea_addebito_retta % rata numero %', in_matricola, in_numero_rata;

        -- Importi: infanzia   165
        --          elementare 250
        --          media      290

        SELECT *
        INTO tmp_stud
        FROM vista_studenti_cv
        WHERE matricola_studente=in_matricola
          AND anno_scolastico=in_anno_scolastico;

        SELECT *
        INTO tmp_conf_rette
        FROM configurazione_rette
        WHERE numero_rata=in_numero_rata
          AND codice_meccanografico=tmp_stud.codice_meccanografico;

        tmp_anno := split_part(in_anno_scolastico, '-', 1);

        IF (tmp_conf_rette.mese_scadenza < 9) THEN
		tmp_anno := tmp_anno + 1;
	END IF;

        data_scadenza := to_date(tmp_conf_rette.giorno_scadenza || '/' || tmp_conf_rette.mese_scadenza || '/' || tmp_anno, 'dd/mm/yyyy');

	result := crea_addebito_retta(in_matricola, tmp_conf_rette.importo, tmp_conf_rette.causale, data_scadenza, in_anno_scolastico);
        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
-- ALTER FUNCTION pagamenti.crea_addebito_retta(integer, character, character) OWNER TO tony;
COMMENT ON FUNCTION pagamenti.crea_addebito_retta(integer, character, character) IS 'Crea tutti gli addebiti retta per un anno con saldo a 0. L''importo viene calcolato in base alla scuola che si frequenta.';


-- Function: pagamenti.crea_addebiti_retta_annuale(character, character)

-- DROP FUNCTION pagamenti.crea_addebiti_retta_annuale(character, character);

CREATE OR REPLACE FUNCTION pagamenti.crea_addebiti_retta_annuale(in_matricola character, in_anno_scolastico character)
  RETURNS integer AS
$BODY$DECLARE
        result integer := 0; -- Numero di righe create
        res addebiti.id_addebito%TYPE := 0;
        tmp_conf configurazione_rette%ROWTYPE;
        tmp_stud vista_studenti_cv%ROWTYPE;
BEGIN
        RAISE LOG 'crea_addebiti_retta_annuale %', in_matricola;

	SELECT *
        INTO tmp_stud
        FROM vista_studenti_cv
        WHERE matricola_studente=in_matricola
          AND anno_scolastico=in_anno_scolastico;
          
        FOR tmp_conf IN SELECT * FROM configurazione_rette WHERE codice_meccanografico=tmp_stud.codice_meccanografico LOOP
		res := crea_addebito_retta(tmp_conf.numero_rata, in_matricola, in_anno_scolastico);
		IF (res > 0) THEN
			result := result + 1;
		END IF;
	END LOOP;

        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
-- ALTER FUNCTION pagamenti.crea_addebiti_retta_annuale(character, character) OWNER TO tony;
COMMENT ON FUNCTION pagamenti.crea_addebiti_retta_annuale(character, character) IS 'Crea tutti gli addebiti retta per un anno con saldo a 0. L''importo viene calcolato in base alla scuola che si frequenta.';


-- Function: pagamenti.crea_addebiti_retta_annuale(character)

-- DROP FUNCTION pagamenti.crea_addebiti_retta_annuale(character);

CREATE OR REPLACE FUNCTION pagamenti.crea_addebiti_retta_annuale(in_anno_scolastico character)
  RETURNS integer AS
$BODY$DECLARE
        result integer := 0; -- Numero di righe create
        tmp_stud vista_studenti_cv%ROWTYPE;
BEGIN
        RAISE LOG 'crea_addebiti_retta_annuale %', in_anno_scolastico;
       
        FOR tmp_stud IN SELECT * FROM vista_studenti_cv WHERE anno_scolastico=in_anno_scolastico LOOP
		result := result + crea_addebiti_retta_annuale(tmp_stud.matricola_studente, in_anno_scolastico);
	END LOOP;

        RETURN result;
END;$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100;
-- ALTER FUNCTION pagamenti.crea_addebiti_retta_annuale(character) OWNER TO tony;
COMMENT ON FUNCTION pagamenti.crea_addebiti_retta_annuale(character) IS 'Crea rata rette per tutti gli studenti nel db';


----------
-- TEST --
----------
select crea_addebito_retta(1, '10-065', '2010-2011');
select crea_addebito_retta(2, '10-065', '2010-2011');
select crea_addebito_retta(3, '10-065', '2010-2011');
select crea_addebito_retta(4, '10-065', '2010-2011');
select crea_addebito_retta(5, '10-065', '2010-2011');
select crea_addebito_retta(6, '10-065', '2010-2011');
select crea_addebito_retta(7, '10-065', '2010-2011');
select crea_addebito_retta(8, '10-065', '2010-2011');
select crea_addebito_retta(9, '10-065', '2010-2011');

select * from addebiti where id_addebito>=13;

select *
from configurazione_rette
order by codice_meccanografico, numero_rata
;

select crea_addebiti_retta_annuale('09-179', '2010-2011');

select * from addebiti where matricola='09-179';

select * from addebiti where matricola='10-065';

select crea_addebiti_retta_annuale('2010-2011');

select count(*)
from addebiti;

select count(*)
from vista_studenti_cv
where anno_scolastico='2010-2011';

select *
from addebiti;
