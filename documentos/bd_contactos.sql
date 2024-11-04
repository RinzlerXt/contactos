-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 01:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_contactos`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `usuario_id`, `nombre`, `telefono`, `correo`, `fecha_creacion`) VALUES
(2, 1, 'sebastian', '3005377098', 'sebas@gmail.com', '2024-10-30 01:09:29'),
(4, 1, 'andres', '43743789', 'and@gmail.com', '2024-10-30 01:17:50'),
(5, 1, 'jhoana', '871267163', 'jh@gmail.com', '2024-10-30 01:18:06'),
(6, 1, 'andres betancour', '873726356', 'andb@gmail.com', '2024-10-30 01:18:57'),
(8, 2, 'daniel', '3278356256', 'daniel@gmail.com', '2024-11-03 21:45:36'),
(9, 2, 'daniel', '3005377098', 'dan@gmail.com', '2024-11-03 22:21:09'),
(10, 2, 'daniel', '3005377098', 'dan@gmail.com', '2024-11-03 22:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_inicio_sesion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo`, `contrasena`, `fecha_creacion`, `ultimo_inicio_sesion`) VALUES
(1, 'rafa', 'rafa22@gmail.com', '$2y$10$K97j91OdvbKVzEg66pVzFuCu1DWEuqwTEod.dBrAszpwRLU65vJ66', '2024-10-30 00:21:06', NULL),
(2, 'sebastian', 'sebas@gmail.com', '$2y$10$zuHsJJnGGygk1Bg9UeqFN.qPpKFDIVT7VEQ5ITfzmFRGvs/fBd1Xm', '2024-11-03 21:28:56', NULL),
(3, 'carlos', 'carlos@gmail.com', '$2y$10$qOyNQolsYHByDSvvcRy8Ie0A95.PJBUw37dKtxN5BSWV8eY7jfjiq', '2024-11-03 21:42:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_nombre_contacto` (`nombre`),
  ADD KEY `idx_correo_contacto` (`correo`),
  ADD KEY `idx_telefono_contacto` (`telefono`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
