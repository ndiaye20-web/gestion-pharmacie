-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 05 mai 2026 à 17:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pharmacie_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_fournisseurs`
--

CREATE TABLE `commande_fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `date_commande` date NOT NULL,
  `date_reception` date DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bon_livraison` varchar(255) DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_fournisseurs`
--

INSERT INTO `commande_fournisseurs` (`id`, `fournisseur_id`, `date_commande`, `date_reception`, `total`, `bon_livraison`, `statut`) VALUES
(1, 1, '2026-05-05', '2026-05-05', 31870.00, NULL, 'reçue'),
(2, 5, '2026-05-05', NULL, 1187.75, NULL, 'en_attente');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `telephone`, `adresse`, `created_at`, `updated_at`) VALUES
(1, 'Laborex Sénégal', '338391010', 'Dakar\r\n', NULL, NULL),
(2, 'Sodipharm', '338491234', 'Dakar', NULL, NULL),
(3, 'Ubipharm Sénégal', '338201122', 'Dakar', NULL, NULL),
(4, 'Duopharm', '338231010', 'Dakar', NULL, NULL),
(5, 'Cophase', '338221515', 'Dakar', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commandes`
--

CREATE TABLE `ligne_commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commande_fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `medicament_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_achat` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_commandes`
--

INSERT INTO `ligne_commandes` (`id`, `commande_fournisseur_id`, `medicament_id`, `quantite`, `prix_achat`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 500, 1.40, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(2, 1, 6, 1000, 3.72, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(3, 1, 9, 1000, 3.43, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(4, 1, 3, 1000, 4.69, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(5, 1, 7, 1000, 1.63, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(6, 1, 8, 1200, 4.50, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(7, 1, 4, 1000, 1.25, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(8, 1, 1, 1000, 1.35, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(9, 1, 10, 1300, 3.40, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(10, 1, 5, 4000, 1.32, '2026-05-05 14:16:38', '2026-05-05 14:16:38'),
(11, 2, 2, 31, 1.25, '2026-05-05 14:19:18', '2026-05-05 14:19:18'),
(12, 2, 3, 88, 1.86, '2026-05-05 14:19:18', '2026-05-05 14:19:18'),
(13, 2, 7, 476, 2.07, '2026-05-05 14:19:18', '2026-05-05 14:19:18');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_ordonnances`
--

CREATE TABLE `ligne_ordonnances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ordonnance_id` bigint(20) UNSIGNED NOT NULL,
  `medicament_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `posologie` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_ordonnances`
--

INSERT INTO `ligne_ordonnances` (`id`, `ordonnance_id`, `medicament_id`, `quantite`, `posologie`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '2-matin', '2026-05-05 14:26:14', '2026-05-05 14:26:14'),
(2, 1, 5, 6, '1 -matin', '2026-05-05 14:26:14', '2026-05-05 14:26:14');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_ventes`
--

CREATE TABLE `ligne_ventes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vente_id` bigint(20) UNSIGNED NOT NULL,
  `medicament_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_ventes`
--

INSERT INTO `ligne_ventes` (`id`, `vente_id`, `medicament_id`, `quantite`, `prix`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 800.00, '2026-05-05 14:41:58', '2026-05-05 14:41:58'),
(2, 1, 5, 6, 500.00, '2026-05-05 14:41:58', '2026-05-05 14:41:58'),
(3, 2, 1, 3, 800.00, '2026-05-05 14:45:17', '2026-05-05 14:45:17'),
(4, 2, 5, 6, 500.00, '2026-05-05 14:45:17', '2026-05-05 14:45:17'),
(5, 3, 7, 1, 1200.00, '2026-05-05 14:49:27', '2026-05-05 14:49:27');

-- --------------------------------------------------------

--
-- Structure de la table `lots`
--

CREATE TABLE `lots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicament_id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_lot` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `date_fabrication` date DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'disponible',
  `date_expiration` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lots`
--

INSERT INTO `lots` (`id`, `medicament_id`, `fournisseur_id`, `numero_lot`, `quantite`, `date_fabrication`, `statut`, `date_expiration`) VALUES
(1, 2, 1, 'LOT-69FA0F21BC771', 500, '2026-05-05', 'disponible', '2027-05-05'),
(2, 6, 1, 'LOT-69FA0F21BD8E0', 1000, '2026-05-05', 'disponible', '2027-05-05'),
(3, 9, 1, 'LOT-69FA0F21BE7A7', 1000, '2026-05-05', 'disponible', '2027-05-05'),
(4, 3, 1, 'LOT-69FA0F21BFBDE', 1000, '2026-05-05', 'disponible', '2027-05-05'),
(5, 7, 1, 'LOT-69FA0F21C0336', 999, '2026-05-05', 'disponible', '2027-05-05'),
(6, 8, 1, 'LOT-69FA0F21C0A24', 1200, '2026-05-05', 'disponible', '2027-05-05'),
(7, 4, 1, 'LOT-69FA0F21C10E3', 1000, '2026-05-05', 'disponible', '2027-05-05'),
(8, 1, 1, 'LOT-69FA0F21C1750', 994, '2026-05-05', 'disponible', '2027-05-05'),
(9, 10, 1, 'LOT-69FA0F21C20F4', 1300, '2026-05-05', 'disponible', '2027-05-05'),
(10, 5, 1, 'LOT-69FA0F21C2DD2', 3988, '2026-05-05', 'disponible', '2027-05-05');

-- --------------------------------------------------------

--
-- Structure de la table `medicaments`
--

CREATE TABLE `medicaments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_commercial` varchar(255) NOT NULL,
  `dci` varchar(255) DEFAULT NULL,
  `code_cip13` varchar(255) NOT NULL,
  `forme` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `classe` varchar(255) DEFAULT NULL,
  `laboratoire` varchar(255) DEFAULT NULL,
  `remboursable` tinyint(1) NOT NULL DEFAULT 0,
  `taux_remboursement` decimal(5,2) DEFAULT NULL,
  `prix_achat` decimal(10,2) NOT NULL,
  `prix_vente` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `medicaments`
--

INSERT INTO `medicaments` (`id`, `nom_commercial`, `dci`, `code_cip13`, `forme`, `dosage`, `classe`, `laboratoire`, `remboursable`, `taux_remboursement`, `prix_achat`, `prix_vente`) VALUES
(1, 'Paracetamol 500mg', 'Paracetamol', '3400930000001', 'Comprimé', '500mg', 'Antalgique', 'Sanofi', 1, 80.00, 500.00, 800.00),
(2, 'Amoxicilline 1g', 'Amoxicilline', '3400930000002', 'Gélule', '1g', 'Antibiotique', 'Pfizer', 1, 70.00, 1500.00, 2000.00),
(3, 'Doliprane Sirop', 'Paracetamol', '3400930000003', 'Sirop', '100mg/5ml', 'Antalgique', 'Sanofi', 1, 80.00, 1200.00, 1500.00),
(4, 'Ibuprofene 400mg', 'Ibuprofène', '3400930000004', 'Comprimé', '400mg', 'Anti-inflammatoire', 'Bayer', 0, 0.00, 700.00, 1000.00),
(5, 'Vitamine C 500mg', 'Acide ascorbique', '3400930000005', 'Comprimé', '500mg', 'Complément', 'UPSA', 0, 0.00, 300.00, 500.00),
(6, 'Augmentin 1g', 'Amoxicilline + Acide clavulanique', '3400930000006', 'Comprimé', '1g', 'Antibiotique', 'GSK', 1, 70.00, 2500.00, 3200.00),
(7, 'Efferalgan 1g', 'Paracetamol', '3400930000007', 'Comprimé effervescent', '1g', 'Antalgique', 'UPSA', 1, 80.00, 800.00, 1200.00),
(8, 'Flagyl 500mg', 'Metronidazole', '3400930000008', 'Comprimé', '500mg', 'Antibiotique', 'Sanofi', 1, 70.00, 900.00, 1300.00),
(9, 'Ciprofloxacine 500mg', 'Ciprofloxacine', '3400930000009', 'Comprimé', '500mg', 'Antibiotique', 'Bayer', 1, 70.00, 2000.00, 2700.00),
(10, 'Smecta', 'Diosmectite', '3400930000010', 'Sachet', '3g', 'Digestif', 'Ipsen', 0, 0.00, 1500.00, 2000.00);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_22_180000_create_patients_table', 1),
(5, '2026_04_22_180002_create_fournisseurs_table', 1),
(6, '2026_04_22_193559_create_medicaments_table', 1),
(7, '2026_04_22_194415_create_lots_table', 1),
(8, '2026_04_22_200257_create_ventes_table', 1),
(9, '2026_04_22_200258_create_ligne_ventes_table', 1),
(10, '2026_04_22_205702_create_ordonnances_table', 1),
(11, '2026_04_22_205703_create_ligne_ordonnances_table', 1),
(12, '2026_04_22_212659_add_statut_to_ordonnances_table', 1),
(13, '2026_04_24_213413_create_commande_fournisseurs_table', 1),
(14, '2026_04_24_213414_create_ligne_commandes_table', 1),
(15, '2026_05_03_000000_add_role_to_users_table', 1),
(16, '2026_05_04_000000_fix_role_column_size', 2),
(17, '2026_05_04_000001_add_user_id_to_patients_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `ordonnances`
--

CREATE TABLE `ordonnances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `medecin` varchar(255) NOT NULL,
  `date_prescription` date NOT NULL,
  `archive_path` varchar(255) DEFAULT NULL,
  `renouvellements` int(11) NOT NULL DEFAULT 0,
  `statut` varchar(255) NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ordonnances`
--

INSERT INTO `ordonnances` (`id`, `patient_id`, `medecin`, `date_prescription`, `archive_path`, `renouvellements`, `statut`) VALUES
(1, 1, 'DR. Arame', '2026-05-05', NULL, 0, 'traitee');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `numero_secu` varchar(255) DEFAULT NULL,
  `mutuelle` varchar(255) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `historique` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `nom`, `prenom`, `date_naissance`, `numero_secu`, `mutuelle`, `allergies`, `historique`, `telephone`) VALUES
(1, 8, 'Mame', 'Diarra', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 9, 'Amina', 'SIDIBE', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'caissier',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Pharmacie', 'admin@pharmacie.com', NULL, '$2y$12$/5zaITp8XucQg5B4tFJ8VeS5yX5P1DCTILxehNdlehdwrvaoa38KO', 'admin', 1, NULL, '2026-05-03 20:23:13', '2026-05-03 20:23:13'),
(2, 'Marie Dupont', 'pharmacien@pharmacie.com', NULL, '$2y$12$rQUbhJzBaMaupp0Q4Cdo5etp3OJrb2QJAdSwIswUQDnGifRbxqaVO', 'pharmacist', 1, NULL, '2026-05-03 20:23:14', '2026-05-03 20:23:14'),
(3, 'Jean Martin', 'preparateur@pharmacie.com', NULL, '$2y$12$Oxob7p725dJHP8uv/lPHE.55jHvSkG8PXkiD3D6tfhCe6t2SUFSVC', 'staff', 1, NULL, '2026-05-03 20:23:14', '2026-05-03 20:23:14'),
(6, 'Arame NDIAYE', 'nooo@gmail.com', NULL, '$2y$12$SYpaBHi/UbN3oAYnY.fvDO7hrjRe9dpFpgQy1DWbKrUI9bXOWg1di', 'pharmacien', 1, NULL, '2026-05-04 13:19:37', '2026-05-04 13:19:37'),
(7, 'fatou', 'ad441633@gmail.com', NULL, '$2y$12$ZmPxsfVrosjolEXw0WhJaOMqQ7fqIpU9UXuoZVnZhy0x0NEsbXWFG', 'preparateur', 1, NULL, '2026-05-04 13:43:13', '2026-05-04 13:43:13'),
(8, 'Mame Diarra', 'fm125@gmail.com', NULL, '$2y$12$3ioO6Emv0SNeoMfHobY/xen18Ui/4YkLj9lvuJF4FNWCEkqsMcO6e', 'patient', 1, NULL, '2026-05-04 13:57:06', '2026-05-04 13:57:06'),
(9, 'Amina SIDIBE', 'gb125@gmail.com', NULL, '$2y$12$ZydirXugWDPXTnGVeksdgefNQzYBvAQwbAb.3Ph09GJPdNU.jDDzS', 'patient', 1, NULL, '2026-05-04 13:59:54', '2026-05-04 13:59:54'),
(12, 'Rama DIOP', 'diop2345@gmail.com', NULL, '$2y$12$qJIeWziw6og3gxroy4Wn2uy8tvyrDN6iBcgJfrPQli5huS.u46rR2', 'caissier', 1, NULL, '2026-05-04 21:27:44', '2026-05-04 21:38:57');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pharmacien_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remboursement` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mode_paiement` varchar(255) DEFAULT NULL,
  `ticket_numero` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `patient_id`, `pharmacien_id`, `remboursement`, `mode_paiement`, `ticket_numero`, `date`, `created_at`, `updated_at`, `total`) VALUES
(1, 1, 6, 0.00, 'Espèces', 'TICKET-20260505154158-6', '2026-05-05 15:41:58', '2026-05-05 14:41:58', '2026-05-05 14:41:58', 5400.00),
(2, 1, 12, 0.00, 'Espèces', 'TICKET-20260505154517-12', '2026-05-05 15:45:17', '2026-05-05 14:45:17', '2026-05-05 14:45:17', 5400.00),
(3, 2, 12, 0.00, 'Espèces', 'POS-20260505154927-12', '2026-05-05 15:49:27', '2026-05-05 14:49:27', '2026-05-05 14:49:27', 1200.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `commande_fournisseurs`
--
ALTER TABLE `commande_fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_fournisseurs_fournisseur_id_foreign` (`fournisseur_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ligne_commandes_commande_fournisseur_id_foreign` (`commande_fournisseur_id`),
  ADD KEY `ligne_commandes_medicament_id_foreign` (`medicament_id`);

--
-- Index pour la table `ligne_ordonnances`
--
ALTER TABLE `ligne_ordonnances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ligne_ordonnances_ordonnance_id_foreign` (`ordonnance_id`),
  ADD KEY `ligne_ordonnances_medicament_id_foreign` (`medicament_id`);

--
-- Index pour la table `ligne_ventes`
--
ALTER TABLE `ligne_ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ligne_ventes_vente_id_foreign` (`vente_id`),
  ADD KEY `ligne_ventes_medicament_id_foreign` (`medicament_id`);

--
-- Index pour la table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lots_medicament_id_foreign` (`medicament_id`),
  ADD KEY `lots_fournisseur_id_foreign` (`fournisseur_id`);

--
-- Index pour la table `medicaments`
--
ALTER TABLE `medicaments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicaments_code_cip13_unique` (`code_cip13`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ordonnances`
--
ALTER TABLE `ordonnances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordonnances_patient_id_foreign` (`patient_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventes_patient_id_foreign` (`patient_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande_fournisseurs`
--
ALTER TABLE `commande_fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `ligne_ordonnances`
--
ALTER TABLE `ligne_ordonnances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ligne_ventes`
--
ALTER TABLE `ligne_ventes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `medicaments`
--
ALTER TABLE `medicaments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `ordonnances`
--
ALTER TABLE `ordonnances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_fournisseurs`
--
ALTER TABLE `commande_fournisseurs`
  ADD CONSTRAINT `commande_fournisseurs_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`);

--
-- Contraintes pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD CONSTRAINT `ligne_commandes_commande_fournisseur_id_foreign` FOREIGN KEY (`commande_fournisseur_id`) REFERENCES `commande_fournisseurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligne_commandes_medicament_id_foreign` FOREIGN KEY (`medicament_id`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ligne_ordonnances`
--
ALTER TABLE `ligne_ordonnances`
  ADD CONSTRAINT `ligne_ordonnances_medicament_id_foreign` FOREIGN KEY (`medicament_id`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligne_ordonnances_ordonnance_id_foreign` FOREIGN KEY (`ordonnance_id`) REFERENCES `ordonnances` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ligne_ventes`
--
ALTER TABLE `ligne_ventes`
  ADD CONSTRAINT `ligne_ventes_medicament_id_foreign` FOREIGN KEY (`medicament_id`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligne_ventes_vente_id_foreign` FOREIGN KEY (`vente_id`) REFERENCES `ventes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`),
  ADD CONSTRAINT `lots_medicament_id_foreign` FOREIGN KEY (`medicament_id`) REFERENCES `medicaments` (`id`);

--
-- Contraintes pour la table `ordonnances`
--
ALTER TABLE `ordonnances`
  ADD CONSTRAINT `ordonnances_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Contraintes pour la table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
