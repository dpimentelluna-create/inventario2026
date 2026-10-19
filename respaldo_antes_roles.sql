-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: inventario2026
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accesorios_equipo`
--

DROP TABLE IF EXISTS `accesorios_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesorios_equipo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `equipo_id` bigint(20) unsigned NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `marca` varchar(80) DEFAULT NULL,
  `num_serie` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malogrado') NOT NULL DEFAULT 'Regular',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accesorios_equipo_equipo_id_foreign` (`equipo_id`),
  CONSTRAINT `accesorios_equipo_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesorios_equipo`
--

LOCK TABLES `accesorios_equipo` WRITE;
/*!40000 ALTER TABLE `accesorios_equipo` DISABLE KEYS */;
INSERT INTO `accesorios_equipo` VALUES (1,1,'CARGADOR','LENOVO','CG-LN001','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 22:32:48'),(2,2,'CARGADOR','LENOVO','CG-LN002','Malogrado',NULL,'2026-09-28 13:38:42','2026-09-29 18:37:06'),(3,3,'CARGADOR','HP','CG-HP003','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(4,4,'BATERIA','DELL','BT-DL004','Regular','AUTONOMIA BAJA','2026-09-28 13:38:42','2026-09-30 00:13:09'),(5,5,'CARGADOR','LENOVO','CG-LN005','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 22:28:36'),(6,6,'CARGADOR','HP','CG-HP006','Regular',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(7,7,'CARGADOR','ASUS','CG-AS007','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(8,8,'BATERIA','ACER','BT-AC008','Malogrado','NO CARGA','2026-09-28 13:38:42','2026-09-28 13:38:42'),(9,9,'CONTROL','EPSON','CT-EP009','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(10,10,'BATERÍA','GENERICO','HM-BQ010','Regular',NULL,'2026-09-28 13:38:42','2026-10-19 03:58:35'),(11,11,'CARGADOR','SAMSUNG','CG-SM011','Bueno',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(12,12,'CABLE USB','EPSON','US-EP012','Bueno',NULL,'2026-09-28 13:38:42','2026-09-30 00:13:22'),(13,13,'CABLE HDMI','LG','HM-LG013','Bueno',NULL,'2026-09-28 13:38:42','2026-09-30 00:13:02'),(14,14,'TECLADO','LENOVO','TC-LN014','Malogrado',NULL,'2026-09-28 13:38:42','2026-09-30 20:14:09'),(16,16,'USB','GENERICO','JV-12','Regular',NULL,'2026-09-29 00:01:50','2026-09-29 00:01:50'),(17,17,'USB','GENERICO','222','Malogrado',NULL,'2026-09-29 00:03:26','2026-09-29 00:03:39'),(18,18,'TECLADO','LENOVO','47','Regular',NULL,'2026-09-30 20:11:52','2026-09-30 20:14:09'),(19,18,'MOUSE','MS','45','Bueno',NULL,'2026-09-30 20:11:52','2026-09-30 20:14:09'),(20,21,'CARGADOR','NUEVAMARCA2','SSSS','Regular',NULL,'2026-10-19 02:56:41','2026-10-19 02:56:41');
/*!40000 ALTER TABLE `accesorios_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL DEFAULT 'Docente',
  `dni` varchar(8) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `docentes_dni_unique` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes`
--

LOCK TABLES `docentes` WRITE;
/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
INSERT INTO `docentes` VALUES (1,'MARIA ELENA','QUISPE ROJAS','DOCENTE','40111222','mquispe@colegio.edu.pe','987111222','2026-09-28 13:37:40','2026-09-28 13:37:40'),(2,'JOSE LUIS','GARCIA MENDOZA','DOCENTE','40222333','jgarcia@colegio.edu.pe','987222333','2026-09-28 13:37:40','2026-09-28 13:37:40'),(3,'ANA LUCIA','TORRES SILVA','COORDINADORA','40333444','atorres@colegio.edu.pe','987333444','2026-09-28 13:37:40','2026-09-28 13:37:40'),(4,'CARLOS ALBERTO','RAMIREZ DIAZ','DOCENTE','40444555','cramirez@colegio.edu.pe','987444555','2026-09-28 13:37:40','2026-09-28 13:37:40'),(5,'ROSA MARIA','FLORES PAREDES','DIRECTORA','40555666','rflores@colegio.edu.pe','987555666','2026-09-28 13:37:40','2026-09-28 13:37:40'),(6,'PEDRO ANTONIO','HUAMAN LOPEZ','DOCENTE','40666777','phuaman@colegio.edu.pe','987666777','2026-09-28 13:37:40','2026-09-28 13:37:40'),(7,'LUCIA FERNANDA','CASTRO RUIZ','SECRETARIA','40777888','lcastro@colegio.edu.pe','987777888','2026-09-28 13:37:40','2026-09-28 13:37:40'),(8,'MIGUEL ANGEL','VARGAS SOTO','DOCENTE','40888999','mvargas@colegio.edu.pe','987888999','2026-09-28 13:37:40','2026-09-28 13:37:40'),(9,'PATRICIA','MENDOZA ALIAGA','SUBDIRECTORA','40999000','pmendoza@colegio.edu.pe','987999000','2026-09-28 13:37:40','2026-09-28 13:37:40'),(10,'JORGE ENRIQUE','SALAS PONCE','DOCENTE','41000111','jsalas@colegio.edu.pe','986111222','2026-09-28 13:37:40','2026-09-28 13:37:40'),(11,'CARMEN ROSA','DIAZ CHAVEZ','DOCENTE','41111222','cdiaz@colegio.edu.pe','986222333','2026-09-28 13:37:40','2026-09-28 13:37:40'),(12,'RICARDO','PENA GUTIERREZ','COORDINADOR TI','41222333','rpena@colegio.edu.pe','986333444','2026-09-28 13:37:40','2026-09-28 13:37:40'),(13,'SILVIA','ORTEGA RAMOS','DOCENTE','41333444','sortega@colegio.edu.pe','986444555','2026-09-28 13:37:40','2026-09-28 13:37:40'),(14,'ALBERTO','NUNEZ VELA','AUXILIAR','41444555','anunez@colegio.edu.pe','986555666','2026-09-28 13:37:40','2026-09-28 13:37:40'),(15,'ELENA','PONCE SERRANO','DOCENTE','41555666','eponce@colegio.edu.pe','986666777','2026-09-28 13:37:40','2026-09-28 13:37:40'),(16,'MARIO','DIAZ','DOCENTE',NULL,NULL,NULL,'2026-09-30 00:16:37','2026-09-30 00:16:37'),(17,'MARIANO','DIAZ','DOCENTE',NULL,NULL,NULL,'2026-09-30 18:08:20','2026-09-30 18:08:20'),(18,'DIEGO ALONSO','PIMENTEL LUNA','DOCENTE','74976425','dpi@gmail.com','933603062','2026-10-19 03:36:35','2026-10-19 03:37:35');
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_equipo_id` bigint(20) unsigned NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `num_serie` varchar(100) DEFAULT NULL,
  `codigo_inventario` varchar(50) DEFAULT NULL,
  `estado` enum('Nuevo','Operativo','Regular','Malogrado','De baja') NOT NULL DEFAULT 'Operativo',
  `ubicacion_id` bigint(20) unsigned NOT NULL,
  `fecha_registro` date NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipos_tipo_equipo_id_foreign` (`tipo_equipo_id`),
  KEY `equipos_ubicacion_id_foreign` (`ubicacion_id`),
  CONSTRAINT `equipos_tipo_equipo_id_foreign` FOREIGN KEY (`tipo_equipo_id`) REFERENCES `tipos_equipo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `equipos_ubicacion_id_foreign` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (1,1,'LENOVO','20384','LN001AA',NULL,'Operativo',13,'2026-03-01',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(2,1,'LENOVO','20384','LN002BB',NULL,'Operativo',13,'2026-03-01',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(3,1,'HP','240 G8','HP003CC',NULL,'Operativo',5,'2026-09-28',NULL,'2026-09-28 13:38:14','2026-09-29 00:56:28'),(4,1,'DELL','LATITUDE','DL004DD',NULL,'Operativo',5,'2026-03-06',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(5,1,'LENOVO','IDEAPAD 3','LN005EE',NULL,'Operativo',1,'2026-03-10',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(6,1,'HP','250 G9','HP006FF',NULL,'Operativo',2,'2026-03-12',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(7,1,'ASUS','VIVOBOOK','AS007GG',NULL,'Operativo',3,'2026-03-15',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(8,1,'ACER','ASPIRE 5','AC008HH',NULL,'Operativo',4,'2026-03-18',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(9,2,'EPSON','X49','EP009II',NULL,'Operativo',12,'2026-04-01',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(10,2,'BENQ','MS550','BQ010JJ',NULL,'Operativo',12,'2026-04-02',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(11,3,'SAMSUNG','TAB A8','SM011KK',NULL,'Operativo',7,'2026-04-10',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(12,4,'EPSON','L3250','EP012LL',NULL,'Operativo',10,'2026-04-12',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(13,5,'LG','24MK','LG013MM',NULL,'Operativo',13,'2026-04-15',NULL,'2026-09-28 13:38:14','2026-09-28 13:38:14'),(14,6,'LENOVO','THINKCENTRE','LN014NN',NULL,'Operativo',13,'2026-09-28',NULL,'2026-09-28 13:38:14','2026-09-29 00:11:50'),(16,14,'JARVIS','JUNIOR','TECL.-23',NULL,'Operativo',15,'2026-09-28',NULL,'2026-09-29 00:01:49','2026-09-29 00:01:49'),(17,14,'JARVIS','JUNIOR','XDD2',NULL,'Operativo',15,'2026-09-28',NULL,'2026-09-29 00:03:26','2026-09-29 00:03:26'),(18,6,'LENOVO','THINKCENTRE','CPU78217',NULL,'Operativo',3,'2026-09-30',NULL,'2026-09-30 20:11:51','2026-09-30 20:11:51'),(20,1,'LENOVO','ASPIRE 5','XX',NULL,'Operativo',2,'2026-10-07',NULL,'2026-10-07 09:04:11','2026-10-07 09:04:11'),(21,16,'NUEVAMARCA NE','NMODELO NE','NUEVO23',NULL,'Operativo',12,'2026-10-18',NULL,'2026-10-19 02:56:41','2026-10-19 02:56:41');
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especificaciones_equipo`
--

DROP TABLE IF EXISTS `especificaciones_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especificaciones_equipo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `equipo_id` bigint(20) unsigned NOT NULL,
  `descripcion` text DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `estado` enum('BUENO','REGULAR','MALOGRADO') NOT NULL DEFAULT 'BUENO',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `especificaciones_equipo_equipo_id_foreign` (`equipo_id`),
  CONSTRAINT `especificaciones_equipo_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especificaciones_equipo`
--

LOCK TABLES `especificaciones_equipo` WRITE;
/*!40000 ALTER TABLE `especificaciones_equipo` DISABLE KEYS */;
INSERT INTO `especificaciones_equipo` VALUES (1,9,'PROYECTOR 3600 LUMENES HDMI VGA','BLANCO','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(2,10,'PROYECTOR 4000 LUMENES','BLANCO','REGULAR','LAMPARA POR CAMBIAR','2026-09-28 13:38:42','2026-09-28 13:38:42'),(3,11,'TABLET 10 PULGADAS 64GB','GRIS','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(4,12,'IMPRESORA TINTA CONTINUA WIFI','NEGRO','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(5,13,'MONITOR 24 PULGADAS HDMI','NEGRO','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(6,14,'CPU ESCRITORIO I5 8GB RAM','NEGRO','MALOGRADO',NULL,'2026-09-28 13:38:42','2026-09-30 18:18:06'),(8,16,'TECLADO GENERICO','NEGRO','BUENO','OK','2026-09-29 00:01:50','2026-09-29 00:02:29'),(9,17,'TECLADO GENERICO','NEGRO','REGULAR',NULL,'2026-09-29 00:03:26','2026-09-29 00:03:26'),(10,18,'CPU ESCRITORIO I5 8GB RAM','NEGRO','MALOGRADO',NULL,'2026-09-30 20:11:52','2026-09-30 20:14:09'),(12,21,'NEUVO EQUIPO REGISTRADO','BLANCO','BUENO',NULL,'2026-10-19 02:56:41','2026-10-19 02:56:41');
/*!40000 ALTER TABLE `especificaciones_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especificaciones_laptop`
--

DROP TABLE IF EXISTS `especificaciones_laptop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especificaciones_laptop` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `equipo_id` bigint(20) unsigned NOT NULL,
  `procesador` varchar(100) DEFAULT NULL,
  `ram` varchar(30) DEFAULT NULL,
  `disco_duro` varchar(30) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `estado` enum('BUENO','REGULAR','MALOGRADO') NOT NULL DEFAULT 'BUENO',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `especificaciones_laptop_equipo_id_foreign` (`equipo_id`),
  CONSTRAINT `especificaciones_laptop_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especificaciones_laptop`
--

LOCK TABLES `especificaciones_laptop` WRITE;
/*!40000 ALTER TABLE `especificaciones_laptop` DISABLE KEYS */;
INSERT INTO `especificaciones_laptop` VALUES (1,1,'INTEL CORE I5-400 CPU 1.70 GHZ','4GB DDR3','HGST 465 GB','NEGRO','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(2,2,'INTEL CORE I5-400 CPU 1.70 GHZ','4GB DDR3','HGST 465 GB','NEGRO','REGULAR',NULL,'2026-09-28 13:38:42','2026-09-29 18:37:06'),(3,3,'INTEL CORE I5-1135G7','8GB DDR4','SSD 256 GB','GRIS','BUENO','SSSSSSS','2026-09-28 13:38:42','2026-09-29 00:56:28'),(4,4,'INTEL CORE I7-1185G7','16GB DDR4','SSD 512 GB','NEGRO','REGULAR','BATERIA DESGASTADA','2026-09-28 13:38:42','2026-09-28 13:38:42'),(5,5,'AMD RYZEN 5 5500U','8GB DDR4','SSD 256 GB','AZUL','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(6,6,'INTEL CORE I3-1115G4','8GB DDR4','HDD 1 TB','PLATEADO','REGULAR',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(7,7,'INTEL CORE I5-1235U','8GB DDR4','SSD 512 GB','NEGRO','BUENO',NULL,'2026-09-28 13:38:42','2026-09-28 13:38:42'),(8,8,'INTEL CORE I5-1135G7','8GB DDR4','SSD 256 GB','GRIS','MALOGRADO','PANTALLA CON MANCHAS','2026-09-28 13:38:42','2026-09-28 13:38:42'),(9,20,'INTEL CORE I5-1135G7','8GB DDR4','SSD 256 GB','GRIS','REGULAR',NULL,'2026-10-07 09:04:11','2026-10-07 09:04:11');
/*!40000 ALTER TABLE `especificaciones_laptop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2026_08_24_143926_create_ubicaciones_table',1),(7,'2026_08_24_144019_create_tipos_equipo_table',1),(8,'2026_08_24_144244_create_equipos_table',1),(9,'2026_08_24_144307_create_especificaciones_laptop_table',1),(10,'2026_08_24_144336_create_accesorios_equipo_table',1),(11,'2026_08_24_144402_create_docentes_table',1),(12,'2026_08_24_144423_create_prestamos_table',1),(13,'2026_08_25_153104_add_observaciones_to_accesorios_equipo_table',1),(14,'2026_08_25_175958_add_estado_observaciones_to_especificaciones_laptop_table',1),(15,'2026_08_25_180920_add_color_to_especificaciones_laptop_table',1),(16,'2026_08_26_193625_create_especificaciones_equipo_table',1),(17,'2026_08_26_194940_remove_old_fields_from_equipos_table',1),(18,'2026_08_31_132129_update_estados_to_bueno_regular_malogrado',1),(19,'2026_09_01_132751_update_tipo_estado_accesorios_equipo_table',1),(20,'2026_09_01_133841_change_tipo_to_string_in_accesorios_equipo_table',1),(21,'2026_09_02_180000_redesign_prestamos_table',1),(22,'2026_09_02_180100_create_prestamo_equipos_table',1),(23,'2026_09_02_180200_create_prestamo_accesorios_table',1),(24,'2026_09_07_184647_normalizar_estados_especificaciones',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo_accesorios`
--

DROP TABLE IF EXISTS `prestamo_accesorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamo_accesorios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prestamo_equipo_id` bigint(20) unsigned NOT NULL,
  `accesorio_equipo_id` bigint(20) unsigned NOT NULL,
  `estado` enum('REGULAR','BUENO','MALOGRADO') NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestamo_accesorios_prestamo_equipo_id_foreign` (`prestamo_equipo_id`),
  KEY `prestamo_accesorios_accesorio_equipo_id_foreign` (`accesorio_equipo_id`),
  CONSTRAINT `prestamo_accesorios_accesorio_equipo_id_foreign` FOREIGN KEY (`accesorio_equipo_id`) REFERENCES `accesorios_equipo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestamo_accesorios_prestamo_equipo_id_foreign` FOREIGN KEY (`prestamo_equipo_id`) REFERENCES `prestamo_equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo_accesorios`
--

LOCK TABLES `prestamo_accesorios` WRITE;
/*!40000 ALTER TABLE `prestamo_accesorios` DISABLE KEYS */;
INSERT INTO `prestamo_accesorios` VALUES (3,3,3,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(4,4,9,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(5,5,11,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(6,6,4,'REGULAR',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(7,7,12,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(9,9,10,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(10,10,6,'REGULAR',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(11,11,7,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(12,12,14,'REGULAR',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(13,13,13,'BUENO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(15,15,8,'MALOGRADO',NULL,'2026-09-28 13:40:45','2026-09-28 13:40:45'),(19,19,14,'REGULAR',NULL,'2026-09-28 21:26:58','2026-09-28 21:26:58'),(22,22,5,'BUENO',NULL,'2026-09-28 22:28:36','2026-09-28 22:28:36'),(27,27,12,'BUENO',NULL,'2026-09-28 23:08:21','2026-09-28 23:08:21'),(29,29,1,'BUENO',NULL,'2026-09-28 23:25:20','2026-09-28 23:25:20'),(30,30,2,'MALOGRADO',NULL,'2026-09-29 18:37:06','2026-09-29 18:37:06'),(32,32,13,'BUENO',NULL,'2026-09-30 00:13:02','2026-09-30 00:13:02'),(33,33,4,'REGULAR',NULL,'2026-09-30 00:13:09','2026-09-30 00:13:09'),(34,34,12,'BUENO',NULL,'2026-09-30 00:13:22','2026-09-30 00:13:22'),(35,35,1,'BUENO',NULL,'2026-09-30 00:17:25','2026-09-30 00:17:25'),(38,38,14,'MALOGRADO','OBS ACCESIROO','2026-09-30 20:14:09','2026-09-30 20:14:09'),(39,39,18,'REGULAR',NULL,'2026-09-30 20:14:09','2026-09-30 20:14:09'),(40,39,19,'BUENO','accesorio 2 obs','2026-09-30 20:14:09','2026-09-30 20:14:09'),(41,40,14,'MALOGRADO',NULL,'2026-10-07 08:06:05','2026-10-07 08:06:05');
/*!40000 ALTER TABLE `prestamo_accesorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo_equipos`
--

DROP TABLE IF EXISTS `prestamo_equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamo_equipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prestamo_id` bigint(20) unsigned NOT NULL,
  `equipo_id` bigint(20) unsigned NOT NULL,
  `estado` enum('REGULAR','BUENO','MALOGRADO') NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestamo_equipos_prestamo_id_foreign` (`prestamo_id`),
  KEY `prestamo_equipos_equipo_id_foreign` (`equipo_id`),
  CONSTRAINT `prestamo_equipos_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestamo_equipos_prestamo_id_foreign` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo_equipos`
--

LOCK TABLES `prestamo_equipos` WRITE;
/*!40000 ALTER TABLE `prestamo_equipos` DISABLE KEYS */;
INSERT INTO `prestamo_equipos` VALUES (3,3,3,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(4,4,9,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(5,5,11,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(6,6,4,'REGULAR','ENTREGADO CON DETALLE EN BATERIA','2026-09-28 13:40:34','2026-09-28 13:40:34'),(7,7,12,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(9,9,10,'REGULAR',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(10,10,6,'REGULAR',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(11,11,7,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(12,12,14,'REGULAR',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(13,13,13,'BUENO',NULL,'2026-09-28 13:40:34','2026-09-28 13:40:34'),(15,15,8,'MALOGRADO','SE PRESTO CON PANTALLA MANCHADA','2026-09-28 13:40:34','2026-09-28 13:40:34'),(19,17,14,'REGULAR',NULL,'2026-09-28 21:26:58','2026-09-28 21:26:58'),(22,8,5,'BUENO',NULL,'2026-09-28 22:28:35','2026-09-28 22:28:35'),(27,20,12,'BUENO',NULL,'2026-09-28 23:08:21','2026-09-28 23:08:21'),(29,1,1,'BUENO',NULL,'2026-09-28 23:25:20','2026-09-28 23:25:20'),(30,2,2,'REGULAR',NULL,'2026-09-29 18:37:06','2026-09-29 18:37:06'),(32,19,13,'BUENO',NULL,'2026-09-30 00:13:02','2026-09-30 00:13:02'),(33,18,4,'REGULAR',NULL,'2026-09-30 00:13:09','2026-09-30 00:13:09'),(34,21,12,'BUENO',NULL,'2026-09-30 00:13:22','2026-09-30 00:13:22'),(35,22,1,'BUENO',NULL,'2026-09-30 00:17:25','2026-09-30 00:17:25'),(38,23,14,'MALOGRADO','OBS EQUIPO','2026-09-30 20:14:09','2026-09-30 20:14:09'),(39,23,18,'MALOGRADO','equipo obs2','2026-09-30 20:14:09','2026-09-30 20:14:09'),(40,24,14,'MALOGRADO',NULL,'2026-10-07 08:06:05','2026-10-07 08:06:05');
/*!40000 ALTER TABLE `prestamo_equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamos`
--

DROP TABLE IF EXISTS `prestamos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `docente_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cargo` varchar(100) NOT NULL DEFAULT 'DOCENTE',
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado` enum('ACTIVO','TERMINADO') NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`),
  KEY `prestamos_docente_id_foreign` (`docente_id`),
  CONSTRAINT `prestamos_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamos`
--

LOCK TABLES `prestamos` WRITE;
/*!40000 ALTER TABLE `prestamos` DISABLE KEYS */;
INSERT INTO `prestamos` VALUES (1,1,'2026-09-28 13:40:11','2026-09-28 23:25:20','DOCENTE','2026-09-28','13:30:00',NULL,'ACTIVO'),(2,2,'2026-09-28 13:40:11','2026-09-29 18:37:05','DOCENTE','2026-09-02','09:00:00','12:00:00','TERMINADO'),(3,3,'2026-09-28 13:40:11','2026-09-28 13:40:11','COORDINADORA','2026-09-03','07:30:00',NULL,'ACTIVO'),(4,4,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-04','10:00:00','12:00:00','TERMINADO'),(5,5,'2026-09-28 13:40:11','2026-09-28 13:40:11','DIRECTORA','2026-09-05','08:30:00',NULL,'ACTIVO'),(6,6,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-08','13:00:00','15:00:00','TERMINADO'),(7,7,'2026-09-28 13:40:11','2026-09-28 13:40:11','SECRETARIA','2026-09-09','09:15:00','11:00:00','TERMINADO'),(8,8,'2026-09-28 13:40:11','2026-09-28 22:28:35','DOCENTE','2026-09-10','08:00:00','12:00:00','TERMINADO'),(9,9,'2026-09-28 13:40:11','2026-09-28 13:40:11','SUBDIRECTORA','2026-09-11','11:00:00','13:00:00','TERMINADO'),(10,10,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-12','07:00:00','09:00:00','TERMINADO'),(11,11,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-15','14:00:00',NULL,'ACTIVO'),(12,12,'2026-09-28 13:40:11','2026-09-28 13:40:11','COORDINADOR TI','2026-09-16','08:00:00','16:00:00','TERMINADO'),(13,13,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-17','09:30:00','11:30:00','TERMINADO'),(15,15,'2026-09-28 13:40:11','2026-09-28 13:40:11','DOCENTE','2026-09-19','08:00:00','12:00:00','TERMINADO'),(17,7,'2026-09-28 21:12:29','2026-09-28 21:26:58','SECRETARIA','2026-09-28','09:00:00','14:30:00','TERMINADO'),(18,11,'2026-09-28 22:32:11','2026-09-30 00:13:09','DOCENTE','2026-09-28','13:00:00','15:00:00','TERMINADO'),(19,11,'2026-09-28 22:39:15','2026-09-30 00:13:02','DOCENTE','2026-09-28','13:00:00','14:00:00','TERMINADO'),(20,7,'2026-09-28 23:08:20','2026-09-28 23:08:20','SECRETARIA','2026-09-28','14:00:00',NULL,'ACTIVO'),(21,7,'2026-09-30 00:12:00','2026-09-30 00:13:22','SECRETARIA','2026-09-28','13:00:00','15:30:00','TERMINADO'),(22,16,'2026-09-30 00:17:25','2026-09-30 00:17:25','DOCENTE','2026-09-29','14:15:00',NULL,'ACTIVO'),(23,17,'2026-09-30 18:09:16','2026-09-30 20:14:09','DOCENTE','2026-09-30','08:08:00','08:17:00','TERMINADO'),(24,17,'2026-10-07 08:06:05','2026-10-07 08:06:05','DOCENTE','2026-10-07','13:00:00',NULL,'ACTIVO');
/*!40000 ALTER TABLE `prestamos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_equipo`
--

DROP TABLE IF EXISTS `tipos_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_equipo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_equipo`
--

LOCK TABLES `tipos_equipo` WRITE;
/*!40000 ALTER TABLE `tipos_equipo` DISABLE KEYS */;
INSERT INTO `tipos_equipo` VALUES (1,'LAPTOP','2026-09-28 13:37:38','2026-09-28 13:37:38'),(2,'PROYECTOR','2026-09-28 13:37:38','2026-09-28 13:37:38'),(3,'TABLET','2026-09-28 13:37:38','2026-09-28 13:37:38'),(4,'IMPRESORA','2026-09-28 13:37:38','2026-09-28 13:37:38'),(5,'MONITOR','2026-09-28 13:37:38','2026-09-28 13:37:38'),(6,'CPU','2026-09-28 13:37:38','2026-09-28 13:37:38'),(7,'PARLANTE','2026-09-28 13:37:38','2026-09-28 13:37:38'),(8,'CAMARA','2026-09-28 13:37:38','2026-09-28 13:37:38'),(9,'MICROFONO','2026-09-28 13:37:38','2026-09-28 13:37:38'),(10,'ROUTER','2026-09-28 13:37:38','2026-09-28 13:37:38'),(11,'SWITCH','2026-09-28 13:37:38','2026-09-28 13:37:38'),(12,'SCANNER','2026-09-28 13:37:38','2026-09-28 13:37:38'),(13,'PANTALLA','2026-09-28 13:37:38','2026-09-28 13:37:38'),(14,'TECLADO','2026-09-28 13:37:38','2026-09-28 13:37:38'),(15,'MOUSE','2026-09-28 13:37:38','2026-09-28 13:37:38'),(16,'NUEVO EQUIPO','2026-10-19 02:56:41','2026-10-19 02:56:41');
/*!40000 ALTER TABLE `tipos_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicaciones`
--

DROP TABLE IF EXISTS `ubicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ubicaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicaciones`
--

LOCK TABLES `ubicaciones` WRITE;
/*!40000 ALTER TABLE `ubicaciones` DISABLE KEYS */;
INSERT INTO `ubicaciones` VALUES (1,'AULA 101','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(2,'AULA 102','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(3,'AULA 201','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(4,'AULA 202','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(5,'LABORATORIO 1','LAB','2026-09-28 13:37:39','2026-09-28 13:37:39'),(6,'LABORATORIO 2','LAB','2026-09-28 13:37:39','2026-09-28 13:37:39'),(7,'BIBLIOTECA','AMBIENTE','2026-09-28 13:37:39','2026-09-28 13:37:39'),(8,'SALA DE PROFESORES','AMBIENTE','2026-09-28 13:37:39','2026-09-28 13:37:39'),(9,'DIRECCION','OFICINA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(10,'SECRETARIA','OFICINA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(11,'ALMACEN TI','ALMACEN','2026-09-28 13:37:39','2026-09-28 13:37:39'),(12,'AUDITORIO','AMBIENTE','2026-09-28 13:37:39','2026-09-28 13:37:39'),(13,'SALA DE COMPUTO','LAB','2026-09-28 13:37:39','2026-09-28 13:37:39'),(14,'AULA 301','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39'),(15,'AULA 302','AULA','2026-09-28 13:37:39','2026-09-28 13:37:39');
/*!40000 ALTER TABLE `ubicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Diego A','diiegoa19sc@gmail.com',NULL,'$2y$12$xdlvRDKg//iDlsCMk.H1eubjSHmItSJEOQPZQ5gNCNb0KSibP0PVS','WlroQe8zS8yKiakMxcbpHhH73HTGtSVKrlkMaYqUJVIHsPyz7qwpQ5NH8nS1','2026-09-28 18:48:56','2026-09-28 18:48:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-19  3:55:49
