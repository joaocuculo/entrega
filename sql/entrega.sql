-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/10/2024 às 20:47
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
-- Banco de dados: `entrega`
--
CREATE DATABASE IF NOT EXISTS `entrega` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `entrega`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela`
--

CREATE TABLE `tabela` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` varchar(15) NOT NULL,
  `chamado` varchar(20) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `recebedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela`
--

INSERT INTO `tabela` (`id`, `id_usuario`, `data`, `chamado`, `id_tecnico`, `recebedor`) VALUES
(15, 2, '15/04/2024', '023215', 2, 'Nilton'),
(17, 2, '06/09/2023', '021987', 5, 'Wellington'),
(21, 1, '08/09/2023', '020147', 6, 'Tom'),
(23, 2, '10/05/2023', '020369', 5, 'Silva'),
(24, 2, '12/02/2024', '023258', 1, 'Renato'),
(25, 1, '01/07/2024', '024213', 1, 'Cleiton'),
(26, 1, '05/05/2024', '024267', 4, 'Douglas'),
(27, 1, '11/09/2023', '022178', 7, 'Yago'),
(29, 1, '12/05/2023', '020006', 7, 'Angélica'),
(38, 3, '25/05/2024', '025014', 1, 'William'),
(39, 4, '14/06/2024', '024100', 7, 'Eric'),
(40, 9, '21/05/2024', '024781', 2, 'Ricardinho'),
(41, 1, '12/12/2023', '025416', 4, 'Ricardo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tecnico`
--

CREATE TABLE `tecnico` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tecnico`
--

INSERT INTO `tecnico` (`id`, `nome`, `status`) VALUES
(1, 'Gabriel', 1),
(2, 'André', 1),
(3, 'Eduardo Gabriel', 1),
(4, 'João', 1),
(5, 'Eduardo Vergentino', 1),
(6, 'Marcos', 1),
(7, 'Otávio', 2),
(8, 'Bernardo Silva', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `senha` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(1) NOT NULL,
  `nivel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `senha`, `status`, `nivel`) VALUES
(1, 'Joao', '$2y$10$p199TEr32XHlTyNBbDIKu.TILrsuWDNsy/a4GNAfmsOEgDD8xPxa6', 1, 2),
(2, 'André', '$2y$10$rSw12JabLjHiYjgtJdXYEeQ12cAYtR76mVhQky5ZyXMmxOcc85sq2', 1, 2),
(3, 'Eduardo', '2345', 1, 1),
(4, 'Marcos', '$2y$10$Td4mp.PcYoB9JRSj/6rP5ucw.vmfHQWdNZaVZZPvJ/9JiWg2pT9bW', 1, 1),
(5, 'José', 'jose', 1, 1),
(6, 'Cesar', '$2y$10$b5kCH9zvvA8y0xLblxxShOU5p/EK/JPruHu2Ma6ojdo9DMStaLjyK', 2, 1),
(7, 'Adriel', '0987', 2, 2),
(8, 'Rony', '$2y$10$4Rpk9Cl3zJ3tB6m2CmQFP.8V2f0FeQwyL1leH72HYOMxHXliMT71y', 1, 1),
(9, 'Marçal', '$2y$10$WgTvejy6Z5U7o92h9rXnEOpohSe9GhvNgdnPDJxw90.EnYm01yiTi', 1, 1),
(10, 'Antônio', '$2y$10$wKy20D/X/sYw.zxL40kBJOEu9jTXwh.2dCCLXdfHROCtUBw9OysN6', 1, 1),
(12, 'Cristiano', '$2y$10$RlrjCvSby11emywGyYoUT.tsbxG1L0Ak2oJWKkys9PN99Ee1IdNoq', 1, 1),
(14, 'Andre', '$2y$10$rISBFj/omHrgkImMUTmLQeg8awJOM3wxon3WSjHrfDCpKnXyuQrSu', 2, 2),
(15, 'Olavo', '$2y$10$31MyxXgmTykKgKLBWI3.ROTQYsjWK2f7aKdCKaYNvL62pnw6lvWA2', 1, 1),
(17, 'Cesar', '$2y$10$sT87fwgJM.HKrij6JxjfQuQwnzmv9QmGFV87CnjMSSSRpa9Og6DoK', 1, 1),
(18, 'Fabrício', '$2y$10$SfQ0goxqWvUr0OaNpXzBHuf8dDGYwZaLHWnq9uOcyzqF8OZNVegIG', 2, 2),
(19, 'Wilton', '$2y$10$.vdfQrjNlFjt6HpZSxOH5.6zgJj8D8meA0bH4b1VaCWnF5EQCt/pS', 2, 2),
(20, 'Silva Saulo', '$2y$10$xZwIRFA805koxNxDcXacwubeKUJVMXRRJgyRNMOz3j818E3rLuKGu', 1, 1),
(21, 'Manoel', '$2y$10$g67PHkPeukJpBi1NEv0NNuIi5RQAvcZywRC4c42M/.N/N03ETH0By', 2, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tabela`
--
ALTER TABLE `tabela`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tabela_tecnico` (`id_tecnico`),
  ADD KEY `fk_tabela_usuario` (`id_usuario`);

--
-- Índices de tabela `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tabela`
--
ALTER TABLE `tabela`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `tecnico`
--
ALTER TABLE `tecnico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tabela`
--
ALTER TABLE `tabela`
  ADD CONSTRAINT `fk_tabela_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `tecnico` (`id`),
  ADD CONSTRAINT `fk_tabela_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
