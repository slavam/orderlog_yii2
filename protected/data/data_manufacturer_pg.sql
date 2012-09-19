SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

\connect orderlog_development
-- \connect orderlog_production

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

DROP TABLE IF EXISTS manufacturer;

-- --------------------------------------------------------

--
-- Table structure for table menu_adjacency
--

CREATE TABLE IF NOT EXISTS manufacturer (
    id serial NOT NULL PRIMARY KEY,
    name character varying NOT NULL
);

ALTER TABLE public.manufacturer OWNER TO postgres;

COMMENT ON TABLE manufacturer IS 'Справочник производителей.';

COMMENT ON COLUMN manufacturer.id  IS 'Первичный ключ таблицы.';
COMMENT ON COLUMN manufacturer.name  IS 'Наименование производителя.';

--
-- Dumping data for table menu_adjacency
--

INSERT INTO manufacturer (name) VALUES
('Производитель № 1'),
('Производитель № 2'),
('Производитель № 3'),
('Производитель № 4'),
('Производитель № 5'),
('Производитель № 6'),
('Производитель № 7'),
('Производитель № 8'),
('Производитель № 9'),
('Производитель № 10');
