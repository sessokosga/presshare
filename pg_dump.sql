--
-- PostgreSQL database dump
--

-- Dumped from database version 14.2
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: presshare; Type: SCHEMA; Schema: -; Owner: u0_a340
--

CREATE SCHEMA presshare;


ALTER SCHEMA presshare OWNER TO u0_a340;

--
-- Name: press_p_genre; Type: TYPE; Schema: presshare; Owner: u0_a340
--

CREATE TYPE presshare.press_p_genre AS ENUM (
    'Text',
    'Link'
);


ALTER TYPE presshare.press_p_genre OWNER TO u0_a340;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: author; Type: TABLE; Schema: presshare; Owner: u0_a340
--

CREATE TABLE presshare.author (
    a_id bigint NOT NULL,
    a_pseudo character varying(20) NOT NULL,
    a_first_name character varying(20),
    a_last_name character varying(50),
    a_password character varying(255) NOT NULL,
    a_created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    a_confirmed_at timestamp with time zone,
    a_confirmation_token character varying(100),
    a_email character varying(255) NOT NULL,
    a_reset_token character varying(200),
    a_reset_at timestamp with time zone,
    a_remember_token character varying(250)
);


ALTER TABLE presshare.author OWNER TO u0_a340;

--
-- Name: press; Type: TABLE; Schema: presshare; Owner: u0_a340
--

CREATE TABLE presshare.press (
    p_id bigint NOT NULL,
    p_title character varying(255) NOT NULL,
    p_content text,
    p_genre presshare.press_p_genre DEFAULT 'Text'::presshare.press_p_genre,
    p_author_id bigint NOT NULL,
    p_created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    p_last_modified timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE presshare.press OWNER TO u0_a340;

--
-- Data for Name: author; Type: TABLE DATA; Schema: presshare; Owner: u0_a340
--

COPY presshare.author (a_id, a_pseudo, a_first_name, a_last_name, a_password, a_created_at, a_confirmed_at, a_confirmation_token, a_email, a_reset_token, a_reset_at, a_remember_token) FROM stdin;
1	senor16	Michée	Sesso Kosga Bamokaï	$2y$10$HruIu9cMnX1xXaE/0sJ86e3M641DzajvMQWA.cKROE.pJai.N2Mhy	2021-03-27 21:21:33+01	2021-04-22 09:43:42+01	\N	msesso@gmail.com	Tmf2WuClQ86prs0j2L8uOmQV2kU6TgRjz1C4MnJNOzPPsyrsII7c0FVEOvWZcEMxwPpTlbFqEMX3EWPeQIn7o8Ry65XwBO5eV73YkbtGtR8IATme3kWRjuoqId20kK9fzQ0ST3JaNaDrzIKEmM2Qtp8iMdHFhoLlAHb0JNe7wkD2ZF7ywR1k71kEUfbXclfmrkyqgX8j	2021-04-24 09:59:14+01	\N
30	dede	Deddy	Derson Danson Danely 	$2y$10$r5PsnvZ8Wc0HnojYQJhqjOvfLPsWVgk6coT9U/SsLVmol3sHOpImK	2021-04-19 15:16:01+01	2021-04-22 09:43:42+01	\N	dede@deda.com	L4FeChMRm2zf3eMZBws96RoWwlGynW43tAOjU8vrLbHsPhPO2xLBGef6QYQGLhlFfuBPpvCzZmXAYLBXEUXMTtkf0zSVQXRUKpZAUITjj8dGDcekfs4fm8UBD0dyZkvXDxSkSpRTrU1eTRihKbQiDnBuleTURbi8QiW8pJzFsL3yhufik9eT6uuAepRlxj4jBxMsZpLe	2021-04-24 10:51:09+01	U3lYtwOWBjPeRmgN2bjQfvW6lF1mj6rNa1fCFEcfSom4RCkXE0aP4NhCnpwyoAYkuMFs86CQtjdv248jeUmB0EszIYDSmlgQf6loh6OoZbpkyoHsUEVDNAJktSw5RYtf7I2CwDPRi8qNR6lt2vakzEs3pxDFYrXrNZHBSr96w5EsqH51uXoZdEaLL63kFvFhGFK5PDWIuzhhutkSaT5NMADBJlP6yHAyAsLYo4HfpU0lkCAg1DqSTFgpaR
31	hello	Kitty	Hello	$2y$10$v/gBC9K8NnacSwhoUiugweQ6CkpPNKQEM1eJE5yDMLIAL8T44tqAS	2021-04-22 09:43:30+01	2021-04-22 09:43:42+01	\N	hello@kitty.com	\N	\N	\N
32	tatou			$2y$10$OTdp.q/IZY5.yAPwEahGH.qkNylauCXoEryuK1GV4fO9bL4mVVCJ2	2021-04-22 20:23:10+01	\N	s5PwsWghuCv7LwGrorIHdyGKOUW0dyQwYQODgz5LXxCS4dtAKMe1IEVwEANf	hello@tatou.com	\N	\N	\N
\.


--
-- Data for Name: press; Type: TABLE DATA; Schema: presshare; Owner: u0_a340
--

COPY presshare.press (p_id, p_title, p_content, p_genre, p_author_id, p_created_at, p_last_modified) FROM stdin;
1	OJ6nClfd9SBh	1qqum9HT3PuPaBmQn0XscQ==	Link	1	2021-04-11 15:21:15+01	2021-04-11 15:21:15+01
3	gMxZXQ==	QgXoMiHZZGXJfdEjog==	Link	1	2021-04-11 15:21:15+01	2021-04-11 15:21:15+01
4	C39YEovtTg==	SG3fgzQcgNfq 5jF57oJU0Rl1kw== 	Text	1	2021-04-11 15:21:15+01	2021-04-11 15:21:15+01
5	4kOIR DfnMIYi/pU=	k8bHPbEn1 UwOURjfhOB2mU1PTxg=	Text	1	2021-04-11 15:21:15+01	2021-04-11 15:21:15+01
6	a0sUyKQ2	FhZVv9FMgQwn8OK/ag3fj9XJ	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
7	8Kz9IxPH6o0=	 LkehqocK Z2wQ==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
8	ufp/	HA9vzHHjEHB74wVgEg==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
9	AlVrC4fDKOwo	YPbeE2kDf/EvMA==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
10	jUA/ LjkYNfUJQw=	IbhKIUivzKQQmxe2ll4XrxWO Q==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
11	eLz6KkPc	9Ie4pOjo2WUKZF5h	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
12	YQ5THg==	5BG74yYl6xpleuGnohFC	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
13	0Q7qZwNB 2snnnE=	ADmrICjraMDcFsWl2vblFlZp	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
14	qe/90pJ3LdBd gs=	WodHooVsYkCo1LSeJJDsuRI=	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
15	ipYM1sQkIh8/VQ==	qUconhWTE6MfYKSZ	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
16	dU0Tckij	rs8xpQ7v7uYwtk4IJ9UPfnc=	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
17	RWUpEw==	AIfrc4VqyUp3f1tBEg==	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
18	dOG00g==	ryYM93WdQKDue3iah41DkUnz/Q==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
19	LxpZsQ==	nwMZVLnG7qISWw==	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
20	gNzK	z4yGloX9pXHoTIg=	Text	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
21	m5aFD 7hR 6rfA==	4DjQ2xjBJDo8WMt 	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
22	8f1P0zDC0E5wyA==	OJ1Mz1FQyj0YGtU=	Link	1	2021-04-11 15:21:16+01	2021-04-11 15:21:16+01
23	CCnV	ibpSXSfiiktzvo7HE6SSaYAn	Link	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
24	wEXVm4L3LxalkPlh	a7ARimEUMPwRjiKGXn0=	Link	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
25	change	MYmb/PlD9BsDMhrD2Xwssw==	Text	1	2021-04-11 15:21:17+01	2021-04-15 13:17:55+01
26	2mXBtLN eNcK	tTyFwApqh56Bdnkw4jeMdA==	Link	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
27	HxU4hsz/	qbNEQuga0Ia ldYeuRAw/g==	Link	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
28	NlVNUE9r Q==	IWeqTwFrtM71wZdtD2y1	Text	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
29	DfXXzA==	dnwiqfRNCS0T2Dm2Ks2JttA=	Link	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
30	UA/l	thze90U5KiCv HVaZnykhw==	Text	1	2021-04-11 15:21:17+01	2021-04-11 15:21:17+01
31	Hello	Kitty	Text	1	2021-04-15 12:00:25+01	2021-04-15 12:00:25+01
32	dede	Collaboratively grow worldwide benefits vis-a-vis client-centric portals. Quickly myocardinate mission-critical quality vectors before interoperable resources. Phosfluorescently empower front-end growth strategies vis-a-vis out-of-the-box.	Text	1	2021-04-15 12:45:05+01	2021-04-15 12:45:05+01
35	dedem	Helo\r\nKitt	Text	1	2021-04-15 13:02:42+01	2021-04-15 13:02:42+01
36	sesso	ddede\n\r\nhello\ntiti	Text	1	2021-04-15 13:04:42+01	2021-04-15 13:04:42+01
37	w	dede\r\nfrfr	Text	1	2021-04-15 13:06:04+01	2021-04-15 13:06:04+01
38	e	a\r\nd\r\nc\r\nc	Text	1	2021-04-15 13:07:00+01	2021-04-15 16:19:07+01
39	qw	q\r\nw\r\ne\r\nr\r\nd	Text	1	2021-04-15 13:27:01+01	2021-04-15 13:27:01+01
72	dedesa	jk	Text	1	2021-04-15 16:02:40+01	2021-04-15 16:29:07+01
73	Hellog	Voici	Link	1	2021-04-15 17:09:42+01	2021-04-15 17:09:42+01
74	Hellog t	Jshs	Text	1	2021-04-15 17:10:04+01	2021-04-15 17:10:04+01
75	helloY	Gff	Text	1	2021-04-15 17:16:33+01	2021-04-15 17:16:52+01
76	KATY	Hello	Text	1	2021-04-16 13:53:00+01	2021-04-16 15:32:36+01
77	tata	Koumi nimi tity <b>Halodny</b>	Text	1	2021-04-22 10:24:05+01	2021-04-22 10:24:05+01
79		12	Text	30	2021-04-23 14:07:32+01	2021-04-23 14:08:00+01
80	aqaqaq	aaaaaaaaaaaaaa	Text	30	2021-04-23 14:20:08+01	2021-04-23 14:20:08+01
81	@sw	swsw	Text	30	2021-04-23 14:20:26+01	2021-04-23 14:44:41+01
\.


--
-- PostgreSQL database dump complete
--

