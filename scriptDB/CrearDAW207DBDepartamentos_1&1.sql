
 
/* Usar la base de datos creada */
    USE db771560824;

/* Creación de la table departamento */
CREATE TABLE IF NOT EXISTS Departamento (
    CodDepartamento CHAR(3) PRIMARY KEY,
    DescDepartamento VARCHAR(255) NOT NULL,
    FechaBaja DATE NULL,
    VolumenNegocio float NULL
)  ENGINE=INNODB;

