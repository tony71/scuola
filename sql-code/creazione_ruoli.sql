create role segreteria;

set search_path=public,pagamenti;

grant all on table addebiti to segreteria;
grant all on table anni_scolastici to segreteria;
grant all on table attivita to segreteria;
grant all on table attivita_svolte to segreteria;
grant all on table cap to segreteria;
grant all on table cittadinanze to segreteria;
grant all on table classi to segreteria;
grant all on table codici_catastali to segreteria;
grant all on table codici_sidi to segreteria;
grant all on table contatti_persona to segreteria;
grant all on table contatti_scuola to segreteria;
grant all on table curriculum to segreteria;
grant all on table eventi_studente to segreteria;
grant all on table foglio_notizie to segreteria;
grant all on table giudizi to segreteria;
grant all on table indirizzi_persone to segreteria;
grant all on table insegnanti to segreteria;
grant all on table materie to segreteria;
grant all on table pagamenti to segreteria;
grant all on table persone to segreteria;
grant all on table province to segreteria;
grant all on table province_old to segreteria;
grant all on table ricevute to segreteria;
grant all on table ricevute_riga to segreteria;
grant all on table rimborsi to segreteria;
grant all on table scuole to segreteria;
grant all on table stato_studenti to segreteria;
grant all on table studenti to segreteria;
grant all on table tipo_addebito to segreteria;
grant all on table voti to segreteria;

grant all on vista_addebiti to segreteria;
grant all on vista_addebiti_non_pagati to segreteria;
grant all on vista_addebiti_pagati to segreteria;
grant all on vista_cittadinanze_persone to segreteria;
grant all on vista_domicili to segreteria;
grant all on vista_persone to segreteria;
grant all on vista_residenze to segreteria;
grant all on vista_ricevute to segreteria;
grant all on vista_ricevute_riga to segreteria;
grant all on vista_studenti to segreteria;
grant all on vista_studenti_con_curriculum to segreteria;
grant all on vista_studenti_cv to segreteria;
grant all on vista_studenti_senza_curriculum to segreteria;

grant all on schema html to segreteria;
grant all on schema pagamenti to segreteria;
grant all on sequence pagamenti.addebiti_id_addebito_seq to segreteria;
grant all on sequence pagamenti.ricevute_id_ricevuta_testata_seq to segreteria;

create role fabio login password 'fruntiX';

grant segreteria to fabio;
