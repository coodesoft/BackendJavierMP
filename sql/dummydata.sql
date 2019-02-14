-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-02-2019 a las 19:03:40
-- Versión del servidor: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `GMercadoPago`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AuthorizedLog`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DocumentsPerProfile`
--

CREATE TABLE `DocumentsPerProfile` (
  `Id` int(11) NOT NULL,
  `IdDocument` int(11) NOT NULL,
  `IdProfile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DocumentTypes`
--

CREATE TABLE `DocumentTypes` (
  `id` int(11) NOT NULL,
  `DocumentCode` varchar(5) NOT NULL,
  `DocumentName` varchar(45) NOT NULL,
  `DocumentDescription` varchar(255) DEFAULT NULL,
  `ObjectTypeId` int(11) NOT NULL,
  `VisibleIfPolicyIsExpired` tinyint(1) DEFAULT NULL,
  `IDType` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Functions`
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
-- Volcado de datos para la tabla `Functions`
--

INSERT INTO `Functions` (`id`, `Code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(6, 'MiPer', 'Edicion de Mi Perfil', 'Edicion del Perfil Personal del Usuario', '2018-04-17 14:41:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FunctionsInRole`
--

CREATE TABLE `FunctionsInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `FunctionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `FunctionsInRole`
--

INSERT INTO `FunctionsInRole` (`id`, `RoleId`, `FunctionId`) VALUES
(45, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Groups`
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
-- Volcado de datos para la tabla `Groups`
--

INSERT INTO `Groups` (`id`, `code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(1, 'Grupo', 'El Grupo', 'La Descripcion', '2018-10-29 15:55:38', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `GroupsInRole`
--

CREATE TABLE `GroupsInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `GroupId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ObjectType`
--

CREATE TABLE `ObjectType` (
  `id` int(11) NOT NULL,
  `cod` varchar(5) DEFAULT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Organizations`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `OrganizationSection`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Profiles`
--

CREATE TABLE `Profiles` (
  `id` int(11) NOT NULL,
  `ProfileName` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Profiles`
--

INSERT INTO `Profiles` (`id`, `ProfileName`) VALUES
(1, 'All documents (testing)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
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
-- Volcado de datos para la tabla `Roles`
--

INSERT INTO `Roles` (`id`, `code`, `Name`, `Description`, `Created`, `Updated`) VALUES
(1, '0001', 'All users', 'Rol definido para todos los usuarios', '2018-03-19 18:02:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sections`
--

CREATE TABLE `Sections` (
  `id` int(5) NOT NULL,
  `Code` varchar(5) CHARACTER SET latin1 NOT NULL,
  `Name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `Description` varchar(100) CHARACTER SET latin1 NOT NULL,
  `MinimunAge` int(11) NOT NULL,
  `MaximumAge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
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
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`id`, `FirstName`, `LastName`, `email`, `password`, `salt`, `created`, `updated`, `created_by`, `disabled_on`, `reset_token`, `reset_date`, `token`, `token_datetime`, `UserTypeCode`) VALUES
(7, 'Usuario', 'Administrador', 'test.coode@gmail.com', '$2y$10$Y8U0gAWbwuAqLYDLI3X69.PiSMIouzgRkTbnuZwvG.P/hnhHHgEb6', '', '2018-03-19 17:28:02', '2018-03-19 17:28:02', 6, NULL, '$2y$10$QqxkkEYNJg4IAnmVkyWP4O1SDzCZ2gIi7LNYnGs4DSUlxvRBJZqGW', '2019-02-06 10:46:07', '$2y$10$HnZWUUzHOAVJAqm/LZwxV.zZdMyfg1nOYZHPNmypL5MDZaekyW5wW', '2019-02-14 18:10:20', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersInGroup`
--

CREATE TABLE `UsersInGroup` (
  `id` int(11) NOT NULL,
  `GroupId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersInOrganization`
--

CREATE TABLE `UsersInOrganization` (
  `id` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersInProfile`
--

CREATE TABLE `UsersInProfile` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProfile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `UsersInProfile`
--

INSERT INTO `UsersInProfile` (`id`, `idUser`, `idProfile`) VALUES
(7, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersInRole`
--

CREATE TABLE `UsersInRole` (
  `id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `UsersInRole`
--

INSERT INTO `UsersInRole` (`id`, `RoleId`, `UserId`) VALUES
(30, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersTokenLog`
--

CREATE TABLE `UsersTokenLog` (
  `id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Token` varchar(256) NOT NULL,
  `DateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `AuthorizedLog`
--
ALTER TABLE `AuthorizedLog`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `DocumentsPerProfile`
--
ALTER TABLE `DocumentsPerProfile`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_DocumentsPerProfile_1_idx` (`IdProfile`),
  ADD KEY `fk_DocumentsPerProfile_2_idx` (`IdDocument`);

--
-- Indices de la tabla `DocumentTypes`
--
ALTER TABLE `DocumentTypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_DocumentTypes_1_idx` (`ObjectTypeId`);

--
-- Indices de la tabla `Functions`
--
ALTER TABLE `Functions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Code` (`Code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indices de la tabla `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FunctionsInRole_fk0` (`RoleId`),
  ADD KEY `FunctionsInRole_fk1` (`FunctionId`);

--
-- Indices de la tabla `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indices de la tabla `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `GroupsInRole_fk0` (`RoleId`),
  ADD KEY `GroupsInRole_fk1` (`GroupId`);

--
-- Indices de la tabla `ObjectType`
--
ALTER TABLE `ObjectType`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Organizations`
--
ALTER TABLE `Organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Organizations_fk0` (`PrimaryUser`);

--
-- Indices de la tabla `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `OrganizationSection_FK01` (`OrganizationId`),
  ADD KEY `OrganizationSection_FK02` (`SectionId`);

--
-- Indices de la tabla `Profiles`
--
ALTER TABLE `Profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indices de la tabla `Sections`
--
ALTER TABLE `Sections`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UsersInGroup_fk0` (`GroupId`),
  ADD KEY `UsersInGroup_fk1` (`UserId`);

--
-- Indices de la tabla `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `OrganizationUsers_fk0` (`OrganizationId`),
  ADD KEY `OrganizationUsers_fk1` (`UserId`);

--
-- Indices de la tabla `UsersInProfile`
--
ALTER TABLE `UsersInProfile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_UsersInProfile_1_idx` (`idProfile`);

--
-- Indices de la tabla `UsersInRole`
--
ALTER TABLE `UsersInRole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UsersInRole_fk0` (`RoleId`),
  ADD KEY `UsersInRole_fk1` (`UserId`);

--
-- Indices de la tabla `UsersTokenLog`
--
ALTER TABLE `UsersTokenLog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `AuthorizedLog`
--
ALTER TABLE `AuthorizedLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `DocumentsPerProfile`
--
ALTER TABLE `DocumentsPerProfile`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `DocumentTypes`
--
ALTER TABLE `DocumentTypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `Functions`
--
ALTER TABLE `Functions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `Groups`
--
ALTER TABLE `Groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ObjectType`
--
ALTER TABLE `ObjectType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Organizations`
--
ALTER TABLE `Organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `Profiles`
--
ALTER TABLE `Profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Sections`
--
ALTER TABLE `Sections`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `UsersInProfile`
--
ALTER TABLE `UsersInProfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `UsersInRole`
--
ALTER TABLE `UsersInRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `UsersTokenLog`
--
ALTER TABLE `UsersTokenLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `DocumentsPerProfile`
--
ALTER TABLE `DocumentsPerProfile`
  ADD CONSTRAINT `fk_DocumentsPerProfile_1` FOREIGN KEY (`IdProfile`) REFERENCES `Profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DocumentsPerProfile_2` FOREIGN KEY (`IdDocument`) REFERENCES `DocumentTypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `DocumentTypes`
--
ALTER TABLE `DocumentTypes`
  ADD CONSTRAINT `fk_DocumentTypes_1` FOREIGN KEY (`ObjectTypeId`) REFERENCES `ObjectType` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `FunctionsInRole`
--
ALTER TABLE `FunctionsInRole`
  ADD CONSTRAINT `FunctionsInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `FunctionsInRole_fk1` FOREIGN KEY (`FunctionId`) REFERENCES `Functions` (`id`);

--
-- Filtros para la tabla `GroupsInRole`
--
ALTER TABLE `GroupsInRole`
  ADD CONSTRAINT `GroupIdInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `GroupIdInRole_fk1` FOREIGN KEY (`GroupId`) REFERENCES `Groups` (`id`);

--
-- Filtros para la tabla `Organizations`
--
ALTER TABLE `Organizations`
  ADD CONSTRAINT `Organizations_fk0` FOREIGN KEY (`PrimaryUser`) REFERENCES `Users` (`id`);

--
-- Filtros para la tabla `OrganizationSection`
--
ALTER TABLE `OrganizationSection`
  ADD CONSTRAINT `OrganizationSection_FK01` FOREIGN KEY (`OrganizationId`) REFERENCES `Organizations` (`id`),
  ADD CONSTRAINT `OrganizationSection_FK02` FOREIGN KEY (`SectionId`) REFERENCES `Sections` (`id`);

--
-- Filtros para la tabla `UsersInGroup`
--
ALTER TABLE `UsersInGroup`
  ADD CONSTRAINT `UsersInGroup_fk0` FOREIGN KEY (`GroupId`) REFERENCES `Groups` (`id`),
  ADD CONSTRAINT `UsersInGroup_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);

--
-- Filtros para la tabla `UsersInOrganization`
--
ALTER TABLE `UsersInOrganization`
  ADD CONSTRAINT `OrganizationUsers_fk0` FOREIGN KEY (`OrganizationId`) REFERENCES `Organizations` (`id`),
  ADD CONSTRAINT `OrganizationUsers_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);

--
-- Filtros para la tabla `UsersInProfile`
--
ALTER TABLE `UsersInProfile`
  ADD CONSTRAINT `fk_UsersInProfile_1` FOREIGN KEY (`idProfile`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UsersInProfile_2` FOREIGN KEY (`idProfile`) REFERENCES `Profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `UsersInRole`
--
ALTER TABLE `UsersInRole`
  ADD CONSTRAINT `UsersInRole_fk0` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `UsersInRole_fk1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
