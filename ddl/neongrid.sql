-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 28, 2024 alle 21:25
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neongrid`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `effect`
--

CREATE TABLE `effect` (
                          `id` int(10) NOT NULL,
                          `name` varchar(30) NOT NULL,
                          `description` varchar(100) NOT NULL,
                          `value` int(10) DEFAULT 0,
                          `is_shown` int(1) DEFAULT 1,
                          `cd` int(10) DEFAULT 0,
                          `img` varchar(100) DEFAULT NULL,
                          `id_event` int(10) DEFAULT NULL,
                          `color_bg` varchar(7) DEFAULT NULL,
                          `color_bd` varchar(7) DEFAULT NULL,
                          `color_bg_disabled` varchar(7) DEFAULT NULL,
                          `color_bd_disabled` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `effect`
--

INSERT INTO `effect` (`id`, `name`, `description`, `value`, `is_shown`, `cd`, `img`, `id_event`, `color_bg`, `color_bd`, `color_bg_disabled`, `color_bd_disabled`) VALUES
                                                                                                                                                                       (1, 'corrosion resistance', 'corrosion stops at 3 hp', 3, 1, 0, NULL, 19, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (2, 'pocket knife', 'gain a knife', 21, 1, 9, 'pocket_knife.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#ADADAD'),
                                                                                                                                                                       (3, 'beefed out', 'potions cure 2 hp extra', 2, 1, 0, NULL, 10, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (4, 'upgrade', 'increase by 1 the power of all adjacent cells', 1, 1, 7, 'upgrade.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#ADADAD'),
                                                                                                                                                                       (5, 'agile', 'immune to traps damage', 0, 1, 0, NULL, 17, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (6, 'swap', 'change place with an adjacent cell', 0, 1, 4, 'swap.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#bbbbbb'),
                                                                                                                                                                       (7, 'furious', 'do not consume the weapon on a kill', 1, 1, 0, NULL, 9, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (8, 'critical hit', 'the next attack deal 2x damage', 2, 1, 10, 'critical_hit.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#ADADAD'),
                                                                                                                                                                       (9, 'shield', 'ignore the first damage taken', 1, 1, 0, NULL, 2, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (10, 'revenge', 'destroy the weapon that kill him', 0, 1, 0, NULL, 1, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (11, 'death puddle', 'spawn a toxic puddle on death', 32, 1, 0, NULL, 1, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (12, 'corrosive touch', 'give corrosion when attacked', 1, 1, 0, NULL, 5, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (13, 'wealthy', 'spawn coins when killed', 13, 1, 0, NULL, 1, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (14, 'spikes', 'deal 1 damage back when attacked', 1, 1, 0, NULL, 5, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (15, 'damage absorption', 'take 1 less damage from all sources except corrosion', 1, 1, 0, NULL, 18, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (16, 'armed', 'spawn a weapon when killed', 5, 1, 0, NULL, 1, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (17, 'laser trap activation', 'activate next turn', 29, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (18, 'laser trap deactivation', 'deactivate next turn', 30, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (19, 'detonation', 'when it dies it explodes dealing as much damage as its health to adjacent cells', 4, 1, 0, NULL, 1, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (20, 'corrosive', 'give corrosion to the target', 1, 1, 0, NULL, 4, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (21, 'temporary', 'decrease the uses every turn', 1, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (22, 'damaging', 'deals 2 damage on interact the player', 2, 1, 0, NULL, 14, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (23, 'toxins immunity', 'immune to corrosion', 0, 1, 0, NULL, 15, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (24, 'poisonous', 'give corrosion', 1, 1, 0, NULL, 14, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (25, 'healing', 'heal', 0, 1, 0, NULL, 14, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (26, 'coins', 'give coins', 0, 1, 0, NULL, 14, NULL, NULL, NULL, NULL),
                                                                                                                                                                       (27, 'shield generator', 'if you don\'t have a shield create 1', 1, 1, 16, 'shield_generator.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#ADADAD'),
(28, 'drain', 'regenerate 1 hp when killing an enemy', 1, 1, 0, NULL, 9, NULL, NULL, NULL, NULL),
(29, 'have rotation', 'spawn with random rotation', 0, 0, 0, NULL, 2, NULL, NULL, NULL, NULL),
(30, 'passive attack', 'deals 1 damage if facing the player', 1, 1, 0, NULL, 13, NULL, NULL, NULL, NULL),
(31, 'rotate clockwise', 'rotate clockwise', 1, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
(32, 'rotate counter clockwise', 'rotate counter clockwise', 1, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
(33, 'spawn corroded', 'spawn with corrosion', 0, 1, 0, NULL, 2, NULL, NULL, NULL, NULL),
(34, 'turn heal', 'heal 1 every turn', 1, 1, 0, NULL, 12, NULL, NULL, NULL, NULL),
(35, 'life steal', 'heal the player for the damage dealt', 1, 1, 0, NULL, 6, NULL, NULL, NULL, NULL),
(36, 'toxic touch', 'give corrosion to an adjacent enemy', 1, 1, 8, 'toxic_touch.jpeg', NULL, '#ffff30', '#fff200', '#bbbbbb', '#ADADAD'),
(37, 'armoury', 'every weapon have 1 more use', 1, 1, 0, NULL, 16, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `game_event`
--

CREATE TABLE `game_event` (
  `id` int(10) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `game_event`
--

INSERT INTO `game_event` (`id`, `description`) VALUES
(1, 'on death'),
(2, 'on spawn'),
(3, 'on dmg taken'),
(4, 'on damage done'),
(5, 'on normal dmg taken'),
(6, 'on normal damage done'),
(7, 'on special dmg taken'),
(8, 'on special damage done'),
(9, 'on kill'),
(10, 'on heal'),
(11, '*unused*'),
(12, 'on turn end'),
(13, 'past turn end'),
(14, 'on interaction'),
(15, 'on effect applied'),
(16, 'on weapon pickup'),
(17, 'before dmg taken'),
(18, 'before normal dmg taken'),
(19, 'before special dmg taken'),
(20, 'before dmg done'),
(21, 'before normal dmg done'),
(22, 'before special dmg done');

-- --------------------------------------------------------

--
-- Struttura della tabella `have_effect`
--

CREATE TABLE `have_effect` (
  `id` int(10) NOT NULL,
  `id_effect` int(10) NOT NULL,
  `id_object` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `have_effect`
--

INSERT INTO `have_effect` (`id`, `id_effect`, `id_object`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 2),
(5, 5, 3),
(6, 6, 3),
(7, 7, 4),
(8, 8, 4),
(9, 9, 6),
(10, 10, 8),
(11, 11, 9),
(12, 12, 9),
(13, 23, 9),
(14, 13, 10),
(15, 14, 11),
(16, 15, 12),
(17, 11, 19),
(18, 16, 20),
(19, 20, 25),
(20, 20, 26),
(21, 18, 29),
(22, 22, 29),
(23, 17, 30),
(24, 21, 31),
(25, 19, 31),
(26, 21, 32),
(27, 24, 32),
(28, 26, 13),
(29, 26, 14),
(30, 25, 15),
(31, 25, 16),
(32, 24, 17),
(33, 24, 18),
(34, 27, 34),
(35, 28, 34),
(36, 29, 35),
(37, 30, 35),
(38, 31, 35),
(39, 29, 36),
(40, 30, 36),
(41, 32, 36),
(42, 33, 37),
(43, 34, 38),
(44, 35, 39),
(45, 36, 40),
(46, 37, 40);

-- --------------------------------------------------------

--
-- Struttura della tabella `have_skin`
--

CREATE TABLE `have_skin` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_skin` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `have_skin`
--

INSERT INTO `have_skin` (`id`, `id_user`, `id_skin`) VALUES
(71, 1, 1),
(72, 1, 69),
(73, 1, 3),
(74, 1, 73),
(75, 1, 72),
(76, 1, 4),
(77, 1, 34),
(78, 1, 65),
(79, 1, 76),
(80, 1, 77),
(81, 12, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `object`
--

CREATE TABLE `object` (
  `id` int(10) NOT NULL,
  `id_type` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `health` int(10) NOT NULL,
  `max_health` int(10) DEFAULT NULL,
  `uses` int(10) DEFAULT NULL,
  `id_original_img` int(11) DEFAULT NULL,
  `spawn_indicator` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `object`
--

INSERT INTO `object` (`id`, `id_type`, `name`, `health`, `max_health`, `uses`, `id_original_img`, `spawn_indicator`) VALUES
(1, 1, 'normie', 10, 10, NULL, 1, 1),
(2, 1, 'tank', 15, 15, NULL, 2, 1),
(3, 1, 'speedy', 6, 6, NULL, 3, 1),
(4, 1, 'warrior', 7, 7, NULL, 4, 1),
(5, 2, 'robot', 5, 5, NULL, NULL, 10),
(6, 2, 'drone', 2, 2, NULL, NULL, 7),
(7, 2, 'vandal', 7, 7, NULL, NULL, 8),
(8, 2, 'cyber dog', 4, 4, NULL, NULL, 6),
(9, 2, 'toxic bot', 8, 8, NULL, NULL, 3),
(10, 2, 'mafioso', 7, 7, NULL, NULL, 7),
(11, 2, 'spiked bot', 7, 7, NULL, NULL, 3),
(12, 2, 'armored bot', 12, 12, NULL, NULL, 2),
(13, 3, 'coins', 5, NULL, NULL, NULL, 10),
(14, 3, 'coins', 15, NULL, NULL, NULL, 5),
(15, 3, 'health bottle', 3, NULL, NULL, NULL, 8),
(16, 3, 'health bottle', 5, NULL, NULL, NULL, 4),
(17, 3, 'toxic vile', 3, NULL, NULL, NULL, 4),
(18, 3, 'toxic vile', 5, NULL, NULL, NULL, 2),
(19, 4, 'toxic barrel', 1, NULL, NULL, NULL, 4),
(20, 4, 'box', 1, NULL, NULL, NULL, 10),
(21, 5, 'knife', 3, NULL, 3, NULL, 10),
(22, 5, 'katana', 7, NULL, 1, NULL, 7),
(23, 5, 'taser', 2, NULL, 5, NULL, 4),
(24, 5, 'gun', 5, NULL, 3, NULL, 3),
(25, 5, 'toxic knife', 2, NULL, 1, NULL, 4),
(26, 5, 'toxic gun', 3, NULL, 2, NULL, 1),
(27, 5, 'laser sword', 4, NULL, 3, NULL, 9),
(28, 5, 'shotgun', 8, NULL, 2, NULL, 4),
(29, 6, 'lasers', 2, NULL, NULL, NULL, 10),
(30, 6, 'lasers', 2, NULL, NULL, NULL, 10),
(31, 6, 'bomb', 3, NULL, 4, NULL, 8),
(32, 6, 'toxic puddle', 2, NULL, 3, NULL, 2),
(33, 6, '', 0, NULL, 0, NULL, 0),
(34, 1, 'absorber', 5, 5, NULL, 34, 1),
(35, 6, 'turret', 10, 10, NULL, NULL, 5),
(36, 6, 'turret', 10, 10, NULL, NULL, 5),
(37, 2, 'fog stalker', 22, 22, NULL, NULL, 6),
(38, 2, 'medic', 4, 8, NULL, NULL, 6),
(39, 5, 'purple sword', 2, NULL, 2, NULL, 3),
(40, 1, 'agent', 10, 10, 2, 40, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `price`
--

INSERT INTO `price` (`id`, `value`) VALUES
(1, 500),
(2, 600),
(3, 700),
(4, 100),
(5, 100),
(6, 200);

-- --------------------------------------------------------

--
-- Struttura della tabella `run`
--

CREATE TABLE `run` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_skin` int(10) NOT NULL,
  `turns` int(10) NOT NULL,
  `coins` int(10) NOT NULL,
  `dt_submit` timestamp NOT NULL DEFAULT current_timestamp(),
  `duration` int(10) NOT NULL,
  `id_version` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `run`
--

INSERT INTO `run` (`id`, `id_user`, `id_skin`, `turns`, `coins`, `dt_submit`, `duration`, `id_version`) VALUES
(2, 1, 77, 66, 10, '2024-05-27 19:59:09', 62, 1),
(3, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(4, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(5, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(6, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(7, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(8, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(9, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(10, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(11, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(12, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(13, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(14, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(15, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(16, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(17, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(18, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(19, 2, 1, 10, 1, '2024-05-27 20:05:08', 1, 1),
(20, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(21, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(22, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(23, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(24, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(25, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1),
(26, 2, 1, 0, 1, '2024-05-27 20:05:08', 1, 1),
(27, 1, 1, 1, 1, '2024-05-27 20:05:08', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `skin`
--

CREATE TABLE `skin` (
  `id` int(10) NOT NULL,
  `id_price` int(11) DEFAULT NULL,
  `id_object` int(10) DEFAULT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `skin`
--

INSERT INTO `skin` (`id`, `id_price`, `id_object`, `img`) VALUES
(1, 1, 1, 'normie.jpeg'),
(2, 1, 2, 'tank.jpeg'),
(3, 1, 3, 'speedy.jpeg'),
(4, 2, 4, 'warrior.jpeg'),
(5, NULL, 5, 'robot.jpeg'),
(6, NULL, 6, 'drone.jpeg'),
(7, NULL, 7, 'vandal.jpeg'),
(8, NULL, 8, 'robotic_dog.jpeg'),
(9, NULL, 9, 'toxic_bot.jpeg'),
(10, NULL, 10, 'cyber_mafioso.jpeg'),
(11, NULL, 11, 'spike_bot.jpeg'),
(12, NULL, 12, 'armored_bot.jpeg'),
(13, NULL, 13, 'coin.jpeg'),
(14, NULL, 14, 'coin.jpeg'),
(15, NULL, 15, 'healing_potion.jpeg'),
(16, NULL, 16, 'healing_potion.jpeg'),
(17, NULL, 17, 'corrosion_potion.jpeg'),
(18, NULL, 18, 'corrosion_potion.jpeg'),
(19, NULL, 19, 'toxic_barrel.jpeg'),
(20, NULL, 20, 'box.jpeg'),
(21, NULL, 21, 'knife.jpeg'),
(22, NULL, 22, 'katana.jpeg'),
(23, NULL, 23, 'taser.jpeg'),
(24, NULL, 24, 'pistol.jpeg'),
(25, NULL, 25, 'toxic_knife.jpeg'),
(26, NULL, 26, 'toxic_gun.jpeg'),
(27, NULL, 27, 'laser_sword.jpeg'),
(28, NULL, 28, 'shotgun.jpeg'),
(29, NULL, 29, 'lasers_on.jpeg'),
(30, NULL, 30, 'lasers_off.jpeg'),
(31, NULL, 31, 'bomb.jpeg'),
(32, NULL, 32, 'toxic_puddle.jpeg'),
(33, NULL, 33, 'empty.jpeg'),
(34, 3, 34, 'absorber.jpeg'),
(35, NULL, 35, 'turret.jpeg'),
(36, NULL, 36, 'turret_inv.jpeg'),
(37, NULL, 37, 'fog_stalker.jpeg'),
(38, NULL, 38, 'medic.jpeg'),
(39, NULL, 39, 'purple_sword.jpeg'),
(40, 3, 40, 'agent.jpeg'),
(64, 5, 34, 'absorber_1.jpeg'),
(65, 5, 34, 'absorber_2.jpeg'),
(66, 5, 40, 'agent_1.jpeg'),
(67, 5, 40, 'agent_2.jpeg'),
(68, 6, 40, 'agent_3.jpeg'),
(69, 5, 1, 'normie_1.jpeg'),
(70, 6, 1, 'normie_2.jpeg'),
(71, 6, 1, 'normie_3.jpeg'),
(72, 6, 3, 'speedy_1.jpeg'),
(73, 5, 3, 'speedy_2.jpeg'),
(74, 6, 2, 'tank_1.jpeg'),
(75, 5, 2, 'tank_2.jpeg'),
(76, 6, 4, 'warrior_1.jpeg'),
(77, 6, 4, 'warrior_2.jpeg');

-- --------------------------------------------------------

--
-- Struttura della tabella `type`
--

CREATE TABLE `type` (
  `id` int(10) NOT NULL,
  `description` varchar(50) NOT NULL,
  `color_bg` varchar(7) NOT NULL,
  `color_bd` varchar(7) NOT NULL,
  `have_max_health` int(1) NOT NULL,
  `spawn_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `type`
--

INSERT INTO `type` (`id`, `description`, `color_bg`, `color_bd`, `have_max_health`, `spawn_rate`) VALUES
(1, 'hero', '#fff9b3', '#fff200', 1, 0),
(2, 'enemy', '#c3c3c3', '#717171', 1, 33),
(3, 'item', '#aaff92', '#40ff00', 0, 10),
(4, 'interactable', '#dda6ff', '#a100ff', 0, 16),
(5, 'weapon', '#8fa8ff', '#0031ff', 0, 24),
(6, 'trap', '#dca969', '#d56900', 0, 17);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `coins` int(10) DEFAULT 500
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `coins`) VALUES
(1, 'marco', 'marco@gmail.com', '$2y$10$RKy3Y.zW.H9ZSk2p3lVlke96cJHE4BSMQhBEa4JfutveMYvMlNp7K', 9976761),
(2, 'mario', 'mario@gmail.com', '$2y$10$RKy3Y.zW.H9ZSk2p3lVlke96cJHE4BSMQhBEa4JfutveMYvMlNp7K', 500),
(11, 'pino', 'pippo@gmail.com', '$2y$10$gSJZluAQ3pu.OS2Tiq6z8e.zFplg4dG2YndagNEWqVqLydpyCPH02', 500),
(12, 'mino', 'mino@gmail.com', '$2y$10$THIzfthQ35wMv1eDmNoqO.6cJ6kTpoYB1cOAG3CoWqGIfnorBshxa', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `version`
--

CREATE TABLE `version` (
  `id` int(10) NOT NULL,
  `description` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `version`
--

INSERT INTO `version` (`id`, `description`) VALUES
(1, '0.0.1');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `effect`
--
ALTER TABLE `effect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKEffect838874` (`id_event`);

--
-- Indici per le tabelle `game_event`
--
ALTER TABLE `game_event`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `have_effect`
--
ALTER TABLE `have_effect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKEffect_Obj913380` (`id_object`),
  ADD KEY `FKRHave_Effect838876` (`id_effect`);

--
-- Indici per le tabelle `have_skin`
--
ALTER TABLE `have_skin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKUnlocked_C500891` (`id_user`),
  ADD KEY `FKUnlocked_C248673` (`id_skin`);

--
-- Indici per le tabelle `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKObject44650` (`id_type`),
  ADD KEY `FKObject938874` (`id_original_img`);

--
-- Indici per le tabelle `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `run`
--
ALTER TABLE `run`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKRun588439` (`id_user`),
  ADD KEY `FKRun838874` (`id_skin`),
  ADD KEY `FKRun838875` (`id_version`);

--
-- Indici per le tabelle `skin`
--
ALTER TABLE `skin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKSkin638874` (`id_price`),
  ADD KEY `id_object` (`id_object`);

--
-- Indici per le tabelle `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`description`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`description`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `effect`
--
ALTER TABLE `effect`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT per la tabella `game_event`
--
ALTER TABLE `game_event`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `have_effect`
--
ALTER TABLE `have_effect`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `have_skin`
--
ALTER TABLE `have_skin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT per la tabella `object`
--
ALTER TABLE `object`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT per la tabella `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `run`
--
ALTER TABLE `run`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `skin`
--
ALTER TABLE `skin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT per la tabella `type`
--
ALTER TABLE `type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `version`
--
ALTER TABLE `version`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `effect`
--
ALTER TABLE `effect`
  ADD CONSTRAINT `FKEffect838874` FOREIGN KEY (`id_event`) REFERENCES `game_event` (`id`);

--
-- Limiti per la tabella `have_effect`
--
ALTER TABLE `have_effect`
  ADD CONSTRAINT `FKEffect_Obj913380` FOREIGN KEY (`id_object`) REFERENCES `object` (`id`),
  ADD CONSTRAINT `FKRHave_Effect838876` FOREIGN KEY (`id_effect`) REFERENCES `effect` (`id`);

--
-- Limiti per la tabella `have_skin`
--
ALTER TABLE `have_skin`
  ADD CONSTRAINT `FKUnlocked_C248673` FOREIGN KEY (`id_skin`) REFERENCES `skin` (`id`),
  ADD CONSTRAINT `FKUnlocked_C500891` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `object`
--
ALTER TABLE `object`
  ADD CONSTRAINT `FKObject44650` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`),
  ADD CONSTRAINT `FKObject938874` FOREIGN KEY (`id_original_img`) REFERENCES `skin` (`id`);

--
-- Limiti per la tabella `run`
--
ALTER TABLE `run`
  ADD CONSTRAINT `FKRun588439` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FKRun838874` FOREIGN KEY (`id_skin`) REFERENCES `skin` (`id`),
  ADD CONSTRAINT `FKRun838875` FOREIGN KEY (`id_version`) REFERENCES `version` (`id`);

--
-- Limiti per la tabella `skin`
--
ALTER TABLE `skin`
  ADD CONSTRAINT `FKSkin638874` FOREIGN KEY (`id_price`) REFERENCES `price` (`id`),
  ADD CONSTRAINT `FKSkin638875` FOREIGN KEY (`id_object`) REFERENCES `object` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
