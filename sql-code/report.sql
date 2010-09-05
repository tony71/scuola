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
