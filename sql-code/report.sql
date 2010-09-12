CREATE OR REPLACE VIEW pagamenti.vista_ricevute_totale AS 
 SELECT a.id_ricevuta, a.numero_ricevuta, a.importo_totale, a.importo_totale_it, a.data_ricevuta, a.data_it, a.tipo_pagamento, a.codice_scuola, a.matricola_studente, a.nome, a.cognome, a.denominazione, b.importo_riga, b.importo_riga_it, b.id_addebito, b.causale, b.anno_scolastico, b.id_tipo_addebito, b.descrizione_tipo
   FROM pagamenti.vista_ricevute a
NATURAL JOIN pagamenti.vista_ricevute_riga b;

CREATE OR REPLACE VIEW pagamenti.vista_ricevute_report_giornaliero AS 
 SELECT a.data_it, a.tipo_pagamento, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta, sum(a.importo_riga) AS somma
   FROM pagamenti.vista_ricevute_totale a
  GROUP BY a.data_it, a.tipo_pagamento, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta;

CREATE OR REPLACE VIEW pagamenti.vista_ricevute_report_giornaliero_cab AS 
         SELECT a.data_it, 'c/a'::text AS pag, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta, sum(a.somma) AS sum
           FROM pagamenti.vista_ricevute_report_giornaliero a
          WHERE a.tipo_pagamento = ANY (ARRAY['a'::"char", 'c'::"char"])
          GROUP BY a.data_it, 'c/a'::text, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta
UNION 
         SELECT a.data_it, 'b'::text AS pag, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta, sum(a.somma) AS sum
           FROM pagamenti.vista_ricevute_report_giornaliero a
          WHERE a.tipo_pagamento = 'b'::"char"
          GROUP BY a.data_it, 'b'::text, a.codice_scuola, a.denominazione, a.cognome, a.nome, a.descrizione_tipo, a.numero_ricevuta;

CREATE OR REPLACE VIEW pagamenti.vista_ricevute_report_mensile AS 
 SELECT a.data_it, a.tipo_pagamento, a.codice_scuola, a.denominazione, a.descrizione_tipo, sum(a.importo_riga) AS somma
   FROM pagamenti.vista_ricevute_totale a
  GROUP BY a.data_it, a.tipo_pagamento, a.codice_scuola, a.denominazione, a.descrizione_tipo;

CREATE OR REPLACE VIEW pagamenti.vista_ricevute_report_mensile_cab AS 
         SELECT a.data_it, 'c/a'::text AS pag, a.codice_scuola, a.denominazione, a.descrizione_tipo, sum(a.somma) AS sum
           FROM pagamenti.vista_ricevute_report_mensile a
          WHERE a.tipo_pagamento = ANY (ARRAY['a'::"char", 'c'::"char"])
          GROUP BY a.data_it, 'c/a'::text, a.codice_scuola, a.denominazione, a.descrizione_tipo
UNION 
         SELECT a.data_it, 'b'::text AS pag, a.codice_scuola, a.denominazione, a.descrizione_tipo, sum(a.somma) AS sum
           FROM pagamenti.vista_ricevute_report_mensile a
          WHERE a.tipo_pagamento = 'b'::"char"
          GROUP BY a.data_it, 'b'::text, a.codice_scuola, a.denominazione, a.descrizione_tipo;

GRANT ALL ON TABLE pagamenti.vista_ricevute_totale TO segreteria;
GRANT ALL ON TABLE pagamenti.vista_ricevute_report_giornaliero TO segreteria;
GRANT ALL ON TABLE pagamenti.vista_ricevute_report_giornaliero_cab TO segreteria;
GRANT ALL ON TABLE pagamenti.vista_ricevute_report_mensile TO segreteria;
GRANT ALL ON TABLE pagamenti.vista_ricevute_report_mensile_cab TO segreteria;


CREATE TABLE pagamenti.ricevute_report_giornaliero
(
  data date NOT NULL,
  tipo character(3) NOT NULL,
  cognome character varying(50) NOT NULL,
  nome character varying(50) NOT NULL,
  numero_ricevuta integer NOT NULL,
  retta numeric(7,2) NOT NULL DEFAULT 0.0,
  iscrizione numeric(7,2) NOT NULL DEFAULT 0.0,
  attivita numeric(7,2) NOT NULL DEFAULT 0.0,
  libri numeric(7,2) NOT NULL DEFAULT 0.0,
  mensa numeric(7,2) NOT NULL DEFAULT 0.0,
  dopo_scuola numeric(7,2) NOT NULL DEFAULT 0.0,
  tuta numeric(7,2) NOT NULL DEFAULT 0.0,
  diario_e_abbon numeric(7,2) NOT NULL DEFAULT 0.0,
  totale numeric(7,2) NOT NULL  DEFAULT 0.0
)
WITH (
  OIDS=FALSE
);

GRANT ALL ON TABLE pagamenti.addebiti TO segreteria;



CREATE OR REPLACE FUNCTION pagamenti.crea_report_giornaliero_ricevuta(in_data date, in_codice_scuola character)
  RETURNS boolean AS
$BODY$DECLARE
        result boolean := true;
BEGIN
        RAISE LOG 'crea_report_giornaliero_ricevuta %, %', in_data, in_codice_scuola;

        EXECUTE 'TRUNCATE TABLE ricevute_report_giornaliero';

        INSERT INTO ricevute_report_giornaliero(data, tipo, cognome, nome, numero_ricevuta)
        SELECT DISTINCT data_it::date, pag, cognome, nome, numero_ricevuta
        FROM vista_ricevute_report_giornaliero_cab
        WHERE data_it::date=in_data AND codice_scuola=in_codice_scuola;

        UPDATE ricevute_report_giornaliero AS b
        SET retta=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='rette';

        UPDATE ricevute_report_giornaliero AS b
        SET iscrizione=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='iscrizioni';

        UPDATE ricevute_report_giornaliero AS b
        SET attivita=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='corsi extrascolastici';

        UPDATE ricevute_report_giornaliero AS b
        SET mensa=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='mensa';
        
        UPDATE ricevute_report_giornaliero AS b
        SET dopo_scuola=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='doposcuola, ripetizioni';

        UPDATE ricevute_report_giornaliero AS b
        SET tuta=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='tuta, divisa';

        UPDATE ricevute_report_giornaliero AS b
        SET diario_e_abbon=a.sum
        FROM vista_ricevute_report_giornaliero_cab a
        WHERE a.data_it::date=data
        AND a.pag=tipo
        AND a.cognome=b.cognome
        AND a.nome=b.nome
        AND a.numero_ricevuta=b.numero_ricevuta
        AND a.descrizione_tipo='diari e abbonamenti';

        UPDATE ricevute_report_giornaliero
        SET totale=retta+iscrizione+attivita+mensa+dopo_scuola+tuta+diario_e_abbon;
        
        RETURN result;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

COMMENT ON FUNCTION pagamenti.crea_report_giornaliero_ricevuta(date, character) IS 'Crea report giornaliero';
