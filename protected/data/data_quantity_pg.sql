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

DROP TABLE IF EXISTS quantity_types;

-- --------------------------------------------------------

--
-- Table structure for table menu_adjacency
--

CREATE TABLE IF NOT EXISTS quantity_types (
    id serial NOT NULL PRIMARY KEY,
    name character varying NOT NULL
);

COMMENT ON TABLE quantity_types IS 'Тип количества в справочнике товаров.';

COMMENT ON COLUMN quantity_types.id  IS 'Первичный ключ таблицы.';
COMMENT ON COLUMN quantity_types.name  IS 'Наименование. Свободное или фиксированное.';

--
-- Dumping data for table menu_adjacency
--

INSERT INTO quantity_types (name) VALUES
('Свободное'),
('Фиксированное');
