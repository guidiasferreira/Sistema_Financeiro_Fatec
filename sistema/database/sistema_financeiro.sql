-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/10/2025 às 18:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `fazenda`
--

CREATE TABLE `fazenda` (
  `id_fazenda` int(11) NOT NULL,
  `id_proprietario` int(11) NOT NULL,
  `nome_fazenda` varchar(150) NOT NULL,
  `producao_hec` decimal(10,2) DEFAULT NULL,
  `tamanho_hec` decimal(10,2) DEFAULT NULL,
  `custo_hec` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fazenda`
--

INSERT INTO `fazenda` (`id_fazenda`, `id_proprietario`, `nome_fazenda`, `producao_hec`, `tamanho_hec`, `custo_hec`) VALUES
(1, 1, 'Fazenda Carrinhos', 1000.00, 200.00, 32000.50),
(2, 2, 'Fazenda Souls', 280.00, 200.00, 30000.00),
(3, 3, 'Fazenda Filhos', 285.00, 200.00, 32000.50),
(4, 4, 'Fazenda CLI', 290.00, 200.00, 35000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `producao`
--

CREATE TABLE `producao` (
  `id_producao` int(11) NOT NULL,
  `id_fazenda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `producao`
--

INSERT INTO `producao` (`id_producao`, `id_fazenda`, `id_produto`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome_produto`, `valor_unitario`) VALUES
(1, 'Canabis', 32.00),
(2, 'Abacate', 107.15),
(3, 'Pêssego', 112.00),
(4, 'Caqui', 120.00),
(5, 'Soja', 133.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

CREATE TABLE `proprietario` (
  `id_proprietario` int(11) NOT NULL,
  `nome_proprietario` varchar(150) NOT NULL,
  `email_proprietario` varchar(100) UNIQUE NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `proprietario`
--

INSERT INTO `proprietario` (`id_proprietario`, `nome_proprietario`, `email_proprietario`, `senha`) VALUES
(1, 'Bassani Games', 'bassanilegend1@gmail.com', '@bassani312'),
(2, 'Vinas Games', 'vinas@gmail.com', '@vinas312'),
(3, 'Pezzoti Games', 'pezzoti@gmail.com', '@pezzoti312'),
(4, 'Gui Games', 'gui@gmail.com', '@gui312');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `fazenda`
--
ALTER TABLE `fazenda`
  ADD PRIMARY KEY (`id_fazenda`),
  ADD KEY `fk_fazenda_2_proprietario` (`id_proprietario`);

--
-- Índices de tabela `producao`
--
ALTER TABLE `producao`
  ADD PRIMARY KEY (`id_producao`),
  ADD KEY `fk_producao_fazenda` (`id_fazenda`),
  ADD KEY `fk_producao_produto` (`id_produto`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `proprietario`
--
ALTER TABLE `proprietario`
  ADD PRIMARY KEY (`id_proprietario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fazenda`
--
ALTER TABLE `fazenda`
  MODIFY `id_fazenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `producao`
--
ALTER TABLE `producao`
  MODIFY `id_producao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `proprietario`
--
ALTER TABLE `proprietario`
  MODIFY `id_proprietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `fazenda`
--
ALTER TABLE `fazenda`
  ADD CONSTRAINT `fk_fazenda_2_proprietario` FOREIGN KEY (`id_proprietario`) REFERENCES `proprietario` (`id_proprietario`);

--
-- Restrições para tabelas `producao`
--
ALTER TABLE `producao`
  ADD CONSTRAINT `fk_producao_fazenda` FOREIGN KEY (`id_fazenda`) REFERENCES `fazenda` (`id_fazenda`),
  ADD CONSTRAINT `fk_producao_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
