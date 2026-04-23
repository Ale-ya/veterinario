-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 10, 2026 alle 21:53
-- Versione del server: 11.8.3-MariaDB-0+deb13u1 from Debian
-- Versione PHP: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `veterinario`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appetito`
--

CREATE TABLE `appetito` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `appetito`
--

INSERT INTO `appetito` (`id`, `description`, `peso`) VALUES
(1, 'Normale', 2),
(2, 'Poco diminuito', 1),
(3, 'Mediamente diminuito', 3),
(4, 'Gravemente diminuito', 4),
(5, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `atteggiamento`
--

CREATE TABLE `atteggiamento` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `atteggiamento`
--

INSERT INTO `atteggiamento` (`id`, `description`, `peso`) VALUES
(1, 'Normale', 2),
(2, 'Poco abbattuto', 1),
(3, 'Mediamente abbattuto', 3),
(4, 'Gravemente abbattuto', 4),
(5, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `dimagrimento`
--

CREATE TABLE `dimagrimento` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `dimagrimento`
--

INSERT INTO `dimagrimento` (`id`, `description`, `peso`) VALUES
(1, 'Assente', 2),
(2, 'Blando (<5%)', 1),
(3, 'Moderato (5-10%)', 3),
(4, 'Grave (>10%)', 4),
(5, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `flatulenza`
--

CREATE TABLE `flatulenza` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `flatulenza`
--

INSERT INTO `flatulenza` (`id`, `description`, `peso`) VALUES
(1, 'Assente', 1),
(2, 'Presente', 3),
(3, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `frequenza_feci`
--

CREATE TABLE `frequenza_feci` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `frequenza_feci`
--

INSERT INTO `frequenza_feci` (`id`, `description`, `peso`) VALUES
(1, 'Normale', 2),
(2, '2-3 al giorno', 1),
(3, '4-5 al giorno', 3),
(4, '5 o più al giorno', 4),
(5, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `lambimento`
--

CREATE TABLE `lambimento` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `lambimento`
--

INSERT INTO `lambimento` (`id`, `description`, `peso`) VALUES
(1, 'Assente', 1),
(2, 'Presente', 3),
(3, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `id_paziente` int(11) NOT NULL,
  `id_vomito` int(11) NOT NULL,
  `id_atteggiamento` int(11) NOT NULL,
  `id_appetito` int(11) NOT NULL,
  `id_dimagrimento` int(11) NOT NULL,
  `id_frequenza_feci` int(11) NOT NULL,
  `id_sangue` int(11) NOT NULL,
  `id_muco` int(11) NOT NULL,
  `id_flatulenza` int(11) NOT NULL,
  `id_lambimento` int(11) NOT NULL,
  `data_di_riferimento` date NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `log`
--

INSERT INTO `log` (`id`, `id_paziente`, `id_vomito`, `id_atteggiamento`, `id_appetito`, `id_dimagrimento`, `id_frequenza_feci`, `id_sangue`, `id_muco`, `id_flatulenza`, `id_lambimento`, `data_di_riferimento`, `timestamp`) VALUES
(1, 4, 1, 2, 5, 4, 2, 3, 2, 3, 2, '2026-04-10', '2026-04-10 20:16:05'),
(2, 8, 2, 4, 1, 2, 4, 1, 1, 1, 1, '2026-04-10', '2026-04-10 21:50:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `muco`
--

CREATE TABLE `muco` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `muco`
--

INSERT INTO `muco` (`id`, `description`, `peso`) VALUES
(1, 'Assente', 1),
(2, 'Presente', 4),
(3, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `pazienti`
--

CREATE TABLE `pazienti` (
  `id` int(11) NOT NULL,
  `id_proprietario` int(11) DEFAULT NULL,
  `nome_paziente` varchar(255) NOT NULL,
  `data_nascita` date NOT NULL,
  `peso` float NOT NULL,
  `razza` varchar(255) NOT NULL,
  `sesso` tinyint(1) DEFAULT NULL,
  `terapie_T0` text DEFAULT NULL,
  `dieta_T0` text DEFAULT NULL,
  `sospetta_diagnosi_T0` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `pazienti`
--

INSERT INTO `pazienti` (`id`, `id_proprietario`, `nome_paziente`, `data_nascita`, `peso`, `razza`, `sesso`, `terapie_T0`, `dieta_T0`, `sospetta_diagnosi_T0`) VALUES
(1, 1, 'Thor', '2020-05-12', 25.5, 'Pastore Tedesco', 1, NULL, NULL, NULL),
(4, 4, 'Cicco', '2024-03-08', 5, 'asdfare', 1, 'asf', 'sdf', 'ssdfa'),
(5, 4, 'Pepe', '2024-02-08', 5, 'sdfaa', 1, 'asf', 'sdaf', 'sder'),
(6, 4, 'Coso', '2024-02-08', 4, 'faer', 1, 'sdf', 'xfww', 'darw'),
(7, 4, 'Coso2', '2025-02-08', 3, 'asdf', 1, 'asdf', 'ertgasd', 'sfer'),
(8, 5, 'Gastone', '2021-07-11', 1.2, 'sanbernardo', 1, 'xxx', 'xxx', 'xxx');

-- --------------------------------------------------------

--
-- Struttura della tabella `pazienti_veterinari`
--

CREATE TABLE `pazienti_veterinari` (
  `id` int(11) NOT NULL,
  `id_paziente` int(11) DEFAULT NULL,
  `id_veterinario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `pazienti_veterinari`
--

INSERT INTO `pazienti_veterinari` (`id`, `id_paziente`, `id_veterinario`) VALUES
(1, 1, 1),
(4, 7, 1),
(5, 8, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `proprietari`
--

CREATE TABLE `proprietari` (
  `id` int(11) NOT NULL,
  `id_vet` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `proprietari`
--

INSERT INTO `proprietari` (`id`, `id_vet`, `username`, `password`, `nome`, `cognome`, `email`, `data_creazione`) VALUES
(1, 1, 'luca85', 'password_proprietario', 'Luca', 'Bianchi', 'luca.bianchi@email.com', '2026-04-08 22:45:06'),
(2, NULL, 'ale', '$2y$12$3JHT.48jxaEbMzt0NMLoUOl9vfwcDRtPcBc1iyUuk/0kBMSTCeOh2', 'pippo', 'paperino', 'sdfas', '2026-04-10 17:19:34'),
(3, 4, '', '$2y$12$WsRRffIb6XW0FipQ38v.de6joUUTYdUsw8IUMYKr1oK1u6OSTDqe6', 'asdfre', 'erwewe', 'asdfasdferr', '2026-04-10 17:34:34'),
(4, NULL, 'valeria', '$2y$12$Ug1Nb80Tc5LrXYEbBP1XLOddplwVrq4UvSvzVfwZh5HAQHpsHq4uO', 'asdsdf', 'fsasad', 'asdfasd', '2026-04-10 19:42:09'),
(5, 1, '', '$2y$12$tDcjWIMSuEhaq.xMEBTGiuM30X9YvEORfpdgKS.6jfDeM/9Qs57SK', 'pippo', 'paperino', 'asdfer', '2026-04-10 21:47:54');

-- --------------------------------------------------------

--
-- Struttura della tabella `sangue`
--

CREATE TABLE `sangue` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `sangue`
--

INSERT INTO `sangue` (`id`, `description`, `peso`) VALUES
(1, 'Assente', 1),
(2, 'Presente', 4),
(3, 'Non rilevato / Non sa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `veterinari`
--

CREATE TABLE `veterinari` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_creazione` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `veterinari`
--

INSERT INTO `veterinari` (`id`, `username`, `password`, `nome`, `cognome`, `email`, `data_creazione`) VALUES
(1, 'dr_rossi', 'hash_password_sicura', 'Mario', 'Rossi', 'mario.rossi@clinicavet.it', '2026-04-08 22:45:05'),
(4, 'ale', '$2y$12$6JAr6OPLJ7Sp6T6Gm6v5h.OkEusKmPDmYAQ/kfP23nBl6H5QwvbuO', 'ale', 'sadfer', 'saf', '2026-04-10 17:33:40'),
(5, 'user', '$2y$12$bmBYtINvFUh83OiJp2lHoukMtLqLslPGJFCPpKzohdoD40jqeSNBi', 'coso', 'sadf', 'saf', '2026-04-10 17:38:52'),
(6, 'dt_hop', '$2y$12$xCMxmlB/KlOt3I0oo0nmtetSazvM5fkn8HPkUSVQ/ujSzpifNNk6G', 'hop', 'qewrq', 'asdfasdf', '2026-04-10 17:43:34');

-- --------------------------------------------------------

--
-- Struttura della tabella `vomito`
--

CREATE TABLE `vomito` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `peso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dump dei dati per la tabella `vomito`
--

INSERT INTO `vomito` (`id`, `description`, `peso`) VALUES
(1, 'Si', 2),
(2, 'No', 1),
(3, 'Blando (1 a settimana)', 3),
(4, 'Moderato (2-3 a settimana)', 4),
(5, 'Grave (>3 a settimana)', 4),
(6, 'Non rilevato / Non sa', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appetito`
--
ALTER TABLE `appetito`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `atteggiamento`
--
ALTER TABLE `atteggiamento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dimagrimento`
--
ALTER TABLE `dimagrimento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `flatulenza`
--
ALTER TABLE `flatulenza`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `frequenza_feci`
--
ALTER TABLE `frequenza_feci`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `lambimento`
--
ALTER TABLE `lambimento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paziente` (`id_paziente`),
  ADD KEY `id_vomito` (`id_vomito`),
  ADD KEY `id_atteggiamento` (`id_atteggiamento`),
  ADD KEY `id_appetito` (`id_appetito`),
  ADD KEY `id_dimagrimento` (`id_dimagrimento`),
  ADD KEY `id_frequenza_feci` (`id_frequenza_feci`),
  ADD KEY `id_sangue` (`id_sangue`),
  ADD KEY `id_muco` (`id_muco`),
  ADD KEY `id_flatulenza` (`id_flatulenza`),
  ADD KEY `id_lambimento` (`id_lambimento`);

--
-- Indici per le tabelle `muco`
--
ALTER TABLE `muco`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `pazienti`
--
ALTER TABLE `pazienti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proprietario` (`id_proprietario`);

--
-- Indici per le tabelle `pazienti_veterinari`
--
ALTER TABLE `pazienti_veterinari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paziente` (`id_paziente`),
  ADD KEY `id_veterinario` (`id_veterinario`);

--
-- Indici per le tabelle `proprietari`
--
ALTER TABLE `proprietari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vet` (`id_vet`);

--
-- Indici per le tabelle `sangue`
--
ALTER TABLE `sangue`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `veterinari`
--
ALTER TABLE `veterinari`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `vomito`
--
ALTER TABLE `vomito`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appetito`
--
ALTER TABLE `appetito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `atteggiamento`
--
ALTER TABLE `atteggiamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `dimagrimento`
--
ALTER TABLE `dimagrimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `flatulenza`
--
ALTER TABLE `flatulenza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `frequenza_feci`
--
ALTER TABLE `frequenza_feci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `lambimento`
--
ALTER TABLE `lambimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `muco`
--
ALTER TABLE `muco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `pazienti`
--
ALTER TABLE `pazienti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `pazienti_veterinari`
--
ALTER TABLE `pazienti_veterinari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `proprietari`
--
ALTER TABLE `proprietari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `sangue`
--
ALTER TABLE `sangue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `veterinari`
--
ALTER TABLE `veterinari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `vomito`
--
ALTER TABLE `vomito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_paziente`) REFERENCES `pazienti` (`id`),
  ADD CONSTRAINT `log_ibfk_10` FOREIGN KEY (`id_lambimento`) REFERENCES `lambimento` (`id`),
  ADD CONSTRAINT `log_ibfk_2` FOREIGN KEY (`id_vomito`) REFERENCES `vomito` (`id`),
  ADD CONSTRAINT `log_ibfk_3` FOREIGN KEY (`id_atteggiamento`) REFERENCES `atteggiamento` (`id`),
  ADD CONSTRAINT `log_ibfk_4` FOREIGN KEY (`id_appetito`) REFERENCES `appetito` (`id`),
  ADD CONSTRAINT `log_ibfk_5` FOREIGN KEY (`id_dimagrimento`) REFERENCES `dimagrimento` (`id`),
  ADD CONSTRAINT `log_ibfk_6` FOREIGN KEY (`id_frequenza_feci`) REFERENCES `frequenza_feci` (`id`),
  ADD CONSTRAINT `log_ibfk_7` FOREIGN KEY (`id_sangue`) REFERENCES `sangue` (`id`),
  ADD CONSTRAINT `log_ibfk_8` FOREIGN KEY (`id_muco`) REFERENCES `muco` (`id`),
  ADD CONSTRAINT `log_ibfk_9` FOREIGN KEY (`id_flatulenza`) REFERENCES `flatulenza` (`id`);

--
-- Limiti per la tabella `pazienti`
--
ALTER TABLE `pazienti`
  ADD CONSTRAINT `pazienti_ibfk_1` FOREIGN KEY (`id_proprietario`) REFERENCES `proprietari` (`id`);

--
-- Limiti per la tabella `pazienti_veterinari`
--
ALTER TABLE `pazienti_veterinari`
  ADD CONSTRAINT `pazienti_veterinari_ibfk_1` FOREIGN KEY (`id_paziente`) REFERENCES `pazienti` (`id`),
  ADD CONSTRAINT `pazienti_veterinari_ibfk_2` FOREIGN KEY (`id_veterinario`) REFERENCES `veterinari` (`id`);

--
-- Limiti per la tabella `proprietari`
--
ALTER TABLE `proprietari`
  ADD CONSTRAINT `proprietari_ibfk_1` FOREIGN KEY (`id_vet`) REFERENCES `veterinari` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
