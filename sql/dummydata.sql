-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 11, 2019 at 04:07 PM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c1200155_Auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuthorizedLog`
--

CREATE TABLE `AuthorizedLog` (
  `id` int(11) NOT NULL,
  `Method` varchar(20) DEFAULT NULL,
  `FunctionCode` varchar(150) DEFAULT NULL,
  `UserToken` varchar(255) DEFAULT NULL,
  `IPv4` varchar(20) DEFAULT NULL,
  `Params` text,
  `DateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `AuthorizedLog`
--

INSERT INTO `AuthorizedLog` (`id`, `Method`, `FunctionCode`, `UserToken`, `IPv4`, `Params`, `DateTime`) VALUES
(1, NULL, NULL, NULL, '', NULL, '2019-01-08 17:27:52'),
(2, NULL, NULL, NULL, '186.129.174.248', NULL, '2019-01-08 17:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `Functions`
--

CREATE TABLE `Functions` (
  `id` int(11) NOT NULL,
  `Code` char(5) NOT NULL,
  `Name` char(30) NOT NULL,
  `Description` char(100) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Functions`
--

INSERT INTO `Functions` (`id`, `Code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(1, 'ConPo', 'Consulta de Poliza', 'Permite la consulta de una poliza a partir de su ramo y numero', '2018-03-19 17:46:00', NULL),
(2, 'CotAP', 'Cotización de Servicio de AP', 'Permite solicitar una cotizacion por un servicio de Accidentes Personales', '2018-03-19 17:46:00', NULL),
(6, 'MiPer', 'Edicion de Mi Perfil', 'Edicion del Perfil Personal del Usuario', '2018-04-17 14:41:04', NULL),
(7, 'Emisi', 'Emision de Polizas', 'Emision de Polizas', '2018-06-19 15:05:08', '2018-06-19 15:05:08'),
(8, 'RePro', 'Reportes de Productor', 'Reportes de Productor', '2018-06-19 16:10:31', NULL),
(9, 'Cupon', 'Genera  cupones de pago', 'Genera  cupones de pago', '2018-06-19 16:11:15', NULL),
(10, 'NAlta', 'Nuevas altas a polizas', 'Nuevas altas a polizas', '2018-06-19 16:12:18', NULL),
(11, 'Produ', 'Emisión Productos', 'Permite la emisión de productos cerrados', '2018-08-06 11:38:18', NULL),
(12, 'EmiPk', 'Emisión de productos', 'Emisión de pólizas mediante productos paquetizados', '2018-08-06 11:38:18', NULL),
(13, 'GEndo', 'Gestión de endosos', 'Permite la autogestión de diversos tipos de endosos sobre las pólizas', '2019-01-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `FunctionsInRole`
--

CREATE TABLE `FunctionsInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `FunctionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `FunctionsInRole`
--

INSERT INTO `FunctionsInRole` (`id`, `RoleId`, `FunctionId`) VALUES
(43, 1, 1),
(45, 1, 6),
(46, 6, 2),
(47, 7, 7),
(48, 8, 12),
(50, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `id` int(11) NOT NULL,
  `code` char(10) NOT NULL,
  `Name` char(20) NOT NULL,
  `Description` char(200) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`id`, `code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(1, 'Grupo', 'El Grupo', 'La Descripcion', '2018-10-29 15:55:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `GroupsInRole`
--

CREATE TABLE `GroupsInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `GroupId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Organizations`
--

CREATE TABLE `Organizations` (
  `id` int(11) NOT NULL,
  `Code` char(10) NOT NULL,
  `Name` char(40) NOT NULL COMMENT 'Nombre de la organizacion',
  `PrimaryUser` int(11) DEFAULT NULL COMMENT 'Usuario que puede mantener usuarios en la Organizacion',
  `Type` char(1) NOT NULL COMMENT 'Tiene el tipo de la organización que podrá ser alguno de los siguientes valores:\nC: Compania de Seguros\nP: Productor\nO: Organizador',
  `EnrollmentCode` char(5) DEFAULT NULL COMMENT 'Representa la matricula asignada por la Superintendencia de Seguros.En el caso de la propia compania de Seguros, podra usarse un valor dummy o dejarlo libre',
  `Created` datetime NOT NULL,
  `Updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Organizations`
--

INSERT INTO `Organizations` (`id`, `Code`, `Name`, `PrimaryUser`, `Type`, `EnrollmentCode`, `Created`, `Updated`) VALUES
(1, '00001', 'Cruz Suiza S.A.', 2, 'C', '00000', '2018-03-19 17:11:00', NULL),
(7, '38180', 'Ricarde', 9, 'P', '38180', '2018-04-13 15:28:22', '2018-04-13 15:28:22'),
(8, '42164', 'Carlos May', 7, 'P', '42164', '2018-04-15 23:27:55', '2018-04-15 23:27:55'),
(9, '45354', 'Zarate', 1, 'P', '45354', '2018-05-07 15:34:12', NULL),
(10, '56975', 'Smile', 1, 'P', '00913', '2018-05-30 15:14:58', NULL),
(11, '73811', 'Alejandro May', 1, 'P', '73811', '2018-06-01 10:34:57', '2018-06-01 10:34:57'),
(12, '00700', 'SEGURARGEN S.R.L.', 1, 'P', '00700', '2018-07-02 11:00:28', NULL),
(13, '08266', 'RUGGIERO NORBERTO MAXI', 1, 'P', '08266', '2018-07-02 11:28:40', NULL),
(14, '01174', 'Segurarse SA', 21, 'P', '01174', '2018-11-09 12:53:18', '2018-11-09 14:34:36'),
(17, '47326', 'Barreiro Diego Rodrigo', 34, 'P', '47326', '2018-11-15 18:00:03', '2018-11-15 18:00:03'),
(18, '80495', 'COLUCCI MARCELO FRANCO', 35, 'P', '80495', '2018-11-21 18:32:14', '2018-11-21 18:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `OrganizationSection`
--

CREATE TABLE `OrganizationSection` (
  `id` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  `MaxInsuredAmount` double(20,2) NOT NULL,
  `MaxBrokerFee` decimal(6,3) NOT NULL,
  `AgentEnrollmentCode` int(11) NOT NULL,
  `AgentFee` decimal(6,3) NOT NULL,
  `MinAge` int(3) NOT NULL COMMENT 'Edad mínima del asegurado',
  `MaxAge` int(3) NOT NULL COMMENT 'Edad máxima del asegurado',
  `urlProductAdm` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `OrganizationSection`
--

INSERT INTO `OrganizationSection` (`id`, `OrganizationId`, `SectionId`, `MaxInsuredAmount`, `MaxBrokerFee`, `AgentEnrollmentCode`, `AgentFee`, `MinAge`, `MaxAge`, `urlProductAdm`) VALUES
(1, 7, 1, 2000000.00, '20.000', 56975, '10.000', 14, 66, 'https://productos.cruzsuiza.com'),
(2, 8, 1, 2000000.00, '40.000', 42164, '0.000', 14, 66, 'https://productos.cruzsuiza.com'),
(3, 1, 1, 2000000.00, '35.000', 0, '5.000', 14, 66, 'https://productos.cruzsuiza.com'),
(4, 9, 1, 2000000.00, '35.000', 45354, '5.000', 14, 66, 'https://productos.cruzsuiza.com'),
(5, 11, 1, 2000000.00, '35.000', 42164, '0.000', 14, 66, 'https://productos.cruzsuiza.com'),
(6, 10, 1, 2000000.00, '40.000', 913, '0.000', 14, 66, 'https://productos.cruzsuiza.com'),
(7, 12, 1, 2000000.00, '35.000', 700, '5.000', 14, 66, 'https://productos.cruzsuiza.com'),
(8, 13, 1, 2000000.00, '40.000', 8266, '0.000', 14, 66, 'https://productos.cruzsuiza.com'),
(9, 14, 1, 2000000.00, '40.000', 1174, '0.000', 14, 66, 'https://productos.cruzsuiza.com'),
(15, 17, 1, 2000000.00, '40.000', 47326, '0.000', 14, 65, 'https://productos.cruzsuiza.com'),
(16, 18, 1, 2000000.00, '20.000', 53513, '25.000', 15, 65, 'https://productos.cruzsuiza.com');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `id` int(11) NOT NULL,
  `code` char(10) NOT NULL,
  `Name` char(20) NOT NULL,
  `Description` char(200) NOT NULL,
  `Created` datetime NOT NULL,
  `Updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`id`, `code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(1, '0001', 'Consultas', 'Consultas de polizas, busquedas y cotizaciones', '2018-03-19 18:02:01', NULL),
(6, '0002', 'Cotizacion', 'Solo cotiza', '2018-05-30 15:55:10', '2018-05-30 15:55:10'),
(7, '0003', 'Emision', 'Emision', '2018-06-27 12:16:31', NULL),
(8, '0004', 'Productos', 'Permite emisión de productos cerrados', '2018-08-06 11:40:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Sections`
--

CREATE TABLE `Sections` (
  `id` int(5) NOT NULL,
  `Code` varchar(5) CHARACTER SET latin1 NOT NULL,
  `Name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `Description` varchar(100) CHARACTER SET latin1 NOT NULL,
  `MinimunAge` int(11) NOT NULL,
  `MaximumAge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Sections`
--

INSERT INTO `Sections` (`id`, `Code`, `Name`, `Description`, `MinimunAge`, `MaximumAge`) VALUES
(1, '12', 'Accidentes Personales', 'Seguros de Accidentes Personales', 14, 65);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `FirstName` char(50) NOT NULL,
  `LastName` char(50) NOT NULL,
  `email` char(60) NOT NULL,
  `password` char(255) NOT NULL,
  `salt` varchar(70) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `disabled_on` datetime DEFAULT NULL,
  `reset_token` varchar(128) NOT NULL,
  `reset_date` datetime NOT NULL,
  `token` varchar(256) NOT NULL,
  `token_datetime` datetime NOT NULL,
  `UserTypeCode` varchar(1) DEFAULT NULL COMMENT 'Tipo de Usuario [A: Admin, U:Usuario]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `FirstName`, `LastName`, `email`, `password`, `salt`, `created`, `updated`, `created_by`, `disabled_on`, `reset_token`, `reset_date`, `token`, `token_datetime`, `UserTypeCode`) VALUES
(1, 'Super', 'Admin', 'admin@insurclicks.com', '$2y$10$03I7p/4/2K8iJMQYbpLmguY0YkV0ZLK708.Xe6EStV5cSY4erAEBu', '', '2018-03-19 17:06:15', '2018-03-19 17:06:15', 0, NULL, '', '0000-00-00 00:00:00', '$2y$10$LsPzTK7Qu7sX2fEuqVWWZO2/0XZ2wdxBzYiv3hQGMXKHbmGmUY9xe', '2018-11-20 14:28:28', 'A'),
(2, 'Administrador', 'Cruz Suiza', 'admin@cruzsuiza.com', '$2y$10$03I7p/4/2K8iJMQYbpLmguY0YkV0ZLK708.Xe6EStV5cSY4erAEBu', '', '2018-03-19 17:13:18', '2018-03-19 17:13:18', 0, NULL, '$2y$10$2rUW.X7OGX8cSwljfZ5yY.aNTE0/xfQxJSeX150/IuXx08qiSNAY.', '2018-04-03 15:48:35', '$2y$10$zLEc/8MgYq1BRmj4plDFZugr6HS1q0Vmbi5sIUhaN0lcajjsI7RMy', '2018-11-19 19:55:39', 'A'),
(7, 'Luciano', 'Vega', 'lucho.2012.tandil@gmail.com', '$2y$10$BAdjpiIyCrzJVcO64XDTje8rzXpcIkfm8ud6.AAlYnDnEyE0BVnZq', '', '2018-03-19 17:28:02', '2018-03-19 17:28:02', 6, NULL, '$2y$10$htq6UOfY8RDaoKCq0obQTuYuAFW0PeLRLKoGxxL7BChX2dwdRQtPO', '2018-11-09 17:32:18', '$2y$10$6wHCU5yujCWnyhAN/WlbTuoa/EHSaFmXz.1boiHx6s4GcEgFwuBI2', '2019-01-11 15:20:56', 'A'),
(9, 'Luis E.', 'Alvarez', 'luis.e.alvarez@hotmail.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '$2y$10$pYxWaqlm0YPSNsfYmtnOIOmm8ixvX3g7dg9ZUaCYjrvviwmAZFeLe', '2018-08-02 15:14:49', '$2y$10$mRA30K39Yx1xBjnzAKmoUumr53DoaGo9V6x1KFo.4ZF1sV3qFI.wC', '2018-11-23 17:23:01', 'U'),
(10, 'Carlos', 'May', 'cmay@segurosmay.com.ar', '$2y$10$HIhq1g4dudV6UQDDm9ddOefbYsfmwikagAPztPFzDmroAXeUuaOQ6', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '', '0000-00-00 00:00:00', '$2y$10$23sEjnbvPwojUJHyK72MgO9acUc7GGuNcjz9JvSCFzpXVgJ0qPLtS', '2018-11-12 10:12:31', 'U'),
(11, 'Carlos', 'Zarate', 'carlos@patagonicaseguros.com.ar', '$2y$10$03I7p/4/2K8iJMQYbpLmguY0YkV0ZLK708.Xe6EStV5cSY4erAEBu', '', '2018-05-07 15:43:44', '0000-00-00 00:00:00', 1, NULL, '', '0000-00-00 00:00:00', '$2y$10$g26TJ9cDw22cyywVBUnRSOFx6Wlfw45FxypQlX6naKEj7CX8TA3EW', '2018-11-12 10:14:17', 'U'),
(12, 'Irene', 'Cimino', 'icimino@smilebroker.com.ar', '$2y$10$03I7p/4/2K8iJMQYbpLmguY0YkV0ZLK708.Xe6EStV5cSY4erAEBu', ' ', '2018-05-30 15:34:18', '2018-05-30 15:34:18', 1, NULL, ' ', '2018-05-30 15:34:18', '$2y$10$Ru5ak/HxYJTF6vY.rW3NteuBXtGiCwLdI06HKzLHTyFDJZsUDchnm', '2018-11-12 10:14:39', 'U'),
(14, 'Alejandro', 'May', 'amay@segurosmay.com.ar', '$2y$10$03I7p/4/2K8iJMQYbpLmguY0YkV0ZLK708.Xe6EStV5cSY4erAEBu', ' ', '2018-06-01 10:37:08', '2018-06-01 10:37:08', 1, NULL, ' ', '2018-06-01 10:37:08', '$2y$10$7QawrZHbroog8Kd.x8e4/eNIxH63csrudEFRa0WyHNE80DD94gXky', '2018-11-14 18:20:59', 'U'),
(15, 'Marcelo', 'Vera', 'marcelov@cruzsuiza.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '', '2018-04-19 18:04:12', '$2y$10$YamevjwddF/aZq3Xudu9XOpcFgsKEvFVvXyGTQmDhav6Y45G/IKy2', '2018-11-26 13:21:28', 'A'),
(16, 'Patricia', 'Leugers', 'patricial@cruzsuiza.com', '$2y$10$2nfq6ua19uCJggyODbLq3u4EUIR1HWlZ6vel5wmTS0ktJvBs9JqoC', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '', '2018-04-19 18:04:12', '$2y$10$ogh92dl4keyFKmQJL/bRr.l0xNMW9GyRMAR5q4o9BSlxlCucvH7GC', '2018-11-23 14:27:51', 'A'),
(17, 'Pablo', 'Spada', 'pablos@cruzsuiza.com', '$2y$10$M8i/IHBvpu0q93PBDavxfuuD6OSx9D2bJHb9lEI4QZr7m9L3liHIO', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '', '2018-04-19 18:04:12', '$2y$10$NEKxDklAMHltr1pNcQQZTOSQ3cctl6713CAva.smWMCOfU43xdwwO', '2018-11-23 13:32:19', 'A'),
(18, 'Cristian', 'Galatti', 'cristiang@cruzsuiza.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', '', '2018-04-13 15:41:32', '2018-04-13 15:41:32', 0, NULL, '', '2018-04-19 18:04:12', '$2y$10$TFAux3E9WjfRxkTzyqlrL.5ocKEmRvY1Bu6cQnvnZtAMlVTj89.6O', '2018-11-22 13:28:33', 'A'),
(20, 'Luis', 'Alvarez', 'luis.alvarez@cruzsuiza.com', '$2y$10$A4/f2npo3/7Z.TmcrN0D/.m0dQNmGea0325HGKXZEUn2nLRIB9z0S', '', '2018-11-08 18:44:18', '2018-11-08 18:44:18', 0, NULL, '', '2018-11-08 18:44:18', '$2y$10$iuCngDs1/6jo6i9DbkRGNuu5BSgNDu4ckuUMNw8o0Z1ENw8CB/WHC', '2018-11-23 14:14:04', 'A'),
(21, 'Anabel', 'Sanchez', 'asanchez@segurarse.com.ar', '$2y$10$A4/f2npo3/7Z.TmcrN0D/.m0dQNmGea0325HGKXZEUn2nLRIB9z0S', '', '2018-11-09 14:13:02', '2018-11-09 14:13:02', 0, NULL, '$2y$10$pYxWaqlm0YPSNsfYmtnOIOmm8ixvX3g7dg9ZUaCYjrvviwmAZFeLe', '2018-11-09 14:13:02', '$2y$10$9XbI0OMYOdNxnN9mU4lpIOLjCE8v0oyMgK7lYnbMsAg6Oby6.mOo.', '2018-11-12 10:15:15', 'U'),
(22, 'German', 'Ricarde', 'germanricarde@sion.com', '$2y$10$NJh4Cmrqh6JGD8y.SA0V4ek3pBmw.ppb7HwhzHzagrezzGucTy8aq', '', '2018-11-09 19:08:18', '2018-11-09 19:08:18', 0, NULL, '$2y$10$fJpkOn.FJ8EG3/P6BE106evl4HorSVY1RYazo76ndZRlw57nONzTC', '2018-11-14 15:38:42', '$2y$10$CDsc9NnFwFlLk6Qk.SSGK.uHIvtXGV51lJH12oqyt4.ATwBRzvSbC', '2018-11-22 13:45:33', 'U'),
(28, 'Carolina', 'Devcic', 'carolinadevcicsegurosricarde@sion.com', '$2y$10$blizHezW2H3Wkwai63uJk.FRtCyEAQ3nmXkfC2SxPw7FULamIAILu', '', '2018-11-14 16:18:38', '2018-11-14 16:18:38', 0, NULL, '', '2018-11-14 16:18:38', '$2y$10$6/OSW4WlNlcaiMowKl/I8u/CjKrFvSPW/ZxAEM9cJh/h5UV5nAN3W', '2018-11-26 10:19:31', 'U'),
(29, 'Lucas', 'Ricarde', 'lucasricarde.segurosricarde@sion.com', '$2y$10$dyiwgvDRoxGNOLsC53Bs2OoZCeVV20sr/B83aN0dfjo2XJLKGtCry', '', '2018-11-14 16:20:47', '2018-11-14 16:20:47', 0, NULL, '', '2018-11-14 16:20:47', '$2y$10$.WprOQrRyii/th7p0ScsbuEfphawfhdc4j/k.RTFnm2iY0PrzXYJy', '2018-11-26 11:50:40', 'U'),
(30, 'Jacqueline', 'Nieto', 'jacquelinenietosegurosricarde@sion.com', '$2y$10$/pgKV23mCPadgjXQplQL0upBXqIegodDyjdObVNFrWassYDk7GSXG', '', '2018-11-14 16:20:48', '2018-11-14 16:20:48', 0, NULL, '', '2018-11-14 16:20:48', '$2y$10$q4MImeSDye9QxpoU52.N6Oo8JOPy364iVD3xSJ9sRSfWvzl.gskCW', '2018-11-26 14:31:20', 'U'),
(31, 'Carla', 'Molina', 'carlamolinasegurosricarde@sion.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', '', '2018-11-14 16:20:49', '2018-11-14 16:20:49', 0, NULL, '', '2018-11-14 16:20:49', '$2y$10$gzJEAdYP3YI1ud.P8v5rIuUzQEoixW1qheJSpc/dOEcuVyM85YkwK', '2018-11-14 16:26:37', 'U'),
(32, 'Jeronimo', 'Ricarde', 'jeronimoricardesegurosricarde@sion.com', '$2y$10$NPcJwxLA6Srv3r8kbWgF2uu4r/SywUML4WuYRhpByD4Pgw69XeIgi', '', '2018-11-14 16:20:50', '2018-11-14 16:20:50', 0, NULL, '', '2018-11-14 16:20:50', '$2y$10$WNncgFWUWOn1Ms36DzFm0.gBaV5C3sihlSbXGmqlpGpVb9Qv4XiqK', '2018-11-22 17:14:52', 'U'),
(33, 'Gaston', 'Canzani', 'gastonc@cruzsuiza.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', '', '2018-11-14 17:58:38', '2018-11-14 17:58:38', 0, NULL, '', '2018-11-14 17:58:38', '$2y$10$YHPyFurxOzpmppZbsXhe7OyDbpnhRtX7VuXky1c6.kllpOF4UlBFm', '2018-11-16 12:50:57', 'A'),
(34, 'Diego Rodrigo', 'Rodrigo', 'dbarreiro@grupotmg.com.ar', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', ' ', '2018-11-15 18:00:03', '2018-11-15 18:00:03', 1, NULL, ' ', '2018-11-15 18:00:03', '$2y$10$QKFYO.TiEGJTf8.wJcJCLuVbEZDgft5KKMExXReIUTn4jjhGRj6V2', '2018-11-15 18:03:49', 'U'),
(35, 'Marcelo', 'Colucci', 'colmar49@gmail.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', ' ', '2018-11-21 18:32:14', '2018-11-21 18:32:14', 1, NULL, ' ', '2018-11-21 18:32:14', '$2y$10$sXba32e.vgVb5NviMu4YMurGtG5cklHUpfwyjC2ZXwgH8jGw4YR62', '2018-11-21 18:34:14', 'U'),
(36, 'Fernando', 'Gasparoni', 'fergaspa@yahoo.com.ar', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', ' ', '2018-11-21 18:36:07', '2018-11-21 18:36:07', 1, NULL, '', '2018-11-21 18:36:07', '$2y$10$WLXllEouachgfNJ170WrvutGq7gH.CcqZo4B8I5aLKqKu6906.CCK', '2018-11-23 15:35:18', 'U'),
(37, 'Javier', 'Ramirez', 'javier.mazzelo@gmail.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', ' ', '2018-11-21 21:32:33', '2018-11-21 21:32:33', 1, NULL, '', '2018-11-21 21:32:33', '', '2018-11-21 21:32:33', 'U'),
(38, 'Juan', 'Paniza', 'emisionesseguros@gmail.com', '$2y$10$29K/Qlc4x7obsTLqhpEw.O9jXPOiJUszMIKo97Y.yGbMuNaYm0MLy', ' ', '2018-11-21 21:32:43', '2018-11-21 21:32:43', 1, NULL, '', '2018-11-21 21:32:43', '', '2018-11-21 21:32:43', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `UsersInGroup`
--

CREATE TABLE `UsersInGroup` (
  `id` int(11) NOT NULL,
  `GroupId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UsersInOrganization`
--

CREATE TABLE `UsersInOrganization` (
  `id` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `UsersInOrganization`
--

INSERT INTO `UsersInOrganization` (`id`, `OrganizationId`, `UserId`) VALUES
(8, 1, 1),
(9, 1, 2),
(15, 7, 9),
(16, 8, 10),
(17, 9, 11),
(18, 10, 12),
(19, 11, 14),
(24, 1, 20),
(25, 14, 21),
(29, 7, 22),
(33, 7, 28),
(34, 7, 29),
(35, 7, 30),
(36, 7, 31),
(37, 7, 32),
(38, 17, 34),
(39, 1, 15),
(40, 1, 7),
(41, 1, 16),
(42, 1, 17),
(43, 1, 18),
(44, 1, 33),
(45, 18, 35),
(46, 18, 36),
(47, 18, 37),
(48, 18, 38);

-- --------------------------------------------------------

--
-- Table structure for table `UsersInRole`
--

CREATE TABLE `UsersInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `UsersInRole`
--

INSERT INTO `UsersInRole` (`id`, `RoleId`, `UserId`) VALUES
(1, 1, 9),
(2, 1, 10),
(3, 1, 11),
(4, 6, 12),
(5, 1, 14),
(7, 1, 14),
(8, 1, 15),
(9, 1, 16),
(10, 1, 17),
(11, 1, 18),
(26, 8, 9),
(28, 1, 21),
(29, 7, 9),
(30, 1, 7),
(31, 6, 14),
(32, 6, 10),
(33, 1, 22),
(34, 6, 22),
(35, 8, 22),
(36, 8, 14),
(37, 8, 10),
(38, 6, 9),
(39, 6, 21),
(40, 8, 21),
(41, 8, 11),
(42, 6, 11),
(43, 6, 16),
(44, 8, 16),
(45, 8, 15),
(46, 6, 15),
(56, 1, 28),
(57, 6, 28),
(58, 8, 28),
(59, 1, 29),
(60, 6, 29),
(61, 8, 29),
(62, 1, 30),
(63, 6, 30),
(64, 8, 30),
(65, 1, 31),
(66, 6, 31),
(67, 8, 31),
(68, 1, 32),
(69, 6, 32),
(70, 8, 32),
(71, 1, 2),
(72, 6, 2),
(73, 1, 33),
(74, 6, 33),
(75, 8, 33),
(76, 1, 34),
(77, 6, 34),
(78, 8, 34),
(80, 6, 7),
(81, 7, 7),
(82, 8, 7),
(83, 6, 17),
(84, 8, 17),
(85, 6, 18),
(86, 8, 18),
(87, 1, 35),
(89, 8, 35),
(90, 1, 36),
(92, 8, 36),
(93, 1, 37),
(95, 8, 37),
(96, 1, 38),
(98, 8, 38),
(102, 1, 20),
(103, 6, 20);

-- --------------------------------------------------------

--
-- Table structure for table `UsersTokenLog`
--

CREATE TABLE `UsersTokenLog` (
  `id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Token` varchar(256) NOT NULL,
  `DateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `UsersTokenLog`
--

INSERT INTO `UsersTokenLog` (`id`, `IdUser`, `Token`, `DateTime`) VALUES
(1, 7, '$2y$10$TQRQix5Vk2hTC1YeC88jRuxgci.4wIb4CRsMZ3sOnqqNRqHbikQDe', '2019-01-08 16:58:23'),
(2, 7, '$2y$10$6wHCU5yujCWnyhAN/WlbTuoa/EHSaFmXz.1boiHx6s4GcEgFwuBI2', '2019-01-11 15:20:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AuthorizedLog`
--
ALTER TABLE `AuthorizedLog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Functions`
--
ALTER TABLE `Functions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Code` (`Code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FunctionsInRole_fk0` (`RoleId`),
  ADD KEY `FunctionsInRole_fk1` (`FunctionId`);

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `GroupsInRole_fk0` (`RoleId`),
  ADD KEY `GroupsInRole_fk1` (`GroupId`);

--
-- Indexes for table `Organizations`
--
ALTER TABLE `Organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Organizations_fk0` (`PrimaryUser`);

--
-- Indexes for table `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `OrganizationSection_FK01` (`OrganizationId`),
  ADD KEY `OrganizationSection_FK02` (`SectionId`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `Sections`
--
ALTER TABLE `Sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UsersInGroup_fk0` (`GroupId`),
  ADD KEY `UsersInGroup_fk1` (`UserId`);

--
-- Indexes for table `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `OrganizationUsers_fk0` (`OrganizationId`),
  ADD KEY `OrganizationUsers_fk1` (`UserId`);

--
-- Indexes for table `UsersInRole`
--
ALTER TABLE `UsersInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UsersInRole_fk0` (`RoleId`),
  ADD KEY `UsersInRole_fk1` (`UserId`);

--
-- Indexes for table `UsersTokenLog`
--
ALTER TABLE `UsersTokenLog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AuthorizedLog`
--
ALTER TABLE `AuthorizedLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Functions`
--
ALTER TABLE `Functions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Groups`
--
ALTER TABLE `Groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Organizations`
--
ALTER TABLE `Organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Sections`
--
ALTER TABLE `Sections`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `UsersInRole`
--
ALTER TABLE `UsersInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `UsersTokenLog`
--
ALTER TABLE `UsersTokenLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  ADD CONSTRAINT `FunctionsInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `FunctionsInRole_fk1` FOREIGN KEY (`FunctionId`) REFERENCES `Functions` (`id`);

--
-- Constraints for table `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  ADD CONSTRAINT `GroupIdInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `GroupIdInRole_fk1` FOREIGN KEY (`GroupId`) REFERENCES `Groups` (`id`);

--
-- Constraints for table `Organizations`
--
ALTER TABLE `Organizations`
  ADD CONSTRAINT `Organizations_fk0` FOREIGN KEY (`PrimaryUser`) REFERENCES `Users` (`id`);

--
-- Constraints for table `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  ADD CONSTRAINT `OrganizationSection_FK01` FOREIGN KEY (`OrganizationId`) REFERENCES `Organizations` (`id`),
  ADD CONSTRAINT `OrganizationSection_FK02` FOREIGN KEY (`SectionId`) REFERENCES `Sections` (`id`);

--
-- Constraints for table `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  ADD CONSTRAINT `UsersInGroup_fk0` FOREIGN KEY (`GroupId`) REFERENCES `Groups` (`id`),
  ADD CONSTRAINT `UsersInGroup_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);

--
-- Constraints for table `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  ADD CONSTRAINT `OrganizationUsers_fk0` FOREIGN KEY (`OrganizationId`) REFERENCES `Organizations` (`id`),
  ADD CONSTRAINT `OrganizationUsers_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);

--
-- Constraints for table `UsersInRole`
--
ALTER TABLE `UsersInRole`
  ADD CONSTRAINT `UsersInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `UsersInRole_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
