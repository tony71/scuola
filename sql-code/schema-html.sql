--
-- PostgreSQL database dump
--

-- Started on 2010-07-11 17:49:17 CEST

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 20 (class 2615 OID 23168)
-- Name: html; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA html;


--
-- TOC entry 2004 (class 0 OID 0)
-- Dependencies: 20
-- Name: SCHEMA html; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA html IS 'Generate HTML pages';


SET search_path = html, pg_catalog;

--
-- TOC entry 74 (class 1255 OID 23434)
-- Dependencies: 470 20
-- Name: column_has_default(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION column_has_default(column_name name, table_name oid) RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
	result pg_attribute.atthasdef%TYPE;
BEGIN
	SELECT atthasdef
	INTO result
	FROM pg_attribute
	WHERE attrelid=table_name
	  AND attstattarget=-1
	  AND attisdropped=false
	  AND attnum>0
	  AND attname=column_name;
	RETURN result;
END;
$$;


--
-- TOC entry 2005 (class 0 OID 0)
-- Dependencies: 74
-- Name: FUNCTION column_has_default(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION column_has_default(column_name name, table_name oid) IS 'Esempio d''uso: select html.column_has_default(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 73 (class 1255 OID 23433)
-- Dependencies: 20 470
-- Name: column_is_required(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION column_is_required(column_name name, table_name oid) RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
	result pg_attribute.attnotnull%TYPE;
BEGIN
	SELECT attnotnull
	INTO result
	FROM pg_attribute
	WHERE attrelid=table_name
	  AND attstattarget=-1
	  AND attisdropped=false
	  AND attnum>0
	  AND attname=column_name;
	RETURN result;
END;
$$;


--
-- TOC entry 2006 (class 0 OID 0)
-- Dependencies: 73
-- Name: FUNCTION column_is_required(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION column_is_required(column_name name, table_name oid) IS 'Esempio d''uso: select html.column_is_required(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 66 (class 1255 OID 23171)
-- Dependencies: 20 470
-- Name: get_column_comment(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_column_comment(column_name name, table_name oid) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
	col_position pg_attribute.attnum%TYPE;
BEGIN
	SELECT attnum
	INTO col_position
	FROM pg_attribute
	WHERE attrelid=table_name
	  AND attstattarget=-1
	  AND attisdropped=false
	  AND attnum>0
	  AND attname=column_name;
	RETURN col_description(table_name, col_position::integer);
END;
$$;


--
-- TOC entry 2007 (class 0 OID 0)
-- Dependencies: 66
-- Name: FUNCTION get_column_comment(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_comment(column_name name, table_name oid) IS 'Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 65 (class 1255 OID 23172)
-- Dependencies: 470 20
-- Name: get_column_label(name, oid, character); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_column_label(column_name name, table_name oid, lang character) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
	col_comment text;
	str RECORD;
BEGIN
	col_comment := html.get_column_comment(column_name, table_name);
	FOR str IN SELECT foo FROM regexp_split_to_table(col_comment, E'\n') AS foo LOOP
		IF str.foo ~* E'^label@it=".*"$' THEN
			RETURN trim(both '"' from substring(str.foo from '".*"'));
		END IF;
	END LOOP;
	RETURN initcap(translate(rtrim(column_name), '_', ' ')) || ':';
END;
$_$;


--
-- TOC entry 2008 (class 0 OID 0)
-- Dependencies: 65
-- Name: FUNCTION get_column_label(column_name name, table_name oid, lang character); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_label(column_name name, table_name oid, lang character) IS 'Esempio d''uso: select html.get_column_label(''matricola_studente'', ''studenti''::regclass, ''it'');
Creare un commento che contiene la label: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"'';';


--
-- TOC entry 76 (class 1255 OID 23443)
-- Dependencies: 20 470
-- Name: get_column_max_size(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_column_max_size(column_name name, table_name oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
	result pg_attribute.atttypmod%TYPE;
BEGIN
	SELECT atttypmod
	INTO result
	FROM pg_attribute
	WHERE attrelid=table_name
	  AND attstattarget=-1
	  AND attisdropped=false
	  AND attnum>0
	  AND attname=column_name;
	IF (result <> -1) THEN
		result := result - 4;
	END IF;
	-- Da aggiungere la gestione di atttypmod = -1
	-- per esempio le date e i caratteri
	RETURN result;
END;
$$;


--
-- TOC entry 2009 (class 0 OID 0)
-- Dependencies: 76
-- Name: FUNCTION get_column_max_size(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_max_size(column_name name, table_name oid) IS 'Ritorna il numero max di caratteri nella form. Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass); Creare un commento che contiene la label e la size: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"'';';


--
-- TOC entry 44 (class 1255 OID 23436)
-- Dependencies: 20 470
-- Name: get_column_visible_size(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_column_visible_size(column_name name, table_name oid) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
	col_comment text;
	str RECORD;
	result integer := 0;
BEGIN
	col_comment := html.get_column_comment(column_name, table_name);
	FOR str IN SELECT foo FROM regexp_split_to_table(col_comment, E'\n') AS foo LOOP
		IF str.foo ~* E'^size=".*"$' THEN
			result := to_number(trim(both '"' from substring(str.foo from '".*"')), '99999');
		END IF;
	END LOOP;
	
	IF result = 0 THEN
		result := html.get_column_max_size(column_name, table_name);
	END IF;
	
	RETURN result;
END;
$_$;


--
-- TOC entry 2010 (class 0 OID 0)
-- Dependencies: 44
-- Name: FUNCTION get_column_visible_size(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_visible_size(column_name name, table_name oid) IS 'Ritorna il numero di caratteri visibili nella form. Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass); Creare un commento che contiene la label e la size: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"'';';


--
-- TOC entry 45 (class 1255 OID 23444)
-- Dependencies: 470 20
-- Name: get_input_text(name, oid, text, boolean); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_input_text(column_name name, table_name oid, value text, read_only boolean DEFAULT true) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
	result text;
BEGIN
	result := E'\n<label for="' || column_name || '"';
	IF html.column_is_required(column_name, table_name) THEN
		result := result || ' class="required"';
	END IF;
	result := result || '>' || html.get_column_label(column_name, table_name, 'it') || '</label>';
	result := result || E'\n<input type="text" name="' || column_name || '" id="' || column_name || '" ';
	result := result || 'size="' || html.get_column_visible_size(column_name, table_name) || '" ';
	result := result || 'maxlength="' || html.get_column_max_size(column_name, table_name) || '" ';
	result := result || 'value="' || value || '"';
	IF read_only THEN
		result := result || ' readonly="readonly" ';
	END IF;
	result := result || ' />';
	RETURN result;
END;
$$;


--
-- TOC entry 75 (class 1255 OID 23435)
-- Dependencies: 20 470
-- Name: show_column(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION show_column(column_name name, table_name oid) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$DECLARE
	result boolean := true;
	col_comment text;
	str RECORD;
BEGIN
	col_comment := html.get_column_comment(column_name, table_name);
	FOR str IN SELECT foo FROM regexp_split_to_table(col_comment, E'\n') AS foo LOOP
		IF str.foo ~* E'^show=".*"$' THEN
			IF lower(trim(both '"' from substring(str.foo from '".*"'))) = 'false' THEN
				RETURN false;
			END IF;
		END IF;
	END LOOP;
	RETURN result;
END;
$_$;


--
-- TOC entry 2011 (class 0 OID 0)
-- Dependencies: 75
-- Name: FUNCTION show_column(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION show_column(column_name name, table_name oid) IS 'Esempio d''uso: select html.show_column(''matricola_studente'', ''studenti''::regclass);Creare un commento che contiene la label, la size e show: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"\\nshow="true"'';';


-- Completed on 2010-07-11 17:49:18 CEST

--
-- PostgreSQL database dump complete
--

