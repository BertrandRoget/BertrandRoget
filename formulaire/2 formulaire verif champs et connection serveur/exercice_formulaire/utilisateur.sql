CREATE TABLE `tableformulaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `gender`varchar(1) DEFAULT NULL,
  `birthdate` DATE DEFAULT NULL,
  `phone` varchar(15),
  `mail_subscribe` tinyint(1) DEFAULT 0,
  `phone_subscribe` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `lastname`, `firstname`, `email`, `gender`, `birthdate`, `phone`, `mail_subscribe`, `phone_subscribe`) VALUES
(1, 'jonathan', 'dequidt', 'jo@deq.com', 'M', '1984-01-03', '', 1, 0),
(2, 'jonathan', 'dequidt', 'a@b.com', 'M', '2018-02-28', '45', 0, 1),
(4, 'gffdsghfdgfd', 'jonathan', 'edith.piaf@milord.com', 'F', '2018-01-31', '', 0, 0),
(5, 'gffdsghfdgfd', 'jonathan', 'dfgdsg@fdfdsq.copm', 'F', '2018-01-31', '', 0, 0),
(6, 'gffdsghfdgfd', 'jonathan', 'dfgdsg@fdfdsq.cop', 'F', '2018-01-31', '', 0, 0),
(7, 'gffdsghfdgfd', 'jonathan', 'dfgdsg@fdfdsq.co', 'F', '2018-01-31', '', 0, 0),
(8, 'gffdsghfdgfd', 'jonathan', 'dfdsg@fdfdsq.co', 'F', '2018-01-31', '', 0, 0),
(9, 'gffdsghfdgfd', 'jonathan', 'dfdsg@fdfsq.co', 'F', '2018-01-31', '', 0, 0),
(10, 'gffdsghfdgfd', 'jonathan', 'dfdsg@fdsq.co', 'F', '2018-01-31', '', 0, 0),
(11, 'gffdsghfdgfd', 'jonathan', 'fdsg@fdsq.co', 'F', '2018-01-31', '', 0, 0),
(12, 'gffdsghfdgfd', 'jonathan', 'fdsg@fsq.co', 'F', '2018-01-31', '', 0, 0);