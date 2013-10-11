CREATE TABLE IF NOT EXISTS `calificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_aviso` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detalle` text COLLATE utf8_spanish_ci NOT NULL,
  `r_recomendado` decimal(10,0) NOT NULL,
  `r_confiable` decimal(10,0) NOT NULL,
  `r_responsable` decimal(10,0) NOT NULL,
  `r_calidad` decimal(10,0) NOT NULL,
  `r_experiencia` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

ALTER TABLE  `usuario` ADD  `r_recomendado` DECIMAL NOT NULL ,
ADD  `r_confiable` DECIMAL NOT NULL ,
ADD  `r_responsable` DECIMAL NOT NULL ,
ADD  `r_calidad` DECIMAL NOT NULL ,
ADD  `r_experiencia` DECIMAL NOT NULL;

ALTER TABLE  `usuario` CHANGE  `r_recomendado`  `r_recomendado` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_confiable`  `r_confiable` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_responsable`  `r_responsable` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_calidad`  `r_calidad` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_experiencia`  `r_experiencia` DECIMAL( 10, 1 ) NOT NULL;

ALTER TABLE  `calificacion` CHANGE  `r_recomendado`  `r_recomendado` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_confiable`  `r_confiable` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_responsable`  `r_responsable` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_calidad`  `r_calidad` DECIMAL( 10, 1 ) NOT NULL ,
CHANGE  `r_experiencia`  `r_experiencia` DECIMAL( 10, 1 ) NOT NULL;