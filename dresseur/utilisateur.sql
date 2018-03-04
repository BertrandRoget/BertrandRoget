CREATE TABLE `tabledresseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `date_licence` DATE DEFAULT NULL,
  `arene_prefere` enum(15),
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Déchargement des données de la table `tabledresseur`
--
