--
-- PostgreSQL database dump
--

-- Dumped from database version 9.0rc1
-- Dumped by pg_dump version 9.0rc1
-- Started on 2010-09-19 01:10:32 CEST

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 7 (class 2615 OID 17630)
-- Name: html; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA html;


--
-- TOC entry 2052 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA html; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA html IS 'Generate HTML pages';


SET search_path = html, pg_catalog;

--
-- TOC entry 29 (class 1255 OID 17648)
-- Dependencies: 7 497
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
-- TOC entry 2054 (class 0 OID 0)
-- Dependencies: 29
-- Name: FUNCTION column_has_default(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION column_has_default(column_name name, table_name oid) IS 'Esempio d''uso: select html.column_has_default(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 30 (class 1255 OID 17649)
-- Dependencies: 497 7
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
-- TOC entry 2055 (class 0 OID 0)
-- Dependencies: 30
-- Name: FUNCTION column_is_required(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION column_is_required(column_name name, table_name oid) IS 'Esempio d''uso: select html.column_is_required(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 81 (class 1255 OID 18770)
-- Dependencies: 497 7 304 304 304
-- Name: column_is_required(information_schema.sql_identifier, information_schema.sql_identifier, information_schema.sql_identifier); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION column_is_required(in_schema_name information_schema.sql_identifier, in_table_name information_schema.sql_identifier, in_column_name information_schema.sql_identifier) RETURNS boolean
    LANGUAGE plpgsql
    AS $$DECLARE
	result boolean := false;
	b information_schema.yes_or_no;
BEGIN
	SELECT is_nullable
	INTO b
	FROM information_schema.columns c
	WHERE c.table_schema=in_schema_name
	AND c.table_name=in_table_name
	AND c.column_name=in_column_name;

	IF (b = 'NO') THEN
		result := true;
	END IF;

	RETURN result;
END;
$$;


--
-- TOC entry 2056 (class 0 OID 0)
-- Dependencies: 81
-- Name: FUNCTION column_is_required(in_schema_name information_schema.sql_identifier, in_table_name information_schema.sql_identifier, in_column_name information_schema.sql_identifier); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION column_is_required(in_schema_name information_schema.sql_identifier, in_table_name information_schema.sql_identifier, in_column_name information_schema.sql_identifier) IS 'Esempio d''uso: select html.column_is_required(''pagamenti'', ''addebiti'', ''importo'');';


--
-- TOC entry 31 (class 1255 OID 17650)
-- Dependencies: 7 497
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
-- TOC entry 2057 (class 0 OID 0)
-- Dependencies: 31
-- Name: FUNCTION get_column_comment(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_comment(column_name name, table_name oid) IS 'Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass);';


--
-- TOC entry 32 (class 1255 OID 17651)
-- Dependencies: 497 7
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
-- TOC entry 2058 (class 0 OID 0)
-- Dependencies: 32
-- Name: FUNCTION get_column_label(column_name name, table_name oid, lang character); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_label(column_name name, table_name oid, lang character) IS 'Esempio d''uso: select html.get_column_label(''matricola_studente'', ''studenti''::regclass, ''it'');
Creare un commento che contiene la label: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"'';';


--
-- TOC entry 33 (class 1255 OID 17652)
-- Dependencies: 7 497
-- Name: get_column_max_size(name, oid); Type: FUNCTION; Schema: html; Owner: -
--

CREATE FUNCTION get_column_max_size(column_name name, table_name oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
	result  pg_attribute.atttypmod%TYPE;
	id_tipo pg_attribute.atttypid%TYPE;
	tipo pg_type%ROWTYPE;
BEGIN
	SELECT atttypmod, atttypid
	INTO result, id_tipo
	FROM pg_attribute
	WHERE attrelid=table_name
	  AND attstattarget=-1
	  AND attisdropped=false
	  AND attnum>0
	  AND attname=column_name;
	IF (result <> -1) THEN
		result := result - 4;
	ELSE
		SELECT *
		INTO tipo
		FROM pg_type
		WHERE oid=id_tipo;
		IF (tipo.typname = 'char') THEN
			result := tipo.typlen;
		ELSIF (tipo.typname = 'date') THEN
			-- typlen e' 4 cioe' basta un intero
			-- ma per una data facciamo 10 caratteri
			result := 10;
		END IF;
	END IF;
	-- Da aggiungere la gestione di atttypmod = -1
	-- per esempio le date e i caratteri
	RETURN result;
END;
$$;


--
-- TOC entry 2059 (class 0 OID 0)
-- Dependencies: 33
-- Name: FUNCTION get_column_max_size(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_max_size(column_name name, table_name oid) IS 'Ritorna il numero max di caratteri nella form. Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass); Creare un commento che contiene la label e la size: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"'';';


--
-- TOC entry 34 (class 1255 OID 17653)
-- Dependencies: 497 7
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
-- TOC entry 2060 (class 0 OID 0)
-- Dependencies: 34
-- Name: FUNCTION get_column_visible_size(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION get_column_visible_size(column_name name, table_name oid) IS 'Ritorna il numero di caratteri visibili nella form. Esempio d''uso: select html.get_column_comment(''matricola_studente'', ''studenti''::regclass); Creare un commento che contiene la label e la size: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"'';';


--
-- TOC entry 35 (class 1255 OID 17654)
-- Dependencies: 497 7
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
-- TOC entry 36 (class 1255 OID 17655)
-- Dependencies: 497 7
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
-- TOC entry 2061 (class 0 OID 0)
-- Dependencies: 36
-- Name: FUNCTION show_column(column_name name, table_name oid); Type: COMMENT; Schema: html; Owner: -
--

COMMENT ON FUNCTION show_column(column_name name, table_name oid) IS 'Esempio d''uso: select html.show_column(''matricola_studente'', ''studenti''::regclass);Creare un commento che contiene la label, la size e show: comment on column studenti.matricola_studente is E''Matricola Studente\\nlabel@it="Matricola:"\\nsize="15"\\nshow="true"'';';


--
-- TOC entry 2053 (class 0 OID 0)
-- Dependencies: 7
-- Name: html; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA html FROM PUBLIC;
REVOKE ALL ON SCHEMA html FROM tony;
GRANT ALL ON SCHEMA html TO tony;
GRANT ALL ON SCHEMA html TO postgres;
GRANT ALL ON SCHEMA html TO segreteria;


-- Completed on 2010-09-19 01:10:32 CEST

--
-- PostgreSQL database dump complete
--

