alter table pagamenti.ricevute add data_annullamento timestamp without time zone;
alter table pagamenti.ricevute add utente_annullamento name;
COMMENT ON COLUMN pagamenti.ricevute.utente_annullamento IS 'Contiene utente che ha eseguito annullamento se data_annullamento non nulla altrimenti utente che ha ripristinato la ricevuta';

COMMENT ON FUNCTION pagamenti.cancella_ricevuta(bigint) IS 'Cancella la ricevuta se e'' l''ultima iserita nel DB';

-- Function: pagamenti.annulla_ricevuta(bigint)

-- DROP FUNCTION pagamenti.annulla_ricevuta(bigint);

CREATE OR REPLACE FUNCTION pagamenti.annulla_ricevuta(in_id_ricevuta bigint)
  RETURNS boolean AS
$BODY$DECLARE
	result boolean := false;
	r pagamenti.ricevute_riga%rowtype;
	dt_annull pagamenti.ricevute.data_annullamento%type := null;
BEGIN
	RAISE LOG 'id_ricevuta %', in_id_ricevuta;

	SELECT data_annullamento
	INTO dt_annull
	WHERE id_ricevuta=in_id_ricevuta;

	IF FOUND AND (dt_annull is not null) THEN
		RAISE LOG 'Ricevuta % gia annullata', in_id_ricevuta;
		RETURN result;
	END IF;

	FOR r IN SELECT * FROM ricevute_riga
	WHERE id_ricevuta=in_id_ricevuta
	LOOP
		UPDATE addebiti
		SET saldo=saldo-r.importo_riga
		WHERE id_addebito=r.id_addebito;
	END LOOP;
	
	UPDATE ricevute
	SET data_annullamento=now(), utente_annullamento=current_user
	WHERE id_ricevuta=in_id_ricevuta;

	IF FOUND THEN
		result := true;
	END IF;
	
	RETURN result;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.annulla_ricevuta(bigint) IS 'Annulla la ricevuta logicamente';


-- Function: pagamenti.ripristina_ricevuta(bigint)

-- DROP FUNCTION pagamenti.ripristina_ricevuta(bigint);

CREATE OR REPLACE FUNCTION pagamenti.ripristina_ricevuta(in_id_ricevuta bigint)
  RETURNS boolean AS
$BODY$DECLARE
	result boolean := false;
	r pagamenti.ricevute_riga%rowtype;
	dt_annull pagamenti.ricevute.data_annullamento%type := null;
BEGIN
	RAISE LOG 'id_ricevuta %', in_id_ricevuta;

	SELECT data_annullamento
	INTO dt_annull
	WHERE id_ricevuta=in_id_ricevuta;

	IF FOUND AND (dt_annull is null) THEN
		RAISE LOG 'Ricevuta % non annullata', in_id_ricevuta;
		RETURN result;
	END IF;

	FOR r IN SELECT * FROM ricevute_riga
	WHERE id_ricevuta=in_id_ricevuta
	LOOP
		UPDATE addebiti
		SET saldo=saldo+r.importo_riga
		WHERE id_addebito=r.id_addebito;
	END LOOP;
	
	UPDATE ricevute
	SET data_annullamento=null, utente_annullamento=current_user
	WHERE id_ricevuta=in_id_ricevuta;

	IF FOUND THEN
		result := true;
	END IF;
	
	RETURN result;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
COMMENT ON FUNCTION pagamenti.ripristina_ricevuta(bigint) IS 'Ripristina una ricevuta precedentemente annullata';


----------
-- TEST --
----------
-- Alcuni test da fare: qui ci sono soprattutto addebiti
-- Aggiungi tutto quello che ti viene in mente su vari report, etc...
set search_path=public, pagamenti;

select *
from ricevute
where id_ricevuta=1170;

select *
from ricevute_riga
where id_ricevuta=1170;

select *
from addebiti
where id_addebito in (
	select id_addebito
	from ricevute_riga
	where id_ricevuta=1170
);

select *
from vista_addebiti
where id_addebito in (
	select id_addebito
	from ricevute_riga
	where id_ricevuta=1170
);

select *
from vista_addebiti_non_pagati
where id_addebito in (
	select id_addebito
	from ricevute_riga
	where id_ricevuta=1170
);

select *
from vista_addebiti_non_pagati2
where id_addebito in (
	select id_addebito
	from ricevute_riga
	where id_ricevuta=1170
);

-- matricola_studente="m09056    "
select *
from vista_addebiti_pagati
where id_addebito in (
	select id_addebito
	from ricevute_riga
	where id_ricevuta=1170
);

select *
from crea_report_addebiti_scaduti(null)
where matricola_studente='m09056'
;

select *
from vista_saldo_studente
where matricola_studente='m09056'
;

select *
from vista_saldo_studente2
where matricola_studente='m09056'
;

-- ANNULLA la ricevuta e rifai le query sopra: i dati dovrebbero essere
-- "consistenti" con l'operazione di annullamento
select annulla_ricevuta(1170);

-- RIPRISTINA la ricevuta e rifai le query sopra
-- deve essere tutto come prima dell'annullamento tranne utente_annullamento
select ripristina_ricevuta(1170);
