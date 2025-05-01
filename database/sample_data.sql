-- Insertion de données de test
-- --------------------------------------------------------

-- Désactivation temporaire des contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Vidage des tables
TRUNCATE TABLE `rides`;
TRUNCATE TABLE `agencies`;
TRUNCATE TABLE `users`;

-- Réactivation des contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Données pour la table `agencies`
-- --------------------------------------------------------

INSERT INTO `agencies` (`id`, `name`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims');

-- --------------------------------------------------------
-- Données pour la table `users`
-- --------------------------------------------------------

-- Admin : admin@example.com / admin123
-- Utilisateur : simple@example.com / simple123
-- Password: le même pour tous (simple123) = '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2'
INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `password`, `phone`, `is_admin`) VALUES
(1, 'Admin', 'User', 'admin@example.com', '$2y$10$uXNfGSQYiCQP7dskYEK.zu.7xMpH.4S6B.r53T0IYdxTLBBvVXL/u', '0123456789', 1),
(2, 'Simple', 'User', 'simple@example.com', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0987654321', 0),
(3, 'Martin', 'Alexandre', 'alexandre.martin@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0612345678', 0),
(4, 'Dubois', 'Sophie', 'sophie.dubois@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0698765432', 0),
(5, 'Bernard', 'Julien', 'julien.bernard@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0622446688', 0),
(6, 'Moreau', 'Camille', 'camille.moreau@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0611223344', 0),
(7, 'Lefèvre', 'Lucie', 'lucie.lefevre@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0777889900', 0),
(8, 'Leroy', 'Thomas', 'thomas.leroy@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0655443322', 0),
(9, 'Roux', 'Chloé', 'chloe.roux@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0633221199', 0),
(10, 'Petit', 'Maxime', 'maxime.petit@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0766778899', 0),
(11, 'Garnier', 'Laura', 'laura.garnier@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0688776655', 0),
(12, 'Dupuis', 'Antoine', 'antoine.dupuis@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0744556677', 0),
(13, 'Lefebvre', 'Emma', 'emma.lefebvre@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0699887766', 0),
(14, 'Fontaine', 'Louis', 'louis.fontaine@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0655667788', 0),
(15, 'Chevalier', 'Clara', 'clara.chevalier@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0788990011', 0),
(16, 'Robin', 'Nicolas', 'nicolas.robin@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0644332211', 0),
(17, 'Gauthier', 'Marine', 'marine.gauthier@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0677889922', 0),
(18, 'Fournier', 'Pierre', 'pierre.fournier@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0722334455', 0),
(19, 'Girard', 'Sarah', 'sarah.girard@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0688665544', 0),
(20, 'Lambert', 'Hugo', 'hugo.lambert@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0611223366', 0),
(21, 'Masson', 'Julie', 'julie.masson@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0733445566', 0),
(22, 'Henry', 'Arthur', 'arthur.henry@email.fr', '$2y$10$fwYz6xmxeFiKS2Tz3Z2Nt.0vqMJxAECZlF7QILZpvHnCB3XGnYEm2', '0666554433', 0);

-- --------------------------------------------------------
-- Données pour la table `rides`
-- --------------------------------------------------------

-- Insérer quelques trajets
-- Les dates sont au format YYYY-MM-DD HH:MM:SS
-- Les trajets sont dans le futur par rapport à la date actuelle
INSERT INTO `rides` (`id`, `departure_agency_id`, `arrival_agency_id`, `departure_datetime`, `arrival_datetime`, `total_seats`, `available_seats`, `user_id`) VALUES
(1, 1, 2, '2025-05-15 08:00:00', '2025-05-15 11:00:00', 4, 3, 3),
(2, 2, 1, '2025-05-16 17:00:00', '2025-05-16 20:00:00', 4, 2, 4),
(3, 1, 3, '2025-05-20 09:00:00', '2025-05-20 13:00:00', 3, 1, 5),
(4, 10, 1, '2025-05-22 07:30:00', '2025-05-22 11:30:00', 4, 4, 6),
(5, 9, 6, '2025-05-25 14:00:00', '2025-05-25 18:00:00', 2, 1, 7),
(6, 3, 5, '2025-06-01 09:15:00', '2025-06-01 11:45:00', 3, 2, 8),
(7, 7, 4, '2025-06-03 16:30:00', '2025-06-03 19:30:00', 5, 3, 9),
(8, 4, 8, '2025-06-05 10:00:00', '2025-06-05 12:30:00', 2, 2, 10),
(9, 8, 1, '2025-06-10 08:45:00', '2025-06-10 13:15:00', 4, 1, 11),
(10, 6, 11, '2025-06-15 11:00:00', '2025-06-15 14:30:00', 3, 3, 12);

COMMIT; 