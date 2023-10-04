DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos (
    id           BIGSERIAL    PRIMARY KEY,
    codigo       NUMERIC(2)   NOT NULL UNIQUE,
    denominacion VARCHAR(255) NOT NULL,
    localidad    VARCHAR(255)
);

INSERT INTO departamentos (codigo, denominacion, localidad)
    VALUES (10, 'Informática', 'Sanlúcar'),
           (20, 'Administrativo', 'Jerez'),
           (30, 'Prevención', 'Trebujena'),
           (40, 'Laboratorio', 'Chipiona');
