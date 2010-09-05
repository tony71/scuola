CREATE OR REPLACE FUNCTION pagamenti.cancella_ricevuta(in_id_ricevuta bigint)
  RETURNS boolean AS
$BODY$DECLARE
	result boolean := false;
	nr pagamenti.ricevute.numero_ricevuta%TYPE;
	n  pagamenti.ricevute.numero_ricevuta%TYPE;
	cs pagamenti.ricevute.codice_scuola%TYPE;
BEGIN
	RAISE LOG 'id_ricevuta %', in_id_ricevuta;

	SELECT codice_scuola, numero_ricevuta
	INTO cs, n
	FROM ricevute
	WHERE id_ricevuta=in_id_ricevuta;
	
	SELECT a.numero_ricevuta
	INTO nr
	FROM ricevute a
	WHERE a.codice_scuola=cs AND date_part('year',now())=date_part('year',data_ricevuta)
	ORDER BY a.numero_ricevuta DESC LIMIT 1;

	IF (nr <> n) THEN
		RAISE EXCEPTION 'Solo ultima ricevuta inserita cancellabile %', nr USING ERRCODE = 'check_violation';
	END IF;
	
	DELETE FROM ricevute_riga WHERE id_ricevuta=in_id_ricevuta;
	IF FOUND THEN
		DELETE FROM ricevute WHERE id_ricevuta=in_id_ricevuta AND numero_ricevuta=nr;
		IF FOUND THEN
			result := true;
		ELSE
			RAISE EXCEPTION 'Solo ultima ricevuta inserita cancellabile';
		END IF;
	END IF;
	
	RETURN result;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
