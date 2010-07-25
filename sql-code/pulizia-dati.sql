-- I dati si prendono dalla tabella codici_catastali
-- Invece per gli stranieri mi pare che ci voglia solo
-- lo stato estero di nascita (vedi flusso al ministero)

update persone
set provincia_nascita='TO', comune_nascita='L219'
where luogo_nascita in ('TORINO', 'Torino')
;


update persone
set provincia_nascita='TO', comune_nascita='L727'
where luogo_nascita in ('VENARIA', 'Venaria (TO)')
;

update persone
set provincia_nascita='TO', comune_nascita='C722'
where luogo_nascita in (E'CIRIE\'', 'Cirié (TO)', 'Ciriè (TO)', 'Cirie (TO)')
;

