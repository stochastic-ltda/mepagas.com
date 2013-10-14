ALTER TABLE  `categoria` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `categoria` CHANGE  `nombre`  `nombre` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `categoria` CHANGE  `permalink`  `permalink` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE  `categoria` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `categoria_2` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `categoria_2` CHANGE  `id_categoria`  `id_categoria` INT( 11 ) NOT NULL;
ALTER TABLE  `categoria_2` CHANGE  `nombre`  `nombre` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `categoria_2` CHANGE  `permalink`  `permalink` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE  `categoria_2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `aviso` CHANGE  `categoria`  `categoria` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `aviso` CHANGE  `subcategoria`  `subcategoria` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `aviso` CHANGE  `descripcion`  `descripcion` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;