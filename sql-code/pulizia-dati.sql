-- I dati si prendono dalla tabella codici_catastali

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

