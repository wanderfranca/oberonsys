-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Set-2022 às 23:42
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `oberonsys`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamentos`
--

CREATE TABLE `formas_pagamentos` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `descricao` varchar(240) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `formas_pagamentos`
--

INSERT INTO `formas_pagamentos` (`id`, `nome`, `ativo`, `descricao`, `criado_em`, `atualizado_em`) VALUES
(1, 'Boleto Bancário', 1, 'Pagamento com boleto bancário', '2022-09-04 15:43:56', '2022-09-04 15:43:56'),
(2, 'Cortesia', 1, 'Destinada apenas às ordens que não geraram valor', '2022-09-04 15:43:56', '2022-09-04 15:43:56'),
(3, 'Cartão de crédito', 1, 'Forma de pagamento em cartão de crédito', '2022-09-04 15:43:56', '2022-09-04 17:51:29'),
(4, 'Cartão de débito', 1, 'Cartão de débito', '2022-09-04 15:43:56', '2022-09-04 15:43:56'),
(5, 'Cartão de pix', 1, 'Pagamento em pix', '2022-09-04 15:43:56', '2022-09-04 15:43:56'),
(6, 'Dinheiro', 1, 'Pagamento em espécie', '2022-09-04 15:43:56', '2022-09-04 15:43:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
