--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.1
-- Dumped by pg_dump version 9.1.3
-- Started on 2012-09-14 12:29:03

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 230 (class 1259 OID 20670)
-- Dependencies: 6
-- Name: purposes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE purposes (
    id integer NOT NULL,
    direction_id integer,
    name character varying
);


ALTER TABLE public.purposes OWNER TO postgres;

--
-- TOC entry 2055 (class 0 OID 0)
-- Dependencies: 230
-- Name: TABLE purposes; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE purposes IS 'Справочник целей, с которой создается строка заявки';


--
-- TOC entry 229 (class 1259 OID 20668)
-- Dependencies: 230 6
-- Name: purpose_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE purpose_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.purpose_id_seq OWNER TO postgres;

--
-- TOC entry 2056 (class 0 OID 0)
-- Dependencies: 229
-- Name: purpose_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE purpose_id_seq OWNED BY purposes.id;


--
-- TOC entry 2057 (class 0 OID 0)
-- Dependencies: 229
-- Name: purpose_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('purpose_id_seq', 1, false);


--
-- TOC entry 2049 (class 2604 OID 20673)
-- Dependencies: 229 230 230
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY purposes ALTER COLUMN id SET DEFAULT nextval('purpose_id_seq'::regclass);


--
-- TOC entry 2052 (class 0 OID 20670)
-- Dependencies: 230
-- Data for Name: purposes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO purposes (id, direction_id, name) VALUES (1, 1, 'Открытие вакансии');
INSERT INTO purposes (id, direction_id, name) VALUES (2, 1, 'Организация рабочего места');


--
-- TOC entry 2051 (class 2606 OID 20678)
-- Dependencies: 230 230
-- Name: purpose_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY purposes
    ADD CONSTRAINT purpose_pkey PRIMARY KEY (id);


-- Completed on 2012-09-14 12:29:04

--
-- PostgreSQL database dump complete
--

