SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

\connect orderlog_development

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: advplace; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

DROP TABLE IF EXISTS purposes;

-- --------------------------------------------------------

--
-- Table structure for table menu_adjacency
--

CREATE TABLE IF NOT EXISTS purposes (
    id serial NOT NULL PRIMARY KEY,
    direction_id integer,
    name character varying NOT NULL
);

COMMENT ON TABLE purposes IS 'Справочник целей с которой создаются строки заявок.';

--
-- Dumping data for table menu_adjacency
--

INSERT INTO quantity_types (direction_id, name) VALUES
(1,'Открытие вакансии'),
(1, 'Организация рабочего места');
