SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `bd_reservas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `bd_reservas`;


/*Estructura de tabla para la tabla `tbl_recursos`*/
CREATE TABLE IF NOT EXISTS `tbl_recursos` (
	`rec_id` int(11) NOT NULL,
	`rec_contingut` varchar(255) NOT NULL,
	`rec_descripció` varchar(255) NOT NULL,
	`rec_reservado` boolean NOT NULL default true,
	`rec_desactivat` boolean NOT NULL default true
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*ASSIGNACIÓ DE CLAU PRIMARIA*/	;
			ALTER TABLE `tbl_recursos`
			ADD CONSTRAINT PRIMARY KEY (rec_id);
/* Modificació a autoincremental */;
			ALTER TABLE `tbl_recursos`
			MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT;	
/* Modificació de la taula Recursos*/;
			ALTER TABLE `tbl_reservas`
			ADD id_tipus_recurs varchar(50) NULL;	
/* INSERTAR DADES A LA TAULA RECURSOS */
INSERT INTO `tbl_recursos`(`rec_id`, `rec_contingut`, `id_tipus_recurs`)VALUES
(1,'Aula de teoria 1'),
(2,'Aula de teoria 2'),
(3,'Aula de teoria 3'),
(4,'Aula de teoria 4'),
(5,'Aula informatica 1'),
(6,'Aula informatica 2'),
(7,'Despatx per a entrevistes 1'),
(8,'Despatx per a entrevistes 2'),
(9,'Sala de reunions'),
(10,'Projector portatil'),
(11,'Carro de portatils'),
(12,'Portatil 1'),
(13,'Portatil 2'),
(14,'Portatil 3'),
(15,'Mobil 1'),
(16,'Mobil 2');

			
CREATE TABLE IF NOT EXISTS `tbl_usuario` (
	`usu_email` varchar(50) NOT NULL,
	`usu_contra` varchar(14) NOT NULL,
	`usu_nom` varchar(35) NOT NULL,
	`usu_rang` boolean NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*ASSIGNACIÓ DE CLAU PRIMARIA*/	;
			ALTER TABLE `tbl_usuario`
			ADD CONSTRAINT PRIMARY KEY (usu_email);
/* INSERTAR DADES A LA TAULA USUARIO */
INSERT INTO `tbl_usuario`(`usu_email`, `usu_contra`, `usu_nom`, `usu_rang`)VALUES
('jorge.jeo@msn.com','1234qwer','Jorge',1),
('oriol.jeo@msn.com','qwer1234','Oriol',1),
('enric.jeo@msn.com','12qw34er','Enric',1),
('aitor.jeo@msn.com','1q2w3e4r','Aitor',1),
('david.jeo@msn.com','r4e3w2q1','David',1),
('xavi.jeo@msn.com','13qe24wr','Xavi',1),
('alejandro.jeo@msn.com','r3w1e2q4','Alejandro',1),
('victor.jeo@msn.com','1r2e3w4q','Victor',1),
('agnes.jeo@msn.com','q1w2e3r4','Agnes',1),
('it.jeo@msn.com','administra','IT',0);

			
CREATE TABLE IF NOT EXISTS `tbl_reservas` (
	`res_id` int(11) NOT NULL,
	`res_fecha_ini` date NOT NULL,
	`res_hora_ini` varchar(8) NOT NULL,
	`res_fecha_fin` date NOT NULL,
	`res_hora_fin` varchar(8) NOT NULL,
	`res_incidencia` boolean NOT NULL default true,
	`res_incidencia_coment` varchar(255) NOT NULL,
	`res_incidencia_usu_email` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*ASSIGNACIÓ DE CLAU PRIMARIA*/	;
			ALTER TABLE `tbl_reservas`
			ADD CONSTRAINT PRIMARY KEY (res_id);
/* Modificació a autoincremental */;
			ALTER TABLE `tbl_reservas`
			MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;	
/* Modificació de la taula Jugador*/;
			ALTER TABLE `tbl_reservas`
			ADD UsuarioReservante varchar(50) NULL;	
			ALTER TABLE `tbl_reservas`
			ADD idRecurso int(11) NULL;	


	
	/* RELACIONS*/
/* FK tbl_reservas PK tbl_usuario */;
ALTER TABLE `tbl_reservas`
ADD CONSTRAINT FOREIGN KEY (UsuarioReservante)
REFERENCES `tbl_usuario` (usu_email);
/* FK tbl_reservas PK tbl_recursos */;
ALTER TABLE `tbl_reservas`
ADD CONSTRAINT FOREIGN KEY (idRecurso)
REFERENCES `tbl_recursos` (rec_id);