DROP TABLE categorias;

CREATE TABLE `categorias` (
  `receta_id` int(11) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  PRIMARY KEY (`receta_id`,`categorias_id`),
  KEY `ganon` (`categorias_id`),
  CONSTRAINT `ganon` FOREIGN KEY (`categorias_id`) REFERENCES `listacategorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pipo3` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categorias VALUES("1","7");
INSERT INTO categorias VALUES("1","9");
INSERT INTO categorias VALUES("2","1");
INSERT INTO categorias VALUES("2","7");
INSERT INTO categorias VALUES("2","8");
INSERT INTO categorias VALUES("3","7");
INSERT INTO categorias VALUES("3","9");
INSERT INTO categorias VALUES("3","10");
INSERT INTO categorias VALUES("4","7");
INSERT INTO categorias VALUES("4","9");
INSERT INTO categorias VALUES("4","10");
INSERT INTO categorias VALUES("5","3");
INSERT INTO categorias VALUES("5","4");
INSERT INTO categorias VALUES("5","8");
INSERT INTO categorias VALUES("6","7");
INSERT INTO categorias VALUES("6","9");
INSERT INTO categorias VALUES("7","7");
INSERT INTO categorias VALUES("7","9");
INSERT INTO categorias VALUES("7","10");



DROP TABLE comentarios;

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `receta_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `pipo2` (`receta_id`),
  KEY `metroid65` (`usuario_id`),
  CONSTRAINT `metroid2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pipo2` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

INSERT INTO comentarios VALUES("2","1","1","Este comentario es de prueba","2020-06-04 18:58:31");
INSERT INTO comentarios VALUES("12","100","1","Me gusta esta receta","2020-06-04 20:00:34");
INSERT INTO comentarios VALUES("13","1","3","Esto me gusta","2020-06-13 14:57:34");
INSERT INTO comentarios VALUES("14","1","5","Me gusta mucho como queda","2020-06-14 19:59:36");
INSERT INTO comentarios VALUES("15","1","2","Se me quem&oacute; la cocina","2020-06-14 20:00:18");
INSERT INTO comentarios VALUES("16","1","4","Est&aacute;n riqu&iacute;simas","2020-06-14 20:02:27");
INSERT INTO comentarios VALUES("17","108","4","A mi no me gustaron tanto","2020-06-14 20:03:17");
INSERT INTO comentarios VALUES("18","110","5","A mi no me gusta tanto","2020-06-14 20:10:55");
INSERT INTO comentarios VALUES("19","110","2","Alguien sabe por a cu&aacute;ntos grados hay que poner el fuego?","2020-06-14 20:12:25");
INSERT INTO comentarios VALUES("20","100","1","Hola, soy an&oacute;nimo y puedo comentar sin registrarme ","2020-06-14 20:14:15");
INSERT INTO comentarios VALUES("21","111","6","Soy un Delf&iacute;n!!!","2020-06-14 20:22:58");



DROP TABLE listacategorias;

CREATE TABLE `listacategorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

INSERT INTO listacategorias VALUES("1","Carne");
INSERT INTO listacategorias VALUES("2","Pescado");
INSERT INTO listacategorias VALUES("3","Arroz");
INSERT INTO listacategorias VALUES("4","Sopa");
INSERT INTO listacategorias VALUES("5","Fácil");
INSERT INTO listacategorias VALUES("6","Difícil");
INSERT INTO listacategorias VALUES("7","Ligero");
INSERT INTO listacategorias VALUES("8","Pesado");
INSERT INTO listacategorias VALUES("9","Postre");
INSERT INTO listacategorias VALUES("10","Merienda");
INSERT INTO listacategorias VALUES("19","CategoriaPrueba");



DROP TABLE log;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4;

INSERT INTO log VALUES("17","2020-06-01 17:51:31","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("18","2020-06-01 22:58:33","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("19","2020-06-01 22:58:44","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("20","2020-06-02 12:48:19","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("21","2020-06-02 12:48:21","El usuario / ha cerrado sesión");
INSERT INTO log VALUES("22","2020-06-02 12:48:22","El usuario / ha cerrado sesión");
INSERT INTO log VALUES("23","2020-06-02 12:53:28","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("24","2020-06-02 13:07:48","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("25","2020-06-02 13:07:59","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("26","2020-06-02 14:52:53","El usuario colab@colab.com ha cerrado sesión");
INSERT INTO log VALUES("27","2020-06-02 14:53:00","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("28","2020-06-02 14:53:03","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("29","2020-06-02 14:53:05","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("30","2020-06-02 14:54:20","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("31","2020-06-02 14:58:40","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("32","2020-06-02 15:00:56","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("33","2020-06-02 15:09:52","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("34","2020-06-04 19:02:36","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("35","2020-06-04 19:32:13","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("36","2020-06-04 19:32:21","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("37","2020-06-04 19:32:24","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("38","2020-06-04 19:32:27","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("39","2020-06-04 19:32:31","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("40","2020-06-04 19:32:33","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("41","2020-06-04 19:32:36","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("42","2020-06-04 19:32:38","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("43","2020-06-04 19:32:41","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("44","2020-06-04 19:58:06","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("45","2020-06-04 20:01:03","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("46","2020-06-04 20:01:07","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("47","2020-06-04 20:01:11","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("48","2020-06-04 20:01:14","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("49","2020-06-04 20:01:31","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("50","2020-06-04 20:01:33","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("51","2020-06-04 20:03:35","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("52","2020-06-04 20:03:36","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("53","2020-06-04 20:03:43","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("54","2020-06-04 20:03:45","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("55","2020-06-04 20:03:50","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("56","2020-06-04 20:03:53","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("57","2020-06-04 20:03:55","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("58","2020-06-04 20:03:59","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("59","2020-06-04 20:04:01","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("60","2020-06-04 20:04:24","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("61","2020-06-10 15:48:18","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("62","2020-06-10 15:48:24","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("63","2020-06-10 15:48:58","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("64","2020-06-11 10:35:10","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("65","2020-06-11 13:21:24","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("66","2020-06-11 13:29:09","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("67","2020-06-11 13:59:06","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("68","2020-06-11 13:59:55","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("69","2020-06-11 14:03:13","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("70","2020-06-11 14:03:16","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("71","2020-06-11 14:04:29","El usuario colab@colab.com ha cerrado sesión");
INSERT INTO log VALUES("72","2020-06-11 14:05:09","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("73","2020-06-11 23:13:17","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("74","2020-06-11 23:13:30","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("75","2020-06-12 02:01:26","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("76","2020-06-12 02:01:30","El usuario prueba@prueba.com ha iniciado sesión");
INSERT INTO log VALUES("77","2020-06-12 02:01:38","El usuario prueba@prueba.com ha iniciado sesión");
INSERT INTO log VALUES("78","2020-06-12 02:03:11","El usuario prueba@prueba.com ha iniciado sesión");
INSERT INTO log VALUES("79","2020-06-12 02:03:21","El usuario prueba@prueba.com ha cerrado sesión");
INSERT INTO log VALUES("80","2020-06-12 02:03:23","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("81","2020-06-12 03:22:50","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("82","2020-06-12 03:22:56","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("83","2020-06-12 03:22:59","El usuario colab@colab.com ha cerrado sesión");
INSERT INTO log VALUES("84","2020-06-12 03:23:01","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("85","2020-06-12 03:23:09","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("86","2020-06-12 03:23:13","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("87","2020-06-12 03:40:23","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("88","2020-06-12 09:25:39","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("89","2020-06-12 09:26:01","El usuario admin@admin.com ha añadido nueva categoría");
INSERT INTO log VALUES("90","2020-06-12 09:26:16","El usuario admin@admin.com ha añadido una nueva receta");
INSERT INTO log VALUES("91","2020-06-12 09:26:29","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("92","2020-06-12 09:27:03","El usuario admin@admin.com ha borrado una receta");
INSERT INTO log VALUES("93","2020-06-12 09:33:04","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("94","2020-06-12 09:33:07","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("95","2020-06-12 09:51:30","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("96","2020-06-12 09:57:23","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("97","2020-06-12 09:57:31","El usuario Prueba@gmail.com ha iniciado sesión");
INSERT INTO log VALUES("98","2020-06-12 09:57:42","El usuario Prueba@gmail.com ha ha borrado a si mismo");
INSERT INTO log VALUES("99","2020-06-12 09:59:06","El usuario  ha ha borrado un usuario");
INSERT INTO log VALUES("100","2020-06-12 09:59:10","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("101","2020-06-12 09:59:11","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("102","2020-06-12 09:59:14","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("103","2020-06-12 09:59:31","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("104","2020-06-12 09:59:36","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("105","2020-06-12 10:00:30","El usuario darokoficial@gmail.com ha iniciado sesión");
INSERT INTO log VALUES("106","2020-06-12 10:00:36","El usuario darokoficial@gmail.com ha ha borrado a si mismo");
INSERT INTO log VALUES("107","2020-06-12 10:00:47","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("108","2020-06-13 12:05:05","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("109","2020-06-13 14:57:09","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("110","2020-06-13 14:57:35","El usuario admin@admin.com ha ha comentado en una receta");
INSERT INTO log VALUES("111","2020-06-14 11:59:46","El usuario admin@admin.com ha añadido una nueva receta");
INSERT INTO log VALUES("112","2020-06-14 12:01:22","El usuario admin@admin.com ha borrado una receta");
INSERT INTO log VALUES("113","2020-06-14 12:31:33","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("114","2020-06-14 12:31:38","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("115","2020-06-14 12:31:46","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("116","2020-06-14 12:31:53","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("117","2020-06-14 12:32:11","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("118","2020-06-14 12:32:20","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("119","2020-06-14 12:32:27","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("120","2020-06-14 12:33:03","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("121","2020-06-14 12:37:45","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("122","2020-06-14 12:39:46","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("123","2020-06-14 12:41:21","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("124","2020-06-14 12:43:45","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("125","2020-06-14 12:43:50","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("126","2020-06-14 12:45:10","El usuario colab@colab.com ha cerrado sesión");
INSERT INTO log VALUES("127","2020-06-14 12:45:13","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("128","2020-06-14 12:45:43","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("129","2020-06-14 12:46:38","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("130","2020-06-14 12:48:17","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("131","2020-06-14 13:00:14","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("132","2020-06-14 13:01:17","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("133","2020-06-14 13:01:34","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("134","2020-06-14 13:01:40","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("135","2020-06-14 13:01:49","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("136","2020-06-14 13:01:56","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("137","2020-06-14 13:05:59","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("138","2020-06-14 13:08:11","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("139","2020-06-14 13:09:49","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("140","2020-06-14 13:10:09","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("141","2020-06-14 13:10:58","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("142","2020-06-14 13:13:51","El usuario ewiwi@uwu.owo ha iniciado sesión");
INSERT INTO log VALUES("143","2020-06-14 13:14:07","El usuario ewiwi@uwu.owo ha cerrado sesión");
INSERT INTO log VALUES("144","2020-06-14 13:14:17","El usuario ewiwi@uwu.owo ha iniciado sesión");
INSERT INTO log VALUES("145","2020-06-14 19:52:55","El usuario ewiwi@uwu.owo ha cerrado sesión");
INSERT INTO log VALUES("146","2020-06-14 19:52:59","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("147","2020-06-14 19:53:35","El usuario admin@admin.com ha ha borrado un usuario");
INSERT INTO log VALUES("148","2020-06-14 19:54:27","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("149","2020-06-14 19:55:21","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("150","2020-06-14 19:56:18","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("151","2020-06-14 19:56:49","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("152","2020-06-14 19:58:13","El usuario admin@admin.com ha añadido nuevo usuario");
INSERT INTO log VALUES("153","2020-06-14 19:58:47","El usuario admin@admin.com ha valorado una receta");
INSERT INTO log VALUES("154","2020-06-14 19:59:16","El usuario admin@admin.com ha valorado una receta");
INSERT INTO log VALUES("155","2020-06-14 19:59:36","El usuario admin@admin.com ha ha comentado en una receta");
INSERT INTO log VALUES("156","2020-06-14 19:59:44","El usuario admin@admin.com ha ha borrado un comentario");
INSERT INTO log VALUES("157","2020-06-14 20:00:18","El usuario admin@admin.com ha ha comentado en una receta");
INSERT INTO log VALUES("158","2020-06-14 20:02:27","El usuario admin@admin.com ha ha comentado en una receta");
INSERT INTO log VALUES("159","2020-06-14 20:02:42","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("160","2020-06-14 20:02:58","El usuario david@david.com ha iniciado sesión");
INSERT INTO log VALUES("161","2020-06-14 20:03:17","El usuario david@david.com ha ha comentado en una receta");
INSERT INTO log VALUES("162","2020-06-14 20:04:03","El usuario david@david.com ha modificado un usuario");
INSERT INTO log VALUES("163","2020-06-14 20:05:18","El usuario david@david.com ha modificado un usuario");
INSERT INTO log VALUES("164","2020-06-14 20:05:48","El usuario david@david.com ha modificado un usuario");
INSERT INTO log VALUES("165","2020-06-14 20:07:36","El usuario david@david.com ha modificado un usuario");
INSERT INTO log VALUES("166","2020-06-14 20:08:37","El usuario david@david.com ha cerrado sesión");
INSERT INTO log VALUES("167","2020-06-14 20:08:52","El usuario Guillermo@guillermo.com ha iniciado sesión");
INSERT INTO log VALUES("168","2020-06-14 20:09:49","El usuario Guillermo@guillermo.com ha modificado un usuario");
INSERT INTO log VALUES("169","2020-06-14 20:10:27","El usuario Guillermo@guillermo.com ha cerrado sesión");
INSERT INTO log VALUES("170","2020-06-14 20:10:31","El usuario javier@correo.com ha iniciado sesión");
INSERT INTO log VALUES("171","2020-06-14 20:10:55","El usuario javier@correo.com ha ha comentado en una receta");
INSERT INTO log VALUES("172","2020-06-14 20:12:25","El usuario javier@correo.com ha ha comentado en una receta");
INSERT INTO log VALUES("173","2020-06-14 20:13:43","El usuario javier@correo.com ha cerrado sesión");
INSERT INTO log VALUES("174","2020-06-14 20:14:15","El usuario  ha ha comentado en una receta");
INSERT INTO log VALUES("175","2020-06-14 20:15:47","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("176","2020-06-14 20:15:58","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("177","2020-06-14 20:16:01","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("178","2020-06-14 20:16:04","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("179","2020-06-14 20:16:47","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("180","2020-06-14 20:17:08","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("181","2020-06-14 20:17:33","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("182","2020-06-14 20:17:46","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("183","2020-06-14 20:18:24","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("184","2020-06-14 20:18:38","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("185","2020-06-14 20:19:24","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("186","2020-06-14 20:19:57","El usuario admin@admin.com ha modificado una receta");
INSERT INTO log VALUES("187","2020-06-14 20:20:31","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("188","2020-06-14 20:22:24","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("189","2020-06-14 20:22:41","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("190","2020-06-14 20:22:45","El usuario paula@correo.com ha iniciado sesión");
INSERT INTO log VALUES("191","2020-06-14 20:22:58","El usuario paula@correo.com ha ha comentado en una receta");
INSERT INTO log VALUES("192","2020-06-14 20:23:05","El usuario paula@correo.com ha cerrado sesión");
INSERT INTO log VALUES("193","2020-06-14 20:23:53","El usuario Guillermo@guillermo.com ha iniciado sesión");
INSERT INTO log VALUES("194","2020-06-14 20:24:00","El usuario Guillermo@guillermo.com ha cerrado sesión");
INSERT INTO log VALUES("195","2020-06-14 20:24:45","El usuario admin@admin.com ha iniciado sesión");
INSERT INTO log VALUES("196","2020-06-14 20:24:57","El usuario admin@admin.com ha modificado un usuario");
INSERT INTO log VALUES("197","2020-06-14 20:25:43","El usuario admin@admin.com ha cerrado sesión");
INSERT INTO log VALUES("198","2020-06-14 20:25:46","El usuario colab@colab.com ha iniciado sesión");
INSERT INTO log VALUES("199","2020-06-14 20:25:48","El usuario colab@colab.com ha cerrado sesión");
INSERT INTO log VALUES("200","2020-06-14 20:28:34","El usuario admin@admin.com ha iniciado sesión");



DROP TABLE receta;

CREATE TABLE `receta` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `ingredientes` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `preparacion` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `fotografia` text CHARACTER SET utf8mb4 NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `metroid` (`usuario_id`),
  CONSTRAINT `metroid` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO receta VALUES("1","Paparajotes","- 6 comensales- 10m- Dificultad baja","- 15 hojas de limonero (si conservan las puntas de la rama, mejor)- 1 cucharada postre de levadura qu&iacute;mica o polvo leudante- 1 vaso peque&ntilde;o de az&uacute;car morena- 2 huevos- 2 vasos de leche semi descremada- 200 gramos de harina com&uacute;n - Ralladura de una c&aacute;scara de lim&oacute;n- 1 pellizco de sal- 2 vasos de aceite de oliva para fre&iacute;r- 4 cucharadas soperas de az&uacute;car blanca- 1 cucharada postre de canela molida","- Es muy sencillo preparar la masa para forrar las hojas de limonero, pues es muy similar a la masa para bu&ntilde;uelos. Para empezar, bate los huevos con la sal y cuando formen una espuma, agrega el az&uacute;car y contin&uacute;a batiendo.- Ahora, ve agregando la harina lentamente y la levadura a mitad de la harina. Ve batiendo para que sea mas f&aacute;cil que se integren los ingredientes. Debe ir quedando una ligera crema.- A&ntilde;ade la ralladura lim&oacute;n y contin&uacute;a batiendo para que la mezcla quede totalmente homog&eacute;nea. Prepara una sart&eacute;n con aceite y ponla a calentar. Mientras tanto, prepara en un plato la mezcla de az&uacute;car blanca y canela para rebozar los paparajotes.- Lleva a un plato la masa de los paparajotes. Impregna las hojas de limonero con la masa y, con cuidado, fr&iacute;elas cuando veas que el aceite ya est&aacute; listo. Presta atenci&oacute;n para evitar que se tuesten demasiado al fre&iacute;rlas, con un par de minutos ambos lados ya estar&aacute;n listos.- Conforme vayas sacando los paparajotes, reb&oacute;zalos en az&uacute;car con canela y deja que se enfr&iacute;en en un plato aparte. No fr&iacute;as muchas hojas a la vez para evitar que se deformen.- &iexcl;Listo! Este es el resultado de estos dulces t&iacute;picos de Murcia. Los paparajotes se pueden comer en cualquier estaci&oacute;n, est&aacute;n ricos en cualquier momento, fr&iacute;os o calientes.","./styles/img/recetas/paparajotes.jpg","1");
INSERT INTO receta VALUES("2","Patas de pollo en salsa","- 2 comensales- 45m- Dificultad baja","- 5 patas de pollo- 1 trozo de cebolla- 1 puerro- 1 zanahoria- 1 diente de ajo- 1 hoja de laurel- 1 taza de tomate troceado sin piel- 3 pellizcos de romero y pimienta molida al gusto- 2 vasos de agua- 1 chorro de aceite de oliva","- Limpia meticulosamente las patas de pollo. Para saber c&oacute;mo limpiar patas de pollo, introduce las patas en un cazo con agua hirviendo durante 11 segundos. No dejes que pasen demasiado tiempo en el agua o la piel quedar&aacute; adherida y no podr&aacute;s sacarla con facilidad. Saca la piel y, ahora s&iacute;, d&eacute;jalas cociendo en agua con sal durante 30 minutos. Res&eacute;rvalas.- Prepara una olla a presi&oacute;n con un buen chorro de aceite. Corta el puerro, la zanahoria, la cebolla y pela el ajo. Introd&uacute;celos en la olla cuando el aceite est&eacute; caliente.- Rehoga las verduras durante 5 minutos y a&ntilde;ade el vino. Deja cocer 2 minutos y, a continuaci&oacute;n, agrega el tomate y sofr&iacute;e 2 minutos mas. Es importante que el tomate est&eacute; pelado para que despu&eacute;s, al triturar, no quede piel.- Remueve para que cueza bien, esta salsa tiene que quedar algo espesa, puesto que debe acompa&ntilde;ar a las patas de pollo cocidas y es un modo de a&ntilde;adir consistencia al plato.- Agrega 2 vasos de agua al sofrito y tapa la olla, dejando que cueza 5 minutos a partir de que empiece a salir el vapor por la v&aacute;lvula. Baja a fuego medio. Si no utilizas olla a presi&oacute;n, puedes dejar que cueza un poco m&aacute;s (al menos 15 minutos). La zanahoria debe quedar blanda para que en la salsa no salgan trozos duros.- Transcurrido este tiempo, tritura para formar la salsa de tomate y verduras. Esta debe de quedar suave, lisa y sin grumos, con una textura similar a la de una crema ligera. A&ntilde;&aacute;dele sal, pimienta, romero y laurel. Introduce las patas de pollo y m&eacute;zclalas con la salsa en la olla. Remueve y deja cocer por 5 minutos dejando la tapa entreabierta.- As&iacute; han quedado nuestras ricas patas de pollo en salsa. Puedes acompa&ntilde;arlas con un poco de pan casero para saborear.","./styles/img/recetas/patataspollo.jpg","2");
INSERT INTO receta VALUES("3","Natillas de turr&oacute;n","- 4 comensales- 45m- Dificultad baja","- 3 vasos de leche semi descremada- 250 gramos de turr&oacute;n blando- 40 gramos de harina de ma&iacute;z (⅓ taza)- 1 cucharada sopera de az&uacute;car morena- 1 vaso de nata para cocinar (ligera)","- En un vaso batidor introduce la leche, pero conserva unos 3 dedos para despu&eacute;s. Agrega la nata para cocinar y bate a mano o con aspas. Si bates la mezcla en un batidor, hazlo a velocidad lenta durante 1 minuto.- A&ntilde;ade tambi&eacute;n el turr&oacute;n y contin&uacute;a batiendo por 2 minutos m&aacute;s a la m&iacute;nima velocidad. Obtendr&aacute;s una crema l&iacute;quida y muy arom&aacute;tica.- A&ntilde;ade una cucharada colmada de az&uacute;car morena. Disuelve el az&uacute;car en la misma crema ya batida, no es necesario que acciones la batidora, simplemente debes disolver el az&uacute;car.- Pon un cazo en el fuego y vierte toda la crema batida de turr&oacute;n. Ve calentando a fuego lento sin dejar que hierva. Remueve a menudo para que la mezcla no se pegue al cazo.- Mientras tanto, disuelve la harina de ma&iacute;z en la leche que ten&iacute;as reservada, esta debe estar a temperatura ambiente. Remueve hasta que quede totalmente diluida.- A&ntilde;ade esta mezcla de harina y leche al cazo sin dejar de remover. Este paso es importante para que no se formen grumos y salga una natilla de turr&oacute;n perfecta. Remueve sin dejar reposar y a los pocos minutos notar&aacute;s que la mezcla comienza a espesar. Sigue mezclando por 3 minutos m&aacute;s.- Ya transcurridos esos minutos, reparte la natilla en los recipientes que hallas predispuesto, despu&eacute;s tomar&aacute;n mas cuerpo a medida que vayan enfriando, puedes espolvorear un poco de canela en polvo, nata o sirope, de los sabores que m&aacute;s te gusten, aunque como nosotros, decidimos utilizar un poco de canela para no distorsionar el sabor del turr&oacute;n tan excepcional e inconfundible.","./styles/img/recetas/natillas.jpg","1");
INSERT INTO receta VALUES("4","Galletas de chocolate","- 3 comensales- 30m- Dificultad baja","- 115 gramos de harina de trigo- 30 gramos de cacao en polvo- 80 gramos de Az&uacute;car moreno- 1 yogur griego sin az&uacute;car- 50 mililitros de aceite de girasol- 5 gramos de levadura qu&iacute;mica en polvo (polvos de hornear)- 1 paquete de pepitas de chocolate- 1 pizca de sal","- Pon la harina en un bol con el az&uacute;car, el cacao, la levadura y la pizca de sal, remueve y mezcla todos los ingredientes secos.- A&ntilde;ade el yogur y el aceite y mezcla hasta integrar bien todos los ingredientes. Ver&aacute;s que cuesta un poco unir todos los ingredientes, por lo que te animamos a trabajar la masa con las manos. Si la masa de galletas de chocolate sin mantequilla quedara muy banda, a&ntilde;ade un poco m&aacute;s de harina, mientras que si queda muy dura puedes verter un poco de agua.- A&ntilde;ade pepitas de chocolate a tu gusto y mezcla un poco m&aacute;s. Recuerda que puedes sustituir este ingrediente por frutos secos. Precalienta el horno a 180 &ordm;C con calor arriba y abajo.- Forra una bandeja de horno con papel vegetal, coge trozos de masa con una cuchara, forma bolas medianas y col&oacute;calas en la bandeja con cierta separaci&oacute;n entre ellas. Para decorar, pon m&aacute;s pepitas de chocolate en cada galleta. Aplasta un poco las galletas si las quieres m&aacute;s finas, si te gustan m&aacute;s gruesas y que queden por dentro tiernas y blanditas d&eacute;jalas m&aacute;s gorditas. Hornea las galletas de chocolate sin mantequilla durante 20 minutos y ret&iacute;ralas.- Reci&eacute;n salidas del horno han de quedar tiernas, ya que al enfriarse se quedan m&aacute;s duras. Si las dejas mucho en el horno se quedar&aacute;n muy secas y duras. Entonces, deja que se enfr&iacute;en por completo antes de comerlas.- &iexcl;Listas! Ya puedes disfrutar de tus galletas de chocolate sin mantequilla ni huevo. Puedes espolvorear un poco de az&uacute;car glas por encima, canela en polvo o dejarlas as&iacute;. Quedan deliciosas y no tienen nada que envidiar a las tradicionales galletas de mantequilla, de manera que si no dispones de este ingrediente, &iexcl;aqu&iacute; tienes una receta de galletas de chocolate sin mantequilla que te encantar&aacute;!","./styles/img/recetas/galletas.jpg","2");
INSERT INTO receta VALUES("5","Arroz caldoso con verduras","- 4 comensales- 45m- Dificultad baja","- 2 tomates- 150 gramos de jud&iacute;as verdes- 1 pimiento rojo peque&ntilde;o- 2 dientes de ajos- 6 alcachofas- 250 gramos de arroz- 1&frac12; mililitros de caldo de verduras- 1 pizca de sal- 1 cucharadita de piment&oacute;n dulce- 1 pizca de c&uacute;rcuma","- Lava y pela los tomates, troc&eacute;alos y retira las semillas. Pon los tomates troceados en el vaso de la batidora y trit&uacute;ralos. Reserva.- Prepara el resto de verduras, de manera que lava las jud&iacute;as verdes y c&oacute;rtalas en trocitos desechando las puntas. Lava los pimientos, retira las semillas y c&oacute;rtalo en trocitos. Pela los dientes de ajo y p&iacute;calos. Retira las hojas exteriores y m&aacute;s duras de las alcachofas. Corta tambi&eacute;n la parte de abajo de las alcachofas, deja la parte m&aacute;s tierna, c&oacute;rtala por la mitad y quita los pelitos del interior en el caso de que los tuviera.- Pon en una olla amplia las cucharadas de aceite de oliva y cali&eacute;ntalo. Cuando est&eacute; caliente, a&ntilde;ade todas las verdura troceadas menos el tomate. Pon un poquito de sal y sofr&iacute;e unos 5 minutos dando vueltas de vez en cuando.- Incorpora el tomate triturado y sorfr&iacute;e todo junto durante unos 3 minutos, removiendo de vez en cuando. El arroz caldoso con verduras queda mucho mejor si usas tomate triturado natural, pero si en estos momentos no dispones de tomates, puedes usar tomate triturado de bote.- A&ntilde;ade el arroz y remueve para que se impregne de los sabores del sofrito durante 2 minutos, mezclando continuamente.- Mientras est&aacute;s con el sofrito, pon a calentar el caldo vegetal hasta que hierva y agr&eacute;galo poco a poco a la olla con las verduras y el arroz. Remueve. Utiliza preferiblemente un caldo de verduras casero.- Incorpora a la olla una cucharadita de piment&oacute;n y una pizca de c&uacute;rcuma. Puedes a&ntilde;adir m&aacute;s o menos c&uacute;rcuma en funci&oacute;n del color que quieras que tenga tu arroz caldoso con verduras. Luego, cubre la cazuela con una tapa y deja que se cueza durante 18 minutos.- Sirve el arroz enseguida y a disfrutar. Esta receta de arroz caldoso con verduras queda realmente exquisita y es perfecta para cualquier d&iacute;a de la semana. No solo te ayudar&aacute; a combatir el fr&iacute;o, tambi&eacute;n te aportar&aacute; un extra de vitaminas, minerales y energ&iacute;a.","./styles/img/recetas/arroz.jpg","1");
INSERT INTO receta VALUES("6","Tarta de leche condensada","- 6 comensales- 4h- Dificultad baja","- 150 gramos de galletas- 80 gramos de mantequilla- 250 gramos de leche condensada- 300 mililitros de crema de leche o nata para montar- 5 hojas de gelatina neutra- 2 galletas para decorar","- Pon las hojas de gelatina en un bol o plato con agua fr&iacute;a y d&eacute;jalas unos 10 minutos para que se hidraten. Tambi&eacute;n puedes ver en este v&iacute;deo c&oacute;mo hidratar las l&aacute;minas de gelatina.- Para hacer la base de galletas, tritura las galletas con ayuda de un robot hasta dejarlas pulverizadas. Tambi&eacute;n puedes hacer este paso a mano introduciendo las galletas en una bolsa de pl&aacute;stico y pasando un rodillo por encima.- Derrite la mantequilla en el microondas unos segundos y m&eacute;zclala con las galletas hasta que quede como una arena mojada. Si hiciera falta se puede a&ntilde;adir un poco m&aacute;s de mantequilla.- Con esta mezcla de galletas cubre el fondo de un molde desmontable redondo o alargado de unos 18 a 20 cm. Cubre la base y las paredes y con ayuda de una cuchara presiona la masa de galletas para que quede bien compacta. Mete el molde en la nevera para seguir con la receta de tarta de leche condensada.- Pon la leche en un bol y cali&eacute;ntala en el microondas 1 minuto a 600 W o al fuego, pero no hay que dejarla que hierva, solo que se caliente. Escurre bien las hojas de gelatina y a&ntilde;&aacute;delas a la leche condensada caliente, removiendo bien hasta que se deshagan. Deja que se enfri&eacute; un poco esta mezcla.- En otro bol, agrega la nata bien fr&iacute;a y m&oacute;ntala con unas varillas el&eacute;ctricas o una batidora el&eacute;ctrica de mano. En este punto se pude a&ntilde;adir unos 50 gramos de az&uacute;car si te gustan los postres muy dulces.- Ve a&ntilde;adiendo la mezcla de la leche condensada a la nata montada poco a poco y mezclando con movimientos suaves. De esta forma, la tarta de leche condensada no perder&aacute; volumen y quedar&aacute; cremosa y esponjosa.- Saca el molde con la base de galletas, vierte en ella la mezcla y alisa la superficie de la tarta. Introd&uacute;cela en la nevera durante 3-4 horas o d&eacute;jala de un d&iacute;a para otro. Puedes adornar la tarta de leche condensada con galletas trituradas cuando est&eacute; cuajada, con virutas de chocolate, coco rallado...","./styles/img/recetas/tarta.jpg","1");
INSERT INTO receta VALUES("7","Pan integral sin gluten","- 4 comensales- 3h- Dificultad baja","- 500 gramos de harina de arroz integral- 1 sobre de levadura seca de panadero (7 g)- 3 cucharadas soperas de aceite de oliva- 1 cucharadita de sal- 400 gramos de agua tibia","- Pon en un bol la harina integral de arroz con la levadura seca de panadero y mezcla.- Incorpora tambi&eacute;n las cucharadas de aceite de oliva y la sal. Estos ingredientes permitir&aacute;n que la masa de pan integral sin gluten quede m&aacute;s esponjosa y con m&aacute;s sabor.- Ve a&ntilde;adiendo el agua tibia poco a poco y ve mezclando. Si amasas en una amasadora, con 5 minutos tendr&aacute;s bastante, si lo haces a mano necesitar&aacute;s 10 minutos.- Una vez que obtengas una masa lisa, homog&eacute;nea y pegajosa, c&uacute;brela con un pa&ntilde;o de cocina y deja que repose durante 2 horas a temperatura ambiente y sin corrientes de aire. La fermentaci&oacute;n es un paso fundamental a la hora de hacer pan casero, por ello es imprescindible respetar los tiempos de reposo.- Pasado el tiempo de reposo, enharina ligeramente una superficie de trabajo con harina de arroz y coloca encima la masa. Dale con las manos una forma redondeada.- Forra una bandeja con papel de horno y pon encima la masa de pan integral sin gluten. Con ayuda de un cortador de pizzas, haz unos cortes en la superficie, en este caso hemos hecho unos rombos, pero puedes hacer los cortes a tu gusto. Cubre con un pa&ntilde;o de cocina y deja levar durante 30 minutos m&aacute;s.- Precalienta el horno a 200 &ordm;C y pon dentro del horno un recipiente con agua para crear vapor. Una vez caliente el horno, mete el pan y cu&eacute;celo durante 30 minutos con calor arriba y abajo a 200 &ordm;C. Deja enfriar en una rejilla una vez horneado y sirve. F&iuml;jate que esponjoso y suave queda esta receta de pan integral sin gluten. Sin duda, nos permite obtener una miga impresionante, un sabor igualmente delicioso y mucho m&aacute;s saludable.","./styles/img/recetas/pan.jpg","1");



DROP TABLE usuarios;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios VALUES("1","admin","admin","admin@admin.com","./styles/img/users/default.jpg","25ee9111b2c2a3d4dc61a2878c98568589a9a1a24a3029fd3d51cace60e169c9","administrador","admin");
INSERT INTO usuarios VALUES("2","colab","colab","colab@colab.com","./styles/img/users/default.jpg","e0e9a7aa0ca920b6bbdf9fd130d2d3f5ce03d35c17d4a0e4cb8af0bfdaae318a","colaborador","colab");
INSERT INTO usuarios VALUES("100","anonimo","","","./styles/img/users/default.jpg","anonimo","visitante","anonimo");
INSERT INTO usuarios VALUES("108","David","RC","david@david.com","./styles/img/users/d4r0k.png","4dad202ccd0bb6b2e8c61539287212617a1a5da8e6452e08f0e4ca834724d4c8","administrador","d4r0k");
INSERT INTO usuarios VALUES("109","Guillermo","PS","Guillermo@guillermo.com","./styles/img/users/wilham.jpg","07ab0a48052ead508d0ce35dcafbb4fe04e5cd548a4e50093544163beb672ba5","administrador","Willham");
INSERT INTO usuarios VALUES("110","Javier","Baena","javier@correo.com","./styles/img/users/jbaena.png","7fbfff4b8f2b02a24f95503133dfb98abf177ba417be1d0aca44ad829c97b90b","colaborador","JBaena");
INSERT INTO usuarios VALUES("111","Paula","Rodr&iacute;guez P&eacute;rez","paula@correo.com","./styles/img/users/delfi.jpg","0360045a6c9afa5f257ce3c3bf32cdc55c1f0cfeca26364f4e368030d0eb184e","colaborador","delfi");



DROP TABLE valoraciones;

CREATE TABLE `valoraciones` (
  `usuario_id` int(11) NOT NULL,
  `receta_id` int(11) NOT NULL,
  `valoracion` tinyint(4) NOT NULL,
  PRIMARY KEY (`usuario_id`,`receta_id`),
  KEY `pipo` (`receta_id`),
  KEY `metroid3` (`usuario_id`),
  CONSTRAINT `metroid3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pipo` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO valoraciones VALUES("1","1","2");
INSERT INTO valoraciones VALUES("1","2","5");
INSERT INTO valoraciones VALUES("1","3","3");
INSERT INTO valoraciones VALUES("1","4","4");
INSERT INTO valoraciones VALUES("1","5","5");
INSERT INTO valoraciones VALUES("1","6","4");
INSERT INTO valoraciones VALUES("1","7","2");
INSERT INTO valoraciones VALUES("2","1","3");
INSERT INTO valoraciones VALUES("2","3","2");



