UPDATE  `mepagas`.`precio` SET  `valor` =  '250000',`nombre` =  '$ 250.000' WHERE  `precio`.`valor` =200000;

ALTER TABLE  `precio` CHANGE  `nombre`  `nombre` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL;

DELETE FROM precio WHERE valor = '150000';

INSERT INTO  `mepagas`.`precio` (`valor` ,`nombre`) VALUES ('500000',  '$ 500.000'), ('1000000',  '$ 1.000.000');

INSERT INTO  `mepagas`.`localidad` (`id` ,`nombre` ,`permalink`) VALUES (NULL ,  'Todo Chile',  'todo-chile');
