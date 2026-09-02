-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-09-2026 a las 16:35:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario2026`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios_equipo`
--

CREATE TABLE `accesorios_equipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `marca` varchar(80) DEFAULT NULL,
  `num_serie` varchar(100) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malogrado') NOT NULL DEFAULT 'Regular',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `accesorios_equipo`
--

INSERT INTO `accesorios_equipo` (`id`, `equipo_id`, `tipo`, `marca`, `num_serie`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 7, 'Batería', 'BATMONI1MAR', 'BAT1MONI1NS', 'Malogrado', 'OBS MONI MALGORADO 1', '2026-08-31 20:36:38', '2026-08-31 20:36:38'),
(4, 10, 'Cargador', 'CARG - PRO 2', 'NS CARGP2', 'Bueno', 'N A CP2', '2026-08-31 20:52:40', '2026-08-31 20:52:40'),
(5, 11, 'Batería', 'ASAF', 'ASFASF', 'Regular', NULL, '2026-08-31 20:54:48', '2026-08-31 20:54:48'),
(6, 11, 'Cargador', 'ASFAS', 'AAAAA', 'Malogrado', 'AA', '2026-08-31 20:54:48', '2026-08-31 20:54:48'),
(7, 13, 'Batería', 'MPRO3', 'NSPRO3', 'Bueno', 'OBS PRO3', '2026-08-31 21:46:21', '2026-08-31 21:46:21'),
(8, 13, 'Cargador', 'MPRRRRO3', 'NSMPRRRR3', 'Regular', NULL, '2026-08-31 21:46:22', '2026-08-31 21:46:22'),
(15, 15, 'Batería', 'JJJJJJJJJ', 'JJJJJJJJJJJ', 'Malogrado', 'JJ', '2026-09-01 00:16:43', '2026-09-01 00:16:43'),
(17, 18, 'Cargador', 'ASSS', 'SAFSAF', 'Bueno', '---', '2026-09-01 00:29:17', '2026-09-01 21:54:29'),
(26, 6, 'Batería', '12', '12', 'Regular', '12', '2026-09-01 20:07:31', '2026-09-01 20:07:31'),
(28, 5, 'CABLE USB', 'LENOVO', '81274128', 'Regular', NULL, '2026-09-01 20:33:44', '2026-09-01 20:33:44'),
(29, 5, 'CABLE HDMI', 'HDMI1', 'CBHDM12', 'Regular', NULL, '2026-09-01 21:27:02', '2026-09-01 21:27:02'),
(31, 18, 'CCAAA', 'CCAAA', 'CCAAA', 'Regular', NULL, '2026-09-01 21:55:03', '2026-09-01 21:55:03'),
(33, 40, 'Cargador', 'LENOVO', '1154XXXXXXX', 'Regular', NULL, '2026-09-01 23:24:45', '2026-09-01 23:24:45'),
(35, 42, 'NUEVO ACCESS1', 'MARC1', 'MARCSERIER', 'Bueno', 'NADA', '2026-09-02 00:44:36', '2026-09-02 00:44:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL DEFAULT 'Docente',
  `dni` varchar(8) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `nombres`, `apellidos`, `cargo`, `dni`, `correo`, `celular`, `created_at`, `updated_at`) VALUES
(1, 'NAME', 'LAST NAME', 'DOCENTE', NULL, NULL, NULL, '2026-08-24 22:48:59', '2026-08-24 22:49:13'),
(2, 'PRUEBA1', 'PRUEBA1', 'DOCENTE', 'DNI24124', NULL, NULL, '2026-09-01 17:48:06', '2026-09-01 17:48:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_equipo_id` bigint(20) UNSIGNED NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `num_serie` varchar(100) DEFAULT NULL,
  `ubicacion_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `tipo_equipo_id`, `marca`, `modelo`, `num_serie`, `ubicacion_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(5, 4, 'PRO12', 'A', 'PRO12', 16, '2026-08-31', '2026-08-31 19:58:19', '2026-09-01 19:26:04'),
(6, 1, 'LAP M', 'LAP MO', 'lap NS', 2, '2026-08-31', '2026-08-31 20:11:22', '2026-08-31 20:11:22'),
(7, 4, 'MONI MA1', 'MONI MAMO', 'MONI NSERIE1', 10, '2026-08-31', '2026-08-31 20:36:38', '2026-08-31 20:36:38'),
(10, 3, 'MARCA 2 PRO', 'MODELO 2 PRO', 'SERIE123 PRO', 8, '2026-08-31', '2026-08-31 20:52:40', '2026-08-31 20:52:40'),
(11, 3, 'ASFAS', NULL, 'ASFASF', 16, '2026-08-31', '2026-08-31 20:54:48', '2026-08-31 20:54:48'),
(12, 1, 'LENOVO', '29374', 'CBAFA', 15, '2026-08-31', '2026-08-31 21:43:54', '2026-08-31 21:43:54'),
(13, 3, 'MARCA PRO3', 'MODELO PRO3', 'NSERIE PRO3', 15, '2026-08-31', '2026-08-31 21:46:21', '2026-08-31 21:46:21'),
(15, 1, 'ASFASF', 'HHH', 'ASFASF', 15, '2026-08-31', '2026-08-31 21:55:17', '2026-08-31 21:55:17'),
(16, 1, 'JJJJJJ', 'JJJJJ', 'JJJJ', 16, '2026-08-31', '2026-08-31 23:19:04', '2026-08-31 23:19:04'),
(18, 1, '1111111111', NULL, '111111111', 16, '2026-07-26', '2026-09-01 00:29:16', '2026-09-01 00:29:16'),
(19, 11, 'Lenovo', 'ThinkPad E14', 'SN-LEN-001', 1, '2026-08-31', NULL, NULL),
(20, 12, 'HP', 'ProDesk 400 G6', 'SN-HP-002', 2, '2026-08-31', NULL, NULL),
(21, 13, 'Samsung', 'S24R350', 'SN-SAM-003', 3, '2026-08-31', NULL, NULL),
(22, 14, 'Epson', 'EB-X06', 'SN-EPS-004', 4, '2026-08-31', NULL, NULL),
(23, 15, 'Epson', 'L3250', 'SN-EPS-005', 5, '2026-08-31', NULL, NULL),
(24, 16, 'LG', '50UP7500', 'SN-LG-006', 6, '2026-08-31', NULL, NULL),
(25, 17, 'Logitech', 'K120', 'SN-LOG-007', 7, '2026-08-31', NULL, NULL),
(26, 18, 'Logitech', 'M90', 'SN-LOG-008', 8, '2026-08-31', NULL, NULL),
(27, 19, 'JBL', 'EON610', 'SN-JBL-009', 9, '2026-08-31', NULL, NULL),
(28, 20, 'TP-Link', 'Archer C6', 'SN-TPL-010', 10, '2026-08-31', NULL, NULL),
(29, 21, 'Cisco', 'SG350', 'SN-CIS-011', 11, '2026-08-31', NULL, NULL),
(30, 22, 'Samsung', 'Galaxy Tab A8', 'SN-SAM-012', 12, '2026-08-31', NULL, NULL),
(31, 23, 'Canon', 'EOS 2000D', 'SN-CAN-013', 13, '2026-08-31', NULL, NULL),
(32, 24, 'Shure', 'SM58', 'SN-SHU-014', 14, '2026-08-31', NULL, NULL),
(33, 25, 'APC', 'Back-UPS 1200', 'SN-APC-015', 15, '2026-08-31', NULL, NULL),
(34, 11, 'HP', '250 G8', 'SN-HP-016', 16, '2026-08-31', NULL, NULL),
(35, 12, 'Dell', 'OptiPlex 3080', 'SN-DEL-017', 17, '2026-08-31', NULL, NULL),
(36, 13, 'LG', '24MK430H', 'SN-LG-018', 18, '2026-08-31', NULL, NULL),
(37, 14, 'BenQ', 'MS550', 'SN-BEN-019', 19, '2026-08-31', NULL, NULL),
(40, 1, 'LENOVO', '20384', 'CB36303098', 39, '2026-09-01', '2026-09-01 23:24:43', '2026-09-01 23:24:43'),
(42, 1, 'Lenovo', 'XFAFA', '222424', 12, '2026-09-01', '2026-09-02 00:44:35', '2026-09-02 00:45:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especificaciones_equipo`
--

CREATE TABLE `especificaciones_equipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malogrado') NOT NULL DEFAULT 'Regular',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `especificaciones_equipo`
--

INSERT INTO `especificaciones_equipo` (`id`, `equipo_id`, `descripcion`, `color`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 5, 'PROYECTORRR12', 'NEGRO22', 'Regular', 'NINUGNA22', '2026-08-31 19:58:20', '2026-08-31 23:28:34'),
(2, 7, 'MONI DESC1', 'NEGRO MONI1', 'Bueno', 'OBS MONI', '2026-08-31 20:36:38', '2026-08-31 20:36:38'),
(5, 10, 'DESC PROYECTOR 2', 'NEGRO', 'Bueno', 'OBS ESPECIFICACAIONES PROYECTOR 2', '2026-08-31 20:52:40', '2026-08-31 20:52:40'),
(6, 11, 'SFAFAS', NULL, 'Bueno', NULL, '2026-08-31 20:54:48', '2026-08-31 20:54:48'),
(7, 13, 'PROUECTOR QWQ2', 'NEGRO', 'Bueno', 'ASFASFPRO3', '2026-08-31 21:46:21', '2026-08-31 21:46:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especificaciones_laptop`
--

CREATE TABLE `especificaciones_laptop` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `procesador` varchar(100) DEFAULT NULL,
  `ram` varchar(30) DEFAULT NULL,
  `disco_duro` varchar(30) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `estado` enum('Bueno','Regular','Malogrado') NOT NULL DEFAULT 'Regular',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `especificaciones_laptop`
--

INSERT INTO `especificaciones_laptop` (`id`, `equipo_id`, `procesador`, `ram`, `disco_duro`, `color`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(4, 6, 'LAP PRO', 'LAP RAM', 'LAP DD', NULL, 'Bueno', 'OBS LAP', '2026-08-31 20:11:22', '2026-08-31 20:11:22'),
(5, 12, 'intel core i5', '8GB', 'SSD ASFHA', NULL, 'Regular', 'safasf', '2026-08-31 21:43:55', '2026-08-31 21:43:55'),
(7, 15, 'HHHHHHHHH', 'HHHHHHHHHHHHH', 'HHHHHHHHHHHHH', NULL, 'Regular', 'HHHHHHHHHH', '2026-08-31 21:55:18', '2026-08-31 21:55:18'),
(8, 16, 'JJJJJJ', 'JJJJJJJ', 'JJJJJJJJJ', 'JJJJJJJJJ', 'Bueno', 'JJJJJ', '2026-08-31 23:19:04', '2026-08-31 23:19:04'),
(10, 18, 'INTEL ICORE', 'ASKFJKASF', 'ASFASF', NULL, 'Malogrado', NULL, '2026-09-01 00:29:17', '2026-09-01 00:29:17'),
(12, 40, 'Intel Core-I3-400 CPU 1.70 Ghz', '4GB DDR3', 'HGST 465 GB', 'Negro', 'Regular', NULL, '2026-09-01 23:24:44', '2026-09-01 23:24:44'),
(14, 42, 'Intel Core-I3-400 CPU 1.70 Ghz', '4GB DDR3', 'HGST 465 GB', 'NEGROS', 'Regular', 'OBDRSFAFAF', '2026-09-02 00:44:35', '2026-09-02 00:45:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(15, '2014_10_12_100000_create_password_resets_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(18, '2026_08_24_143926_create_ubicaciones_table', 1),
(19, '2026_08_24_144019_create_tipos_equipo_table', 1),
(20, '2026_08_24_144244_create_equipos_table', 1),
(21, '2026_08_24_144307_create_especificaciones_laptop_table', 1),
(22, '2026_08_24_144336_create_accesorios_equipo_table', 1),
(23, '2026_08_24_144402_create_docentes_table', 1),
(24, '2026_08_24_144423_create_prestamos_table', 1),
(25, '2026_08_25_151517_add_observaciones_to_accesorios_equipos_table', 2),
(26, '2026_08_25_151553_add_observaciones_to_accesorios_equipos_table', 2),
(28, '2026_08_25_153104_add_observaciones_to_accesorios_equipo_table', 3),
(29, '2026_08_25_175958_add_estado_observaciones_to_especificaciones_laptop_table', 4),
(30, '2026_08_25_180920_add_color_to_especificaciones_laptop_table', 5),
(31, '2026_08_26_193625_create_especificaciones_equipo_table', 6),
(32, '2026_08_26_194940_remove_old_fields_from_equipos_table', 7),
(33, '2026_08_31_132129_update_estados_to_bueno_regular_malogrado', 8),
(34, '2026_09_01_132751_update_tipo_estado_accesorios_equipo_table', 9),
(35, '2026_09_01_133841_change_tipo_to_string_in_accesorios_equipo_table', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `docente_id` bigint(20) UNSIGNED NOT NULL,
  `ubicacion_destino_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_devolucion_prevista` date DEFAULT NULL,
  `fecha_devolucion_real` date DEFAULT NULL,
  `estado` enum('Prestado','Devuelto','Vencido') NOT NULL DEFAULT 'Prestado',
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_equipo`
--

CREATE TABLE `tipos_equipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_equipo`
--

INSERT INTO `tipos_equipo` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'LAPTOP', '2026-08-24 21:32:35', '2026-08-24 21:32:35'),
(3, 'PROYECTOR', '2026-08-24 21:36:16', '2026-08-24 21:36:16'),
(4, 'MONITOR', '2026-08-24 21:36:24', '2026-08-24 21:36:24'),
(5, 'PARLANTE', '2026-08-24 21:36:30', '2026-08-24 21:36:30'),
(6, 'IMPRESORA', '2026-08-24 23:26:23', '2026-08-24 23:26:23'),
(7, 'TELEVISOR', '2026-08-24 23:26:40', '2026-08-24 23:26:40'),
(8, 'MOUSE OPTICO', '2026-08-24 23:26:49', '2026-08-24 23:26:49'),
(9, 'MONITOR 14\"', '2026-08-24 23:26:57', '2026-08-24 23:26:57'),
(10, 'MONITOR 21\"', '2026-08-24 23:27:05', '2026-08-24 23:27:05'),
(11, 'Laptop', NULL, NULL),
(12, 'PC', NULL, NULL),
(13, 'Monitor', NULL, NULL),
(14, 'Proyector', NULL, NULL),
(15, 'Impresora', NULL, NULL),
(16, 'Televisor', NULL, NULL),
(17, 'Teclado', NULL, NULL),
(18, 'Mouse', NULL, NULL),
(19, 'Parlante', NULL, NULL),
(20, 'Router', NULL, NULL),
(21, 'Switch', NULL, NULL),
(22, 'Tablet', NULL, NULL),
(23, 'Cámara', NULL, NULL),
(24, 'Micrófono', NULL, NULL),
(25, 'UPS', NULL, NULL),
(26, 'Laptop', NULL, NULL),
(27, 'PC', NULL, NULL),
(28, 'Monitor', NULL, NULL),
(29, 'Proyector', NULL, NULL),
(30, 'Impresora', NULL, NULL),
(31, 'Televisor', NULL, NULL),
(32, 'Teclado', NULL, NULL),
(33, 'Mouse', NULL, NULL),
(34, 'Parlante', NULL, NULL),
(35, 'Router', NULL, NULL),
(36, 'Switch', NULL, NULL),
(37, 'Tablet', NULL, NULL),
(38, 'Cámara', NULL, NULL),
(39, 'Micrófono', NULL, NULL),
(40, 'UPS', NULL, NULL),
(41, 'TIPO 21', '2026-08-31 20:53:35', '2026-08-31 20:53:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `nombre`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'AULA AIP I', 'AULA', '2026-08-24 21:19:34', '2026-08-26 18:17:24'),
(2, 'AULA AIP II', 'fasfas', '2026-08-24 23:27:42', '2026-08-26 19:09:58'),
(3, 'AULA 1', NULL, '2026-08-26 19:10:34', '2026-08-26 19:10:34'),
(4, 'AULA 2', NULL, '2026-08-26 19:10:39', '2026-08-26 19:10:39'),
(5, 'SALON 4', NULL, '2026-08-26 19:10:43', '2026-08-26 19:10:43'),
(6, 'DIRECCION', NULL, '2026-08-26 19:10:49', '2026-08-26 19:10:49'),
(7, 'SALON 6', NULL, '2026-08-26 19:11:01', '2026-08-26 19:11:01'),
(8, 'SALON 19', NULL, '2026-08-26 19:11:10', '2026-08-26 19:11:10'),
(9, 'AULA ERP', NULL, '2026-08-26 19:11:17', '2026-08-26 19:11:17'),
(10, 'SALON 14', NULL, '2026-08-26 19:11:24', '2026-08-26 19:11:24'),
(11, 'GSGDS', NULL, '2026-08-26 19:11:30', '2026-08-26 19:11:30'),
(12, 'Aula Innovación 1', 'Aula', NULL, NULL),
(13, 'Aula Innovación 2', 'Aula', NULL, NULL),
(14, 'Laboratorio 1', 'Laboratorio', NULL, NULL),
(15, 'Laboratorio 2', 'Laboratorio', NULL, NULL),
(16, 'Oficina CIST', 'Oficina', NULL, NULL),
(17, 'Dirección', 'Oficina', NULL, NULL),
(18, 'Secretaría', 'Oficina', NULL, NULL),
(19, 'Sala de Profesores', 'Oficina', NULL, NULL),
(20, 'Biblioteca', 'Ambiente', NULL, NULL),
(21, 'Almacén', 'Almacén', NULL, NULL),
(22, 'Sala de Reuniones', 'Ambiente', NULL, NULL),
(23, 'Aula 101', 'Aula', NULL, NULL),
(24, 'Aula 102', 'Aula', NULL, NULL),
(25, 'Aula 103', 'Aula', NULL, NULL),
(26, 'Aula 104', 'Aula', NULL, NULL),
(27, 'Aula Innovación 1', 'Aula', NULL, NULL),
(28, 'Aula Innovación 2', 'Aula', NULL, NULL),
(29, 'Laboratorio 1', 'Laboratorio', NULL, NULL),
(30, 'Laboratorio 2', 'Laboratorio', NULL, NULL),
(31, 'Oficina CIST', 'Oficina', NULL, NULL),
(32, 'Dirección', 'Oficina', NULL, NULL),
(33, 'Secretaría', 'Oficina', NULL, NULL),
(34, 'Sala de Profesores', 'Oficina', NULL, NULL),
(35, 'Biblioteca', 'Ambiente', NULL, NULL),
(36, 'Almacén', 'Almacén', NULL, NULL),
(37, 'Sala de Reuniones', 'Ambiente', NULL, NULL),
(38, 'Aula 101', 'Aula', NULL, NULL),
(39, 'Aula 102', 'Aula', NULL, NULL),
(40, 'Aula 103', 'Aula', NULL, NULL),
(41, 'Aula 104', 'Aula', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Diego Pimentel', 'correo1@gmail.com', NULL, '$2y$12$Un9tzm2JGPPE9LOiDN2hIeSEVrziivewMBiOp53hPxvdhNmY8aisy', 'wVxRHwLrqXzt72ezGlXay8KGL0PPagAb2g2SsbxmdQ2yUAcx0ZxeVCLYiYoP', '2026-08-24 21:29:02', '2026-08-24 21:29:02'),
(2, 'prueba2', 'prueba2@gmail.com', NULL, '$2y$12$EJLuqopku5wXTVZ56c6rXeUQSD4A/Gfe1xpipn8gcD7WpguRtmV1e', NULL, '2026-09-01 17:42:59', '2026-09-01 17:42:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios_equipo`
--
ALTER TABLE `accesorios_equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accesorios_equipo_equipo_id_foreign` (`equipo_id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `docentes_dni_unique` (`dni`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipos_tipo_equipo_id_foreign` (`tipo_equipo_id`),
  ADD KEY `equipos_ubicacion_id_foreign` (`ubicacion_id`);

--
-- Indices de la tabla `especificaciones_equipo`
--
ALTER TABLE `especificaciones_equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `especificaciones_equipo_equipo_id_foreign` (`equipo_id`);

--
-- Indices de la tabla `especificaciones_laptop`
--
ALTER TABLE `especificaciones_laptop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `especificaciones_laptop_equipo_id_foreign` (`equipo_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestamos_equipo_id_foreign` (`equipo_id`),
  ADD KEY `prestamos_docente_id_foreign` (`docente_id`),
  ADD KEY `prestamos_ubicacion_destino_id_foreign` (`ubicacion_destino_id`);

--
-- Indices de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios_equipo`
--
ALTER TABLE `accesorios_equipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `especificaciones_equipo`
--
ALTER TABLE `especificaciones_equipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especificaciones_laptop`
--
ALTER TABLE `especificaciones_laptop`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesorios_equipo`
--
ALTER TABLE `accesorios_equipo`
  ADD CONSTRAINT `accesorios_equipo_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_tipo_equipo_id_foreign` FOREIGN KEY (`tipo_equipo_id`) REFERENCES `tipos_equipo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipos_ubicacion_id_foreign` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `especificaciones_equipo`
--
ALTER TABLE `especificaciones_equipo`
  ADD CONSTRAINT `especificaciones_equipo_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `especificaciones_laptop`
--
ALTER TABLE `especificaciones_laptop`
  ADD CONSTRAINT `especificaciones_laptop_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamos_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamos_ubicacion_destino_id_foreign` FOREIGN KEY (`ubicacion_destino_id`) REFERENCES `ubicaciones` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
