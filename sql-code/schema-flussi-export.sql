-- Per scoprire dove postgres puo' scrivere il file sono entrato come
-- utente postgres (facendo da root 'su - postgres') ed eseguendo pwd
-- che ha restituito /var/lib/pgsql
--
-- Comando per creare un file a partire da una tabella/vista
-- copy (select * from flussi_export.ministero) to '/var/lib/pgsql/report_ministero.txt' with (format csv, delimiter '|');

-- ******************************************************************************
-- io ho usato il seguente comando in pgadmin:
-- copy (select * from flussi_export.ministero_primaria) to '/var/lib/postgresql/report_ministero2011.txt' with delimiter '|';
-- ******************************************************************************

-- Nell'esempio ho fatto un file con tutte e 3 le scuole
-- Ho anche creato 3 viste per fare un export separato di ciascuna scuola
--
-- Il record di testata lo devi inserire a mano
--
-- C'e' invece da controllare la consistenza dei dati secondo il pdf
-- che mi hai mandato (per esempio se ho stato I allora non devo avere la
-- sezione; se non ho il comune di nascita allora ho lo stato estero; etc
-- Mi pare che molti di questi controlli falliscono :-(
-- Inoltre l'esito e' sempre sconosciuto (foglio notizie vuoto)
--
-- Nuovo schema
CREATE SCHEMA flussi_export;

CREATE TABLE flussi_export.tipi_flusso
(
  nome character varying(10) NOT NULL,
  CONSTRAINT tipi_flusso_pkey PRIMARY KEY (nome)
)
WITH (
  OIDS=FALSE
);

INSERT INTO flussi_export.tipi_flusso(
            nome)
    VALUES ('Ministero');

CREATE TABLE flussi_export.testata_flussi
(
  nome character varying(10) NOT NULL,
  codice_appicativo_segreteria character varying(4) NOT NULL,
  versione_sw character varying(8) NOT NULL,
  CONSTRAINT testata_flussi_pkey PRIMARY KEY (nome),
  CONSTRAINT testata_flussi_nome_fkey FOREIGN KEY (nome)
      REFERENCES flussi_export.tipi_flusso (nome) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

INSERT INTO flussi_export.testata_flussi(
            nome, codice_appicativo_segreteria, versione_sw)
    VALUES ('Ministero', 'ABCD', '12345678');

CREATE OR REPLACE FUNCTION flussi_export.stato_attuale_studente(in_matricola_studente character)
  RETURNS character AS
$BODY$DECLARE
	result stato_studenti.stato_studente%TYPE := NULL;
	r stato_studenti%ROWTYPE;
	min INTEGER := 2147483647;
BEGIN
        RAISE LOG 'Matricola %', in_matricola_studente;

        FOR r IN SELECT * FROM stato_studenti
        WHERE matricola_studente=in_matricola_studente
          AND anno_scolastico=calcola_anno_scolastico()
          AND now() BETWEEN data_inizio AND data_fine
        LOOP
		IF result is null AND not isfinite(r.data_fine) THEN
			result := r.stato_studente;
		END IF;

		IF isfinite(r.data_fine) AND ((r.data_fine-r.data_inizio) < min) THEN
			min := r.data_fine-r.data_inizio;
			result := r.stato_studente;
		END IF;
			
        END LOOP;
	
        RETURN result;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

CREATE OR REPLACE VIEW flussi_export.stato_attuale_studenti AS 
 SELECT DISTINCT stato_studenti.matricola_studente, stato_studenti.anno_scolastico, flussi_export.stato_attuale_studente(stato_studenti.matricola_studente) AS stato
   FROM stato_studenti
  WHERE stato_studenti.anno_scolastico = calcola_anno_scolastico();

CREATE OR REPLACE VIEW flussi_export.ministero AS 
 SELECT vista_studenti_cv.codice_meccanografico AS codice_scuola, "substring"(vista_studenti_cv.anno_scolastico::text, 1, 4) AS anno_scolastico, vista_studenti_cv.classe AS anno_cronologico, vista_studenti_cv.sezione, vista_studenti_cv.codice_fiscale, vista_studenti_cv.cognome_breve AS cognome, vista_studenti_cv.nome_breve AS nome, vista_studenti_cv.sesso, 
        CASE vista_studenti_cv.sigla_comune_nascita
            WHEN 'XXXX'::bpchar THEN NULL::bpchar
            ELSE vista_studenti_cv.sigla_comune_nascita
        END AS codice_comune_nascita, to_char(vista_studenti_cv.data_nascita::timestamp with time zone, 'dd/mm/yyyy'::text) AS data_nascita, 
        CASE vista_studenti_cv.sigla_stato_nascita
            WHEN 'UNK'::bpchar THEN NULL::bpchar
            ELSE vista_studenti_cv.sigla_stato_nascita
        END AS codice_stato_straniero_nascita, vista_studenti_cv.sigla_comune_residenza AS codice_comune_residenza, vista_studenti_cv.sigla_provincia_residenza AS provincia_residenza, NULL::bpchar AS indirizzo_residenza, NULL::bpchar AS cap, stato_attuale_studenti.stato AS stato_alunno, 
        CASE foglio_notizie.esito
            WHEN 'Positivo'::tipo_esito THEN 0
            WHEN 'Negativo'::tipo_esito THEN 1
            WHEN 'Sconosciuto'::tipo_esito THEN 2
            ELSE 2
        END AS esito, 
        CASE vista_studenti_cv.sigle_stati_cittadinanza[1]
            WHEN 'UNK'::bpchar THEN NULL::bpchar
            ELSE vista_studenti_cv.sigle_stati_cittadinanza[1]
        END AS cittadinanza1, 
        CASE vista_studenti_cv.sigle_stati_cittadinanza[2]
            WHEN 'UNK'::bpchar THEN NULL::bpchar
            ELSE vista_studenti_cv.sigle_stati_cittadinanza[2]
        END AS cittadinanza2, ' '::character(1) AS filler1, '    '::character(4) AS filler2, ' '::character(1) AS filler3
   FROM vista_studenti_cv
   LEFT JOIN foglio_notizie ON vista_studenti_cv.anno_scolastico = foglio_notizie.anno_scolastico AND vista_studenti_cv.matricola_studente = foglio_notizie.matricola_studente AND vista_studenti_cv.codice_meccanografico = foglio_notizie.codice_meccanografico
   LEFT JOIN flussi_export.stato_attuale_studenti ON vista_studenti_cv.anno_scolastico = stato_attuale_studenti.anno_scolastico AND vista_studenti_cv.matricola_studente = stato_attuale_studenti.matricola_studente
  WHERE vista_studenti_cv.anno_scolastico = calcola_anno_scolastico();

CREATE OR REPLACE VIEW flussi_export.ministero_to1a139001 AS 
 SELECT ministero.codice_scuola, ministero.anno_scolastico, ministero.anno_cronologico, ministero.sezione, ministero.codice_fiscale, ministero.cognome, ministero.nome, ministero.sesso, ministero.codice_comune_nascita, ministero.data_nascita, ministero.codice_stato_straniero_nascita, ministero.codice_comune_residenza, ministero.provincia_residenza, ministero.indirizzo_residenza, ministero.cap, ministero.stato_alunno, ministero.esito, ministero.cittadinanza1, ministero.cittadinanza2, ministero.filler1, ministero.filler2, ministero.filler3
   FROM flussi_export.ministero
  WHERE ministero.codice_scuola = 'TO1A139001'::bpchar;

CREATE OR REPLACE VIEW flussi_export.ministero_to1e02100r AS 
 SELECT ministero.codice_scuola, ministero.anno_scolastico, ministero.anno_cronologico, ministero.sezione, ministero.codice_fiscale, ministero.cognome, ministero.nome, ministero.sesso, ministero.codice_comune_nascita, ministero.data_nascita, ministero.codice_stato_straniero_nascita, ministero.codice_comune_residenza, ministero.provincia_residenza, ministero.indirizzo_residenza, ministero.cap, ministero.stato_alunno, ministero.esito, ministero.cittadinanza1, ministero.cittadinanza2, ministero.filler1, ministero.filler2, ministero.filler3
   FROM flussi_export.ministero
  WHERE ministero.codice_scuola = 'TO1E02100R'::bpchar;

CREATE OR REPLACE VIEW flussi_export.ministero_to1m054009 AS 
 SELECT ministero.codice_scuola, ministero.anno_scolastico, ministero.anno_cronologico, ministero.sezione, ministero.codice_fiscale, ministero.cognome, ministero.nome, ministero.sesso, ministero.codice_comune_nascita, ministero.data_nascita, ministero.codice_stato_straniero_nascita, ministero.codice_comune_residenza, ministero.provincia_residenza, ministero.indirizzo_residenza, ministero.cap, ministero.stato_alunno, ministero.esito, ministero.cittadinanza1, ministero.cittadinanza2, ministero.filler1, ministero.filler2, ministero.filler3
   FROM flussi_export.ministero
  WHERE ministero.codice_scuola = 'TO1M054009'::bpchar;

