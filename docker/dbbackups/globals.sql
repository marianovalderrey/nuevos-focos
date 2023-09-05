--
-- PostgreSQL database cluster dump
--

SET default_transaction_read_only = off;

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

--
-- Roles
--

CREATE ROLE camposatelital_u5r;
ALTER ROLE camposatelital_u5r WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:jWYdpJg7dETaACbzsWbPxA==$1KjvDqS9vicEcSnZ8D4vz9rMeZhEOif5Xq0n6SkJsfw=:WSOCjLkUnQECbbUVtfDFSdjwcTEeuT7GUfnskhs6BvM=';

--
-- User Configurations
--








--
-- PostgreSQL database cluster dump complete
--

