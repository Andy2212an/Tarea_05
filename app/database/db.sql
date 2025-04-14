CREATE DATABASE cursos;
USE cursos;

CREATE TABLE categorias
(
	id 				INT AUTO_INCREMENT PRIMARY KEY,
    categoria 		VARCHAR(40) 	NOT NULL,
    creado 			DATETIME 		NOT NULL DEFAULT NOW(),
    modificado 		DATETIME		NULL,
    CONSTRAINT uk_categoria UNIQUE (categoria)
)ENGINE = INNODB;

CREATE TABLE cursos
(
	id 				INT AUTO_INCREMENT PRIMARY KEY,
    idcategoria 	INT 			NOT NULL,
    titulo 			VARCHAR(100) 	NOT NULL,
    duracion 		VARCHAR(50) 	NOT NULL,
    nivel 			ENUM('Básico', 'Intermedio', 'Avanzado') NOT NULL DEFAULT 'Básico',
    precio			DECIMAL(7,2) 	NOT NULL,
    fechas 			VARCHAR(100) 	NOT NULL,
    creado			DATETIME 		NOT NULL DEFAULT NOW(),
    modificado 		DATETIME 		NULL,
    CONSTRAINT fk_idcategoria_curso FOREIGN KEY (idcategoria) REFERENCES categorias (id)
)ENGINE = INNODB;

INSERT INTO categorias (categoria) VALUES
	('Matemáticas'),
    ('Literatura'),
    ('Informática');

INSERT INTO cursos (idcategoria, titulo, duracion, nivel, precio, fechas) VALUES
	(1, 'Álgebra Básica', '3 meses', 'Básico', 150.00, 'Enero - Marzo'),
    (2, 'Literatura Clásica', '4 meses', 'Intermedio', 200.00, 'Febrero - Mayo'),
    (3, 'Programación en Python', '6 meses', 'Avanzado', 300.00, 'Marzo - Agosto');

-- Objetos más utilizados en BD relacionales
-- Tabla			: contenedor de datos
-- Vistas			: consulta con un nombre
-- Procedimientos	: programa (algoritmo) que se ejecuta SGBD - Input / Output
-- Triggers			: disparador (automática)
-- Funciones		: método (tarea programada)

CREATE VIEW vista_cursos_todos
AS
	SELECT
		CR.id,
        CT.categoria,
        CR.titulo,
        CR.duracion,
        CR.nivel,
        CR.precio,
        CR.fechas
    FROM cursos CR
    INNER JOIN categorias CT ON CR.idcategoria = CT.id
    ORDER BY CR.id;

-- El cliente ha solicitado filtrar los cursos según su nivel
-- Delimitadores = MYSQL | MARIADB
-- SPU = Store Procedure User
DELIMITER //
CREATE PROCEDURE spu_cursos_filtrar_nivel(IN _nivel ENUM('Básico', 'Intermedio', 'Avanzado'))
BEGIN
	SELECT * FROM vista_cursos_todos WHERE nivel = _nivel;
END //

DELIMITER //
CREATE PROCEDURE spu_cursos_registrar(
	IN _idcategoria 	INT, 
    IN _titulo 			VARCHAR(100),
    IN _duracion 		VARCHAR(50),
    IN _nivel 			ENUM('Básico', 'Intermedio', 'Avanzado'),
    IN _precio 			DECIMAL(7,2),
    IN _fechas 			VARCHAR(100)
)
BEGIN
	INSERT INTO cursos (idcategoria, titulo, duracion, nivel, precio, fechas) 
		VALUES
        (_idcategoria, _titulo, _duracion, _nivel, _precio, _fechas);
END //

DELIMITER //
CREATE PROCEDURE spu_cursos_actualizar(
	IN _idcurso 		INT,
	IN _idcategoria 	INT, 
    IN _titulo 			VARCHAR(100),
    IN _duracion 		VARCHAR(50),
    IN _nivel 			ENUM('Básico', 'Intermedio', 'Avanzado'),
    IN _precio 			DECIMAL(7,2),
    IN _fechas 			VARCHAR(100)
)
BEGIN
	UPDATE cursos 
	SET 
		idcategoria = _idcategoria,
		titulo = _titulo,
		duracion = _duracion,
		nivel = _nivel,
		precio = _precio,
		fechas = _fechas,
		modificado = NOW()
	WHERE id = _idcurso;
END //

-- TRIGGER = desencadenador / disparador / EVENTO
-- Se ejecuta al CREAR / ELIMINAR
-- Objetivo: Cuando se actualice cualquier campo de la tabla "Cursos", registramos la FECHA+HORA
DELIMITER //
CREATE TRIGGER cursos_actualizar_fecha_modificacion
BEFORE UPDATE ON cursos
FOR EACH ROW
BEGIN
	SET NEW.modificado = NOW();
END //
SELECT * FROM vista_cursos_todos; 