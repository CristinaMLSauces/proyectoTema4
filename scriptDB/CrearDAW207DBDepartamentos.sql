
/*Creacion de la base de datos DAW207DBDepartamentos*/
CREATE DATABASE IF NOT EXISTS DAW207DBDepartamentos;

/* Creacion de usuario administrador de la base de datos: usuarioDAW207DBDepartamentos / paso */
CREATE USER 'usuarioDAW207DBDepartamentos'@'%' IDENTIFIED BY 'P@ssw0rd';
/* Permisos para la base de datos */
GRANT ALL PRIVILEGES ON DAW207DBDepartamentos.* TO 'usuarioDAW207DBDepartamentos'@'%' WITH GRANT OPTION;
/* Usar la base de datos creada */
USE DAW207DBDepartamentos;

/* Creación de la table departamento */
CREATE TABLE IF NOT EXISTS Departamento (
    CodDepartamento CHAR(3) PRIMARY KEY,
    DescDepartamento VARCHAR(255) NOT NULL,
    FechaBaja DATE NULL,
    VolumenNegocio float NULL
)  ENGINE=INNODB;

