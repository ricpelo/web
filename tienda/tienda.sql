DROP TABLE IF EXISTS articulos CASCADE;

CREATE TABLE articulos (
    id BIGSERIAL PRIMARY KEY,
    codigo NUMERIC(4) NOT NULL UNIQUE,
    denominacion VARCHAR(255) NOT NULL,
    precio NUMERIC(6,2) NOT NULL
);

INSERT INTO articulos (codigo, denominacion, precio)
    VALUES (1111, 'Tornillo', 40.00),
           (2222, 'Tuerca', 22.00);
