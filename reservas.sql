SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `bd_reservas_millorat` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `bd_reservas_millorat`;


/*Estructura de tabla para la tabla `tbl_recursos`*/
CREATE TABLE IF NOT EXISTS `tbl_recursos` (
	`rec_id` int(11) NOT NULL,
	`rec_contingut` varchar(55) NOT NULL,
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
			ALTER TABLE `tbl_recursos`
			ADD id_tipus_recurs int(11) NULL;	
/* INSERTAR DADES A LA TAULA RECURSOS */
INSERT INTO `tbl_recursos`(`rec_id`, `rec_contingut`, `rec_descripció`, `id_tipus_recurs`)VALUES
(1,'Aula de teoria 1', 'Aula de teoria per 30 alumnes', 1),
(2,'Aula de teoria 2', 'Aula de teoria per 35 alumnes', 1),
(3,'Aula de teoria 3', 'Aula de teoria per 25 alumnes', 1),
(4,'Aula de teoria 4', 'Aula de teoria per 40 alumnes', 1),
(5,'Aula informatica 1', 'Aula de teoria per 30 alumnes', 2),
(6,'Aula informatica 2', 'Aula de teoria per 20 alumnes', 2),
(7,'Despatx per a entrevistes 1', 'Despatx petit per reunions amb pares', 3),
(8,'Despatx per a entrevistes 2', 'Despatx gran per reunions amb pares', 3),
(9,'Sala de reunions', 'Sala gran per reunions administratives', 4),
(10,'Projector portatil', 'Projector portatil per ', 5),
(11,'Carro de portatils', 'Carro de portatils amb 25 ordinadors portatils Toshiba amb carregador', 6),
(12, 'Portatil 1', 'Portatil Acer 1T disc dur i 8GB ram', 7),
(13, 'Portatil 2', 'Portatil Acer 1T disc dur i 8GB ram', 7),
(14, 'Portatil 3', 'Portatil Acer 1T disc dur i 8GB ram', 7),
(15, 'Mobil 1', 'Mobil samsung per a excursions i sortides amb alumnes', 8),
(16, 'Mobil 2', 'Mobil samsung per a excursions i sortides amb alumnes', 8);

/*Estructura de tabla para la tabla `tbl_tipus_recurs`*/
CREATE TABLE IF NOT EXISTS `tbl_tipo_recursos` (
	`id_tipus` int(11) NOT NULL,
	`nom_tipus` varchar(55) NOT NULL,
	`tipus_recurs` varchar(55) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*ASSIGNACIÓ DE CLAU PRIMARIA*/	;
			ALTER TABLE `tbl_tipo_recursos`
			ADD CONSTRAINT PRIMARY KEY (id_tipus);
/* Modificació a autoincremental */;
			ALTER TABLE `tbl_tipo_recursos`
			MODIFY `id_tipus` int(11) NOT NULL AUTO_INCREMENT;
/* INSERTAR DADES A LA TAULA tbl_tipus_recurs */
INSERT INTO `tbl_tipo_recursos`(`id_tipus`, `nom_tipus`, `tipus_recurs`)VALUES
(1,'Aula de teoria', 'Aula'),
(2,'Aula informatica', 'Aula'),
(3,'Despatx per a entrevistes', 'Despatx'),
(4,'Sala de reunions', 'Sala'),
(5,'Projector portatil', 'Material'),
(6,'Carro de portatils', 'Material'),
(7,'Portatil', 'Material'),
(8,'Mobil', 'Material');


/*Estructura de tabla para la tabla `tbl_usuario`*/			
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
	`res_hora_ini` varchar(5) NOT NULL,
	`res_fecha_fin` date NOT NULL,
	`res_hora_fin` varchar(5) NOT NULL,
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
/* FK tbl_recursos PK tbl_tipo_recursos */;
ALTER TABLE `tbl_recursos`
ADD CONSTRAINT FOREIGN KEY (id_tipus_recurs)
REFERENCES `tbl_tipo_recursos` (id_tipus);