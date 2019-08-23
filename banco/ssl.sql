-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Ago-2019 às 00:45
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssl`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cads_usuarios`
--

CREATE TABLE `adms_cads_usuarios` (
  `id` int(11) NOT NULL,
  `env_email_conf` int(11) NOT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `adms_cads_usuarios`
--

INSERT INTO `adms_cads_usuarios` (`id`, `env_email_conf`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 2, 4, 3, '2019-08-15 00:00:00', '2019-08-22 17:30:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_confs_emails`
--

CREATE TABLE `adms_confs_emails` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `email` varchar(220) NOT NULL,
  `host` varchar(220) NOT NULL,
  `usuario` varchar(220) NOT NULL,
  `senha` varchar(120) NOT NULL,
  `smtpsecure` varchar(10) NOT NULL,
  `porta` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `adms_confs_emails`
--

INSERT INTO `adms_confs_emails` (`id`, `nome`, `email`, `host`, `usuario`, `senha`, `smtpsecure`, `porta`, `created`, `modified`) VALUES
(1, 'SS Editora', 'admin@sseditora.com.br', 'mail.sseditora.com.br', 'admin@sseditora.com.br', 'eEo!9MR2WR1I', 'ssl', 465, '2019-08-15 00:00:00', '2019-08-19 16:24:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cors`
--

CREATE TABLE `adms_cors` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cors`
--

INSERT INTO `adms_cors` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Azul', 'primary', '2018-03-23 00:00:00', NULL),
(2, 'Cinza', 'secondary', '2018-03-23 00:00:00', NULL),
(3, 'Verde', 'success', '2018-03-23 00:00:00', NULL),
(4, 'Vermelho', 'danger', '2018-03-23 00:00:00', NULL),
(5, 'Laranjado', 'warning', '2018-03-23 00:00:00', NULL),
(6, 'Azul claro', 'info', '2018-03-23 00:00:00', NULL),
(7, 'Claro', 'light', '2018-03-23 00:00:00', NULL),
(8, 'Cinza escuro', 'dark', '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_grps_pgs`
--

CREATE TABLE `adms_grps_pgs` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `adms_grps_pgs`
--

INSERT INTO `adms_grps_pgs` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Listar', 1, '2019-07-30 00:00:00', NULL),
(2, 'Cadastrar', 2, '2019-07-30 00:00:00', NULL),
(3, 'Editar', 3, '2019-07-30 00:00:00', NULL),
(4, 'Apagar', 4, '2019-07-30 00:00:00', NULL),
(5, 'Visualizar', 5, '2019-07-30 00:00:00', NULL),
(6, 'Outros', 6, '2019-07-30 00:00:00', NULL),
(7, 'Acesso', 7, '2019-07-30 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_menus`
--

CREATE TABLE `adms_menus` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_menus`
--

INSERT INTO `adms_menus` (`id`, `nome`, `icone`, `ordem`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', 1, 1, '2018-03-23 00:00:00', NULL),
(2, 'Usuario', 'fas fa-user', 2, 1, '2018-03-23 00:00:00', NULL),
(3, 'Menu', 'fas fa-list-ul', 3, 1, '2018-03-23 00:00:00', '2019-08-13 12:04:30'),
(4, 'Sair', 'fas fa-sign-out-alt', 5, 1, '2018-03-23 00:00:00', '2019-08-15 16:35:13'),
(10, 'ConfiguraÃ§Ãµes', 'fas fa-cogs', 4, 1, '2019-08-15 16:33:46', '2019-08-15 16:35:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_nivacs_pgs`
--

CREATE TABLE `adms_nivacs_pgs` (
  `id` int(11) NOT NULL,
  `permissao` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `dropdown` int(11) NOT NULL,
  `lib_menu` int(11) NOT NULL DEFAULT '2',
  `adms_menu_id` int(11) NOT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_pagina_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_nivacs_pgs`
--

INSERT INTO `adms_nivacs_pgs` (`id`, `permissao`, `ordem`, `dropdown`, `lib_menu`, `adms_menu_id`, `adms_niveis_acesso_id`, `adms_pagina_id`, `created`, `modified`) VALUES
(1, 1, 1, 2, 1, 1, 1, 1, '2018-03-23 00:00:00', NULL),
(2, 1, 2, 1, 1, 2, 1, 5, '2018-03-23 00:00:00', NULL),
(3, 1, 3, 1, 1, 2, 1, 6, '2018-03-23 00:00:00', NULL),
(4, 1, 4, 1, 1, 3, 1, 7, '2018-03-23 00:00:00', NULL),
(5, 1, 5, 1, 1, 3, 1, 8, '2018-03-23 00:00:00', NULL),
(6, 1, 6, 2, 1, 4, 1, 4, '2018-03-23 00:00:00', NULL),
(7, 1, 7, 2, 2, 2, 1, 9, '2018-03-23 00:00:00', NULL),
(8, 1, 8, 2, 2, 2, 1, 10, '2018-03-23 00:00:00', NULL),
(9, 1, 9, 2, 2, 2, 1, 11, '2018-03-23 00:00:00', NULL),
(10, 1, 10, 2, 2, 2, 1, 12, '2018-03-23 00:00:00', NULL),
(11, 1, 11, 2, 2, 2, 1, 13, '2018-03-23 00:00:00', NULL),
(12, 1, 1, 2, 1, 1, 3, 1, '2018-03-23 00:00:00', NULL),
(13, 1, 2, 1, 1, 2, 3, 5, '2018-03-23 00:00:00', NULL),
(14, 1, 3, 1, 1, 2, 3, 6, '2018-03-23 00:00:00', NULL),
(15, 1, 4, 1, 1, 3, 3, 7, '2018-03-23 00:00:00', NULL),
(16, 1, 5, 1, 1, 3, 3, 8, '2018-03-23 00:00:00', NULL),
(17, 1, 6, 2, 1, 4, 3, 4, '2018-03-23 00:00:00', NULL),
(18, 1, 7, 2, 2, 2, 3, 9, '2018-03-23 00:00:00', NULL),
(19, 1, 8, 2, 2, 2, 3, 10, '2018-03-23 00:00:00', NULL),
(20, 1, 9, 2, 2, 2, 3, 11, '2018-03-23 00:00:00', '2019-08-07 14:30:46'),
(21, 1, 10, 2, 2, 2, 3, 12, '2018-03-23 00:00:00', '2019-08-07 14:30:47'),
(22, 1, 11, 2, 2, 2, 3, 13, '2018-03-23 00:00:00', NULL),
(23, 1, 12, 2, 2, 2, 1, 14, '2018-03-23 00:00:00', NULL),
(24, 1, 13, 2, 2, 2, 1, 15, '2018-03-23 00:00:00', NULL),
(25, 1, 14, 1, 2, 3, 1, 16, '2018-03-23 00:00:00', NULL),
(26, 1, 15, 1, 2, 3, 1, 17, '2018-03-23 00:00:00', NULL),
(27, 1, 16, 1, 2, 3, 1, 19, '2019-07-31 17:29:38', NULL),
(28, 2, 1, 1, 2, 3, 2, 19, '2019-07-31 17:29:38', NULL),
(29, 2, 12, 1, 2, 3, 3, 19, '2019-07-31 17:29:38', NULL),
(30, 2, 1, 1, 2, 3, 9, 19, '2019-07-31 17:29:38', NULL),
(31, 1, 17, 1, 2, 3, 1, 20, '2019-08-01 17:05:42', NULL),
(32, 2, 2, 1, 2, 3, 2, 20, '2019-08-01 17:05:42', NULL),
(33, 2, 13, 1, 2, 3, 3, 20, '2019-08-01 17:05:42', NULL),
(34, 2, 2, 1, 2, 3, 9, 20, '2019-08-01 17:05:42', NULL),
(35, 1, 18, 1, 2, 3, 1, 21, '2019-08-01 17:50:28', NULL),
(36, 2, 3, 1, 2, 3, 2, 21, '2019-08-01 17:50:28', NULL),
(37, 2, 14, 1, 2, 3, 3, 21, '2019-08-01 17:50:28', NULL),
(38, 2, 3, 1, 2, 3, 9, 21, '2019-08-01 17:50:28', NULL),
(39, 1, 19, 1, 2, 3, 1, 22, '2019-08-02 11:07:07', NULL),
(40, 2, 4, 1, 2, 3, 2, 22, '2019-08-02 11:07:07', NULL),
(41, 2, 15, 1, 2, 3, 3, 22, '2019-08-02 11:07:07', NULL),
(42, 2, 4, 1, 2, 3, 9, 22, '2019-08-02 11:07:07', NULL),
(50, 2, 5, 1, 2, 3, 9, 24, '2019-08-05 15:16:38', NULL),
(49, 2, 16, 1, 2, 3, 3, 24, '2019-08-05 15:16:38', NULL),
(48, 1, 5, 1, 2, 3, 2, 24, '2019-08-05 15:16:38', '2019-08-08 15:38:31'),
(47, 1, 20, 1, 2, 3, 1, 24, '2019-08-05 15:16:38', NULL),
(51, 1, 21, 1, 2, 3, 1, 25, '2019-08-07 13:59:32', NULL),
(52, 2, 6, 1, 2, 3, 2, 25, '2019-08-07 13:59:32', NULL),
(53, 2, 17, 1, 2, 3, 3, 25, '2019-08-07 13:59:32', NULL),
(54, 2, 6, 1, 2, 3, 9, 25, '2019-08-07 13:59:32', NULL),
(55, 1, 22, 1, 2, 3, 1, 26, '2019-08-07 17:34:53', NULL),
(56, 2, 7, 1, 2, 3, 2, 26, '2019-08-07 17:34:53', NULL),
(57, 2, 18, 1, 2, 3, 3, 26, '2019-08-07 17:34:53', NULL),
(58, 2, 7, 1, 2, 3, 9, 26, '2019-08-07 17:34:53', NULL),
(59, 1, 23, 1, 2, 3, 1, 27, '2019-08-07 17:55:08', NULL),
(60, 2, 8, 1, 2, 3, 2, 27, '2019-08-07 17:55:08', NULL),
(61, 2, 19, 1, 2, 3, 3, 27, '2019-08-07 17:55:08', NULL),
(62, 2, 8, 1, 2, 3, 9, 27, '2019-08-07 17:55:08', NULL),
(63, 1, 24, 1, 2, 3, 1, 28, '2019-08-08 14:34:06', NULL),
(64, 2, 9, 1, 2, 3, 2, 28, '2019-08-08 14:34:06', NULL),
(65, 2, 20, 1, 2, 3, 3, 28, '2019-08-08 14:34:06', NULL),
(66, 2, 9, 1, 2, 3, 9, 28, '2019-08-08 14:34:06', NULL),
(67, 1, 25, 1, 2, 3, 1, 29, '2019-08-08 15:07:14', NULL),
(68, 2, 10, 1, 2, 3, 2, 29, '2019-08-08 15:07:14', NULL),
(69, 2, 21, 1, 2, 3, 3, 29, '2019-08-08 15:07:14', NULL),
(70, 2, 10, 1, 2, 3, 9, 29, '2019-08-08 15:07:14', NULL),
(71, 1, 26, 1, 2, 3, 1, 2, '2019-08-08 15:33:35', NULL),
(72, 1, 27, 1, 2, 3, 1, 3, '2019-08-08 15:33:35', NULL),
(73, 2, 11, 2, 1, 1, 2, 1, '2019-08-08 15:33:35', '2019-08-08 15:34:31'),
(74, 1, 12, 2, 1, 4, 2, 4, '2019-08-08 15:33:35', '2019-08-08 15:35:06'),
(75, 1, 13, 1, 2, 3, 2, 2, '2019-08-08 15:33:35', NULL),
(76, 1, 14, 1, 2, 3, 2, 3, '2019-08-08 15:33:35', NULL),
(77, 1, 15, 1, 2, 2, 2, 5, '2019-08-08 15:33:35', '2019-08-08 15:35:29'),
(78, 1, 16, 1, 2, 2, 2, 6, '2019-08-08 15:33:35', '2019-08-08 15:35:31'),
(79, 2, 17, 1, 2, 3, 2, 7, '2019-08-08 15:33:35', NULL),
(80, 2, 18, 1, 2, 3, 2, 8, '2019-08-08 15:33:35', NULL),
(81, 1, 19, 1, 2, 2, 2, 9, '2019-08-08 15:33:35', '2019-08-08 15:37:30'),
(82, 1, 20, 1, 2, 2, 2, 10, '2019-08-08 15:33:35', '2019-08-08 15:37:46'),
(83, 1, 21, 1, 2, 2, 2, 11, '2019-08-08 15:33:35', '2019-08-08 15:37:48'),
(84, 1, 22, 1, 2, 2, 2, 12, '2019-08-08 15:33:35', '2019-08-08 15:37:51'),
(85, 1, 23, 1, 2, 2, 2, 13, '2019-08-08 15:33:35', '2019-08-08 15:37:30'),
(86, 1, 24, 1, 2, 2, 2, 14, '2019-08-08 15:33:35', '2019-08-08 15:37:48'),
(87, 1, 25, 1, 2, 2, 2, 15, '2019-08-08 15:33:35', '2019-08-08 15:38:08'),
(88, 2, 26, 1, 2, 3, 2, 16, '2019-08-08 15:33:35', NULL),
(89, 2, 27, 1, 2, 3, 2, 17, '2019-08-08 15:33:35', NULL),
(90, 1, 22, 1, 2, 3, 3, 2, '2019-08-08 15:33:35', NULL),
(91, 1, 23, 1, 2, 3, 3, 3, '2019-08-08 15:33:35', NULL),
(92, 2, 24, 1, 2, 2, 3, 14, '2019-08-08 15:33:35', NULL),
(93, 2, 25, 1, 2, 2, 3, 15, '2019-08-08 15:33:35', NULL),
(94, 2, 26, 1, 2, 3, 3, 16, '2019-08-08 15:33:35', NULL),
(95, 2, 27, 1, 2, 3, 3, 17, '2019-08-08 15:33:35', NULL),
(96, 2, 11, 1, 2, 1, 9, 1, '2019-08-08 15:33:35', NULL),
(97, 1, 12, 1, 2, 4, 9, 4, '2019-08-08 15:33:35', NULL),
(98, 1, 13, 1, 2, 3, 9, 2, '2019-08-08 15:33:35', NULL),
(99, 1, 14, 1, 2, 3, 9, 3, '2019-08-08 15:33:35', NULL),
(100, 2, 15, 1, 2, 2, 9, 5, '2019-08-08 15:33:35', NULL),
(101, 2, 16, 1, 2, 2, 9, 6, '2019-08-08 15:33:35', NULL),
(102, 2, 17, 1, 2, 3, 9, 7, '2019-08-08 15:33:35', NULL),
(103, 2, 18, 1, 2, 3, 9, 8, '2019-08-08 15:33:35', NULL),
(104, 2, 19, 1, 2, 2, 9, 9, '2019-08-08 15:33:35', NULL),
(105, 2, 20, 1, 2, 2, 9, 10, '2019-08-08 15:33:35', NULL),
(106, 2, 21, 1, 2, 2, 9, 11, '2019-08-08 15:33:35', NULL),
(107, 2, 22, 1, 2, 2, 9, 12, '2019-08-08 15:33:36', NULL),
(108, 2, 23, 1, 2, 2, 9, 13, '2019-08-08 15:33:36', NULL),
(109, 2, 24, 1, 2, 2, 9, 14, '2019-08-08 15:33:36', NULL),
(110, 2, 25, 1, 2, 2, 9, 15, '2019-08-08 15:33:36', NULL),
(111, 2, 26, 1, 2, 3, 9, 16, '2019-08-08 15:33:36', NULL),
(112, 2, 27, 1, 2, 3, 9, 17, '2019-08-08 15:33:36', NULL),
(113, 1, 28, 1, 2, 3, 1, 30, '2019-08-08 16:50:35', NULL),
(114, 2, 28, 1, 2, 3, 2, 30, '2019-08-08 16:50:35', NULL),
(115, 2, 28, 1, 2, 3, 3, 30, '2019-08-08 16:50:35', NULL),
(116, 2, 28, 1, 2, 3, 9, 30, '2019-08-08 16:50:35', NULL),
(117, 1, 29, 1, 2, 3, 1, 31, '2019-08-08 16:55:00', NULL),
(118, 2, 29, 1, 2, 3, 2, 31, '2019-08-08 16:55:00', NULL),
(119, 2, 29, 1, 2, 3, 3, 31, '2019-08-08 16:55:00', NULL),
(120, 2, 29, 1, 2, 3, 9, 31, '2019-08-08 16:55:00', NULL),
(121, 1, 30, 1, 2, 3, 1, 32, '2019-08-12 14:28:16', NULL),
(122, 2, 30, 1, 2, 3, 2, 32, '2019-08-12 14:28:16', NULL),
(123, 2, 30, 1, 2, 3, 3, 32, '2019-08-12 14:28:16', NULL),
(124, 2, 30, 1, 2, 3, 9, 32, '2019-08-12 14:28:16', NULL),
(125, 1, 31, 1, 2, 3, 1, 33, '2019-08-12 14:43:50', NULL),
(126, 2, 31, 1, 2, 3, 2, 33, '2019-08-12 14:43:50', NULL),
(127, 2, 31, 1, 2, 3, 3, 33, '2019-08-12 14:43:50', NULL),
(128, 2, 31, 1, 2, 3, 9, 33, '2019-08-12 14:43:50', NULL),
(129, 1, 32, 1, 2, 3, 1, 34, '2019-08-12 16:54:17', NULL),
(130, 2, 32, 1, 2, 3, 2, 34, '2019-08-12 16:54:17', NULL),
(131, 2, 32, 1, 2, 3, 3, 34, '2019-08-12 16:54:17', NULL),
(132, 2, 32, 1, 2, 3, 9, 34, '2019-08-12 16:54:17', NULL),
(133, 1, 33, 1, 2, 3, 1, 35, '2019-08-12 17:22:58', NULL),
(134, 2, 33, 1, 2, 3, 2, 35, '2019-08-12 17:22:58', NULL),
(135, 2, 33, 1, 2, 3, 3, 35, '2019-08-12 17:22:58', NULL),
(136, 2, 33, 1, 2, 3, 9, 35, '2019-08-12 17:22:58', NULL),
(137, 1, 34, 1, 2, 3, 1, 36, '2019-08-12 17:41:06', NULL),
(138, 2, 34, 1, 2, 3, 2, 36, '2019-08-12 17:41:06', NULL),
(139, 2, 34, 1, 2, 3, 3, 36, '2019-08-12 17:41:06', NULL),
(140, 2, 34, 1, 2, 3, 9, 36, '2019-08-12 17:41:06', NULL),
(141, 1, 35, 1, 2, 3, 1, 37, '2019-08-13 11:32:43', NULL),
(142, 2, 35, 1, 2, 3, 2, 37, '2019-08-13 11:32:43', NULL),
(143, 2, 35, 1, 2, 3, 3, 37, '2019-08-13 11:32:43', NULL),
(144, 2, 35, 1, 2, 3, 9, 37, '2019-08-13 11:32:43', NULL),
(145, 1, 36, 1, 2, 3, 1, 38, '2019-08-13 11:58:07', NULL),
(146, 2, 36, 1, 2, 3, 2, 38, '2019-08-13 11:58:07', NULL),
(147, 2, 36, 1, 2, 3, 3, 38, '2019-08-13 11:58:07', NULL),
(148, 2, 36, 1, 2, 3, 9, 38, '2019-08-13 11:58:07', NULL),
(149, 1, 37, 1, 2, 3, 1, 39, '2019-08-13 16:00:12', NULL),
(150, 2, 37, 1, 2, 3, 2, 39, '2019-08-13 16:00:12', NULL),
(151, 2, 37, 1, 2, 3, 3, 39, '2019-08-13 16:00:12', NULL),
(152, 2, 37, 1, 2, 3, 9, 39, '2019-08-13 16:00:12', NULL),
(153, 1, 38, 1, 2, 3, 1, 40, '2019-08-13 16:45:15', NULL),
(154, 2, 38, 1, 2, 3, 2, 40, '2019-08-13 16:45:15', NULL),
(155, 2, 38, 1, 2, 3, 3, 40, '2019-08-13 16:45:15', NULL),
(156, 2, 38, 1, 2, 3, 9, 40, '2019-08-13 16:45:15', NULL),
(157, 1, 39, 1, 2, 3, 1, 41, '2019-08-14 14:57:29', NULL),
(158, 2, 39, 1, 2, 3, 2, 41, '2019-08-14 14:57:29', NULL),
(159, 2, 39, 1, 2, 3, 3, 41, '2019-08-14 14:57:29', NULL),
(160, 2, 39, 1, 2, 3, 9, 41, '2019-08-14 14:57:29', NULL),
(161, 1, 40, 1, 2, 3, 1, 42, '2019-08-14 16:59:41', NULL),
(162, 2, 40, 1, 2, 3, 2, 42, '2019-08-14 16:59:41', NULL),
(163, 2, 40, 1, 2, 3, 3, 42, '2019-08-14 16:59:41', NULL),
(164, 2, 40, 1, 2, 3, 9, 42, '2019-08-14 16:59:41', NULL),
(165, 1, 41, 1, 2, 3, 1, 43, '2019-08-14 17:10:01', NULL),
(166, 2, 41, 1, 2, 3, 2, 43, '2019-08-14 17:10:01', NULL),
(167, 2, 41, 1, 2, 3, 3, 43, '2019-08-14 17:10:01', NULL),
(168, 2, 41, 1, 2, 3, 9, 43, '2019-08-14 17:10:01', NULL),
(169, 1, 42, 1, 2, 3, 1, 44, '2019-08-14 17:20:04', NULL),
(170, 2, 42, 1, 2, 3, 2, 44, '2019-08-14 17:20:04', NULL),
(171, 2, 42, 1, 2, 3, 3, 44, '2019-08-14 17:20:04', NULL),
(172, 2, 42, 1, 2, 3, 9, 44, '2019-08-14 17:20:04', NULL),
(173, 1, 43, 1, 2, 3, 1, 45, '2019-08-15 14:22:45', NULL),
(174, 2, 43, 1, 2, 3, 2, 45, '2019-08-15 14:22:45', NULL),
(175, 2, 43, 1, 2, 3, 3, 45, '2019-08-15 14:22:45', NULL),
(176, 2, 43, 1, 2, 3, 9, 45, '2019-08-15 14:22:45', NULL),
(177, 1, 44, 1, 2, 3, 1, 46, '2019-08-15 14:26:44', NULL),
(178, 2, 44, 1, 2, 3, 2, 46, '2019-08-15 14:26:44', NULL),
(179, 2, 44, 1, 2, 3, 3, 46, '2019-08-15 14:26:44', NULL),
(180, 2, 44, 1, 2, 3, 9, 46, '2019-08-15 14:26:44', NULL),
(181, 1, 45, 1, 2, 3, 1, 47, '2019-08-15 14:56:52', NULL),
(182, 2, 45, 1, 2, 3, 2, 47, '2019-08-15 14:56:52', NULL),
(183, 2, 45, 1, 2, 3, 3, 47, '2019-08-15 14:56:52', NULL),
(184, 2, 45, 1, 2, 3, 9, 47, '2019-08-15 14:56:52', NULL),
(185, 1, 46, 1, 1, 10, 1, 48, '2019-08-15 16:32:18', '2019-08-15 16:35:06'),
(186, 2, 46, 1, 2, 3, 2, 48, '2019-08-15 16:32:18', NULL),
(187, 2, 46, 1, 2, 3, 3, 48, '2019-08-15 16:32:18', NULL),
(188, 2, 1, 1, 2, 3, 4, 48, '2019-08-15 16:32:18', NULL),
(189, 1, 47, 1, 2, 3, 1, 49, '2019-08-15 16:43:42', NULL),
(190, 2, 47, 1, 2, 3, 2, 49, '2019-08-15 16:43:42', NULL),
(191, 2, 47, 1, 2, 3, 3, 49, '2019-08-15 16:43:42', NULL),
(192, 2, 2, 1, 2, 3, 4, 49, '2019-08-15 16:43:42', NULL),
(193, 1, 48, 1, 1, 10, 1, 50, '2019-08-19 16:11:24', '2019-08-19 16:13:03'),
(194, 2, 48, 1, 2, 3, 2, 50, '2019-08-19 16:11:24', NULL),
(195, 2, 48, 1, 2, 3, 3, 50, '2019-08-19 16:11:24', NULL),
(196, 2, 3, 1, 2, 3, 4, 50, '2019-08-19 16:11:24', NULL),
(197, 1, 49, 1, 2, 3, 1, 51, '2019-08-19 16:12:33', NULL),
(198, 2, 49, 1, 2, 3, 2, 51, '2019-08-19 16:12:33', NULL),
(199, 2, 49, 1, 2, 3, 3, 51, '2019-08-19 16:12:33', NULL),
(200, 2, 4, 1, 2, 3, 4, 51, '2019-08-19 16:12:33', NULL),
(201, 1, 50, 1, 2, 3, 1, 52, '2019-08-19 16:26:22', NULL),
(202, 2, 50, 1, 2, 3, 2, 52, '2019-08-19 16:26:22', NULL),
(203, 2, 50, 1, 2, 3, 3, 52, '2019-08-19 16:26:22', NULL),
(204, 2, 5, 1, 2, 3, 4, 52, '2019-08-19 16:26:22', NULL),
(205, 1, 51, 1, 2, 3, 1, 53, '2019-08-19 17:50:25', NULL),
(206, 2, 51, 1, 2, 3, 2, 53, '2019-08-19 17:50:25', NULL),
(207, 2, 51, 1, 2, 3, 3, 53, '2019-08-19 17:50:25', NULL),
(208, 2, 6, 1, 2, 3, 4, 53, '2019-08-19 17:50:25', NULL),
(209, 1, 52, 1, 2, 3, 1, 54, '2019-08-20 15:09:02', NULL),
(210, 2, 52, 1, 2, 3, 2, 54, '2019-08-20 15:09:02', NULL),
(211, 2, 52, 1, 2, 3, 3, 54, '2019-08-20 15:09:02', NULL),
(212, 2, 7, 1, 2, 3, 4, 54, '2019-08-20 15:09:02', NULL),
(213, 1, 53, 1, 1, 10, 1, 55, '2019-08-20 16:05:32', '2019-08-20 16:06:20'),
(214, 2, 53, 1, 2, 3, 2, 55, '2019-08-20 16:05:32', NULL),
(215, 2, 53, 1, 2, 3, 3, 55, '2019-08-20 16:05:32', NULL),
(216, 2, 8, 1, 2, 3, 4, 55, '2019-08-20 16:05:32', NULL),
(217, 1, 54, 1, 2, 3, 1, 56, '2019-08-21 15:33:57', NULL),
(218, 2, 54, 1, 2, 3, 2, 56, '2019-08-21 15:33:57', NULL),
(219, 2, 54, 1, 2, 3, 3, 56, '2019-08-21 15:33:57', NULL),
(220, 2, 9, 1, 2, 3, 4, 56, '2019-08-21 15:33:57', NULL),
(221, 1, 55, 1, 2, 3, 1, 57, '2019-08-21 15:37:35', NULL),
(222, 2, 55, 1, 2, 3, 2, 57, '2019-08-21 15:37:35', NULL),
(223, 2, 55, 1, 2, 3, 3, 57, '2019-08-21 15:37:35', NULL),
(224, 2, 10, 1, 2, 3, 4, 57, '2019-08-21 15:37:35', NULL),
(225, 1, 56, 1, 2, 3, 1, 58, '2019-08-21 16:31:35', NULL),
(226, 2, 56, 1, 2, 3, 2, 58, '2019-08-21 16:31:35', NULL),
(227, 2, 56, 1, 2, 3, 3, 58, '2019-08-21 16:31:35', NULL),
(228, 2, 11, 1, 2, 3, 4, 58, '2019-08-21 16:31:35', NULL),
(229, 1, 57, 1, 2, 3, 1, 59, '2019-08-21 16:35:43', NULL),
(230, 2, 57, 1, 2, 3, 2, 59, '2019-08-21 16:35:43', NULL),
(231, 2, 57, 1, 2, 3, 3, 59, '2019-08-21 16:35:43', NULL),
(232, 2, 12, 1, 2, 3, 4, 59, '2019-08-21 16:35:43', NULL),
(233, 1, 58, 1, 2, 3, 1, 60, '2019-08-21 16:37:24', NULL),
(234, 2, 58, 1, 2, 3, 2, 60, '2019-08-21 16:37:24', NULL),
(235, 2, 58, 1, 2, 3, 3, 60, '2019-08-21 16:37:24', NULL),
(236, 2, 13, 1, 2, 3, 4, 60, '2019-08-21 16:37:24', NULL),
(237, 1, 59, 1, 2, 3, 1, 61, '2019-08-21 17:01:03', NULL),
(238, 2, 59, 1, 2, 3, 2, 61, '2019-08-21 17:01:03', NULL),
(239, 2, 59, 1, 2, 3, 3, 61, '2019-08-21 17:01:03', NULL),
(240, 2, 14, 1, 2, 3, 4, 61, '2019-08-21 17:01:03', NULL),
(241, 1, 60, 1, 2, 3, 1, 62, '2019-08-21 17:31:50', NULL),
(242, 2, 60, 1, 2, 3, 2, 62, '2019-08-21 17:31:50', NULL),
(243, 2, 60, 1, 2, 3, 3, 62, '2019-08-21 17:31:50', NULL),
(244, 2, 15, 1, 2, 3, 4, 62, '2019-08-21 17:31:50', NULL),
(245, 1, 16, 2, 1, 1, 4, 1, '2019-08-23 14:11:06', '2019-08-23 14:33:51'),
(246, 1, 17, 2, 1, 4, 4, 4, '2019-08-23 14:11:06', '2019-08-23 14:33:48'),
(247, 1, 18, 1, 2, 3, 4, 2, '2019-08-23 14:11:06', NULL),
(248, 1, 19, 1, 2, 3, 4, 3, '2019-08-23 14:11:06', NULL),
(249, 2, 20, 1, 2, 2, 4, 5, '2019-08-23 14:11:06', NULL),
(250, 2, 21, 1, 2, 2, 4, 6, '2019-08-23 14:11:06', NULL),
(251, 2, 22, 1, 2, 3, 4, 7, '2019-08-23 14:11:06', NULL),
(252, 2, 23, 1, 2, 3, 4, 8, '2019-08-23 14:11:06', NULL),
(253, 2, 24, 1, 2, 2, 4, 9, '2019-08-23 14:11:06', NULL),
(254, 2, 25, 1, 2, 2, 4, 10, '2019-08-23 14:11:06', NULL),
(255, 2, 26, 1, 2, 2, 4, 11, '2019-08-23 14:11:06', NULL),
(256, 2, 27, 1, 2, 2, 4, 12, '2019-08-23 14:11:06', NULL),
(257, 2, 28, 1, 2, 2, 4, 13, '2019-08-23 14:11:06', NULL),
(258, 2, 29, 1, 2, 2, 4, 14, '2019-08-23 14:11:06', NULL),
(259, 2, 30, 1, 2, 2, 4, 15, '2019-08-23 14:11:06', NULL),
(260, 2, 31, 1, 2, 3, 4, 16, '2019-08-23 14:11:06', NULL),
(261, 2, 32, 1, 2, 3, 4, 17, '2019-08-23 14:11:06', NULL),
(262, 2, 33, 1, 2, 3, 4, 19, '2019-08-23 14:11:06', NULL),
(263, 2, 34, 1, 2, 3, 4, 20, '2019-08-23 14:11:06', NULL),
(264, 2, 35, 1, 2, 3, 4, 21, '2019-08-23 14:11:06', NULL),
(265, 2, 36, 1, 2, 3, 4, 22, '2019-08-23 14:11:06', NULL),
(266, 2, 37, 1, 2, 3, 4, 24, '2019-08-23 14:11:06', NULL),
(267, 2, 38, 1, 2, 3, 4, 25, '2019-08-23 14:11:06', NULL),
(268, 2, 39, 1, 2, 3, 4, 26, '2019-08-23 14:11:06', NULL),
(269, 2, 40, 1, 2, 3, 4, 27, '2019-08-23 14:11:06', NULL),
(270, 2, 41, 1, 2, 3, 4, 28, '2019-08-23 14:11:06', NULL),
(271, 2, 42, 1, 2, 3, 4, 29, '2019-08-23 14:11:06', NULL),
(272, 2, 43, 1, 2, 3, 4, 30, '2019-08-23 14:11:06', NULL),
(273, 2, 44, 1, 2, 3, 4, 31, '2019-08-23 14:11:06', NULL),
(274, 2, 45, 1, 2, 3, 4, 32, '2019-08-23 14:11:06', NULL),
(275, 2, 46, 1, 2, 3, 4, 33, '2019-08-23 14:11:06', NULL),
(276, 2, 47, 1, 2, 3, 4, 34, '2019-08-23 14:11:06', NULL),
(277, 2, 48, 1, 2, 3, 4, 35, '2019-08-23 14:11:06', NULL),
(278, 1, 49, 1, 2, 3, 4, 36, '2019-08-23 14:11:06', NULL),
(279, 2, 50, 1, 2, 3, 4, 37, '2019-08-23 14:11:06', NULL),
(280, 2, 51, 1, 2, 3, 4, 38, '2019-08-23 14:11:06', NULL),
(281, 2, 52, 1, 2, 3, 4, 39, '2019-08-23 14:11:06', NULL),
(282, 2, 53, 1, 2, 3, 4, 40, '2019-08-23 14:11:06', NULL),
(283, 2, 54, 1, 2, 3, 4, 41, '2019-08-23 14:11:06', NULL),
(284, 2, 55, 1, 2, 3, 4, 42, '2019-08-23 14:11:06', NULL),
(285, 2, 56, 1, 2, 3, 4, 43, '2019-08-23 14:11:06', NULL),
(286, 2, 57, 1, 2, 3, 4, 44, '2019-08-23 14:11:06', NULL),
(287, 1, 58, 1, 2, 3, 4, 45, '2019-08-23 14:11:06', '2019-08-23 14:12:17'),
(288, 1, 59, 1, 2, 3, 4, 46, '2019-08-23 14:11:06', '2019-08-23 14:12:21'),
(289, 1, 60, 1, 2, 3, 4, 47, '2019-08-23 14:11:07', NULL),
(290, 1, 61, 1, 2, 3, 1, 63, '2019-08-23 14:39:56', NULL),
(291, 2, 61, 1, 2, 3, 2, 63, '2019-08-23 14:39:56', NULL),
(292, 2, 61, 1, 2, 3, 3, 63, '2019-08-23 14:39:56', NULL),
(293, 2, 61, 1, 2, 3, 4, 63, '2019-08-23 14:39:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_niveis_acessos`
--

CREATE TABLE `adms_niveis_acessos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_niveis_acessos`
--

INSERT INTO `adms_niveis_acessos` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Super Administrador', 1, '2018-03-23 00:00:00', NULL),
(2, 'Administrador', 3, '2018-03-23 00:00:00', '2019-07-29 16:41:11'),
(3, 'Colaborador', 4, '2018-03-23 00:00:00', '2019-07-29 16:41:10'),
(4, 'Autor', 5, '2019-08-15 15:08:34', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_paginas`
--

CREATE TABLE `adms_paginas` (
  `id` int(11) NOT NULL,
  `nome_pagina` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  `keywords` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lib_pub` int(11) NOT NULL DEFAULT '2',
  `icone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depend_pg` int(11) NOT NULL DEFAULT '0',
  `adms_grps_pg_id` int(11) NOT NULL,
  `adms_tps_pg_id` int(50) NOT NULL,
  `adms_robot_id` int(11) NOT NULL DEFAULT '4',
  `adms_sits_pg_id` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_paginas`
--

INSERT INTO `adms_paginas` (`id`, `nome_pagina`, `endereco`, `obs`, `keywords`, `description`, `author`, `lib_pub`, `icone`, `depend_pg`, `adms_grps_pg_id`, `adms_tps_pg_id`, `adms_robot_id`, `adms_sits_pg_id`, `created`, `modified`) VALUES
(1, 'Home', 'visualizar/home', 'Pagina home', 'home', 'pagina home', 'JoÃ£o de Oliveira Lima Neto', 2, 'fas fa-tachometer-alt', 0, 5, 1, 4, 1, '2018-03-23 00:00:00', '2019-08-01 18:02:19'),
(4, 'Sair', 'acesso/sair', 'Sair do ADM', 'Sair do ADM', 'Sair do ADM', 'Celke', 1, 'fas fa-sign-out-alt', 0, 7, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(2, 'Login', 'acesso/login', 'Pagina de login do ADM', 'pagina login', 'Pagina login', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 7, 1, 1, 1, '2018-03-23 00:00:00', '2019-08-01 18:02:42'),
(3, 'Validar Login', 'acesso/valida', 'Validar Login', 'Validar Login', 'Validar Login', 'JoÃ£o de Oliveira Lima Neto', 1, '', 2, 7, 1, 4, 1, '2018-03-23 00:00:00', '2019-08-01 18:02:56'),
(5, 'Usuarios', 'listar/list_usuario', 'Pagina para listar usuarios', 'Listar usuarios', 'Listar usuarios', 'Celke', 2, 'fas fa-users', 0, 1, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(6, 'Nivel de Acesso', 'listar/list_niv_aces', 'Pagina para listar nivel de acesso', 'Listar nivel de acesso', 'Listar nivel de acesso', 'Celke', 2, 'fas fa-key', 0, 1, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(7, 'Paginas', 'listar/list_pagina', 'Pagina para listar as paginas do ADM', 'Listar pagina', 'Listar pagina', 'Celke', 2, 'fas fa-file-alt', 0, 1, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(8, 'Menu', 'listar/list_menu', 'Pagina para listar os itens do menu', 'Pagina para listar os itens do menu', 'Pagina para listar os itens do menu', 'Celke', 2, 'fab fa-elementor', 0, 1, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(9, 'Cadastrar NÃ­vel de Acesso', 'cadastrar/cad_niv_aces', 'Pagina para cadastrar nÃ­vel de acesso', 'Cadastrar NÃ­vel de Acesso', 'Cadastrar NÃ­vel de Acesso', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 2, 1, 4, 1, '2018-03-23 00:00:00', '2019-08-08 15:37:17'),
(10, 'Visualizar nivel de acesso', 'visualizar/vis_niv_aces', 'Pagina para Visualizar nivel de acesso', 'Pagina para Visualizar nivel de acesso', 'Pagina para Visualizar nivel de acesso', 'Celke', 2, NULL, 0, 5, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(11, 'Editar nivel de acesso', 'editar/edit_niv_aces', 'Pagina para editar nivel de acesso', 'Pagina para editar nivel de acesso', 'Pagina para editar nivel de acesso', 'Celke', 2, NULL, 0, 3, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(12, 'Apagar nivel de acesso', 'processa/apagar_niv_aces', 'Pagina para apagar nivel de acesso', 'Pagina para apagar nivel de acesso', 'Pagina para apagar nivel de acesso', 'Celke', 2, NULL, 0, 4, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(13, 'Processa o formulario cadastrar nivel de acesso', 'processa/proc_cad_niv_aces', 'Processa o formulario cadastrar nivel de acesso', 'Processa o formulario cadastrar nivel de acesso', 'Processa o formulario cadastrar nivel de acesso', 'Celke', 2, NULL, 9, 2, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(14, 'Processa o formulario editar nivel de acesso', 'processa/proc_edit_niv_aces', 'Processa o formulario editar nivel de acesso', 'Processa o formulario editar nivel de acesso', 'Processa o formulario editar nivel de acesso', 'Joao de Oliveira Lima Neto', 2, '', 11, 3, 1, 4, 1, '2018-03-23 00:00:00', '2019-08-07 14:33:01'),
(15, 'Alterar a ordem do nivel de acesso', 'processa/proc_ordem_niv_aces', 'alterar a ordem do nivel de acesso', 'alterar a ordem do nivel de acesso', 'alterar a ordem do nivel de acesso', 'Joao de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2018-03-23 00:00:00', '2019-08-02 11:26:55'),
(16, 'Cadastrar Pagina', 'cadastrar/cad_pagina', 'Pagina para cadastrar pagina', 'Pagina para cadastrar pagina', 'Pagina para cadastrar pagina', 'Joao de Oliveira Lima Neto', 2, NULL, 0, 2, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(17, 'Processa o formulario cadastrar pagina', 'processa/proc_cad_pagina', 'Processa o formulario cadastrar pagina', 'Processa o formulario cadastrar pagina', 'Processa o formulario cadastrar pagina', 'Joao de Oliveira Lima Neto', 2, NULL, 16, 2, 1, 4, 1, '2018-03-23 00:00:00', NULL),
(19, 'Visualizar pÃ¡gina', 'visualizar/vis_pagina', 'PÃ¡gina para visualizar detalhes da pÃ¡gina', 'Visualizar pÃ¡gina', 'Visualizar pÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 5, 1, 4, 1, '2019-07-31 17:29:38', NULL),
(20, 'Editar PÃ¡gina', 'editar/edit_pagina', 'FormulÃ¡rio para Editar PÃ¡gina', 'Editar PÃ¡gina', 'Editar PÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-01 17:05:42', NULL),
(21, 'Processa FormulÃ¡rio Editar PÃ¡gina', 'processa/proc_edit_pagina', 'Processa FormulÃ¡rio Editar PÃ¡gina', 'Processa FormulÃ¡rio Editar PÃ¡gina', 'Processa FormulÃ¡rio Editar PÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 20, 3, 1, 4, 1, '2019-08-01 17:50:28', '2019-08-07 14:32:38'),
(22, 'Apagar PÃ¡gina', 'processa/apagar_pagina', 'Pagina para apagar pÃ¡gina', 'Pagina para apagar pÃ¡gina', 'Pagina para apagar pÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 4, 1, 4, 1, '2019-08-02 11:07:07', NULL),
(24, 'PermissÃµes', 'listar/list_permissao', 'PÃ¡gina para listar as permissÃµes', 'Listar PermissÃµes', 'Listar PermissÃµes', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 1, 1, 4, 1, '2019-08-05 15:16:38', '2019-08-05 15:40:01'),
(25, 'Processa Liberar PermissÃ£o', 'processa/proc_lib_per', 'PÃ¡gina para liberar permissÃ£o', 'Liberar PermissÃ£o', 'PÃ¡gina para liberar permissÃ£o', 'Acesso', 2, '', 0, 3, 1, 4, 1, '2019-08-07 13:59:32', NULL),
(26, 'Processa Liberar Menu', 'processa/proc_lib_menu', 'PÃ¡gina para liberar o item no menu', 'Liberar Menu', 'Processa Liberar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-07 17:34:53', NULL),
(27, 'Processa Liberar Dropdown', 'processa/proc_lib_dropdown', 'PÃ¡gina para liberar dropdown no menu', 'Liberar Dropdown Menu', 'Liberar Dropdown Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-07 17:55:08', NULL),
(28, 'Alterar a ordem do menu', 'processa/proc_ordem_menu', 'PÃ¡gina para alterar ordem do menu', 'Alterar ordem do menu', 'Alterar ordem do menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-08 14:34:05', NULL),
(29, 'Sincronizar PÃ¡ginas', 'processa/proc_sincro_nivac_pg', 'PÃ¡gina para sincronizar pÃ¡ginas com nÃ­vel de acesso', 'Sincronizar PÃ¡ginas', 'Sincronizar PÃ¡ginas', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-08 15:07:14', NULL),
(30, 'Editar nome do menu', 'editar/edit_permissao', 'PÃ¡gina para editar o nome do item do menu', 'Editar nome do menu', 'Editar nome do menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-08 16:50:35', NULL),
(31, 'Processa FormulÃ¡rio Editar PermissÃ£o', 'processa/proc_edit_permissao', 'PÃ¡gina para processar o formulÃ¡rio editar permissÃ£o', 'Processa FormulÃ¡rio Editar PermissÃ£o', 'Processa FormulÃ¡rio Editar PermissÃ£o', 'JoÃ£o de Oliveira Lima Neto', 2, '', 30, 3, 1, 4, 1, '2019-08-08 16:55:00', NULL),
(32, 'Cadastrar Menu', 'cadastrar/cad_menu', '', 'Cadastrar Menu', 'Cadastrar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 2, 1, 4, 1, '2019-08-12 14:28:16', NULL),
(33, 'Processa FormulÃ¡rio Cadastrar Menu', 'processa/proc_cad_menu', 'PÃ¡gina para processar o formulÃ¡rio cadastrar menu', 'Processa FormulÃ¡rio Cadastrar Menu', 'Processa FormulÃ¡rio Cadastrar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 32, 2, 1, 4, 1, '2019-08-12 14:43:50', NULL),
(34, 'Editar Menu', 'editar/edit_menu', 'FormulÃ¡rio para editar o item do menu', 'Editar Menu', 'Editar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-12 16:54:17', NULL),
(35, 'Processa FormulÃ¡rio Editar Menu', 'processa/proc_edit_menu', 'Processar o FormulÃ¡rio Editar Menu', 'Processa FormulÃ¡rio Editar Menu', 'Processa FormulÃ¡rio Editar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 34, 3, 1, 4, 1, '2019-08-12 17:22:58', NULL),
(36, 'Visualizar menu', 'visualizar/vis_menu', 'PÃ¡gina para visualizar Menu', 'Visualizar menu', 'Visualizar menu', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 5, 1, 4, 1, '2019-08-12 17:41:06', NULL),
(37, 'Apagar Menu', 'processa/apagar_menu', 'PÃ¡gina para apagar menu', 'Apagar Menu', 'Apagar Menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 4, 1, 4, 1, '2019-08-13 11:32:43', NULL),
(38, 'Alterar ordem item menu', 'processa/proc_ordem_menu_item', 'PÃ¡gina par alterar ordem item menu', 'Alterar odem item menu', 'Alterar ordem item menu', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-13 11:58:07', NULL),
(39, 'Cadastrar UsuÃ¡rio', 'cadastrar/cad_usuario', 'FormulÃ¡rio para cadastrar usuÃ¡rio', 'Cadastrar UsuÃ¡rio', 'Cadastrar UsuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 2, 1, 4, 1, '2019-08-13 16:00:12', NULL),
(40, 'Processa FormulÃ¡rio Cadastrar UsuÃ¡rio', 'processa/proc_cad_usuario', 'PÃ¡gina para processar a pÃ¡gina cadastrar usuÃ¡rio', 'Processa FormulÃ¡rio Cadastrar UsuÃ¡rio', 'Processa FormulÃ¡rio Cadastrar UsuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 39, 2, 1, 4, 1, '2019-08-13 16:45:15', NULL),
(41, 'Visualizar usuÃ¡rio', 'visualizar/vis_usuario', 'PÃ¡gina para visualizar usuÃ¡rio', 'Visualizar usuÃ¡rio', 'Visualizar usuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 5, 1, 4, 1, '2019-08-14 14:57:29', NULL),
(42, 'Editar UsuÃ¡rio', 'editar/edit_usuario', 'FormulÃ¡rio para editar usuÃ¡rio', 'Editar UsuÃ¡rio', 'Editar UsuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-14 16:59:41', NULL),
(43, 'Processa FormulÃ¡rio Editar UsuÃ¡rio', 'processa/proc_edit_usuario', 'PÃ¡gina para processar o formulÃ¡rio editar usuÃ¡rio', 'Processa FormulÃ¡rio Editar UsuÃ¡rio', 'Processa FormulÃ¡rio Editar UsuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 42, 3, 1, 4, 1, '2019-08-14 17:10:01', NULL),
(44, 'Apagar UsuÃ¡rio', 'processa/apagar_usuario', 'Apagar UsuÃ¡rio', 'Apagar UsuÃ¡rio', 'Apagar UsuÃ¡rio', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 4, 1, 4, 1, '2019-08-14 17:20:04', NULL),
(45, 'Editar Perfil', 'editar/edit_perfil', 'FormulÃ¡rio para editar perfil', 'Editar Perfil', 'Editar Perfil', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-15 14:22:45', NULL),
(46, 'Visualizar Perfil', 'visualizar/vis_perfil', 'PÃ¡gina para usuÃ¡rio visualizar seu perfil', 'Visualizar Perfil', 'Visualizar Perfil', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 5, 1, 4, 1, '2019-08-15 14:26:44', NULL),
(47, 'Cadastrar usuÃ¡rio no login', 'cadastrar/cad_user_login', 'PÃ¡gina para cadastrar usuÃ¡rio no login', 'Cadastrar usuÃ¡rio no login', 'Cadastrar usuÃ¡rio no login', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 2, 1, 4, 1, '2019-08-15 14:56:52', NULL),
(48, 'Cadastro Login', 'editar/edit_cad_user_login', 'FormulÃ¡rio para editar o nÃ­vel de acesso e situaÃ§Ã£o do formulÃ¡rio cadastrar usuÃ¡rio na pÃ¡gina de login', 'Editar Nivel e SituaÃ§Ã£o UsuÃ¡rio Login', 'Editar Nivel e SituaÃ§Ã£o UsuÃ¡rio Login', 'JoÃ£o de Oliveira Lima Neto', 2, 'fas fa-edit', 0, 3, 1, 4, 1, '2019-08-15 16:32:18', '2019-08-15 16:35:52'),
(49, 'Processa FormulÃ¡rio Editar Login', 'processa/proc_cad_user_login', 'PÃ¡gina para processar o formulÃ¡rio utilizado para editar o nÃ­vel de acesso e a situaÃ§Ã£o do formulÃ¡rio cadastrar usuÃ¡rio atravÃ©s da pÃ¡gina de login', 'Processa FormulÃ¡rio Cadastrar Login', 'Processa FormulÃ¡rio Cadastrar Login', 'JoÃ£o de Oliveira Lima Neto', 2, '', 48, 3, 1, 4, 1, '2019-08-15 16:43:42', NULL),
(50, 'Credenciais E-mail', 'editar/edit_cred_email', 'PÃ¡gina para editar as credenciais de e-mail', 'Credenciais E-mail', 'Credenciais E-mail', 'JoÃ£o de Oliveira Lima Neto', 2, 'fas fa-at', 0, 3, 1, 4, 1, '2019-08-19 16:11:24', '2019-08-19 16:14:05'),
(51, 'Processar formuÃ¡rio credenciais e-mails', 'processa/proc_edit_cred_email', 'PÃ¡gina para processar o formulÃ¡rio editar credenciais de envio de e-mail', 'Processar formuÃ¡rio credenciais e-mails', 'Processar formuÃ¡rio credenciais e-mails', 'JoÃ£o de Oliveira Lima Neto', 2, '', 50, 3, 1, 4, 1, '2019-08-19 16:12:33', NULL),
(52, 'Validar E-mail', 'acesso/valida_email', 'PÃ¡gina para validar e-mail', 'Validar E-mail', 'Validar E-mail', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 3, 1, 4, 1, '2019-08-19 16:26:22', '2019-08-19 16:26:32'),
(53, 'Recuperar Login', 'acesso/recuperar_login', 'FormulÃ¡rio para recuperar login', 'Recuperar Login', 'Recuperar Login', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 7, 1, 4, 1, '2019-08-19 17:50:25', NULL),
(54, 'Atualizar a senha', 'acesso/atual_senha', 'FormulÃ¡rio para atualizar a senha', 'Atualizar a senha', 'Atualizar a senha', 'JoÃ£o de Oliveira Lima Neto', 1, '', 0, 7, 1, 4, 1, '2019-08-20 15:09:02', NULL),
(55, 'Listar Tipos de PÃ¡ginas', 'listar/list_tps_pgs', 'PÃ¡gina para listar os tipos de pÃ¡ginas', 'Listar Tipos de PÃ¡ginas', 'Listar Tipos de PÃ¡ginas', 'JoÃ£o de Oliveira Lima Neto', 2, 'fas fa-list-ol', 0, 1, 1, 4, 1, '2019-08-20 16:05:32', '2019-08-20 16:06:20'),
(56, 'Cadastrar Tipo de PÃ¡gina', 'cadastrar/cad_tps_pgs', 'FormulÃ¡rio para cadastrar tipo de pÃ¡gina', 'Cadastrar Tipo de PÃ¡gina', 'Cadastrar Tipo de PÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 2, 1, 4, 1, '2019-08-21 15:33:57', NULL),
(57, 'Processa formulÃ¡rio cadastrar tipo de pÃ¡gina', 'processa/proc_cad_tps_pgs', 'PÃ¡gina para processar o formulÃ¡rio cadastrar tipo de pÃ¡gina', 'Processa formulÃ¡rio cadastrar tipo de pÃ¡gina', 'Processa formulÃ¡rio cadastrar tipo de pÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 56, 2, 1, 2, 1, '2019-08-21 15:37:35', NULL),
(58, 'Visualizar Tipo de PÃ¡gina', 'visualizar/vis_tps_pgs', 'PÃ¡gina para ver detalhes do tipo de pÃ¡gina', 'Visualizar Tipo de PÃ¡gina', 'Visualizar Tipo de PÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 5, 1, 4, 1, '2019-08-21 16:31:35', NULL),
(59, 'Editar Tipo de PÃ¡gina', 'editar/edit_tps_pgs', 'FormulÃ¡rio para editar tipo de pÃ¡gina', 'Editar Tipo Pagina', 'Editar Tipo de PÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 3, 1, 4, 1, '2019-08-21 16:35:43', NULL),
(60, 'Processa formulÃ¡rio editar tipo de pÃ¡gina', 'processa/proc_edit_tps_pgs', 'Processa formulÃ¡rio editar tipo de pÃ¡gina', 'Processa formulÃ¡rio editar tipo pagina', 'Processa formulÃ¡rio editar tipo de pÃ¡gina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 59, 3, 1, 4, 1, '2019-08-21 16:37:24', NULL),
(61, 'Apagar Tipo PÃ¡gina', 'processa/apagar_tps_pgs', 'PÃ¡gina para apagar tipo de pÃ¡gina', 'Apagar Tipo Pagina', 'Apagar Tipo Pagina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 4, 1, 4, 1, '2019-08-21 17:01:03', NULL),
(62, 'Ordem Tipo PÃ¡gina', 'processa/proc_ordem_tps_pgs', 'PÃ¡gina para alterar a ordem do tipo de pÃ¡gina', 'Ordem Tipo Pagina', 'Ordem Tipo Pagina', 'JoÃ£o de Oliveira Lima Neto', 2, '', 0, 6, 1, 4, 1, '2019-08-21 17:31:50', NULL),
(63, 'Processa FormulÃ¡rio Editar Perfil', 'processa/proc_edit_perfil', 'Processa FormulÃ¡rio Editar Perfil', 'Processa Formulario Editar Perfil', 'Processa Formulario Editar Perfil', 'JoÃ£o de Oliveira Lima Neto', 2, '', 45, 3, 1, 4, 1, '2019-08-23 14:39:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_robots`
--

CREATE TABLE `adms_robots` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_robots`
--

INSERT INTO `adms_robots` (`id`, `nome`, `tipo`, `created`, `modified`) VALUES
(1, 'Indexar a pÃ¡gina e seguir os links', 'index, follow', '2018-03-23 00:00:00', NULL),
(2, 'NÃ£o indexar a pÃ¡gina mas seguir os links', 'noindex, follow', '2018-03-23 00:00:00', NULL),
(3, 'Indexar a pÃ¡gina mas nÃ£o seguir os links', 'index, nofollow', '2018-03-23 00:00:00', NULL),
(4, 'NÃ£o indexar a pÃ¡gina e nem seguir os links', 'noindex, nofollow', '2018-03-23 00:00:00', NULL),
(5, 'NÃ£o exibir a versÃ£o em cache da pÃ¡gina', 'noarchive', '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits`
--

CREATE TABLE `adms_sits` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(40) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits`
--

INSERT INTO `adms_sits` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2018-03-23 00:00:00', NULL),
(2, 'Inativo', 4, '2018-03-23 00:00:00', NULL),
(3, 'Analise', 1, '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_pgs`
--

CREATE TABLE `adms_sits_pgs` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_pgs`
--

INSERT INTO `adms_sits_pgs` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Ativo', 'success', '2018-03-23 00:00:00', NULL),
(2, 'Inativo', 'danger', '2018-03-23 00:00:00', NULL),
(3, 'Analise', 'primary', '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_usuarios`
--

CREATE TABLE `adms_sits_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_usuarios`
--

INSERT INTO `adms_sits_usuarios` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2018-03-23 00:00:00', NULL),
(2, 'Inativo', 5, '2018-03-23 00:00:00', NULL),
(3, 'Aguardando confirmacao', 1, '2018-03-23 00:00:00', NULL),
(4, 'Spam', 4, '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_tps_pgs`
--

CREATE TABLE `adms_tps_pgs` (
  `id` int(11) NOT NULL,
  `tipo` varchar(40) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `obs` text NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `adms_tps_pgs`
--

INSERT INTO `adms_tps_pgs` (`id`, `tipo`, `nome`, `obs`, `ordem`, `created`, `modified`) VALUES
(1, 'adms', 'Administrativo', 'Core do Administrativo', 1, '2019-07-30 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_usuarios`
--

CREATE TABLE `adms_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `num_end` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pais` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chave_descadastro` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conf_email` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_usuarios`
--

INSERT INTO `adms_usuarios` (`id`, `nome`, `cpf`, `telefone`, `email`, `senha`, `rua`, `num_end`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `pais`, `recuperar_senha`, `chave_descadastro`, `conf_email`, `imagem`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 'Cesar N. Szpak', 'Cesar', '', 'cesar@celke.com.br', '$2y$10$UDdxOqZghWMPVQQ094COZeNdT/VFBJXqwFfAyRNLZnycaXhY8yK9u', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'celke.jpg', 1, 1, '2018-03-23 00:00:00', NULL),
(2, 'Jessica', 'jessica', '', 'jessica@celke.com.br', '$2y$10$UDdxOqZghWMPVQQ094COZeNdT/VFBJXqwFfAyRNLZnycaXhY8yK9u', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'jessica.png', 3, 1, '2019-07-24 00:00:00', NULL),
(3, 'JoÃ£o de Oliveira Lima Neto', '232.499.160-80', '(68) 99914-4544', 'joaooln@gmail.com', '$2y$10$t4lf5AxCPgSTa3dUDbeIPeSxw9pX6UdaRE9ZE47/vSS8y0fWLF8PG', 'Rua Luiz Z da Silva', '292', 'Bloco C6 - Apt 424', 'Manoel JuliÃ£o', 'Rio Branco', 'AC', '69918-452', 'Brasil', NULL, NULL, NULL, 'elfmaker.png', 1, 1, '2019-08-14 14:36:11', '2019-08-23 15:11:11'),
(15, 'JoÃ£o de Oliveira Lima Neto', '942.227.702-72', '(68) 91445-4444', 'joaooln3@gmail.com', '$2y$10$Xd8LJenA7w8ThQvAhgD.0uFlQU58ngMRPIUyN.hkF1kx2Zyvr9Usa', 'Rua A', '29', '123', 'Moel', 'Rio Branco', 'AC', '69918-452', 'Brasil', NULL, NULL, 'b61aaa10b63358ebdffdcde693d3ee6b', NULL, 4, 3, '2019-08-23 14:08:12', NULL),
(14, 'JoÃ£o de Oliveira Lima Neto', '123.456.789-79', '(68) 99914-4454', 'joaooln5@gmail.com', '$2y$10$z1mth1Ouizv1ldGNW2hQqedPLuBURgi0QxNiJe9TtR1zP4hrqTUq.', 'Rua A', '29', '', 'Moel', 'Rio Branco', 'AC', '69918-452', 'Brasil', NULL, NULL, 'b14dab71cf63e1533192cf6b8903e525', NULL, 4, 3, '2019-08-23 14:04:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adms_cads_usuarios`
--
ALTER TABLE `adms_cads_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_cors`
--
ALTER TABLE `adms_cors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_grps_pgs`
--
ALTER TABLE `adms_grps_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_menus`
--
ALTER TABLE `adms_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_nivacs_pgs`
--
ALTER TABLE `adms_nivacs_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_niveis_acessos`
--
ALTER TABLE `adms_niveis_acessos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_paginas`
--
ALTER TABLE `adms_paginas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_robots`
--
ALTER TABLE `adms_robots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits`
--
ALTER TABLE `adms_sits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits_pgs`
--
ALTER TABLE `adms_sits_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits_usuarios`
--
ALTER TABLE `adms_sits_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_tps_pgs`
--
ALTER TABLE `adms_tps_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_usuarios`
--
ALTER TABLE `adms_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adms_cads_usuarios`
--
ALTER TABLE `adms_cads_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adms_cors`
--
ALTER TABLE `adms_cors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `adms_grps_pgs`
--
ALTER TABLE `adms_grps_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `adms_menus`
--
ALTER TABLE `adms_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `adms_nivacs_pgs`
--
ALTER TABLE `adms_nivacs_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `adms_niveis_acessos`
--
ALTER TABLE `adms_niveis_acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adms_paginas`
--
ALTER TABLE `adms_paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `adms_robots`
--
ALTER TABLE `adms_robots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `adms_sits`
--
ALTER TABLE `adms_sits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `adms_sits_pgs`
--
ALTER TABLE `adms_sits_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `adms_sits_usuarios`
--
ALTER TABLE `adms_sits_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adms_tps_pgs`
--
ALTER TABLE `adms_tps_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adms_usuarios`
--
ALTER TABLE `adms_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
