CREATE OR REPLACE FUNCTION cerca_studenti(IN nominativo character varying, IN codice_meccanografico character[], IN anno_scolastico character, IN anno integer, IN sezione character, IN indirizzo character, IN stato_studente character, IN data date)
  RETURNS TABLE(matricola_studente character, nome character varying, cognome character varying, data_nascita date, comune_nascita character varying) AS
$BODY$
DECLARE
        sql text;
        str text;
        tbl text;
        val text;
        exp text;
        as_corrente char(9);
        first boolean := TRUE;
BEGIN
	-- SELECT * INTO TEMP TABLE tmp FROM cerca_stato_studenti(anno_scolastico, stato_studente, data);
	EXECUTE 'DROP TABLE IF EXISTS tmp';
	EXECUTE 'CREATE TEMP TABLE tmp AS SELECT * FROM cerca_stato_studenti(' || quote_nullable(anno_scolastico) || ', ' || quote_nullable(stato_studente) || ', ' || quote_nullable(data) || ')';
	
	SELECT * INTO as_corrente FROM calcola_anno_scolastico();
        exp := '';
        str := quote_literal('%' || nominativo || '%');
        RAISE LOG 'Ricerca studenti nominativo %', str;
        tbl := quote_ident('vista_studenti_cv');

        IF (codice_meccanografico IS NOT NULL) THEN
                exp := exp || ' AND codice_meccanografico in (';

                IF (array_lower(codice_meccanografico, 1) IS NULL) THEN
			RAISE LOG 'Ricerca studenti tutti codici meccanografici';
			exp := exp || ' select codice_meccanografico from scuole where codice_scuola is not null ';
			
                ELSE 
			FOR i IN array_lower(codice_meccanografico, 1)..array_upper(codice_meccanografico,1) LOOP
				IF (first = FALSE) THEN
					exp := exp || ', ';
				END IF;
				val := quote_literal(codice_meccanografico[i]);
				RAISE LOG 'Ricerca studenti codice meccanografico %', val;
				exp := exp || val;
				first := FALSE;
			END LOOP;
		END IF;
		exp := exp || ')';
        END IF;

        IF ((anno_scolastico IS NOT NULL) AND (length(anno_scolastico) > 0)) THEN
                val := quote_literal(anno_scolastico);
                RAISE LOG 'Ricerca studenti anno scolastico %', val;
                exp := exp || ' AND anno_scolastico=' || val;
        END IF;

        IF (anno IS NOT NULL) THEN
                RAISE LOG 'Ricerca studenti classe %', anno;
                exp := exp || ' AND classe=' || anno;
        END IF;

        IF ((sezione IS NOT NULL) AND (length(sezione) > 0)) THEN
                val := quote_literal(sezione);
                RAISE LOG 'Ricerca studenti sezione %', val;
                exp := exp || ' AND sezione=' || val;
        END IF;

        IF ((indirizzo IS NOT NULL) AND (length(indirizzo) > 0)) THEN
                val := quote_literal(indirizzo);
                RAISE LOG 'Ricerca studenti indirizzo %', val;
                exp := exp || ' AND indirizzo=' || val;
        END IF;

        RAISE LOG 'Ricerca studenti tabella %', tbl;

        sql := 'SELECT DISTINCT matricola_studente, nome, cognome, data_nascita, comune_nascita FROM ' || tbl || ' WHERE (cognome ILIKE ' || str || ' OR nome ILIKE ' || str || ')' || exp  || ' AND matricola_studente IN (SELECT matricola_studente FROM tmp)';
        RAISE LOG 'Ricerca studenti sql %', sql;
        RETURN QUERY EXECUTE sql;
END;
$BODY$
  LANGUAGE 'plpgsql' VOLATILE
  COST 100
  ROWS 1000;
