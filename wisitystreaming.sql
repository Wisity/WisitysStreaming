-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql107.infinityfree.com
-- Tempo de geração: 26/01/2025 às 10:09
-- Versão do servidor: 10.6.19-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_38100723_wisitystreaming`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `episode_number` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `episodes`
--

INSERT INTO `episodes` (`id`, `season_id`, `title`, `episode_number`, `url`) VALUES
(22, 18, 'UNICA', 1, 'https://superflixapi.dev/serie/56295'),
(23, 19, 'Temporada Unica', 1, 'https://superflixapi.link/serie/94154'),
(24, 20, 'PILOTO', 1, 'https://superflixapi.link/serie/127532/1'),
(25, 21, 'PILOTO', 1, 'https://superflixapi.link/serie/207332/1'),
(26, 22, 'piloto', 1, 'https://superflixapi.link/serie/93405'),
(27, 23, 'PILOTO', 1, 'https://superflixapi.link/serie/253905'),
(28, 24, 'PILOTO', 1, 'https://superflixapi.link/serie/240411'),
(29, 25, 'PILOTO', 1, 'https://superflixapi.link/serie/62745'),
(30, 26, 'PILOTO', 1, 'https://superflixapi.link/serie/1399');

-- --------------------------------------------------------

--
-- Estrutura para tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `release_year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `synopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movies`
--

INSERT INTO `movies` (`id`, `title`, `year`, `genre`, `image_url`, `release_year`, `description`, `url`, `link`, `synopsis`) VALUES
(11, 'José e Maria', 2016, ' Drama', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/rppXv4b4DgCzvxQCpT0YZyt7miN.jpg', NULL, NULL, NULL, 'https://superflixapi.dev/filme/tt5206098', 'Em 30a.C., Herodes reinava sob Israel até que os rumores do nascimento do Messias ameaçavam a sua soberania. Surge então Maria e José, os escolhidos por Deus para cuidar daquele que salvaria a humanidade, Jesus.'),
(12, 'SOLO LEVELING -Segundo Despertar-', 2025, 'AÇÃO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/ggQjQpd5OIIjeQbv11yXfjixj1Z.jpg', NULL, NULL, NULL, 'https://superflixapi.dev/filme/tt33428606', 'Em Solo Leveling - Segundo Despertar, mais de uma década após o surgimento dos portais que conectam o mundo humano a uma dimensão misteriosa, a vida foi transformada pela presença de \"caçadores\", indivíduos com habilidades sobre-humanas despertadas por esses portais.'),
(13, 'Master Kid - O Despertar de um HerÃ³i', 2021, 'Aventura/AÃ§Ã£o', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/pxl3gQG1BebbA8GhcJXAvwuipgj.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt15072480', 'Li Ã© um garoto que sonha em ser um herÃ³i, mas apesar de sua boa intenÃ§Ã£o, suas aÃ§Ãµes sempre causam problemas para o seu vilarejo. ApÃ³s um perigoso encontro, ele descobre que Ã© a reencarnaÃ§Ã£o de um lendÃ¡rio herÃ³i do passado.'),
(16, 'Kraven - O CaÃ§ador', 2024, ' AÃ§Ã£o, Fantasia', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/pWvQsP9o1MQ4vQNjpL9QeYFXKOs.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt8790086', 'Em Kraven - O CaÃ§ador, acompanhamos a histÃ³ria de origem de um dos vilÃµes da franquia Homem-Aranha. De origem russa, Kraven (Aaron Taylor-Johnson) vem de um lar criminoso e de uma famÃ­lia de caÃ§adores. Seus poderes nascem de uma forÃ§a sobrenatural e super humana que o faz um oponente destemido e habilidoso. A relaÃ§Ã£o complexa com seu pai Nicolai Kravinoff (Russell Crowe) o leva para uma jornada de vinganÃ§a e caos para se tornar um dos maiores e mais temidos caÃ§adores de sua linhagem. De frente para questÃµes familiares, Kraven mostra sua potÃªncia nesse spin-off.'),
(17, 'Turbo', 2013, 'Aventura, AnimaÃ§Ã£o, ComÃ©dia', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/inTKQni4YW8syrfgnXHwzmNeSo4.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt1860353', 'Theo (voz original de Ryan Reynolds) Ã© um caracol de jardim, que passa o dia com outros caracÃ³is, colhendo tomates e torcendo para nÃ£o ser capturado por aves predadoras. Apesar da vida pacata, este jovem animal sonha em se tornar extremamente veloz, como o seu Ã­dolo, o corredor campeÃ£o de IndianÃ¡polis Guy GagnÃ© (voz original de Bill Hader). A obsessÃ£o pela velocidade faz que com Theo seja ridicularizado pelos colegas. Um dia, no entanto, ele cai acidentalmente dentro do motor de um grande carro de corrida, e um efeito inesperado acontece em seu corpo, fazendo com que ele se torne extremamente veloz. Rebatizado Turbo, o caracol encontra abrigo na casa de Tito (voz original de Michael PeÃ±a), um vendedor de comida mexicana conhecido pelos planos inusitados e que quase sempre dÃ£o errado. Surpreso com a velocidade de Turbo, Tito decide levÃ¡-lo Ã  corrida de IndianÃ¡polis, para competir com Guy GagnÃ©.'),
(18, 'AtÃ© o Ãšltimo Homem', 2016, 'Biopic, Drama, Guerra', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/88sCL8OQMoieKpHClqRCCbcgH6w.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt2119532', 'AtÃ© o Ãšltimo Homem conta a histÃ³ria verdadeira de um combatente de guerra que, sem dar um tiro, recebeu a maior condecoraÃ§Ã£o militar dos Estados Undios. Foi durante a Segunda Guerra Mundial que o mÃ©dico do exÃ©rcito Desmond T. Doss (Andrew Garfield) demonstrou imensa coragem e respeito ao seu batalhÃ£o ao se recusar a pegar em uma arma e matar pessoas em meio ao conflito. Suas convicÃ§Ãµes religiosas e anti-violÃªncia fazem-o se destacar, assim como seu trabalho na ala mÃ©dica durante a Batalha de Okinawa, na qual salvou mais de 75 homens. Doss Ã© o primeiro Opositor Consciente da histÃ³ria norte-americana a receber a Medalha de Honra do Congresso.\r\n\r\n'),
(19, 'De Volta Ã  AÃ§Ã£o', 2024, 'AÃ§Ã£o, ComÃ©dia', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/m4gzzzeYRmrwasrBdJmjhBmjS3U.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt21191806', 'De Volta a AÃ§Ã£o Ã© um longa dirigido por Seth Gordon, roteirizado por Brendan Oâ€™Brien e estrelado por Cameron Diaz e Jamie Foxx. O filme vai retratar os ex-espiÃµes da CIA, Emily (Cameron Diaz) e Matt (Jamie Foxx), que deixaram as suas carreiras para trÃ¡s com a intenÃ§Ã£o de construÃ­rem uma famÃ­lia juntos, longe dos riscos que a espionagem podem apresentar. Entretanto, muitos anos depois de terem largado seus trabalhos, eles serÃ£o obrigados a voltar para o mundo da espionagem. Essa volta repentina deve-se ao fato das suas identidades secretas terem sido expostas. De Volta Ã  AÃ§Ã£o Ã© uma celebraÃ§Ã£o de amizade entre Cameron e Jamie, uma vez que eles jÃ¡ realizaram outros trabalhos juntos como Um Domingo Qualquer e Annie.'),
(20, 'Oblivion', 2013, 'AÃ§Ã£o, FicÃ§Ã£o CientÃ­fica', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/qL1qC0BCIgOvCLKyVj8bIeijMY9.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt1483013', '2077. Jack Harper (Tom Cruise) Ã© o responsÃ¡vel pela manutenÃ§Ã£o de equipamentos de seguranÃ§a em um planeta Terra irreconhecÃ­vel, visto que a superfÃ­cie foi destruÃ­da devido a confrontos com uma raÃ§a alienÃ­gena. O que restou da humanidade vive hoje em uma colÃ´nia lunar. Jack irÃ¡ para este local daqui a duas semanas, jÃ¡ que estÃ¡ perto de terminar seu trabalho na Terra. SÃ³ que, um dia, ele encontra uma espaÃ§onave que traz uma mulher dentro. Ao conhecÃª-la, tudo o que Jack sabe atÃ© entÃ£o Ã© posto em dÃºvida. Ã‰ o inÃ­cio de uma jornada onde ele precisarÃ¡ descobrir o que realmente aconteceu no passado.'),
(21, 'O Telefone Preto', 2022, 'trama,suspense', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/yw6H4C64tjBWlyKFG1pzmq5zOQh.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt7144666', 'Finney Shaw foi sequestrado por um sÃ¡dico serial killer e estÃ¡ preso em um porÃ£o a prova de som, mas apÃ³s um tempo ele comeÃ§a a escutar as vozes das vÃ­timas anteriores do assassino que o ajudam a sair do porÃ£o.'),
(22, 'Projeto ExtraÃ§Ã£o', 2023, 'AÃ‡ÃƒO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/t3vZkkM5G40pUJxUzkz69H777Hm.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt6879446', 'Dois ex-soldados devem se unir para combater o plano de uma gangue de saqueadores.'),
(23, 'Sword Art Online Progressive: Scherzo do CrepÃºsculo Sombrio', 2023, 'AnimaÃ§Ã£o, ComÃ©dia, FicÃ§Ã£o CientÃ­fica, Romance', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/gzs2XMWatrPjVJputJUugbKA4Z.jpg', NULL, NULL, NULL, 'https://superflixapi.link/filme/tt15830702', 'Dois meses apÃ³s entrarem no jogo Sword Art Online, Asuna e Kirito seguem firmes na jornada para escaparem do videogame e voltarem Ã s suas vidas normais.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `seasons`
--

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `season_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `seasons`
--

INSERT INTO `seasons` (`id`, `series_id`, `season_number`) VALUES
(18, 7, 1),
(19, 8, 1),
(20, 9, 1),
(21, 10, 1),
(22, 11, 1),
(23, 12, 1),
(24, 13, 1),
(25, 14, 1),
(26, 15, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `series`
--

INSERT INTO `series` (`id`, `title`, `year`, `genre`, `image_url`) VALUES
(7, 'Halo 4: Em Direção ao Amanhecer', 2024, 'AÇÃO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/fYRWEnmvyQ3vkNBfG2Qc8eabDYy.jpg'),
(8, 'O Ãšltimo DragÃ£o', 2019, 'AÃ§Ã£o, Drama', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/5gJLpSjh4vgkF0YosBxbAAuIjKc.jpg'),
(9, 'Solo Leveling', 2024, 'AÃ‡ÃƒO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/1KRSR1dUAOpUv3mxHU5W3QWo2og.jpg'),
(10, 'SAKAMOTO DAYS', 2024, 'AÃ‡ÃƒO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/qTNIxDIzKjLLuS17fxdXjcKAlW7.jpg'),
(11, 'Round 6', 2024, 'AÃ‡ÃƒO - SUSPENSE', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/6gcHdboppvplmBWxvROc96NJnmm.jpg'),
(12, 'Quando o Telefone Toca', 2024, 'Drama, Romance, Suspense', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/jF0jc4GiLoA2UxTurcCh1ED3akU.jpg'),
(13, 'DAN DA DAN', 2024, 'AnimaÃ§Ã£o, ComÃ©dia, FicÃ§Ã£o CientÃ­fica', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/vtQug1eOyeU2VXIpNoDF1lTlcH4.jpg'),
(14, 'DanMachi: Ã‰ Errado Tentar Pegar Garotas em uma Masmorra?', 2015, 'Drama', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/eanhJgkvsqGPf5Bot77kjuuZVco.jpg'),
(15, 'Game of Thrones', 2019, 'suspense,drama', 'https://d1muf25xaso8hp.cloudfront.net/https://image.tmdb.org/t/p/w500/l2ezB41chGDjXcKo24lseuXYtKP.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `is_admin`) VALUES
(1, 'wisitys', '$2y$10$jGAWI8kWCPOSt7NYzJdVr.ZVNvprCHB1WrWf8CCOdOj8KLAF2Nn8K', 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `season_id` (`season_id`);

--
-- Índices de tabela `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Índices de tabela `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_season_series` (`series_id`);

--
-- Índices de tabela `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Restrições para tabelas `seasons`
--
ALTER TABLE `seasons`
  ADD CONSTRAINT `fk_season_series` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seasons_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
